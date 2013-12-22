<?php

include_once('functions.php');

$db = new db();

$court = $_GET['c'];
$query = $db->query("SELECT BookingJeu.ID,BookingJeu.Player1_ID,BookingJeu.Player2_ID,start,[end],playerjeu1.lastName AS player1, playerjeu2.lastName AS player2
				FROM BookingJeu
				INNER JOIN PlayerJeu AS playerjeu1
				ON BookingJeu.Player1_ID = playerjeu1.ID 
				INNER JOIN PlayerJeu AS playerjeu2
				ON BookingJeu.Player2_ID = playerjeu2.ID
				WHERE Court_ID='".$court."'","Liste books");

$i=0;

while($result=mssql_fetch_array($query))
{	
	$start = date("Y-m-d H:i:s",strtotime($result['start']));

	$end = date_create($start);
	date_add($end,date_interval_create_from_date_string('1 hours'));
	$end = date_format($end,'Y-m-d H:i:s');

	if(($_SESSION['id']==$result['Player2_ID'])||($_SESSION['id']==$result['Player1_ID']))
	{
		$editable = true;
		$draggable = true;
	}
	else
	{
		$editable = false;
		$draggable = false;
	}

	$back[] = array(
		'id' => $result['ID'].'-'.$result['Player1_ID'].'-'.$result['Player2_ID'],
		'title' => $result['player1']." vs ".$result['player2'],
		'start' => $start,
		'end' => $end,
		'allDay' => false,
		//'editable' => $editable,
		'startEditable' => $draggable
		//'eventStartEditable' => $editable
		//'eventDurationEditable' => $editable
		);
}

echo json_encode($back);