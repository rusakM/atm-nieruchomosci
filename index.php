<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ATM nieruchomości</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" typ="image/x-icon" href="assets/favicon/icon.ico">
</head>
<body>
    <header>
        <div class="logo">
            <img src="assets/logo.png" alt="logo" class="logo-img">
        </div>
        <ul class="navbar">
            <li class="nav-item">Wyszukiwarka</li>
            <li class="nav-item">Najnowsze oferty</li>
            <li class="nav-item">Usługi</li>
            <li class="nav-item">Kontakt</li>
            <li class="nav-item">O nas</li>
        </ul>
    </header>
    <section class="main-page">
        <div class="search-form-container">
            <form action="" class="search-form"  >
                <select name="transaction-type" id="transaction-type" class="input-field">
                    <option value="" class="input-option">Rodzaj transakcji</option>
                    <option value="rent" class="input-option">Wynajem</option>
                    <option value="sell" class="input-option">Sprzedaż</option>
                </select>
                <select name="property-type" id="property-type" class="input-field">
                    <option value="" class="input-option">Rodzaj nieruchomości</option>
                    <option value="flat" class="input-option">Mieszkania</option>
                    <option value="house" class="input-option">Domy</option>
                    <option value="locals" class="input-field">Lokale użytkowe</option>
                    <option value="field" class="input-option">Działki</option>
                </select>
                <select name="market" id="market" class="input-field">
                    <option value="" class="input-option">Rynek</option>
                    <option value="primary" class="input-option">Pierwotny</option>
                    <option value="aftermarket" class="input-option">Wtórny</option>
                </select>
                <select name="localization" id="localization" class="input-field">
                    <option value="" class="input-option">Lokalizacja</option>
                    <option value="warsaw" class="input-option">Warszawa</option>
                    <option value="garwolin" class="input-option">Garwolin</option>
                    <option value="lublin" class="input-option">Lublin</option>
                </select>
                <input type="text" placeholder="Cena od" name="pricemin" class="input-field" id="pricemin">
                <input type="text" placeholder="Cena do" name="pricemax" class="input-field" id="pricemax">
                <input type="text" placeholder="m&sup2; od" name="metersmin" class="input-field" id="metersmin">
                <input type="text" placeholder="m&sup2; do" name="metersmax" class="input-field" id="metersmax">
                <input type="submit" value="Szukaj" class="btn-search">
            </form>
        </div>
    </section>
    <section class="latest-offers">
        <h2>Najnowsze oferty:</h2>
    </section>
    <footer>
    </footer>
</body>
</html>