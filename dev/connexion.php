<?php
include('functions.php');


//On check si il ya  une demande de déconnexion
$demandeDeconnexion = (isset($_GET['deconnect']) === true ? true : false); 

//Soit on connecte soit on déconnecte
if ($demandeDeconnexion===true){
	deconnect();
}
else{
	connect(cleanGetVar($_POST['mail']), cleanGetVar($_POST['mdp']));
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
	//temporaire juste pour tester
	if($login=='test' AND $mdp=='test')
	{

		$_SESSION['isConnected'] = true;
		$_SESSION['id'] = 1;
		header('Location: index.php');
	}
	else{
		header('Location: index.php?loginerror=true');
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
	session_unset();
	header('Location: index.php');
}

?>