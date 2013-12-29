<?php

include_once('functions.php');
$db = new db();


/*$query = $db->query('SELECT * FROM BookingJeu',"select");
while ($result = mssql_fetch_array($query)) {
	echo $result['Player1_ID'].'/'.$result['Player2_ID'].'/date : '.$result['name'].'<br>';
}*/
//$query = $db->query('DELETE FROM BookingJeu WHERE Player1_ID=1 AND Player2_ID=94',"select");

/*$query = $db->query('SELECT * FROM StatusSet',"select");
while ($result = mssql_fetch_array($query)) {
	echo $result['statusName']."<br>";
}*/

/*$query = $db->query('SELECT * FROM PlayerJeu WHERE ID=1',"select");
while ($result = mssql_fetch_array($query)) {
	echo $result['ID']."<br>";
}*/
/*
$query = $db->query('SELECT statusName,PlayerJeu.ID FROM StatusSet,PlayerJeu WHERE StatusSet.Id=PlayerJeu.Status_Id','droits admin');
while ($result = mssql_fetch_array($query)) {
	echo $result['ID']."------------".$result['statusName']."<br>";
}
*/

//$db->query("UPDATE PlayerJeu SET Status_Id=3 WHERE ID=1",'bite');

/*$query = $db->query("SELECT Id FROM StatusSet WHERE statusName='Administrateur'",'bite');
while ($result = mssql_fetch_assoc($query))
{
	echo $result['Id'];
}*/
/*
$db->query("INSERT INTO BookingAggregationJeu (name) VALUES ('test')","insert Aggreg");
$result = mssql_fetch_assoc($db->query("SELECT @@IDENTITY AS id","get last id"));
echo $result['id'];*/

/*
$db->query("DELETE FROM BookingAggregationJeu WHERE name='test'","delete aggreg");*/

