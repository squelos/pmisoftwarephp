<?php

include_once('functions.php');

$error=0;
$player1 = cleanGetVar($_GET["p1"]);
$player2 = cleanGetVar($_GET["p2"]);
$date = cleanGetVar($_GET["d"]);
$hour = cleanGetVar($_GET["h"]);
$court = cleanGetVar($_GET["c"]);

$db = new db();

//Vérification des droits à réservation
$checkRights = $db->query("SELECT * FROM PlayerJeu WHERE ID='".$player1."' AND isEnabled='true'");
if (mssql_num_rows($checkRights)>0)
{
	$error = 1;
	$message = "Vous n'avez pas l'autorisation de réserver.";
}
else
{
	//Vérification si réservations déjà existantes dans la semain voulue
	$checkBooking = $db->query("SELECT * 
									FROM BookingJeu 
									WHERE Court_ID='".$court."' 
									AND (Player1_ID='".$player1."' OR Player2_ID='".$player2."') 
									AND WEEK(start)=WEEK(CAST(".$date." ".$hour.") AS DATETIME)
									ORDER BY start DESC");
	//réservations déjà existantes dans la semaine
	if (mssql_num_rows($checkBooking)>0)
	{
		$bookDate = mssql_result($checkBooking,0,'start');
		$today = date("d M Y H:i:s");
		//Réservation en attente
		if ($bookDate>$today)
		{
			$error = 1;
			$message = "Vous avez déjà une réservation cette semaine.";
		}
		//Réservation possible
		else
		{
			$error = 0;
			$message = "Opération valide";
		}
	}
}

if ($error==0)
{
	$db->query('INSERT INTO BookingJeu (ID,name,isSpecial,start,[end],creationDate,BookingAggregation_ID,Court_ID,Player1_ID,Player2_ID) 
				VALUES ("","Perso","False","'.$date.' '.$hour.',"",TODAY(),"","'.$court.'","'.$player1.'","'.$player2.'")');
}

echo utf8_encode($message);