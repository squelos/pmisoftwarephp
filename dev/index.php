<?php include_once('header.php'); ?>
    <div class="page">
        <div class="page-region">
            <div class="page-region-content">
                <h1>
                    <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Accueil<small class="on-right">lolilol</small>
                </h1>
				
				<?php
					if(isset($_GET['loginerror'])){
					?>
				<div class="example" style='border-color:red;'>
					<p>Votre email ou votre mot de passe ne sont pas correct ! </p>
                </div>
					
					<?php
					}
				?>
                <div class="example">
					<p>Bonjour l'accueil ! </p>
					<p><?php echo ( isset($_SESSION['isConnected']) === true ? 'connecté' : 'pas connecté'); ?></p>
                </div>


            </div>
        </div>
<?php include_once('footer.php'); ?>