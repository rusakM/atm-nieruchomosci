<?php
    require_once('../assets/connect.php');
    $con = mysqli_connect($host, $usr, $pass, $db);

    if(!isset($_GET['id'])) {
        header('Location: http://localhost/atm-nieruchomosci/wyszukiwarka/');
    }
    $q = 'SELECT offers.title, offers.price, offers.area, cities.name as location, typesOfEstates.typeName as typeOfEstate, offers.typeOfMarket, offers.typeOfTransaction, offers.adress, offers.description, offers.insertionDate, offers.isFurnitured, offers.isFinished, offers.numOfRooms, offers.floor, offers.cityId FROM offers, cities, typesOfEstates WHERE cities.cityId = offers.cityId AND offers.typeOfEstate = typesOfEstates.typeOfEstateId AND offers.offerId = '.$_GET['id'];

    $photos_query = mysqli_query($con, 'SELECT photoId, isPrimary FROM photos WHERE offerId = '.$_GET['id'].' ORDER BY isPrimary DESC');
    $offer_query = mysqli_query($con, $q);

    $offer = mysqli_fetch_assoc($offer_query);
    $pricem2 = floor($offer['price'] / $offer['area']);
    $photos = [];

    if(mysqli_num_rows($photos_query) > 0) {
        while($row = mysqli_fetch_array($photos_query)) {
            array_push($photos, $row);
        }
    }

    $params = '';
    foreach($_GET as $key => $val) {
        if($key != 'id') {
            $params = $params.''.$key.'='.$val.'&';
        }
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
    <?php
        if(strlen($offer['title']) > 50) {
            for($a = 0; $a < 50; $a++) {
                echo $offer['title'][$a];
            }
            echo '...';
        }
        else {
            echo $offer['title'];
        }
    ?>
    </title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="offer-style.css">
    <link rel="icon" typ="image/x-icon" href="../assets/favicon/icon.ico">
    <script src="https://kit.fontawesome.com/f2d0422ee2.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="logo">
                <img src="../assets/logo.png" alt="logo" class="logo-img" onclick="goToHome();">
            </div>
            <div class="menu-bar">
                <p class="nav-item search-link" onclick="goToHome();"></i>Strona główna</p>
                <p class="nav-item search-link" onclick="scroller('contact');">Kontakt</p>
                <a href="http://localhost/atm-nieruchomosci" id="link-main-page" hidden></a>
                <a href="http://localhost/atm-nieruchomosci" id="link-contact" hidden></a>
        </div>
    </header>
        <?php
            if(count($photos) > 0) {
                foreach($photos as $photo) {
                    if($photo[1] == 1) {
                        echo '<section class="main-photo" style="background-image: url(&apos;http://localhost/atm-nieruchomosci/uploads/'.$photo[0].'.jpg&apos;)"></section>';
                    break;
                    }
                }
            }
        ?>
    <section class="title-bar">
        <?php
            echo '<a href="http://localhost/atm-nieruchomosci/wyszukiwarka/';
            if(strlen($params) > 0) {
                echo '?'.$params;
            }
            echo '"id="back-link" hidden></a>'
        ?>
        <span class="back-btn" onclick="goBack();">
        <i class="fas fa-chevron-left"></i>
         Powrót do wyszukiwarki
        </span>
        <h1 class="offer-title">
        <?php
        echo $offer['title'];
        ?>
        </h1>
    </section>
    <section class="properties">
        <ul class="props-list">
            <li class="prop-item">
            <?php
                echo 'Powierzchnia: '.$offer['area'].'m&sup2;';
            ?>
            </li>
            <li class="prop-item">
            <?php
                echo 'Rodzaj transakcji: ';
                if($offer['typeOfTransaction'] == 0) {
                    echo 'Wynajem';
                }
                else {
                    echo 'Sprzedaż';
                }
            ?>
            </li>
            <li class="prop-item">
            <?php
                echo 'Rynek: ';
                if($offer['typeOfMarket'] == 0) {
                    echo 'Pierwotny';
                }
                else {
                    echo 'Wtórny';
                }
            ?>
            </li>
            <li class="prop-item">
                Rodzaj nieruchomości:
                <?php
                    echo $offer['typeOfEstate'];
                ?>
            </li>
            <?php
                if($offer['floor'] != -1) {
                    echo '<li class="prop-item">Piętro: ';
                    if($offer['floor'] == 0) {
                        echo 'Parter';
                    }
                    else {
                        echo $offer['floor'];
                    }
                    echo '</li>';
                }
                if($offer['numOfRooms'] > 0) {
                    echo '<li class="prop-item">Liczba pokoi: '.$offer['numOfRooms'].'</li>';
                }
                if($offer['isFinished'] == 0) {
                    echo '<li class="prop-item">Wykończone: Nie</li>';
                }
                else if($offer['isFinished'] == 1){
                    echo '<li class="prop-item">Wykończone: Tak</li>';
                }
                if($offer['isFurnitured'] == 0) {
                    echo '<li class="prop-item">Umeblowane: Nie</li>';
                }
                else if($offer['isFurnitured'] == 1) {
                    echo '<li class="prop-item">Umeblowane: Tak</li>';
                }
                if(strlen($offer['adress']) > 0) {
                    echo '<li class="prop-item">Adres: '.$offer['adress'].'</li>';
                }
            ?>
        </ul>
        <div class="price-container">
            <?php
                echo '<a href="http://localhost/atm-nieruchomosci/wyszukiwarka/?localization='.$offer['cityId'].'" class="location"">
                <i class="fas fa-map-marker-alt"></i> '.$offer['location'].'
                </a>'
            ?>
            <h3>Cena:</h3>
            <h1>
            <?php
                echo $offer['price'].' zł';
            ?>
            </h1>
            <p>
            <?php
                echo $pricem2.' zł/m&sup2;';
            ?>
            </p>
            <h3 class="call">Zadzwoń:</h3>
            <h2>506 568 042</h2>
        </div>
    </section>
    <section class="description">
        <?php
            if(strlen($offer['description']) > 0) {
                echo '<h1 class="offer-heading">Opis:</h1>';
                echo '<p class="offer-description">'.nl2br($offer['description']).'</p>';
            }
        ?>
        <p class="insertion-date">
            <?php
                echo 'Data dodania oferty: '.$offer['insertionDate'];
            ?>
        </p>
    </section>
    <section class="photos">
        <?php
        if(count($photos) > 0) {
            echo '<h1 class="offer-heading">Zdjęcia:</h1>';
        }
        ?>
        <div class="photos-container">
        <?php
        if(count($photos) > 0) {
            foreach($photos as $photo) {
                echo '<div class="photo"><img src="http://localhost/atm-nieruchomosci/uploads/'.$photo[0].'.jpg" onclick="showGallery(event);" class="photo-img"></div>';
            }
        }
        ?>
        </div>
    </section>
    <footer id="contact">
        <h5>ATM NIERUCHOMOŚCI</h5>
        <div>
            <p><i class="fas fa-phone-alt"></i> Telefon: 507 766 665</p>
            <p><i class="far fa-envelope-open"></i> Email: nieruchomosciatm@gmail.com</p>
            <!-- <p><i class="fas fa-map-marked-alt"></i> Adres: 08-400 Garwolin</p> -->
        </div>
        <p>Projekt i wykonanie: Mateusz Rusak</p>
    </footer>
    <aside class="gallery" id="gallery">
        <div id="gallery-container">
            <img src="" id="photo-preview">
            <i class="fas fa-times" id="btn-close" onclick="galleryClose();"></i>
            <i class="fas fa-chevron-left" id="btn-prev" onclick="prevImage();"></i>
            <i class="fas fa-chevron-right" id="btn-next" onclick="nextImage();"></i>
        </div>
    </aside>
</body>
</html>
<script src="../script.js"></script>
<script src="gallery.js"></script>