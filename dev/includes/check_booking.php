<?php
/* CODES ERREURS 
0 : Aucune erreur
1 : Authorisation refus�e
2 : R�servation d�j� accord�e
3 : Autre
*/
include_once('functions.php');

$error = 0;
$message = "";
$player1 = cleanGetVar($_GET["p1"]);
$player2 = cleanGetVar($_GET["p2"]);
$date = cleanGetVar($_GET["d"]);
$hour = cleanGetVar($_GET["h"]);
$court = cleanGetVar($_GET["c"]);
$camera = cleanGetVar($_GET['cam']);

$date = substr($date, 6,10)."-".substr($date,3,2)."-".substr($date, 0,2)." ".$hour.":00";

$db = new db();

//V�rification des droits à r�servation
$checkRights = $db->query("SELECT * FROM PlayerJeu WHERE ID='".$player1."' AND isEnabled='true'","rights");
if (mssql_num_rows($checkRights)>0)
{
	$error = 1;
	$message = "Vous n'avez pas l'autorisation de r�server.";
}
else
{
	//V�rification si r�servations d�jà existantes dans la semaine voulue
	
	$checkBooking = $db->query("SELECT * 
									FROM BookingJeu 
									WHERE (Player1_ID='".$player1."' OR Player2_ID='".$player2."') 
									AND DATEPART(wk,start)=DATEPART(wk,convert(datetime,'".$date."',120))
									ORDER BY start DESC","select");
	//r�servations d�jà existantes dans la semaine
	if (mssql_num_rows($checkBooking)>0)
	{
		$bookDate = mssql_result($checkBooking,0,'start');
		$today = date("d M Y H:i:s");
		//R�servation en attente
		if ($bookDate>$today)
		{
			$error = 2;
			$message = "Vous avez d�j� une r�servation cette semaine.";
		}
		//R�servation possible
		else
		{
			$error = 0;
			$message = "Op�ration valide";
		}
	}
}

if ($error==0)
{
	$db->query('INSERT INTO BookingJeu (name,isSpecial,start,[end],creationDate,Court_ID,Player1_ID,Player2_ID,Filmed) 
				VALUES ("Perso","False",convert(datetime,"'.$date.'",120),"",getutcdate(),'.$court.','.$player1.','.$player2.',"'.$camera.'")','insert');	
	$message = $message."<br>Requ�te �x�cut�e";

	$query = $db->query('SELECT * FROM BookingJeu',"select");
}

echo utf8_encode($error);