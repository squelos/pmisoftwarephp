<?php 
session_start();
include_once 'functions.php';
include_once 'db.php';
$bdd = new db();
$mail = $bdd->returnLoginFromId($_SESSION['id']);
?>

<p>Voici l'adresse mail ou vous sera envoyé un courriel
 contenant un lien qui vous permettra de définir un nouveau mot de passe.</p>
<form action="profile.php?p=pwdreset&q=noforget" method="POST">
<fieldset style="width:40%;">

<label>Adresse mail :</label>
<div class="input-control text" data-role="input-control" style="padding-bottom:20px;">
<input name="mail" type="text" placeholder="Tapez votre adresse mail" READONLY value="<?= $mail ; ?>">
<button class="btn-clear" tabindex="-1" type="button"></button>
</div>
<input type="submit" value="Valider" id="submitbtn" >

</fieldset>
</form>

