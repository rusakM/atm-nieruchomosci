<?php
    require_once('../assets/connect.php');
    $con = mysqli_connect($host, $usr, $pass, $db);

    $img_location = $_SERVER['DOCUMENT_ROOT'].'/uploads';

    if(!isset($_GET['id'])) {
        header('Location: http://nieruchomosciatm.pl/formularz');
    }


    if(count($_FILES) > 0) {
        foreach($_FILES as $k => $p) {
            if($p['error'] === 0) {
                if(mysqli_query($con, 'INSERT INTO photos (photoId, offerId, isPrimary) VALUES (NULL, '.$_GET['id'].', 0)')) {
                    $photoId = mysqli_insert_id($con);
                    $image = imagecreatefromjpeg($p['tmp_name']);

                    if(imagesx($image) > 1920) {
                        $image = imagescale($image);
                    }

                    imagejpeg($image, $img_location.'/'.$photoId.'.jpg', 80);

                    imagedestroy($image);
                }
            }
        }
    }

    mysqli_close($con);
    header('Location: http://nieruchomosciatm.pl/formularz/?strona=edytuj&id='.$_GET['id']);
    
?>