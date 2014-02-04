<?php
@session_start();
include('functions.php');

$action = cleanGetVar($_GET['action']);

if ($action=="listplayer")
{
	$search = cleanGetVar($_GET['search']);

	$db = new db();
	$query = $db->query("SELECT * 
						FROM PlayerJeu 
						WHERE (lastName+' '+firstName LIKE '%".$search."%'
												OR firstName+' '+lastName LIKE '%".$search."%')
						AND Subscribed=1
						ORDER BY lastName","list players");

	$return = "";
	while ($result=mssql_fetch_array($query))
	{
		$return = $return.'<a href="#" style="width:95%;"class="list" id="play-'.$result['ID'].'-1" onclick="addTo(this);">
            			<div class="list-content" >'.$result['lastName'].' '.$result['firstName'].'</div>
            		</a>';
	}
	
	echo $return;
}

if ($action=="listcateg")
{
	$db = new db();
	$query = $db->query("SELECT * 
						FROM CategorySet ","category list");

	$return = "";
	while ($result=mssql_fetch_array($query))
	{
		$queryNbCateg = $db->query("SELECT COUNT(Player_ID) AS nbCateg 
									FROM PlayerCategory 
									WHERE Category_Id=".$result['Id']."
									AND Player_ID NOT IN (SELECT ID FROM PlayerJeu WHERE Subscribed=0 OR Subscribed=NULL)","nbCateg");
		$nbCateg = mssql_result($queryNbCateg, 0, "nbCateg");
		$return = $return.'<a href="#" style="width:95%;"class="list" id="categ-'.$result['Id'].'-'.$nbCateg.'" onclick="addTo(this);">
            			<div class="list-content" >'.$result['categoryName'].'</div>
            		</a>';
	}
	
	echo $return;
}

if ($action =="playerFromCateg")
{
	$db = new db();
	$query = $db->query("SELECT Player_ID 
						FROM PlayerCategory 
						WHERE Category_Id=".cleanGetVar($_GET['categ'])."
						AND Player_ID NOT IN (SELECT ID FROM PlayerJeu WHERE Subscribed=0)",'player from categ');
	
	while ($result=mssql_fetch_array($query))
	{
		$back[] = array(
			'idPlayer'=>$result['Player_ID']);
	}

	echo json_encode($back);
}

if ($action=="sendmail")
{
	$message = $_GET['m'];
	$to = $_GET['to'];

	$subject = "Newsletter TCP - ".$date('d/m/Y');
	$db = new db();
	$query = $db->query("SELECT email FROM PlayerJeu WHERE ID=".$to,"get mail address");
	$mail = mssql_result($query, 0, 'email');

	$message = $message."<br><br><br><p><font size='2'>Afin de vous désabonner de cette newsletter merci de suivre ce <a href='#'>lien</a></font>";
	
	sendMail($to,$subject,$message);
}