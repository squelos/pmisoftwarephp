<?php
class db{
	private $link='';
	
	function db(){
		$servername 	= '10.154.122.156';
		$username 		= 'tcpAdmin';
		$password  		= 'TCPJambon54';
		
		$link=mssql_connect (  $servername ,  $username, $password );
		if (!$link || !mssql_select_db('TCP_DB', $link)) {
			die('Impossible de se connecter à la base!');
		}
		
		// Exécution d'une requête simple, pour obtenir la
		// version de MSSQL et l'afficher.

		
	}
	
	public function query($sttm){
		$version = mssql_query($sttm);
		return $version;
		mssql_free_result($version);
	}
	
	
	function select($champ, $table, $cond){
		
	}
	
	
	
	
	
	public function listeBadgeActive(){
		$resultats = $this->query('	SELECT number
						FROM BadgeJeu
						WHERE isEnabled=1');
		$rtrnArray[]='';
		while ($row = mssql_fetch_array($resultats)) {
			if($row['number']!='')
			$rtrnArray[]=$row['number'];
		}
		return $rtrnArray;
	}

	public function listPlayers(){
		$resultats = $this->query('SELECT * 
						FROM PlayerJeu
						ORDER BY lastName ASC');
		return $resultats;
	}

	public function searchPlayers($search)
	{
		$resultats = $this->query('SELECT *
						FROM PlayerJeu
						WHERE firstName LIKE "%'.$search.'%"
						OR lastName LIKE "%'.$search.'%"');
		return $resultats;
	}
	
}