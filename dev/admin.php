<?php
include_once('includes/functions.php');

//TODO : ajouter isAdmin dans ce if
(isset($_SESSION['isConnected']) === true ? '' : die('acc�s non autoris�'));
(isset($_GET['p']) === true ? '' : die('acc�s direct interdit'));
$pageDemandee = cleanGetVar($_GET['p']);
if($pageDemandee=='planning'){
	include('includes/admin_planning.php');
}
elseif($pageDemandee=='newsletter'){
	include('includes/admin_newsletter.php');
}
else{
die('bien tent�');
}
?>