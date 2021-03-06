<?php
include('functions.php');
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="product" content="Metro UI CSS Framework">
    <meta name="description" content="Simple responsive css framework">
    <meta name="author" content="Sergey S. Pimenov, Ukraine, Kiev">

    <link href="css/metro-bootstrap.css" rel="stylesheet">
    <link href="css/metro-bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/prettify/prettify.css" rel="stylesheet">

    <!-- Load JavaScript Libraries -->
    <script src="js/jquery/jquery.min.js"></script>
    <script src="js/jquery/jquery.widget.min.js"></script>
    <script src="js/jquery/jquery.mousewheel.js"></script>
    <script src="js/prettify/prettify.js"></script>

    <!-- Metro UI CSS JavaScript plugins -->
    <script src="js/metro/metro-loader.js"></script>

    <!-- Local JavaScript -->
    <script src="js/docs.js"></script>
    <script src="js/github.info.js"></script>
    <script src="js/core.js"></script>

    <title>Metro UI CSS : Metro Bootstrap CSS Library</title>
</head>
<body class="metro">
    <header class="bg-dark" data-load="footer.html"></header>
	<?php include("menu.php");?> 
	<div id="login">
		<fieldset id='fieldsetlogin'>
	<?php include("fieldlogin.php"); ?>
		</fieldset>
	</div>
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

        <div class="page-footer">
            <div class="page-footer-content">
                <!--<div data-load="header.html"></div>-->
            </div>
        </div>
    </div>

    <script src="js/hitua.js"></script>

</body>
</html>