<?php
require_once('../assets/connect.php');
$con = mysqli_connect($host, $usr, $pass, $db);

if(!isset($_GET['id'])) {
    header('Location: http://localhost/atm-nieruchomosci/formularz');
}

$fields = [];

$q_fields = mysqli_query($con, 'SHOW COLUMNS FROM offers');


while($r = mysqli_fetch_assoc($q_fields)) {
    array_push($fields, $r['Field']);
}

foreach($_POST as $key => $val) {
    if(in_array($key, $fields)) {

        if($key === 'title' || $key === 'adress' || $key === 'description') {
            $val = '"'.$val.'"';
        }
       mysqli_query($con, 'UPDATE offers SET '.$key.' = '.$val.' WHERE offerId='.$_GET['id']);
    }
}

mysqli_close($con);

header('Location: http://localhost/atm-nieruchomosci/formularz/?strona=edytuj&id='.$_GET['id']);

?>