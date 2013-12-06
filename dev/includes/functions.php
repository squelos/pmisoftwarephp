<?php
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
$servername 	= '10.154.122.156';
$username 		= 'tcpAdmin';
$password  		= 'TCPJambon54';

$link=mssql_connect (  $servername ,  $username, $password );
if (!$link || !mssql_select_db('TCP_DB', $link)) {
    die('Impossible de se connecter à la base!');
}

// Exécution d'une requête simple, pour obtenir la 
// version de MSSQL et l'afficher.
$version = mssql_query('SELECT * FROM dbo.PlayerJeu WHERE firstName LIKE "Olivier"');
    while ($row = mssql_fetch_array($version, MSSQL_NUM)) {
        print_r($row);
    }

// Netoyage
mssql_free_result($version);
/*
 require  'medoo.min.php';
 
$database = new medoo([
	// required
	'database_type' => 'odbc',
	'database_name' => 'TCP_DB',
	'server' => '109.190.19.113',
	'username' => 'tcpAdmin',
	'password' => 'TCPJambon54',
	'port' => 1443,
	// optional
	'charset' => 'utf8',
	'option' => [
		PDO::ATTR_CASE => PDO::CASE_NATURAL
	]
	// driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
]);
 */


?>