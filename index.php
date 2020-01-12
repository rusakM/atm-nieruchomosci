<?php
    require_once('assets/connect.php');
    $con = mysqli_connect($host, $usr, $pass, $db);

    $property_types = [];
    $cities = [];
    $latest_offers = [];

    $types_estates_query = mysqli_query($con, 'SELECT * FROM typesOfEstates');
    $cities_query = mysqli_query($con, 'SELECT * FROM cities');
    $latest_offers_query = mysqli_query($con, 'SELECT offers.offerId, offers.title, offers.price, offers.area, cities.name AS city, typesOfEstates.typeName AS type, typeOfTransaction, offers.cityId FROM offers, cities, typesOfEstates WHERE offers.cityId = cities.cityId AND offers.typeOfEstate = typesOfEstates.typeOfEstateId ORDER BY offers.offerId DESC LIMIT 3');

    while($row = mysqli_fetch_array($types_estates_query)) {
        array_push($property_types, $row);
    }

    while ($row = mysqli_fetch_array($cities_query)) {
        array_push($cities, $row);
    }

    while($row = mysqli_fetch_assoc($latest_offers_query)) {
        array_push($latest_offers, $row);
    }

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="ATM Nieruchomości - sprzedaż, wynajem, zarządzanie najmem i ubezpieczenie nieruchomości. Garwolin i okolice.">
    <meta name="keywords" content="ATM, nieruchomości garwolin, ATM nieruchomości, atm, nieruchomosci, garwolin">
    <meta name="robots" content="index, follow">
    
    <title>ATM nieruchomości</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" typ="image/x-icon" href="assets/favicon/icon.ico">
    <script src="https://kit.fontawesome.com/f2d0422ee2.js" crossorigin="anonymous"></script>
</head>
<body>
    <aside class="cookies-alert" id="cookies-alert">
        <p class="cookie">Ta strona wykorzystuje pliki cookie aby świadczyć usługi na najwyższym poziomie. Pliki te są usuwane po zamknięciu okan przeglądarki. Dalsze korzystanie ze strony oznacza ich akceptację.</p>
        <span class="cookies-btn" id="cookie-accept" onclick="confirmCookies();"><i class="fas fa-times"></i></span>
    </aside>
    <header>
        <div class="logo">
            <img src="assets/logo.png" alt="logo" class="logo-img" onclick="goToHome();">
        </div>
        <div class="menu-bar">
            <p class="nav-item search-link" onclick="goToSearch();">Wyszukiwarka</p>
            <a href="http://localhost/atm-nieruchomosci/wyszukiwarka" id="searchLink" hidden></a>
        <p class="menu-btn" id="menu-btn" onclick="switchMenuBar();"><i class="fas fa-bars"></i></p> 
        </div>
    </header>
    <aside class="left-menu" id="left-menu">
        <ul class="navbar">
            <li class="nav-item" onclick="scroller('search');">Wyszukiwarka</li>
            <li class="nav-item" onclick="scroller('latest-offers');">Najnowsze oferty</li>
            <li class="nav-item" onclick="scroller('services');">Usługi</li>
            <li class="nav-item" onclick="scroller('contact');">Kontakt</li>
        </ul>
    </aside>
    <section class="main-page">
        <div class="search-form-container">
            <div class="slogan">
                <h2>AGENCJA <br>NIERUCHOMOŚCI</h2>
                <button onclick="scroller('search');">Wyszukaj ofertę</button>
            </div>
        </div>
        <img src="assets/background-wide.jpeg" alt="background" class="background-img">
    </section>
    <section class="services" id="services">
        <h1 class="section-heading">Nasze usługi:</h1>
        <div class="service-container left" id="estate-sell-container">
            <div class="service-left">
                <img src="assets/services-img/sell.jpg" alt="Sprzedaż" class="service-img left-img">
                <div class="service-description">
                    <h3>Sprzedaż nieruchomości</h3>
                    <p>Skutecznie poprowadzimy cię przez proces sprzedaży nieruchomości. Przygotujemy profesjonalną ofertę sprzedaży, będziemy czuwać nad negocjacjami i zadbamy o to by twoje mieszkanie znalazło nowego właściciela.</p>
                </div>
            </div>
        </div>
        <div class="service-container right">
            <div class="service-right">
            <img src="assets/services-img/rent.jpg" alt="Sprzedaż" class="service-img">
                <div class="service-description">
                    <h3>Wynajem nieruchomości</h3>
                    <p>Specjalizujemy się w wynajmie różnych typów nieruchomości: mieszkań, domów, lokali użytkowych. Bezpiecznie przeprowadzimy cię przez proces wynajmu, od szukania sprawdzonych najemców, poprzez prezentację nieruchomości, aż po podpisanie umowy. </p>
                </div>
            </div>
        </div>
        <div class="service-container left">
            <div class="service-left">
            <img src="assets/services-img/insurance.jpg" alt="Sprzedaż" class="service-img">
                <div class="service-description">
                    <h3>Zarządzanie najmem</h3>
                    <p>Nasza firma zajmuje się również kompleksową obsługą najmu mieszkania. Stworzymy dla ciebie ofertę, znajdziemy lokatorów, oraz zapewnimy nadzór nad mieszkaniem i wszystkim co się w nim znajduje. Usługa zarządzania najmem obejmuje również kontrolę nad płatnościami i windykacją.</p>
                </div>
            </div>
        </div>
        <div class="service-container right">
            <div class="service-right">
            <img src="assets/services-img/insurance.jpg" alt="Sprzedaż" class="service-img">
                <div class="service-description">
                    <h3>Ubezpieczenie nieruchomości</h3>
                    <p>Zajmujemy się również ubezpieczeniem nieruchomości. Przygotujemy dla ciebie indywidualną ofertę zapewniając szeroki zakres ochrony, by jak najlepiej zabezpieczyć twoją posiadłość.</p>
                </div>
            </div>
            </div>
        </div>
    </section>
    <section class="search-bar" id="search">
        <h1 class="section-heading">Znajdź coś dla siebie:</h1>
        <form action="wyszukiwarka" class="search-form" id="search-form">
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
            <div class="search-form-row input-fields">
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
            </div>
            <div class="search-form-row input-fields">
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
    
    <section class="latest-offers" id="latest-offers">
        <h1 class="section-heading">Najnowsze oferty:</h1>
        <div class="latest-offers-container">
            <?php
                $s = "";
                foreach($latest_offers as $o) {
                    $photo_q = mysqli_query($con, 'SELECT photoId FROM photos WHERE offerId='.$o['offerId'].' AND isPrimary=1 LIMIT 1');
                    $photo = mysqli_fetch_array($photo_q)[0];
                    $price_for_meter = floor($o['price'] / $o['area']);
                    if(!($photo > 0)) {
                        $photo = 'default-offer';
                    }
                    if(strlen($o['title']) > 30) {
                        $title = '';
                        for($a = 0; $a < 30; $a++) {
                            $title .= $o['title'][$a];
                        }
                        $title .= '...';
                    }
                    else {
                        $title = $o['title'];
                    }
                    $s .='<div class="latest-offer-container">
                        <div class="latest-offer">
                            <img src="http://localhost/atm-nieruchomosci/uploads/'.$photo.'.jpg" class="offer-photo">
                            <h4>'.$title.'</h4>
                            <ul class="offer-description-list">
                                <li class="offer-description-item">
                                    <a href="http://localhost/atm-nieruchomosci/wyszukiwarka/?localization='.$o['cityId'].'">
                                    <i class="fas fa-map-marker-alt"></i>'.$o['city'].'</a>
                                </li>
                                <li class="offer-description-item">
                                    Rodzaj nieruchomości: '.$o['type'].'
                                </li>';
                               if($o['typeOfTransaction'] == 0) {
                                   $typeOfTransaction = "Wynajem";
                               }
                               else if ($o['typeOfTransaction'] == 1) {
                                   $typeOfTransaction = "Sprzedaż";
                               }
                               if(isset($typeOfTransaction)) {
                                   $s .= '<li class="offer-description-item">Rodzaj transakcji: '.$typeOfTransaction.'</li>';
                               }

                    $s .= '<li class="offer-description-item">Powierzchnia: '.$o['area'].' m&sup2;</li>
                            </ul>
                            <h4>Cena:</h4>
                            <h2>'.$o['price'].' zł</h2>
                            <small>'.$price_for_meter.' zł/m&sup2;</small>
                            <span class="open-offer-btn" onclick="openOffer('.$o['offerId'].');">Sprawdź!</span>
                        </div>
                    </div>';
                }
                echo $s;
            ?>
        </div>
    </section>
    
    <section class="contact" id="contact">
        <h1 class="section-heading">Kontakt</h1>
        <div class="contact-container">
            <div class="contact-data">
                <p>Jeśli jesteś zainteresowany naszą ofertą, lub masz jakieś pytania - skontaktuj się z nami!</p>
                <h5 id="company">ATM NIERUCHOMOŚCI</h5>
                <div class="telephone">
                    <i class="fas fa-phone-alt"></i>
                    <p>Telefon:<p> 
                    <ul>
                        <li>507 766 665</li>
                        <li>506 568 042</li>
                    </ul>
                </div>
                <p><i class="far fa-envelope-open"></i> Email: nieruchomosciatm@gmail.com</p>
                <!-- <p><i class="fas fa-map-marked-alt"></i> Adres: 08-400 Garwolin</p> -->
                
            </div>
            <img src="assets/map.png" alt="Mapa dojazu" class="map-img">
        </div>
            <p class="author">Projekt i wykonanie: Mateusz Rusak</p>
    </section>
</body>
</html>

<script src="script.js"></script>
<script src="cookies.js"></script>
<?php

mysqli_close($con);

?>