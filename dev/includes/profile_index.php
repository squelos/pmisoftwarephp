<?php if(!isset($_SESSION['isConnected'])){
die("Vous devez vous connecter pour consulter votre profil.");
}?>
<?php include_once('header.php'); 
$bdd = new db();
$userinfos = $bdd->getUserInfos($_SESSION['id']);


$bdd = new db();
$mail = $bdd->returnLoginFromId($_SESSION['id']);
?>
<div class="page">
	<div class="page-region">
		<div class="page-region-content">
			<h1>
			<a href="<?= $_SERVER['HTTP_REFERER']; ?>"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
			Profil<small class="on-right">Votre profil</small>
			</h1>
			
			<div class="example">
			<p>Votre profil contient les informations suivantes :</p>
			<table style="margin:auto">
			<tr><td><b>Prénom</td><td style="padding-left: 20px;padding-bottom: 10px;"><?= $userinfos['firstName'] ?></td></tr>
			<tr><td><b>Nom</b></td><td style="padding-left: 20px;padding-bottom: 10px;"><?= $userinfos['lastName'] ?></td></tr>
			<tr><td><b>Date de naissance</b></td><td style="padding-left: 20px;padding-bottom: 10px;"><?= $userinfos['formatedBirthDate'] ?></td></tr>
			<tr><td><b>Classement</b></td><td style="padding-left: 20px;padding-bottom: 10px;"><?= $userinfos['ranking'] ?></td></tr>
			<tr><td><b>Numéro de licence</b></td><td style="padding-left: 20px;padding-bottom: 10px;"><?= $userinfos['licenceNumber'] ?></td></tr>

			</table>
				<button class="shortcut danger" onClick="chgPwd();">
				    <i class=" icon-locked"></i>
				    Mot de passe
				</button>
				<button class="shortcut primary"onClick="chgMail()">
				    <i class="icon-mail"></i>
				    Adresse email
				</button>
			</div>
			<div class="example" id="chgMail" style="display:none;">
				<p>Pour modifier votre adresse mail, vous devez avoir accès à votre adresse actuelle ainsi qu'à votre nouvelle adresse. 
				Dans le cas contraire, merci de contacter le webmestre.</p>
				<fieldset style="width:40%;">
					<form action="profile.php?p=mailreset" method="POST">
						<label>Adresse mail actuelle :</label>
						<div class="input-control text" data-role="input-control" style="padding-bottom:20px;">
							<input name="oldMail" type="text" placeholder="Tapez votre adresse mail" READONLY value="<?= $mail ; ?>">
							<button class="btn-clear" tabindex="-1" type="button"></button>
						</div>
						<label>Nouvelle adresse mail :</label>
						<div class="input-control text" data-role="input-control" style="padding-bottom:20px;">
							<input name="newMail" type="text" placeholder="Tapez votre adresse mail" value="">
							<button class="btn-clear" tabindex="-1" type="button"></button>
						</div>			
						<input type="submit" value="Valider" id="submitbtn" >
					</form>
				</fieldset>
			</div>
			<div class="example" id="chgPwd" style="display:none;" src="includes/profile_pwdreset.php">
			pwd
			</div>
		</div>
	</div>
</div>
<script src="includes/profile.js"></script>