<?php
include_once('includes/functions.php');


if (isset($_GET['uid']) && isset($_GET['key'])) {
	include('includes/profile_pwdcreate.php');
} elseif (isset($_GET['uid']) && isset($_GET['key']) && $_GET['p']=="pwdreset") {
	include('includes/profile_pwdcreate.php');
}elseif ($_GET['p']=="pwdset"){
	include('includes/profile_bddpwdset.php');
}elseif ($_GET['p']=="pwdreset"){
	include('includes/profile_pwdreset.php');
}




//(isset($_SESSION['isConnected']) === true ? '' : die('accès non autorisé'));
/*(isset($_GET['p']) === true ? '' : die('accès direct interdit'));
$pageDemandee = cleanGetVar($_GET['p']);
if($pageDemandee=='index'){
	include('includes/profile_index.php');
}
elseif($pageDemandee=='newsletter'){
	include('includes/admin_newsletter.php');
}
else{
die('bien tenté');
}*/
?>