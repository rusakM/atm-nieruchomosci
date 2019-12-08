<?php
require_once('../assets/connect.php');
$con = mysqli_connect($host, $usr, $pass, $db);

$q = 'SELECT offers.offerId, offers.title, offers.cityId, cities.name as cityName, typesOfEstates.typeName, offers.insertionDate FROM offers, cities, typesOfEstates WHERE offers.cityId = cities.cityId AND typesOfEstates.typeOfEstateId = offers.typeOfEstate ORDER BY offers.offerId DESC';

$offers_array = [];

$offer_query = mysqli_query($con, $q);
while ($row = mysqli_fetch_assoc($offer_query)) {
    if(isset($offers_array[$row['typeName']])) {
        array_push($offers_array[$row['typeName']], $row);
    }
    else {
        $offers_array[$row['typeName']] = [];
        array_push($offers_array[$row['typeName']], $row);
    }  
}

function offer_list($arr) {
    $s = '';
    foreach($arr as $key => $items) {
        $s = $s.'<h2 class="property-type">'.$key.'</h2><ul class="offers-list">';
        foreach($items as $k => $i) {
            $s = $s.'<li class="list-offer-item"><a href="http://localhost/atm-nieruchomosci/oferta/?id='.$i['offerId'].'" target="_blank"><i>'.$i['insertionDate'].',</i> ';
            if(strlen($i['title']) > 50) {
                for($a = 0; $a < 50; $a++) {
                    $s = $s.$i['title'][$a];
                }
                $s = $s.'... - ';
            }
            else {
                $s = $s.''.$i['title'].' - ';
            }
            $s = $s.''.$i['cityName'].', id: '.$i['offerId'].'</a>
            <button class="btn btn-light"><a href="http://localhost/atm-nieruchomosci/formularz/?strona=edytuj&id='.$i['offerId'].'">Edytuj</a></button>
            <button class="btn btn-danger"><a href="http://localhost/atm-nieruchomosci/scripts/delete.php?id='.$i['offerId'].'">Usuń</a></button>
            </li>';
        }
        $s = $s.'</ul>';
    }
    return $s;
}

function add_offer($con) {

    $s = '<h1>Dodaj ofertę:</h1>';
    $cities_q = mysqli_query($con, 'SELECT * FROM cities');
    $types_q = mysqli_query($con, 'SELECT * FROM typesOfEstates');
    $cities = [];
    $types = [];

    while($row = mysqli_fetch_array($cities_q)) {
        array_push($cities, $row);
    }
    while($row = mysqli_fetch_array($types_q)) {
        array_push($types, $row);
    }

    $s = $s.'<form action="http://localhost/atm-nieruchomosci/scripts/add.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Tytuł:</label>
            <input type="text" name="title" placeholder="Tytuł" class="form-control" id="title" required>
        </div>
        <div class="form-group">
            <label for="price">Cena:</label>
            <input type="number" name="price" class="form-control" id="price" required>
        </div>
        <div class="form-group">
            <label for="area">Powierzchnia:</label>
            <input type="number" name="area" class="form-control" id="area" required>
        </div>
        <div class="form-group">
            <label for="city">Miasto:</label>
            <select name="city" id="city">';
        foreach($cities as $city) {
            $s = $s.'<option value="'.$city[0].'">'.$city[0].' - '.$city[1].'</option>';
        }
    $s = $s.'</select>
        </div>
        <div class="form-group">
            <label for="property-type">Rodzaj nieruchomości:</label>
            <select name="property-type" id="property-type">';
        foreach($types as $type) {
            $s = $s.'<option value="'.$type[0].'">'.$type[0].' - '.$type[1].'</option>';
        }
    $s = $s.'</select>
        </div>
        <div class="form-group">
            <label for="transaction-type">Rodzaj transakcji:</label>
            <select name="transaction-type" id="transaction-type">
                <option value="0">Wynajem</option>
                <option value="1">Sprzedaż</option>
            </select>
        </div>
        <div class="form-group">
            <label for="market-type">Rynek:</label>
            <select name="market-type" id="market-type">
                <option value="0">Pierwotny</option>
                <option value="1">Wtórny</option>
            </select>
        </div>
        <div class="form-group">
            <label for="adress">Adres:</label>
            <input type="text" name="adress" id="adress" aria-describedby="adressHelp" class="form-control">
            <small class="form-text text-muted" id="adressHelp">np. ul. Długa 1, 08-400 Garwolin</small>
        </div>
        <div class="form-group">
            <label for="description">Opis:</label>
            <textarea id="description" class="form-control" name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="isFinished">Wykończone:</label>
            <select id="isFinished" name="isFinished">
                <option value="-1">Nie podano/nie dotyczy</option>
                <option value="1">Tak</option>
                <option value="0">Nie</option>
            </select>
        </div>
        <div class="form-group">
            <label for="isFurnitured">Umeblowane</label>
            <select name="isFurnitured" id="isFurnitured">
                <option value="-1">Nie podano/nie dotyczy</option>
                <option value="1">Tak</option>
                <option value="0">Nie</option>
            </select>
        </div>
        <div class="form-group">
            <label for="rooms">Liczba pokoi:</label>
            <input type="number" class="form-control" id="rooms" name="rooms" aria-describedby="roomsHelp" value="-1">
            <small class="form-text text-muted" id="roomsHelp">-1 jeśli nie podano lub nie dotyczy</small>
        </div>
        <div class="form-group">
            <label for="floor">Piętro</label>
            <input type="number" class="form-control" id="floor" name="floor" aria-describedby="floorHelp" value="-1">
            <small class="form-text text-muted" id="floorHelp">-1 jeśli nie podano lub nie dotyczy</small>
        </div>
        <div class="form-group">
            <h3>Zdjęcia</h3>
            <div id="photos-container">
                <div class="photo-container">
                    <div class="photo-preview" id="photo-preview-1"></div>
                    <input type="file" name="photo-1" id="photo-1" onchange="fileChangeHandler(event);" accept="image/jpeg">
                </div>
            </div>
            <button class="btn btn-info" onclick="addAnotherPhoto(event);">Dodaj kolejne zdjęcie</button>
        </div>
        <input type="submit" class="btn btn-primary" value="Wyślij">
        </form>';
    return $s;
}

function edit_offer($con, $id) {
    $s = '<h1>Edytor oferty:</h1>';
    $cities_q = mysqli_query($con, 'SELECT * FROM cities');
    $types_q = mysqli_query($con, 'SELECT * FROM typesOfEstates');
    $photos_q = mysqli_query($con, 'SELECT * FROM photos WHERE offerId='.$id);
    $q = 'SELECT offers.title, offers.price, offers.area, cities.name as location, offers.cityId, typesOfEstates.typeName as typeOfEstate, offers.typeOfEstate, offers.typeOfMarket, offers.typeOfTransaction, offers.adress, offers.description, offers.isFurnitured, offers.isFinished, offers.numOfRooms, offers.floor FROM `offers`, cities, typesOfEstates WHERE offers.cityId = cities.cityId AND offers.typeOfEstate = typesOfEstates.typeOfEstateId AND offers.offerId ='.$id;
    $offer_q = mysqli_query($con, $q);
    $cities = [];            
    $types = [];
    $photos = [];
    $offer = mysqli_fetch_assoc($offer_q);

    while($row = mysqli_fetch_array($cities_q)) {
        array_push($cities, $row);
    }
    while($row = mysqli_fetch_array($types_q)) {
        array_push($types, $row);
    }
    while($row = mysqli_fetch_array($photos_q)) {
        array_push($photos, $row);
    }

    $s=$s.'<form action="http://localhost/atm-nieruchomosci/scripts/edit.php?id='.$id.'" method="post">
        <div class="form-group">
            <label for="title">Tytuł</label>
            <input type="checkbox" name="isEditing-title" value="0" id="isEditing-title" onchange="switchInputEnable(event);">
            <input type="text" id="title" class="form-control" name="title" value="'.$offer['title'].'" disabled>
        </div>
        <div class="form-group">
            <label for="price">Cena:</label>
            <input type="checkbox" value="0" name="isEditing-price" id="isEditing-price" onchange="switchInputEnable(event);"> 
            <input type="number" name="price" value="'.$offer['price'].'" id="price" class="form-control" disabled>
        </div>
        <div class="form-group">
            <label for="area">Powierzchnia:</label>
            <input type="checkbox" value="0" name="isEditing-area" id="idEditing-area" onchange="switchInputEnable(event);">
            <input type="number" id="area" name="area" class="form-control" value="'.$offer['area'].'" disabled>
        </div>
        <div class="form-group">
            <label for="cityId">Miasto</label>
            <input type="checkbox" value="0" name="isEditing-cityId" id="isEditing-cityId" onchange="switchInputEnable(event);">
            <select id="cityId" name="cityId" value="'.$offer['cityId'].'" disabled>';
    foreach($cities as $c) {
        $s = $s.'<option value="'.$c[0].'">'.$c[1].'</option>';
    }
    $s = $s.'</select></div>
        <div class="form-group">
            <label for="typeOfEstate">Rodzaj nieruchomości:</label>
            <input type="checkbox" value="0" name="isEditing-typeOfEstate" id="isEditing-typeOfEstate" onChange="switchInputEnable(event);">
            <select id="typeOfEstate" name="typeOfEstate" value="'.$offer['typeOfEstate'].'" disabled>';
        foreach($types as $t) {
            $s = $s.'<option value="'.$t[0].'">'.$t[1].'</option>';
        }
    $s = $s.'</select></div>
        <div class="form-group">
            <label for="typeOfMarket">Rynek:</label>
            <input type="checkbox" value="0" name="isEditing-typeOfMarket" id="isEditing-typeOfMarket" onchange="switchInputEnable(event);">
            <select name="typeOfMarket" id="typeOfMarket" value="'.$offer['typeOfMarket'].'" disabled>
                <option value="0">Pierwotny</option>
                <option value="1">Wtórny</option>
            </select>
        </div>
        <div class="form-group">
            <label for="typeOfTransaction">Rodzaj transakcji</label>
            <input type="checkbox" name="isEditing-typeOfTransaction" id="isEditing-typeOfTransaction" onchange="switchInputEnable(event);">
            <select id="typeOfTransaction" name="typeOfTransaction" value="'.$offer['typeOfTransaction'].'" disabled>
                <option value="0">Wynajem</option>
                <option value="1">Sprzedaż</option>
            </select>
        </div>
        <div class="form-group">
            <label for="adress">Adres</label>
            <input type="checkbox" name="isEditing-adress" id="isEditing-adress" onchange="switchInputEnable(event);">
            <input type="text" value="'.$offer['adress'].'" id="adress" name="adress" class="form-control" disabled>
        </div>
        <div class="form-group">
            <label for="description">Opis</label>
            <input type="checkbox" name="isEditing-description" id="isEditing-description" onchange="switchInputEnable(event);">
            <textarea id="description" name="description" class="form-control" disabled rows="15">'.$offer['description'].'</textarea>
        </div>
        <div class="form-group">
            <label for="isFinished">Wykończone:</label>
            <input type="checkbox" name="isEditing-isFinished" id="isEditing-isFinished" onchange="switchInputEnable(event);">
            <select id="isFinished" name="isFinished" value="'.$offer['isFinished'].'" disabled>
                <option value="0">Nie</option>
                <option value="1">Tak</option>
            </select>
        </div>
        <div class="form-group">
            <label for="isFurnitured">Wykończone:</label>
            <input type="checkbox" name="isEditing-isFurnitured" id="isEditing-isFurnitured" onchange="switchInputEnable(event);">
            <select id="isFurnitured" name="isFurnitured" value="'.$offer['isFurnitured'].'" disabled>
                <option value="0">Nie</option>
                <option value="1">Tak</option>
            </select>
        </div>
        <div class="form-group">
            <label for="numOfRooms">Liczba pokoi:</label>
            <input type="checkbox" value="0" name="isEditing-numOfRooms" id="idEditing-numOfRooms" onchange="switchInputEnable(event);">
            <input type="number" id="numOfRooms" name="numOfRooms" class="form-control" value="'.$offer['numOfRooms'].'" disabled>
        </div>
        <div class="form-group">
            <label for="floor">Piętro:</label>
            <input type="checkbox" value="0" name="isEditing-floor" id="idEditing-floor" onchange="switchInputEnable(event);">
            <input type="number" id="floor" name="floor" class="form-control" value="'.$offer['floor'].'" disabled>
        </div>
        <input type="submit" class="btn btn-primary" value="Zapisz">
    </form>
    <h3>Zdjęcia:</h3>
    <div class="appended-photos-container">';
    foreach($photos as $photo) {
        $s = $s.'<div class="appended-photo-container">
            <img src="http://localhost/atm-nieruchomosci/uploads/'.$photo[0].'.jpg" class="appended-photo">';
        if($photo[2] == 0) {
            $s = $s.'<a href="http://atm-nieruchomosci/scripts/set_as_primary.php?id='.$photo[0].'&offer='.$id.'">
            <button class="btn btn-info">Ustaw jako zdjęcie główne</button></a>';
        }
            
        $s = $s.'<a href="http://localhost/atm-nieruchomosci/scripts/delete_photo.php?id='.$photo[0].'&offer='.$id.'"><button class="btn btn-danger">Usuń</button></a></div>';
    }
    $s = $s.'</div>
    <div class="new-photos">
        <h3>Nowe zdjęcia:</h3>
        <form action="http://localhost/atm-nieruchomosci/scripts/add_photo.php?offer='.$id.'" method="post" enctype="multipart/form-data">
            <div id="photos-container">
                <div class="photo-container">
                    <div class="photo-preview" id="photo-preview-1"></div>
                    <input type="file" name="photo-1" id="photo-1" onchange="fileChangeHandler(event);" accept="image/jpeg">
                </div>
            </div>
            <button class="btn btn-info" onclick="addAnotherPhoto(event);">Dodaj kolejne zdjęcie</button>
            <input type="submit" class="btn btn-primary">
        </form>
    </div>';

    return $s;
}



?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Panel Admina - Atm-nieruchomości</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <p>ATM-nieruchomości - Panel Admina</p>
        <ul>
            <li><a href="http://localhost/atm-nieruchomosci/formularz">Lista ofert</a></li>
            <li><a href="http://localhost/atm-nieruchomosci/formularz/?strona=dodaj">Dodaj ofertę</a></li>
            <li><a href="">Wyloguj</a></li>
        </ul>
    </header>
    <section class="container">
        <?php
            if(isset($_GET['strona'])) {
                switch($_GET['strona']) {
                    case 'lista':
                        echo offer_list($offers_array);
                    break;
                    case 'dodaj':
                        echo add_offer($con);
                    break;
                    case 'edytuj':
                        echo edit_offer($con, $_GET['id']);
                    break;
                    default:
                        echo offer_list($offers_array);
                break;
                }
            }
            else {
                echo offer_list($offers_array);
            }
        ?>
    </section>
</body>
</html>

<script src="script.js"></script>

<?php
    mysqli_close($con);
?>