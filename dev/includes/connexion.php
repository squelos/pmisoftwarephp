<?php
include('functions.php');

//On initialise la variable qui va renvoyer une réponse au JS
$returnvalues= array();


//On check si il ya  une demande de déconnexion
$demandeDeconnexion = (isset($_GET['deconnect']) === true ? true : false); 

//Soit on connecte soit on déconnecte
if ($demandeDeconnexion===true){
	deconnect();
}
else{
	connect(cleanGetVar($_POST['mail']), cleanGetVar($_POST['pass']));
}


/**
* Description de la fonction connect.
*
* @author     	Fred
* @Modified by	
* @version    	1.0
* @date  	  	26/11/2013
* @Description  Register les sessions 'isConnected' et 'id' si 
*				connexion réussie
* @return		rien
*
*/
function connect($login, $mdp)
{
	global $returnvalues;
	//temporaire juste pour tester
	$bdd = new db();
	$results = $bdd->getPwdHashAndSalt($login);
	while ($row = mssql_fetch_array($results)) {
		$salt = $row['salt'];
		$hash = $row['passwordHash'];
		$uid  = $row['ID'];
	}
	if(isset($salt))//Retir� && isset($hash)
	{
		$pwd = hash ( "sha256" , $mdp . $salt);//on sale
		
		if($pwd==$hash) //Si ce que l'utilisateur a tap� est = � ce qu'il y a en BDD une fois sal�.
		{
			$_SESSION['isConnected'] = true;
			$_SESSION['id'] = $uid;
			$bdd3= new db();//On prends le statut de l'utilisateur
			$statusandNameResults = $bdd3->getStatusandName($uid);
			$_SESSION['status'] =  $statusandNameResults['statusName'];
			$_SESSION['pnNom'] = $statusandNameResults['firstName'] . ' ' . $statusandNameResults['lastName'];
			$returnvalues['etatconnexion'] = "succes";
			$bdd = new db();
			$bdd->updateLastLogin($uid);//On met � jour lastLogin
		}
		else{
			$returnvalues['etatconnexion'] = "erreur";
		}
	}
	else{
		$returnvalues['etatconnexion'] = "erreur2";
	}
}


/**
* Description de la fonction deconnect.
*
* @author     	Fred
* @Modified by	
* @version    	1.0
* @date  	  	26/11/2013
* @Description  Unregister les sessions 'isConnected' et 'id'  
* @return		rien
*
*/
function deconnect()
{
	global $returnvalues;
	session_unset();
	$returnvalues['etatconnexion'] = "deconnecte";
	header('Location: ../index.php');
}
//$returnvalues['etatconnexion'] = "erreur";
//On émet le JASON
echo json_encode($returnvalues);
?>