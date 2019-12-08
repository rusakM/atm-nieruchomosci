<?php
    require_once('../assets/connect.php');
    $con = mysqli_connect($host, $usr, $pass, $db);

    $property_types = [];
    $cities = [];

    $types_estates_query = mysqli_query($con, 'SELECT * FROM typesOfEstates');
    $cities_query = mysqli_query($con, 'SELECT * FROM cities');

    while($row = mysqli_fetch_array($types_estates_query)) {
        array_push($property_types, $row);
    }

    while ($row = mysqli_fetch_array($cities_query)) {
        array_push($cities, $row);
    }

    $default_query = "SELECT offers.offerId, offers.title, offers.price, offers.area, cities.name AS location, offers.typeOfMarket, typesOfEstates.typeName AS typeOfEstate, offers.typeOfTransaction FROM offers, cities, typesOfEstates WHERE offers.typeOfEstate = typesOfEstates.typeOfEstateId AND offers.cityId = cities.cityId ORDER BY offers.offerId DESC LIMIT 25";

    $q = "SELECT offers.offerId, offers.title, offers.price, offers.area, cities.name AS location, offers.typeOfMarket, typesOfEstates.typeName AS typeOfEstate, offers.typeOfTransaction FROM offers, cities, typesOfEstates ";
    $q_array = [];
    $offers_array = [];
    $params_to_offer = '';

    if(count($_GET) > 0) {
        if(isset($_GET['transaction-type'])) {
            $params_to_offer = $params_to_offer.'transaction-type='.$_GET['transaction-type'].'&';
            if($_GET['transaction-type'] > -1) {
                array_push($q_array, 'offers.typeOfTransaction = '.$_GET['transaction-type'].' ');
            }
        }
        if(isset($_GET['property-type'])) {
            $params_to_offer = $params_to_offer.'property-type='.$_GET['property-type'].'&';
            if($_GET['property-type'] > -1) {
                array_push($q_array, 'offers.typeOfEstate = '.$_GET['property-type'].' ');
            }
        }
        if(isset($_GET['market-type'])) {
            $params_to_offer = $params_to_offer.'market-type='.$_GET['market-type'].'&';
            if($_GET['market-type'] > -1) {
                array_push($q_array, 'offers.typeOfMarket = '.$_GET['market-type'].' ');
            }
        }
        if(isset($_GET['localization'])) {
            $params_to_offer = $params_to_offer.'localization='.$_GET['localization'].'&';
            if($_GET['localization'] > -1) {
                array_push($q_array, 'offers.cityId = '.$_GET['localization'].' ');
            }
        }
        if(isset($_GET['pricemin'])) {
            $params_to_offer = $params_to_offer.'pricemin='.$_GET['pricemin'].'&';
            if($_GET['pricemin'] != '') {
                array_push($q_array, 'offers.price >= '.$_GET['pricemin'].' ');
            }
        }
        if(isset($_GET['pricemax'])) {
            $params_to_offer = $params_to_offer.'pricemax='.$_GET['pricemax'].'&';
            if($_GET['pricemax'] != '') {
                if(isset($_GET['pricemin'])) {
                    if($_GET['pricemax'] > $_GET['pricemin']) {
                        array_push($q_array, 'offers.price <= '.$_GET['pricemax'].' ');
                    }
                }
                else {
                    array_push($q_array, 'offers.price <= '.$_GET['pricemax'].' ');
                }
            }  
        }
        if(isset($_GET['metersmin'])) {
            $params_to_offer = $params_to_offer.'metersmin='.$_GET['metersmin'].'&';
            if($_GET['metersmin'] != '') {
                array_push($q_array, 'offers.area >= '.$_GET['metersmin'].' ');
            }
        }
        if(isset($_GET['metersmax'])) {
            $params_to_offer = $params_to_offer.'metersmax='.$_GET['metersmax'].'&';
            if($_GET['metersmax'] != '') {
                if(isset($_GET['metersmin'])) {
                    if($_GET['metersmax'] > $_GET['metersmin']) {
                        array_push($q_array, 'offers.area <= '.$_GET['pricemax'].' ');
                    }
                }
                else {
                    array_push($q_array, 'offers.area <= '.$_GET['pricemax'].' ');
                }
            }  
        }
        if(count($q_array) > 0) {
            $q = $q.'WHERE cities.cityId = offers.cityId AND typesOfEstates.typeOfEstateId = offers.typeOfEstate AND ';
            if(count($q_array) > 1) {
                for($i = 0; $i < count($q_array)-1; $i++) {
                    $q = $q."".$q_array[$i];
                    $q = $q.'AND ';
                }
                $q = $q.''.$q_array[count($q_array) - 1];
            }
            else {
                $q = $q.''.$q_array[0];
            }
            $q = $q.'ORDER BY offers.offerId DESC LIMIT 25';
        }
        else {
            $q = $default_query;
        }
    }
    else {
        $q = $default_query;
    }
    
    $query = mysqli_query($con, $q);
    while($row = mysqli_fetch_assoc($query)) {
        array_push($offers_array, $row);
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ATM nieruchomości - Wyszukiwarka</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="search-style.css">
    <link rel="icon" typ="image/x-icon" href="../assets/favicon/icon.ico">
    <script src="https://kit.fontawesome.com/f2d0422ee2.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="logo">
                <img src="../assets/logo.png" alt="logo" class="logo-img">
            </div>
            <div class="menu-bar">
                <p class="nav-item search-link" onclick="goToHome();"></i>Strona główna</p>
                <p class="nav-item search-link" onclick="goToContact();">Kontakt</p>
                <a href="http://localhost/atm-nieruchomosci" id="link-main-page" hidden></a>
                <a href="http://localhost/atm-nieruchomosci" id="link-contact" hidden></a>
        </div>
    </header>
    <section class="search-bar">
        <!-- <h1 class="section-heading">Wyszukiwarka:</h1> -->
        <form action="" class="search-form">
            <div class="search-form-row">
                <!-- select TRANSACTION TYPE -->
                <select name="transaction-type" id="transaction-type" hidden>
                    <option value="-1">-1</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                </select>
                <div class="custom-select">
                    <span class="custom-btn" id="custom-transaction-type" onclick="switchTransactionType(event);">
                        <i class="fas fa-chevron-down"></i>
                        <span class="select-description">Rodzaj transakcji:</span>
                    </span>
                    <ul class="custom-list" id="transaction-type-list">
                        <li class="custom-list-item" id="rent" onclick="selectTransactionType(event);">Wynajem</li>
                        <li class="custom-list-item" id="sell" onclick="selectTransactionType(event);">Sprzedaż</li>
                    </ul>
                </div>
                <!-- select PROPERTY TYPE -->
                <select name="property-type" id="property-type" hidden>
                    <option value="-1">Rodzaj nieruchomości</option>
                    <?php
                        foreach($property_types as $item) {
                            echo '<option value="'.$item[0].'">'.$item[1].'</option>';
                        }
                    ?>
                </select>
                <div class="custom-select">
                    <span class="custom-btn" id="custom-property-type" onclick="switchPropertyType(event);">
                        <i class="fas fa-chevron-down"></i>
                        <span class="select-description">Rodzaj nieruchomości:</span>
                    </span>
                    <ul class="custom-list" id="property-type-list">
                        <?php
                            foreach($property_types as $item) {
                                echo '<li class="custom-list-item" id="property-type-'.$item[0].'" onclick="selectPropertyType(event);">'.$item[1].'</li>';
                            }
                        ?>
                    </ul>
                </div>

                <!-- select MARKET TYPE -->
                <select name="market-type" id="market-type" hidden>
                    <option value="-1">Rynek</option>
                    <option value="0">Pierwotny</option>
                    <option value="1">Wtórny</option>
                </select>
                <div class="custom-select">
                    <span class="custom-btn" id="custom-market-type" onclick="switchMarketType(event);">
                        <i class="fas fa-chevron-down"></i>
                        <span class="select-description">Rynek:</span>
                    </span>
                    <ul class="custom-list" id="market-type-list">
                        <li class="custom-list-item" id="primary" onclick="selectMarketType(event);">Pierwotny</li>
                        <li class="custom-list-item" id="aftermarket" onclick="selectMarketType(event);">Wtórny</li>
                    </ul>
                </div>

                <!-- select LOCALIZATION -->
                <select name="localization" id="localization" hidden>
                    <option value="-1">Lokalizacja</option>
                    <?php
                        foreach($cities as $city) {
                            echo '<option value="'.$city[0].'">'.$city[1].'</option>';
                        }
                    ?>
                </select>
                <div class="custom-select">
                    <span class="custom-btn" id="custom-localization" onclick="switchLocalizationList(event);">
                        <i class="fas fa-chevron-down"></i>
                        <span class="select-description">Lokalizacja:</span>
                    </span>
                    <ul class="custom-list" id="localization-list">
                        <?php
                            foreach($cities as $city) {
                                echo '<li class="custom-list-item" id="localization-'.$city[0].'" onClick="selectLocalization(event);">'.$city[1].'</li>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="search-form-row">
                <input
                    type="text"
                    placeholder="Cena od"
                    name="pricemin"
                    class="input-field"
                    id="pricemin"
                />
                <input
                    type="text"
                    placeholder="Cena do"
                    name="pricemax"
                    class="input-field"
                    id="pricemax"
                />
                <input
                    type="text"
                    placeholder="m&sup2; od"
                    name="metersmin"
                    class="input-field"
                    id="metersmin"
                />
                <input
                    type="text"
                    placeholder="m&sup2; do"
                    name="metersmax"
                    class="input-field"
                    id="metersmax"
                />
            </div>
            <input type="submit" value="Szukaj" class="btn-search" />
        </form>
    </section>
    <section class="search-results">
        <div class="results-header">
            <h1>Wyniki wyszukiwania:</h1>
            <p>Znaleziono 
            <?php
                echo count($offers_array);
            ?>
             ogłoszeń:</p>
        </div>
        <div class="results-container">
            <?php
                foreach($offers_array as $num => $item) {
                    $photo_query = mysqli_query($con, 'SELECT photoId from photos WHERE isPrimary=1 AND offerId='.$item['offerId'].' ORDER BY photoId LIMIT 1');
                    if(mysqli_num_rows($photo_query) > 0) {
                        $photo = mysqli_fetch_array($photo_query);
                        $photo = 'http://localhost/atm-nieruchomosci/uploads/'.$photo[0].'.jpg';
                    }
                    else {
                        $photo = 'http://localhost/atm-nieruchomosci/uploads/default-offer.jpg';
                    }
                    $offer = '<div class="offer-container ';
                    if($num % 2 == 0) {
                        $offer = $offer.'left" ';
                    }
                    else{
                        $offer = $offer.'right" ';
                    }
                        
                    $offer = $offer.'onclick="openOffer('.$item['offerId'].');">
                    <a href="http://localhost/atm-nieruchomosci/oferta/?'.$params_to_offer.'id='.$item['offerId'].'" hidden id="link-'.$item['offerId'].'"></a>
                    <img src="'.$photo.'" class="offer-img">
                    <div class="offer-description">
                    <h1 class="offer-title">'.$item['title'].'</h1>
                    <span class="offer-location"><i class="fas fa-map-marker-alt"></i> '.$item['location'].'</span>
                    <div class="description-container">
                    <ul class="description">
                    <li class="offer-attribute">Powierzchnia '.$item['area'].' m&sup2;</li>';
                    if($item['typeOfTransaction'] == 0) {
                        $offer = $offer.'<li class="offer-attribute">Rodzaj transakcji: Wynajem</li>';
                    }
                    else if($item['typeOfTransaction'] == 1){
                        $offer = $offer.'<li class="offer-attribute">Rodzaj transakcji: Sprzedaż</li>';
                    }
                    if($item['typeOfMarket'] == 0) {
                        $offer = $offer.'<li class="offer-attribute">Rynek: Pierwotny</li>';
                    }
                    else if($item['typeOfMarket'] == 1) {
                        $offer = $offer.'<li class="offer-attribute">Rynek: Wtórny</li>';
                    }
                    $pricem2 = floor($item['price'] / $item['area']);
                    $offer = $offer.'<li class="offer-attribute">Typ nieruchomości: '.$item['typeOfEstate'].'</li>
                    </ul>
                    <div class="price-container">
                    <h4 class="price-description">Cena:</h4>
                    <h2 class="price">'.$item['price'].' zł</h2>
                    <h5 class="price-m2">'.$pricem2.'zł/m&sup2;</h5>
                    </div></div></div></div>';

                    echo $offer;
                }
            ?>
        </div>
    </section>
    <section class="contact" id="contact">
        <h1 class="section-heading">Kontakt</h1>
        <div class="contact-container">
            <div class="contact-data">
                <p>Jeśli jesteś zainteresowany naszą ofertą, lub masz jakieś pytania - skontaktuj się z nami!</p>
                <h5>ATM NIERUCHOMOŚCI</h5>
                <p><i class="fas fa-phone-alt"></i> Telefon: 506 568 042</p>
                <p><i class="far fa-envelope-open"></i> Email: some@mail.com</p>
                <p><i class="fas fa-map-marked-alt"></i> Adres: 08-400 Garwolin</p>
            </div>
            <img src="../assets/map.png" alt="Mapa dojazu" class="map-img">
        </div>
    </section>
</body>
</html>
<script src="../script.js"></script>
<script src="search.js"></script>
<script src="fill-form.js"></script>