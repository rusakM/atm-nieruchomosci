<?php
    require_once('../assets/connect.php');
    $con = mysqli_connect($host, $usr, $pass, $db);

    $location = $_SERVER['DOCUMENT_ROOT'].'/atm-nieruchomosci/uploads';

    if(isset($_GET['offer']) && isset($_GET['id'])) {
        if(mysqli_query($con, 'DELETE FROM photos WHERE photoId='.$_GET['id'])) {
            $id = $_GET['id'];
            unlink("$location/$id.jpg");
        }
        mysqli_close($con);
        header('Location: http://localhost/atm-nieruchomosci/formularz/?strona=edytuj&id='.$_GET['offer']);
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