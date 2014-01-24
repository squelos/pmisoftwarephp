<?php include_once('header.php'); ?>
<?php

$uid = cleanGetVar($_GET['uid']);
$key = cleanGetVar($_GET['key']);
$bdd = new db();
$uidKeyValidated = $bdd->validateUidWithKey($uid, $key);
$bdd = new db();
$howLongWasPwdResetAsked = $bdd->howLongWasPwdResetAsked($uid);
$bdd = new db();
$isPasswordSet = $bdd->isPasswordSet($uid);
$pwdReset=true;
$inputAuthorized=false;
if(isset($_GET['p']) && $howLongWasPwdResetAsked<24){
	if($uidKeyValidated && $_GET['p']=="pwdreset"){
		$inputAuthorized=true;
		$pwdReset=true;
	}
}
elseif ($uidKeyValidated && !$isPasswordSet){
	$inputAuthorized=true;
	$pwdReset=false;
}
else {
	$inputAuthorized=false;

	$pwdReset=false;
}
if(isset($_GET['p']))
{
	if($_GET['p']=="pwdreset"){
		$pwdReset=true;
	}
}
unset($bdd);
$bdd = new db();
?>







    <div class="page">
        <div class="page-region">
            <div class="page-region-content">
                <h1>
                    <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    <?php echo ($pwdReset) ? "Mot de passe" : "Première connexion"; ?><small class="on-right">
                    <?php echo ($pwdReset) ? "Changement de mot de passe" : "Création du mot de passe"; ?></small>
                </h1>
				
                <div class="example">	<?php if ($inputAuthorized) { ?>
                <p><?php echo ($pwdReset) ? "Vous pouvez à présent changer votre mot de passe" : "Ceci est votre première connexion, il vous faut créer votre mot de passe."; ?></p>
                    <fieldset style="width: 45%; float: right;margin-top: 125px;padding-top: 0px;">
                    <div style='float:right; display:none;' id="scorediv">0/100</div>
                    <a href="#"
						    data-hint="Complexité du mot de passe|Augmentez la complexité du mot de passe avec des Majuscules des chiffres et des caractères spéciaux. Plus le mot de passe est complexe, plus il est sûr."
						    data-hint-position="top">
	                     	<p>Complexité du mot de passe : </p>
	                     	
	                     	<div class="progress-bar" data-role="progress-bar" data-value="0" id="barreCplxMdp" style="width:80%;"></div>
	                     	
						</a>
                     	<div id="mdpUniqCheck"></div>
                     </fieldset>
					<fieldset style="width:40%;">
				
                                        <label>Login</label>
                                        <div class="input-control text" data-role="input-control" style="padding-bottom:20px;">
                                            <input type="text" placeholder="type text" disabled="disabled" value="<?php echo $bdd->returnLoginFromId($uid); ?>">
                                            <button class="btn-clear" tabindex="-1" type="button"></button>
                                        </div>
                                        <label><?php echo ($pwdReset) ? "Saisissez votre nouveau mot de passe": "Créez votre mot de passe" ?></label>
                                        <div class="input-control password" data-role="input-control" style="padding-bottom:20px;">
                                            <input type="password" placeholder="Tapez votre mot de passe" autofocus="" id="pwd1" name="pwd">
                                            <button class="btn-reveal" tabindex="-1" type="button"></button>
                                        </div>
                                        <label>Retapez votre mot de passe</label>
                                        <div class="input-control password" data-role="input-control" style="padding-bottom:20px;">
                                            <input type="password" placeholder="Tapez votre mot de passe" id="pwd2">
                                            <button class="btn-reveal" tabindex="-1" type="button"></button>
                                        </div>
                                        <input type="submit" value="Valider" id="submitbtn" class="disabled" onClick="pwdresetvalidate();">

                     </fieldset>

                     <?php } else { ?>
                     <p class="icon-warning fg-red on-left"> La clé que vous avez utilisée est invalide ou périmée.</p>
                     <?php } ?>


                </div>
<script type="text/javascript" src="includes/profile.js"></script>
            </div>
        </div>
<?php include_once('footer.php'); ?>