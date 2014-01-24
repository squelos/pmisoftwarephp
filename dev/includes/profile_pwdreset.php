<?php include_once('header.php'); 
include_once 'db.php';
?>
    <div class="page">
        <div class="page-region">
            <div class="page-region-content">
                <h1>
                    <a href="<?= $_SERVER['HTTP_REFERER']; ?>"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Mot de passe oublié<small class="on-right">Récupération du mot de passe</small>
                </h1>
				
                <div class="example">
                <?php if(!isset($_POST['mail'])) {?>
                <p>Votre mot de passe est perdu ? Entrez ici votre adresse mail et un courriel vous sera envoyé, 
                contenant un lien qui vous permettra de définir un nouveau mot de passe.</p><br/>
				
				<form action="profile.php?p=pwdreset" method="POST">
					<fieldset style="width:40%;">
				
                                        <label>Adresse mail :</label>
                                        <div class="input-control text" data-role="input-control" style="padding-bottom:20px;">
                                            <input name="mail" type="text" placeholder="Tapez votre adresse mail" value="">
                                            <button class="btn-clear" tabindex="-1" type="button"></button>
                                        </div>
                                        <input type="submit" value="Valider" id="submitbtn" >

                     </fieldset>
				</form>
				<?php } 
				else{
					$mail = cleanGetVar($_POST['mail']);
					$bdd = new db();
					$dbResult = $bdd->userMailExists($mail);
					if($dbResult['nbocc']==1){
						$bdd= new db();
						$newPwdReset = $bdd->genNewPwdReset($dbResult['ID']);
						$mailContent = "Bonjour, <br/><br/> Une demande de changement de mot de passe a été demandée pour votre compte. 
                    		Veuillez cliquer sur le lien si dessous pour continuer la procédure. 
                    		Si vous ne souhaitez pas changer votre mot de passe, ne faites rien. Le lien ci-dessous est valide pendant 24h.<br/>
                    		
                    		<a href='http://172.17.100.1/fred/dev/profile.php?p=pwdreset&uid=". $dbResult['ID'] . "&key=" . $newPwdReset . "'>http://172.17.100.1/fred/dev/profile.php?uid=". $dbResult['ID'] . "&key=" . $newPwdReset . "</a>
                    		";
						mailSend($mail, "Demande de changement de mdp", $mailContent);
						echo " <p class='icon-warning fg-green on-left'> Le courriel avec les instructions pour la réinitialisation de votre mot de passe vient d'être envoyé.</p>";
					}
					else{
					echo" <p class='icon-warning fg-red on-left'> L'adresse que vous avez utilisée est invalide.</p>";
					}
				}				
				?>


                </div>
            </div>
        </div>
<?php include_once('footer.php'); ?>