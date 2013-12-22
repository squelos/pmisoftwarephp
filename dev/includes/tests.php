<?php

include_once('functions.php');
$db = new db();

/*$query = $db->query('SELECT * FROM BookingJeu',"select");
while ($result = mssql_fetch_array($query)) {
	echo $result['Player1_ID'].'/'.$result['Player2_ID'].'/date : '.$result['start'].'<br>';
}*/

$query = $db->query('DELETE FROM BookingJeu WHERE Player1_ID=1 AND Player2_ID=94',"select");

