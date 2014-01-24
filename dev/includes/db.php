<?php
class db{
	private $link='';
	
	function db(){
		$servername 	= '10.154.122.156';
		$username 		= 'tcpAdmin';
		$password  		= 'TCPJambon54';
		
		$link=mssql_connect (  $servername ,  $username, $password );
		if (!$link || !mssql_select_db('TCP_DB', $link)) {
			die('Impossible de se connecter Ã  la base!');
		}
		
		// ExÃ©cution d'une requÃªte simple, pour obtenir la
		// version de MSSQL et l'afficher.

		
	}
	
	public function query($sttm,$name){
		$version = mssql_query($sttm) or die($sttm);
		return $version;
		mssql_free_result($version);
	}
	
	public function close(){
		mssql_close();
	}
	
	function select($champ, $table, $cond){
		
	}
	
	
	
	
	
	public function listeBadgeActive($playerStatus){
		$resultats = $this->query('[getAuthorizedUsersTagsNumbers] ' . $playerStatus , 'listeBadgeActive');
		$rtrnArray[]='';
		while ($row = mssql_fetch_array($resultats)) {
			if($row['number']!='')
			$rtrnArray[]=$row['number'];
		}
		return $rtrnArray;
	}
	
	public function getBadgeVersion(){
		$resultats = $this->query('	SELECT TOP 1 [versionNumber]
						FROM AuthorizedTagsVersion', 'getBadgeVersion');
		$rtrn='';
		while ($row = mssql_fetch_array($resultats)) {
			if($row['versionNumber']!='')
				$rtrn=$row['versionNumber'];
		}
		return $rtrn;
	}
	
	public function getFilmedHours(){
		$resultats = $this->query('[getFilmedHours]', 'getFilmedHours');
		return $resultats;
	}

	public function listPlayers(){
		$resultats = $this->query('SELECT * 
						FROM PlayerJeu
						ORDER BY lastName ASC','listPlayers');
		return $resultats;
	}

	public function searchPlayers($search)
	{
		$resultats = $this->query('SELECT *
						FROM PlayerJeu
						WHERE firstName LIKE "%'.$search.'%"
						OR lastName LIKE "%'.$search.'%"','searchPlayers');
		return $resultats;
	}
	
	public function getPwdHashAndSalt($login){
		$resultats = $this->query('SELECT salt, passwordHash, ID
								   FROM PlayerJeu
								   WHERE login like "' . $login .'"', 'getPwdHashAndSalt');
		return $resultats;
	}
	
	
	/**
	 * Fonction validateUidWithKey.
	 *
	 * @author     	Fred
	 * @version    	2.0 -> Supprimé le contrôle sur la vidétude du mdp
	 * @date  	  	28/12/2013
	 * @Description Vérifie en base que le key 
	 *				correspond bien à l'uid
	 *				notemment utilisé pour 
	 *				la création du mdp
	 * @return		true ou false
	 *
	 */
	public function validateUidWithKey($uid, $key){
		$resultats = $this->query('SELECT passwordReset, passwordHash
								   FROM PlayerJeu
								   WHERE ID = ' . $uid , 'validateUidWithKey');
		$row = mssql_fetch_array($resultats);
		$this->close();
		if($row['passwordReset']==$key){
			return true;
		}
		else {
			return false;
		}
	}
	/**
	 * Fonction returnLoginFromId.
	 *
	 * @author     	Fred
	 * @version    	1.0
	 * @date  	  	28/12/2013
	 * @Description Retourne le login
	 * 				en fonction de l'id
	 * @return		le login
	 *
	 */
	public function returnLoginFromId($id){
		$resultats = $this->query('SELECT email
								   FROM PlayerJeu
								   WHERE ID = ' . $id , 'returnLoginFromId');
		$row = mssql_fetch_array($resultats);
		$this->close();
		return $row['email'];
	}
	/**
	 * Fonction setPwd.
	 *
	 * @author     	Fred
	 * @version    	1.0
	 * @date  	  	19/01/2013
	 * @Description Met à jour le mdp
	 * @return		Rien
	 *
	 */
	function setPwd($id, $pwd){
		$this->query('UPDATE [PlayerJeu] 
									SET [passwordHash] = "' . $pwd . '" 
									 WHERE [ID] = ' . $id, 'setPwd');
	}
	/**
	 * Fonction getSalt.
	 *
	 * @author     	Fred
	 * @version    	1.0
	 * @date  	  	20/01/2013
	 * @Description Recupère le salt en fonction de l'ID
	 * @return		le salt
	 *
	 */	
	function getSalt($id){
		$resultats=$this->query('	SELECT salt 
						FROM [PlayerJeu] 
						WHERE [ID] = ' . $id, 'getSalt');
		$row = mssql_fetch_array($resultats);
		$this->close();
		return $row['salt'];
	}
	/**
	 * Fonction getStatus.
	 *
	 * @author     	Fred
	 * @version    	1.0
	 * @date  	  	20/01/2013
	 * @Description Recupère le statut en fonction de l'ID
	 * @return		le statut sous forme de string
	 *
	 */
	function getStatusandName($id){
		$resultats=$this->query('	SELECT StatusSet.statusName, PlayerJeu.firstName, PlayerJeu.lastName
									FROM [PlayerJeu] INNER JOIN StatusSet
									ON PlayerJeu.Status_Id = StatusSet.Id
									WHERE [PlayerJeu].[ID] = ' . $id, 'getStatus');
		$row = mssql_fetch_array($resultats);
		$this->close();
		if ($row['statusName']=="Utilisateur" || $row['statusName']=="Club" || $row['statusName']=="Administrateur"){
			return $row;
		}
		else {
			die ("erreur de status");
		}
	}
	
	/**
	 * Fonction genNewPwdReset.
	 *
	 * @author     	Fred
	 * @version    	1.0
	 * @date  	  	20/01/2013
	 * @Description Génère un nouveau pwdReset et le met à jour.
	 * @return		le pwdReset
	 *
	 */
	function genNewPwdReset($id){
		$words = preg_split('//', 'abcdefghijklmnopqrstuvwxyz0123456789', -1);
		shuffle($words);
		$buffer='';
		foreach($words as $word) {
			$buffer.=$word;
		}
		$this->query('	UPDATE [PlayerJeu]
						SET passwordReset = "' . $buffer . '" 
						WHERE ID = ' . $id
					, "genNewPwdReset");
		return $buffer;
	}
	/**
	 * Fonction userMailExists.
	 *
	 * @author     	Fred
	 * @version    	1.0
	 * @date  	  	20/01/2013
	 * @Description Check si le user existe
	 * @return		le nombre d'occurence et l'ID
	 *
	 */
	function userMailExists($mail){
		$resultats=$this->query('	SELECT COUNT([email]) AS nbocc , ID 
									FROM [PlayerJeu]
									WHERE [email] LIKE "' . $mail . '" 
									GROUP BY ID ', "userMailExists");
		$row = mssql_fetch_array($resultats);
		$this->close();
		return $row;
	}
	
	
	/**
	 * Fonction howLongWasPwdResetAsked.
	 *
	 * @author     	Fred
	 * @version    	1.0
	 * @date  	  	20/01/2013
	 * @Description Détermine depuis combien de temps le Pwdreste a été demandé
	 * @return		le nombre d'heures
	 *
	 */	
	function howLongWasPwdResetAsked($id){
		$resultats=$this->query('	SELECT   DATEDIFF ( hour , [passwordResetDemand] , getdate() ) AS temps
									FROM [PlayerJeu]
									WHERE ID = ' . $id, "howLongWasPwdResetAsked");
		$row = mssql_fetch_array($resultats);
		$this->close();
		return $row['temps'];
	}
	/**
	 * Fonction isPasswordSet.
	 *
	 * @author     	Fred
	 * @version    	1.0
	 * @date  	  	20/01/2013
	 * @Description Détermine si le mot de passe est déjà créé.
	 * @return		true or false
	 *
	 */
	function isPasswordSet($id)
	{
		$resultats=$this->query('	SELECT  [passwordHash]
									FROM [PlayerJeu]
									WHERE ID = ' . $id, "isPasswordSet");
		$row = mssql_fetch_array($resultats);
		$this->close();
		if ($row['passwordHash']==""){
			return false;
		}
		else {
			return true;
		}
	}
	/**
	 * Fonction razPwdReset.
	 *
	 * @author     	Fred
	 * @version    	1.0
	 * @date  	  	20/01/2013
	 * @Description vide les champs [passwordReset] et [passwordResetDemand]
	 * @return		rien du tout du tout
	 *
	 */
	function razPwdReset($id){
		$this->query('  UPDATE [PlayerJeu]
						SET passwordReset =NULL, passwordResetDemand=NULL
						WHERE ID = ' . $id, 'razPwdReset');
		$this->close();
	}
	/**
	 * Fonction updateLastLogin.
	 *
	 * @author     	Fred
	 * @version    	1.0
	 * @date  	  	20/01/2013
	 * @Description met à jour le champ [lastLogin]
	 * @return		rien du tout du tout
	 *
	 */
	function updateLastLogin($id){
		$this->query('  UPDATE [PlayerJeu]
						SET [lastLogin] = getdate()
						WHERE ID = ' . $id, 'updateLastLogin');
		$this->close();
	}
}