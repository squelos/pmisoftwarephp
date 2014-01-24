<?php
@session_start();
include('functions.php');

$action = cleanGetVar($_GET['action']);

if ($action=="addnews")
{
	$db = new db();

	$title = cleanGetVar($_GET['title']);
	$message = $_GET['message'];
	$online = $_GET['online'];

	$db->query("INSERT INTO NewsSet (Title,[Content],PublishDate,Visibility) VALUES ('".$title."','".$message."',getutcdate(),'".$online."')","insert news");
}

if ($action=="listnews")
{
	$return = "";
	$db = new db();

	$query = $db->query("SELECT * FROM NewsSet ORDER BY PublishDate DESC","list news");

	while ($result = mssql_fetch_array($query))
	{
		$date = new DateTime($result['PublishDate']);
		$date = $date->format('d/m/Y H:i:s');
		$return .= '<div class="example"><div style="float:left;"><h2>'.$result['Title'].'</h2></div><div style="float:right;"><a href="#" onclick="deleteNews('.$result['Id'].');"><i class="icon-cancel-2 fg-red "></i></a></div><div style="float:right;">'.$date.'&nbsp&nbsp</div><div style="clear:both"></div><div style="width:100%;">'.$result['Content'].'</div></div></div>';
	}

	echo utf8_encode($return);
}

if ($action=="deletenews")
{
	$db = new db();
	$id = cleanGetVar($_GET['id']);
	$db->query('DELETE FROM NewsSet WHERE Id='.$id,'delete news');
	echo 'ok';
}
?>