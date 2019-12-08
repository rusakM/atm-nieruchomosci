<?php
    require_once('../assets/connect.php');
    $con = mysqli_connect($host, $usr, $pass, $db);

    $date = date("Y/m/d H:i", time());
    $img_location = $_SERVER['DOCUMENT_ROOT'].'/atm-nieruchomosci/uploads';

    $q_offers = 'INSERT INTO offers (offerId, title, price, area, cityId, typeOfEstate, typeOfMarket, typeOfTransaction, adress, description, insertionDate, isFurnitured, isFinished, numOfRooms, floor) VALUES (NULL, "'.$_POST['title'].'", '.$_POST['price'].', '.$_POST['area'].', '.$_POST['city'].', '.$_POST['property-type'].', '.$_POST['market-type'].', '.$_POST['transaction-type'].', "'.$_POST['adress'].'", "'.$_POST['description'].'", "'.$date.'", '.$_POST['isFinished'].', '.$_POST['isFurnitured'].', '.$_POST['rooms'].', '.$_POST['floor'].')';

    if(mysqli_query($con, $q_offers)) {
        $offer_id = mysqli_insert_id($con);
        if(count($_FILES) > 0) {
            foreach($_FILES as $k => $f) {
                if($f['error'] === 0) {
                    if($k === 'photo-1') {
                        $isPrimary = 1;
                    }
                    else {
                        $isPrimary = 0;
                    }
                    $photo_q = 'INSERT INTO photos (photoId, offerId, isPrimary) VALUES (NULL, '.$offer_id.', '.$isPrimary.')';

                    if(mysqli_query($con, $photo_q)) {
                        $photoId = mysqli_insert_id($con);

                        $image = imagecreatefromjpeg($f['tmp_name']);
                        if(imagesx($image) > 1920) {
                            $image = imagescale($image);
                        }

                        imagejpeg($image, $img_location.'/'.$photoId.'.jpg', 80);

                        imagedestroy($image);
                    }
                }
            }
        }
    }

    mysqli_close($con);
    header('Location: http://localhost/atm-nieruchomosci/formularz');
?>