				<?php 
				if(isset($_SESSION['isConnected'])){
					?>
					<legend>Profil</legend>
					<p>Bonjour M.Test Test.</p>
					<a href='includes/connexion?deconnect=true'><button class='warning'>Déconnexion</button></a>
					<?php
				}
				else
				{
				?>
                <legend>Connexion</legend>
				<form method='POST' action='includes/connexion.php'>
					<label>Identifiant</label>
					<div class="input-control text" data-role="input-control">
						<input type="text" placeholder="Email" name='mail' >
						<button class="btn-clear" tabindex="-1"></button>
					</div>
					<label>Mot de passe</label>
					<div class="input-control password" data-role="input-control">
						<input type="password" placeholder="Mot de passe" name='mdp' >
						<button class="btn-reveal" tabindex="-1"></button>
					</div>
					<input type="submit" value="Submit">
				</form>
				<?php
				}
				?>
