<?php
include('db.php');
 session_start();

/**
* Description de la fonction cleanGetVar.
*
* @author     	Fred
* @version    	1.0
* @date  	  	26/11/2013
* @Description  Nettoie les variables qu'on reçois en GET 
*				et en POST || A vérifier / améliorer
* @return		La variable nettoyée
*
*/ 
 function cleanGetVar($inputVar)
 {
   //$inputVar = mysql_real_escape_string($inputVar); //Obsolète a partir de php 5.5.0
   $inputVar = htmlspecialchars($inputVar, ENT_IGNORE, 'utf-8');
   $inputVar = strip_tags($inputVar);
   $inputVar = stripslashes($inputVar);
   return $inputVar; //enfait la c'est outputVar, mais bon on fais du PHP...
 }


?>