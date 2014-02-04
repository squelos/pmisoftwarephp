<?php
include_once 'dbconf.php';
class db{
	private $link='';
	
	function db(){
		$servername 	= SERVERNAME;
		$username 		= USERNAME;
		$password  		= CONSTANT;
		
		$link=mssql_connect (  $servername ,  $username, $password );
		if (!$link || !mssql_select_db('TCP_DB', $link)) {
			die('Impossible de se connecter à la base!');
		}
		
		// Exécution d'une requête simple, pour obtenir la
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

	public function listEnabledPlayers(){
		$resultats = $this->query('SELECT * 
						FROM PlayerJeu
						WHERE isEnabled="true"
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
								   WHERE email like "' . $login .'"', 'getPwdHashAndSalt');
		return $resultats;
	}
	
	
	/**
	 * Fonction validateUidWithKey.
	 *
	 * @author     	Fred
	 * @version    	2.0 -> Supprim� le contr�le sur la vid�tude du mdp
	 * @date  	  	28/12/2013
	 * @Description V�rifie en base que le key 
	 *				correspond bien � l'uid
	 *				notemment utilis� pour 
	 *				la cr�ation du mdp
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
	 * @Description Met � jour le mdp
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
	 * @Description Recup�re le salt en fonction de l'ID
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
	 * @Description Recup�re le statut en fonction de l'ID
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
	 * @Description G�n�re un nouveau pwdReset et le met � jour.
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
	 * @Description D�termine depuis combien de temps le Pwdreste a �t� demand�
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
	 * @Description D�termine si le mot de passe est d�j� cr��.
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
	 * @Description met � jour le champ [lastLogin]
	 * @return		rien du tout du tout
	 *
	 */
	function updateLastLogin($id){
		$this->query('  UPDATE [PlayerJeu]
						SET [lastLogin] = getdate()
						WHERE ID = ' . $id, 'updateLastLogin');
		$this->close();
	}
	/**
	 * Fonction getUserInfos.
	 *
	 * @author     	Fred
	 * @version    	1.0
	 * @date  	  	20/01/2013
	 * @Description R�cup�re les informations de l'utilisateur pour affichage dans le profil.
	 * @return		les infos utilisateur.
	 *
	 */
	function getUserInfos($id){
		$result = $this->query('  SELECT CONVERT(VARCHAR, birthDate, 101) AS formatedBirthDate, firstName, lastName, ranking, licenceNumber
						FROM [PlayerJeu]
						WHERE ID = ' . $id, 'getUserInfos');
		return mssql_fetch_array($result);
		$this->close();
	}
	/**
	 * Fonction updatePasswordResetDate.
	 *
	 * @author     	Fred
	 * @version    	1.0
	 * @date  	  	31/01/2013
	 * @Description Met � jour la date de demande de reset de mdp ou d'adresse mail.
	 * @return		nothiiiiing
	 *
	 */
	function updatePasswordResetDate($id){
		$result = $this->query('	UPDATE [PlayerJeu]
									SET passwordResetDemand = getdate()
									WHERE ID = ' . $id, 'updatePasswordResetDate');
		$this->close();
	}
	
	
	/**
	 * Fonction pushLogs.
	 *
	 * @author     	Fred
	 * @version    	1.0
	 * @date  	  	28/01/2013
	 * @Description Envoie les logs depuis l'api � la BDD
	 * @return		nothiiiiing
	 *
	 */
	function pushLogs($logs){
		
			$lines = split(';', $logs);
			foreach ($lines as $line){
				if($line!=''){
					$stmt = mssql_init('addLogEntry');
					$logItems = split(',', $line);
					
					$logItemDeux = (int) $logItems[2];
					mssql_bind($stmt, '@entryDate',  $logItems[0],        SQLVARCHAR);
					mssql_bind($stmt, '@readerName',      $logItems[1],        SQLVARCHAR);
					mssql_bind($stmt, '@tagNumber',      $logItemDeux  ,            SQLINT4);
					mssql_bind($stmt, '@readerResponse',       $logItems[3],             SQLINT1);
					mssql_execute($stmt);
					mssql_free_statement($stmt);
					//print_r($logItemDeux);  echo "|";
				}

			}
			echo "ok";

	}
	/**
	 * Fonction setMail getMail
	 *
	 * @author     	Fred
	 * @version    	1.0
	 * @date  	  	29/01/2013
	 * @Description Sette et gette les valeurs des champs oldMailValidated et newMailValidated.
	 * @return		nothiiiiing
	 *
	 */
	function setMailResetStateTo($id, $oldMailValidated, $newMailValidated){
		$this->query('  UPDATE [PlayerJeu]
						SET oldMailValidated = '.$oldMailValidated.', newMailValidated = '.$newMailValidated.'
						WHERE ID = ' . $id, 'setMailResetStateTo');
		$this->close();
	}
	function getMailResetState($id){
		$result = $this->query('  SELECT oldMailValidated, newMailValidated 
						FROM [PlayerJeu]
						WHERE ID = ' . $id, 'getMailResetStateTo');
		return mssql_fetch_array($result);
	}
	function setNewMailAddress($id, $newMailAddress){
		$this->query('  UPDATE [PlayerJeu]
						SET newEmail = "' . $newMailAddress . '"
						WHERE ID = ' . $id, 'setNewMailAddress');
		$this->close();
	}
	function setNewMail($id){
		$this->query('  UPDATE [PlayerJeu]
						SET oldMailValidated = null , newMailValidated = null, 
						email = (SELECT newEmail FROM  [PlayerJeu] WHERE ID = ' . $id . ') 
						WHERE ID = ' . $id, 'getMailResetStateTo');
		$this->close();
	}
	
	
}