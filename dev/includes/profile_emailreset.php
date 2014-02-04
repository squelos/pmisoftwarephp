<?php
include 'header.php';
?>
<div class="page">
	<div class="page-region">
		<div class="page-region-content">
			<h1>
			<a href="<?= $_SERVER['HTTP_REFERER']; ?>"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
			Modification de l'adresse mail<small class="on-right"></small>
			</h1>
			
			<div class="example">
<?php 
if (isset($_POST['newMail'])) {
	echo "<p class='icon-warning fg-red on-left'>Un courriel a été envoyé à l'ancienne et à la nouvelle adresse mail. 
		Cliquez sur les deux liens pour valider le changement de mail.</p>";
	$subject = "Demande de changement de l'adresse mail.";
	$content = "Bonjour, </br></br> Une demande de changement d'adresse email a été demandée pour votre compte. Veuillez cliquer sur le lien ci dessous pour continuer la procédure. Si vous ne souhaitez pas changer votre adresse mail, ne faites rien. Le lien ci-dessous est valide pendant 24h.</br>";
	$bdd = new db();				
	$key = $bdd->genNewPwdReset($_SESSION['id']);
	$bdd = new db();
	$bdd->setNewMailAddress($_SESSION['id'], $_POST['newMail']);
	$bdd = new db();
	$bdd->updatePasswordResetDate($_SESSION['id']);
	mailSend($_POST['newMail'], $subject, $content . "<a href='http://172.17.100.1/fred/dev/profile.php?p=mailResetStep1&id=".$_SESSION['id']."&newMail=".$_POST['newMail']."&key=" . $key . "'>http://172.17.100.1/fred/dev/profile.php?p=mailResetStep1&id=".$_SESSION['id']."&newMail=".$_POST['newMail']."&key=" . $key . "</a>");
	mailSend($_POST['oldMail'], $subject, $content . "<a href='http://172.17.100.1/fred/dev/profile.php?p=mailResetStep1&id=".$_SESSION['id']."&oldMail=".$_POST['oldMail']."&key=" . $key . "'>http://172.17.100.1/fred/dev/profile.php?p=mailResetStep1&id=".$_SESSION['id']."&oldMail=".$_POST['oldMail']."&key=" . $key . "</a>");
}


?>
			</div>
		</div>
	</div>
</div>