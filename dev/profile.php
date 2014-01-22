<?php
@session_start();
include_once('includes/functions.php');

include_once('header.php');
?>
 <div class="page">
        <div class="page-region">
            <div class="page-region-content">
                <h1>
                    <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Profil
                </h1>
				<div class="example" >
 					
 					<div id="changeNewsletter" style="float:left; width:45%;border-style:solid;border-width:2px;border-color:#F5923D;padding:20px;">
	 					<?php

	 					$db = new db();
	 					$query = $db->query("SELECT Subscribed FROM PlayerJeu WHERE ID=".$_SESSION['id'],"select subscription news");
	 					$subscibed = mssql_result($query, 0, 'Subscribed');

	 					$check="";
	 					if ($subscibed=="1")
	 					{
	 						$check = "checked";
	 					}
	 					else
	 					{
	 						$check = "";
	 					}

	 					?>
	 					<br>
	 					<br>
	 					<br>
	 					<input type="checkBox" id="news" />  M'abonner à la newsletter
	 					<br>
	 					<br>
	 					<input type="submit" onClick="changeNews();" value="Valider" />
 					</div>
 			</div>
 		</div>
 	</div>
</div>
