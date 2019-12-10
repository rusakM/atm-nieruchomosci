<?php
    require_once('../assets/connect.php');
    $con = mysqli_connect($host, $usr, $pass, $db);

    if(isset($_GET['offer']) && isset($_GET['id'])) {
        if(mysqli_query($con, 'UPDATE photos SET isPrimary=0 WHERE offerId = '.$_GET['offer'])) {
            mysqli_query($con, 'UPDATE photos SET isPrimary=1 WHERE photoId='.$_GET['id']);
            mysqli_close($con);
            header('Location: http://localhost/atm-nieruchomosci/formularz/?strona=edytuj&id='.$_GET['offer']);
        }
    }
    else if(!isset($_GET['id']) && isset($_GET['offer'])) {
        mysqli_close($con);
        header('Location: http://localhost/atm-nieruchomosci/formularz/?strona=edytuj&id='.$_GET['offer']);
    }
    else {
        mysqli_close($con);
        header('Location: http://localhost/atm-nieruchomosci/formularz');
    }
?>