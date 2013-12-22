<?php
include_once("functions.php");

$action = $_GET['action'];

$db = new db();

if ($action=="start")
{
	$id = $_GET['i'];
	$start = $_GET['s'];
	$end = $_GET['e'];

	$idBook = split('-', $id);

	$db->query('UPDATE BookingJeu SET start="'.$start.'", [end]="'.$end.'" WHERE ID='.$idBook[0],'update start');

	echo utf8_encode("Mise à jour effectuée");
}

if ($action=="delete")
{
	$id = $_GET['id'];

	$idBook = split('-', $id);

	$db->query("DELETE FROM BookingJeu WHERE ID=".$idBook[0],'delete event');
}

if ($action=="update")
{
	$id = $_GET['id'];
	$idBook = split('-', $id);

	$player1 = $idBook[1];
	$player2 = $idBook[2];
	$date = cleanGetVar($_GET["d"]);
	$hour = cleanGetVar($_GET["h"]);
	$court = cleanGetVar($_GET["c"]);
	$camera = cleanGetVar($_GET['cam']);

	$date = substr($date, 6,10)."-".substr($date,3,2)."-".substr($date, 0,2)." ".$hour.":00";

	$db->query("UPDATE BookingJeu SET start='".$date."',Player1_ID='".$player1."', Player2_ID='".$player2."',Filmed='".$camera."' WHERE ID=".$idBook[0],'update event');
}