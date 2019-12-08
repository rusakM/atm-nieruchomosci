<?php
    require_once('assets/connect.php');
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

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ATM nieruchomości</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" typ="image/x-icon" href="assets/favicon/icon.ico">
    <script src="https://kit.fontawesome.com/f2d0422ee2.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="assets/logo.png" alt="logo" class="logo-img">
        </div>
        <div class="menu-bar">
            <p class="nav-item search-link">Wyszukiwarka</p>
        <p class="menu-btn" id="menu-btn" onclick="switchMenuBar();"><i class="fas fa-bars"></i></p> 
        </div>
    </header>
    <aside class="left-menu" id="left-menu">
        <ul class="navbar">
            <li class="nav-item">Wyszukiwarka</li>
            <li class="nav-item">Najnowsze oferty</li>
            <li class="nav-item">Usługi</li>
            <li class="nav-item">Kontakt</li>
        </ul>
    </aside>
    <section class="main-page">
        <div class="search-form-container">
            <div class="slogan">
                <h2>AGENCJA <br>NIERUCHOMOŚCI</h2>
            <button>Wyszukaj ofertę</button>
            </div>
        </div>
        <img src="assets/background-wide.jpeg" alt="background" class="background-img">
    </section>
    <section class="search-bar">
        <h1 class="section-heading">Znajdź coś dla siebie:</h1>
        <form action="wyszukiwarka" class="search-form">
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
            </div>
            <div class="search-form-row">
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
    <section class="latest-offers">
        <h1 class="section-heading">Najnowsze oferty:</h1>
    </section>
    <section class="services">
        <h1 class="section-heading">Nasze usługi:</h1>
        <div class="service-container left">
            <div class="service-left">
                <img src="assets/services-img/sell.jpg" alt="Sprzedaż" class="service-img left-img">
                <div class="service-description">
                    <h3>Sprzedaż nieruchomości</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lacus vel facilisis volutpat est velit. Placerat vestibulum lectus mauris ultrices eros in cursus turpis massa.</p>
                </div>
            </div>
        </div>
        <div class="service-container right">
            <div class="service-right">
            <img src="assets/services-img/rent.jpg" alt="Sprzedaż" class="service-img">
                <div class="service-description">
                    <h3>Wynajem nieruchomości</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lacus vel facilisis volutpat est velit. Placerat vestibulum lectus mauris ultrices eros in cursus turpis massa.</p>
                </div>
            </div>
        </div>
        <div class="service-container left">
            <div class="service-left">
            <img src="assets/services-img/insurance.jpg" alt="Sprzedaż" class="service-img">
                <div class="service-description">
                    <h3>Ubezpieczenie nieruchomości</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lacus vel facilisis volutpat est velit. Placerat vestibulum lectus mauris ultrices eros in cursus turpis massa.</p>
                </div>
            </div>
        </div>
        <div class="service-container">
            <div class="service-right"></div>
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
            <img src="assets/map.png" alt="Mapa dojazu" class="map-img">
        </div>
    </section>
</body>
</html>

<script src="script.js"></script>

<?php

mysqli_close($con);

?>