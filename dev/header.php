<?php
include_once('includes/functions.php');
 ?>
<!DOCTYPE html>
<html>
<head>
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
    <script type='text/javascript' src='fullcalendar-1.6.4/lib/jquery.min.js'></script>
    <script type='text/javascript' src='fullcalendar-1.6.4/lib/jquery-ui.custom.min.js'></script>

    <!-- Metro UI CSS JavaScript plugins -->
    <script src="js/metro/metro-loader.js"></script>
    <script src="js/metro/metro-notify.js"></script>

    <script src="js/metro/metro-calendar.js"></script>
    <script src="js/metro/metro-datepicker.js"></script>
    <script src="js/metro/metro-listview.js"></script>
    <script src="tinymce/js/tinymce/tinymce.min.js"></script>

    <!-- Local JavaScript -->
    <script src="js/docs.js"></script>
    <script src="js/github.info.js"></script>
    <script src="js/core.js"></script>
		
    <title>Tennis Club Portois</title>
	<meta charset="UTF-8">
</head>
<body class="metro">
    <header class="bg-dark"></header>
	<?php include("includes/menu.php");?> 
	<div id="login">
		<fieldset id='fieldsetlogin'>
	<?php include("includes/fieldlogin.php"); ?>
		</fieldset>
	</div>