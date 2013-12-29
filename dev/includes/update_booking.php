<?php
include_once("functions.php");

$action = $_GET['action'];

$db = new db();

if ($action=="start")
{
	$id = $_GET['i'];
	$start = $_GET['s'];
	$end = $_GET['e'];
	$type = $_GET['type'];

	$idBook = split('-', $id);


	if ($type=="unique")
	{
		$db->query('UPDATE BookingJeu SET start="'.$start.'", [end]="'.$end.'" WHERE ID='.$idBook[0],'update start');
	}
	else
	{
		$query = $db->query("SELECT ID FROM BookingJeu WHERE BookingAggregation_ID=".$idBook[4],'get aggreg list');

		$start = new DateTime($start);

		while ($result = mssql_fetch_array($query)) {
			$db->query("UPDATE BookingJeu SET start=convert(datetime,'".$start->format('Y-m-d H:i:s') ."',120) WHERE ID=".$result['ID'],'update start aggreg');
			$start->add(new DateInterval('P7D'));
		}
	}

	echo utf8_encode("Mise à  jour effectuée");
}

if ($action=="delete")
{
	$id = cleanGetVar($_GET['id']);
	$type = cleanGetVar($_GET['type']);

	$idBook = split('-', $id);

	if ($type=='unique')
	{
		$db->query("DELETE FROM BookingJeu WHERE ID=".$idBook[0],'delete event');
	}
	elseif ($type=="all")
	{
		$db->query("DELETE FROM BookingJeu WHERE BookingAggregation_ID=".$idBook[4],'delete aggreg events');
		$db->query("DELETE FROM BookingAggregationJeu WHERE ID=".$idBook[4],'delete Aggreg');
	}
	echo utf8_encode("Suppression effectuée.");
}

if ($action=="update")
{
	$id = $_GET['id'];
	$idBook = split('-', $id);

	$player1 = cleanGetVar($_GET['p1']);
	$player2 = cleanGetVar($_GET['p2']);
	$date = cleanGetVar($_GET["d"]);
	$hour = cleanGetVar($_GET["h"]);
	$court = cleanGetVar($_GET["c"]);
	$camera = cleanGetVar($_GET['cam']);

	$date = substr($date, 6,10)."-".substr($date,3,2)."-".substr($date, 0,2)." ".$hour.":00";

	$db->query("UPDATE BookingJeu SET start='".$date."',Player1_ID='".$player1."', Player2_ID='".$player2."',Filmed='".$camera."' WHERE ID=".$idBook[0],'update event');

	echo utf8_encode('Mise à jour effectuée.');
}