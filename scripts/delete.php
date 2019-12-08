<?php
    require_once('../assets/connect.php');
    $con = mysqli_connect($host, $usr, $pass, $db);
    $location = $_SERVER['DOCUMENT_ROOT'].'/atm-nieruchomosci/uploads';
    if(isset($_GET['id'])) {
        $offer_photos_q = 'SELECT photoId FROM photos WHERE offerId='.$_GET['id'];
        $offer_photos = mysqli_query($con, $offer_photos_q);
        
        while($row = mysqli_fetch_array($offer_photos)[0]) {
            unlink("$location/$row.jpg");
        }
        mysqli_query($con, 'DELETE FROM photos WHERE offerId = '.$_GET['id']);
        mysqli_query($con, 'DELETE FROM offers WHERE offerId = '.$_GET['id']);
    }

    mysqli_close($con);
    header('Location: http://localhost/atm-nieruchomosci/formularz');
?>