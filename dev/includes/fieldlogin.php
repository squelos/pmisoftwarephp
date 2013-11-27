<?php
include_once('functions.php');
?>
	<!-- Javascript de connexion -->
	 <script src="includes/connexion.js"></script> 
				<?php 
				if(isset($_SESSION['isConnected'])){
					?>
					<legend>Profil</legend>
					<p>Bonjour M.Test Test.</p>
					<a href='includes/connexion.php?deconnect=true'><button class='warning'>Déconnexion</button></a>
					<?php
				}
				else
				{
				?>
                <legend>Connexion</legend>
				<!--<form method='POST' action='includes/connexion.php'>-->
					<p class='text-warning' style='display:none; width:270px;'>L'adresse mail ou le mot de passe est incorrect. Vérifiez que la touche de verrouillage majuscule n'est pas activée, puis retapez votre nom d'utilisateur ou votre mot de passe.</p>
					<label>Identifiant</label>
					<div class="input-control text" data-role="input-control">
						<input type="text" placeholder="Email" name='mail' id='mailinput'>
						<button class="btn-clear" tabindex="-1"></button>
					</div>
					<label>Mot de passe</label>
					<div class="input-control password" data-role="input-control">
						<input type="password" placeholder="Mot de passe" name='mdp' id='mdpinput'>
						<button class="btn-reveal" tabindex="-1"></button>
					</div>
					<input id='connectsubmit' onClick="jsconnect()" type="submit" value="Valider" >
					<img src='images/ajax-loader.gif' alt='chargement en cours'  id='ajaxload' style='display:none;'/>
				<!--</form>-->
				<?php
				}
				?>
