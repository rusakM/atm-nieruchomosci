<?php
    if(!isset($_POST['password'])) {
        header('Location: http://localhost/atm-nieruchomosci');
    }

    require_once('../assets/connect.php');
    $con = mysqli_connect($host, $usr, $pass, $db);

    $q = mysqli_query($con, 'SELECT pass FROM user');
    $pass = mysqli_fetch_array($q)[0];
    mysqli_close($con);
    if($_POST['password'] === $pass) {
        session_start();
        $_SESSION['login'] = 1;
        header('Location: http://localhost/atm-nieruchomosci/formularz');
    }
    else {
        header('Location: http://localhost/atm-nieruchomosci/formularz/login');
    }
?>