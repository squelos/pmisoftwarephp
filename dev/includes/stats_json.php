<?php
@session_start();
include_once('functions.php');

	$db = new db();
	//Niveau de ball
	$query = $db->query("SELECT COUNT(ID) AS NB, BallLevel_ID
						FROM PlayerJeu
						WHERE isEnabled='true'
						GROUP BY BallLevel_ID","Stats ball level");

	$balllevel = 'var data = google.visualization.arrayToDataTable([
				 ["Niveau", "Nombre"],';
	while ($result=mssql_fetch_array($query))
	{
		$ballName = $db->query("SELECT ballName FROM BallLevelSet WHERE Id=".$result['BallLevel_ID'],"Ball name");
		$name = mssql_result($ballName, 0, "ballName");

		$balllevel.='["'.$name.'",'.$result['NB'].'],';
	}

	$balllevel.=']);';

	//Catégories
	$query = $db->query("SELECT COUNT(Player_ID) AS NB, Category_ID
						FROM PlayerCategory
						GROUP BY Category_ID ","Stats category");
	$category = 'var data=google.visualization.arrayToDataTable([
				["Catégorie","Nombre"],';
	while ($result=mssql_fetch_array($query))
	{
		$categoryName = $db->query("SELECT categoryName FROM CategorySet WHERE Id=".$result['Category_ID'],"Category name");
		$name = mssql_result($categoryName, 0, "categoryName");

		$category .= '["'.$name.'",'.$result['NB'].'],';
	}
	$category.=']);';

	//SEXE
	$query = $db->query("SELECT COUNT(ID) AS NB, sex
						FROM PlayerJeu
						WHERE isEnabled='true'
						GROUP BY sex ","Stats category");
	$sexe = 'var data=google.visualization.arrayToDataTable([
				["Sexe","Nombre"],';
	while ($result=mssql_fetch_array($query))
	{
		if($result['sex']==1)
		{
			$sexeName = "Femmes";
		}
		elseif ($result['sex']==0)
		{
			$sexeName = "Hommes";
		}
		else
		{
			$sexeName = "Inconnu";
		}

		$sexe .= '["'.$sexeName.'",'.$result['NB'].'],';
	}
	$sexe.=']);';

	//ORIGINE
	$query = $db->query("SELECT COUNT(ID) AS NB
						FROM PlayerJeu
						WHERE zipCode=54210
						AND isEnabled='true'
						AND UPPER(city) LIKE '%NICOLAS%'","origin players");
	$originStNic = mssql_result($query, 0, 'NB');

	$query = $db->query("SELECT COUNT(ID) AS NB 
						FROM PlayerJeu","nb players");
	$nbPlayer = mssql_result($query, 0, 'NB');

	$originOther = $nbPlayer-$originStNic;

	$origin = 'var data=google.visualization.arrayToDataTable([
				["Origine","Nombre"],["St Nicolas",'.$originStNic.'],["Autres",'.$originOther.']]);';


	//TERRAIN PAR CATEGORIE
	$queryCateg = $db->query("SELECT * FROM CategorySet",'liste category');

	 $fieldByCateg = "var data = google.visualization.arrayToDataTable([
        ['Terrain', 'Terrain 1', 'Terrain 2', 'Terrain 3',{ role: 'annotation' } ],";

	while ($resultCateg = mssql_fetch_array($queryCateg))
	{
		$queryPlayer = $db->query("SELECT * FROM PlayerCategory WHERE Category_Id=".$resultCateg['Id'],'liste player categ');

		$proc = mssql_init("mostBookedCourtsForPlayerCategory");
		mssql_bind($proc, "@Category_Id", $resultCateg['Id'],  SQLINT1);

		$query = mssql_execute($proc);

		$fieldByCateg .= "['".$resultCateg['categoryName']."',";

		//$nb  = mssql_result($query, 0, 'NB');
		$nb=0;
		if (mssql_result($query, 0, 'NB')) $nb=mssql_result($query, 0, 'NB');
		$fieldByCateg .= $nb.",";

		//$nb  = mssql_result($query, 1, 'NB');
		$nb=0;
		if (mssql_result($query, 1, 'NB')) $nb=mssql_result($query, 1, 'NB');
		$fieldByCateg .= $nb.",";

		//$nb  = mssql_result($query, 2, 'NB');
		$nb=0;
		if (@mssql_result($query, 2, 'NB')) $nb=@mssql_result($query, 2, 'NB');
		$fieldByCateg .= $nb.",";

		/*while ($result = mssql_fetch_array($query))
		{
			$fieldByCateg .= $result['NB'].",";
		}*/

		$fieldByCateg .= "''],";
		
	}

	$fieldByCateg .= "]);";
?>
