<?php
include_once('includes/functions.php');
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
    <script src="Datejs-all/build/date-fr-FR.js"></script>

    <!-- Metro UI CSS JavaScript plugins -->
    <script src="js/metro/metro-loader.js"></script>

    <!-- Local JavaScript -->
    <script src="js/docs.js"></script>
    <script src="js/github.info.js"></script>
    <script src="js/core.js"></script>
	

	
    <title>Tennis Club Portois</title>
</head>
<body class="metro">
    <header class="bg-dark" data-load="footer.html"></header>
	<?php include("includes/menu.php");?> 
	<div id="login">
		<fieldset id='fieldsetlogin'>
	<?php include("includes/fieldlogin.php"); ?>
		</fieldset>
	</div>