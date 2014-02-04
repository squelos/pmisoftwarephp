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
			$bdd = new db();
			$nbHrDemande = $bdd->howLongWasPwdResetAsked($_GET['id']);
			if ($nbHrDemande>24){
				echo "<p>La demande de changement d'adresse mail a expiré.</p>";
			}
			else{ // dans ce cas la cl� est valide
				if (isset($_GET['newMail']))
				{
					$bdd = new db();
					$mailResetState = $bdd->getMailResetState($_GET['id']);
					if($mailResetState['newMailValidated']==1)
						echo "<p>Vous avez déjà validé cette adresse mail.</p>";
					
					elseif ($mailResetState['newMailValidated']==0)
					{
						if($mailResetState['oldMailValidated']==0){
							echo "<p>Merci, cette adresse mail est maintenant validée. Il vous faut encore cliquer sur le lien de votre ancienne adresse email.</p>";
							$bdd = new db();
							$bdd->setMailResetStateTo($_GET['id'], 0, 1);
						}
						elseif($mailResetState['oldMailValidated']==1)
						{
							$bdd = new db();
							$bdd->setNewMail($_GET['id']);
							echo "<p>La modification de votre adresse mail est maintenant effective.</p>";
							$bdd = new db();
							$bdd->razPwdReset($_GET['id']);							
						}
					}
				}
				elseif (isset($_GET['oldMail']))
				{
					$bdd = new db();
					$mailResetState = $bdd->getMailResetState($_GET['id']);
					if($mailResetState['oldMailValidated']==1)
						echo "<p>Vous avez déjà validé cette adresse mail.</p>";
					
					elseif ($mailResetState['oldMailValidated']==0)
					{
						if($mailResetState['newMailValidated']==0){
							echo "<p>Merci, cette adresse mail est maintenant validée. Il vous faut encore cliquer sur le lien de votre nouvelle adresse email.</p>";
							$bdd = new db();
							$bdd->setMailResetStateTo($_GET['id'], 1, 0);
						}
						elseif($mailResetState['newMailValidated']==1)
						{
							$bdd = new db();
							$bdd->setNewMail($_GET['id']);
							echo "<p>La modification de votre adresse mail est maintenant effective.</p>";
							$bdd = new db();
							$bdd->razPwdReset($_GET['id']);
							
						}
					}
				}
			}
				
				
			?>
			</div>
		</div>
	</div>
</div>