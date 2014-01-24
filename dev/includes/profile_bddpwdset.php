<?php
include_once('functions.php');
$uid = cleanGetVar($_POST['uid']);
$key = cleanGetVar($_POST['key']);
$pwd = cleanGetVar($_POST['pwd']);
$bdd = new db();
if($bdd->validateUidWithKey($uid, $key)){// On vérifie que le $key est bon
	$saltbdd =  new db();
	$salt = $saltbdd->getSalt($uid);//on recupere le salt pour saler le MDP
	$pwd = hash ( "sha256" , $pwd . $salt);//on sale
	$bdd2 = new db();
	$bdd2->setPwd($uid, $pwd);//Et on insère
	$bdd = new db();
	$bdd->razPwdReset($uid);//On vide les champs qui permettent de redéfinir le MDP.
	$bdd = new db();
	$bdd->updateLastLogin($uid);//On met à jour lastLogin
	$bdd3= new db();//On prends le statut de l'utilisateur
	$statusandNameResults = $bdd3->getStatusandName($uid);
	$_SESSION['status'] =  $statusandNameResults['statusName'];
	$_SESSION['pnNom'] = $statusandNameResults['firstName'] . ' ' . $statusandNameResults['lastName'];
	$_SESSION['isConnected'] = true;//Finalement on logue l'utilisateur
	$_SESSION['id'] = $uid;
	echo "success";
}
else {
	echo "failed";
}
