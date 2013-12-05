<?php
include_once('includes/functions.php');

//TODO : ajouter isAdmin dans ce if
(isset($_SESSION['isConnected']) === true ? '' : die('accès non autorisé'));
(isset($_GET['p']) === true ? '' : die('accès direct interdit'));
$pageDemandee = cleanGetVar($_GET['p']);
if($pageDemandee=='fields'){
    include('includes/booking_fields.php');
}
elseif($pageDemandee=='calendar'){
    include('includes/booking_calendar.php');
}
else{
die('bien tenté');
}
?>

