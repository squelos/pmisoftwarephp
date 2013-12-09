<?php

include_once('functions.php');

$player1 = cleanGetVar($_GET["p1"]);
$player2 = cleanGetVar($_GET["p2"]);
$date = cleanGetVar($_GET["d"]);
$hour = cleanGetVar($_GET["h"]);
$court = cleanGetVar($_GET["c"]);

//Vérification des droits à réservation
$checkRights = mssql_query("SELECT * FROM dbo.PlayerJeu WHERE ID='".$player1."' AND isEnabled");
if (mssql_num_rows($checkRights)>0)
{
	$error = 1;
	$message = "Vous n'avez pas l'autorisation de réserver";
}

//Vérification si réservations déjà existantes dans la semain voulue
$checkBooking = mssql_query("SELECT * 
								FROM dbo.BookingJeu 
								WHERE Court_ID='".$court."' 
								AND (Player1=='".$player1."' OR Player2=='".$player2."') 
								AND");
