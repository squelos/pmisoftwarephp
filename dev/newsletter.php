<?php
@session_start();

//Activation élément menu
$newsletter = "class=active";

if (isset($_SESSION['isConnected']))
{
$_SESSION['isAdmin'] = "false";
include_once('includes/functions.php');

$db = new db();
$result = $db->query('SELECT statusName FROM StatusSet,PlayerJeu WHERE StatusSet.Id=PlayerJeu.Status_Id AND PlayerJeu.ID='.$_SESSION['id'],'droits admin');

if (mssql_result($result, 0, 'statusName')=="Administrateur")
{
    $_SESSION['isAdmin'] = "true";
}

if ($_SESSION['isAdmin']=="true")
{
	include_once('header.php'); 
	
?>
<script type="text/javascript">
var nbTo = 0;
	function listPlayers(search)
	{
		maj("includes/newsletter_ajax.php?action=listplayer&search="+search,"listplayer");
	}

	function listCateg()
	{
		maj("includes/newsletter_ajax.php?action=listcateg","listcategory");
	}

	function addTo(object)
	{
		var origin = object.id.split('-');

		if ($("#"+object.id).parent().attr('id')=="listto")
		{			
			switch (origin[0])
			{
				case "play" : 
				nbTo -= parseFloat(origin[2]);
				$("#listplayer").append(object);

				break;
				case "categ" :
				nbTo -= parseFloat(origin[2]);
				$("#listcategory").append(object);
				break;
				default :
				break;
			}
		}
		else
		{
			nbTo += parseFloat(origin[2]);
			$("#listto").append(object);
		}
	}

	function sendMail()
	{
		if (nbTo>0)
		{
			var idTo;
			var message = tinyMCE.activeEditor.getContent();
			message = escape(message);
			console.log(message);
			$.Dialog({
	                              overlay: true,
	                              shadow: true,
	                              flat: true,
	                              padding : 20,
	                              width:400,
	                              height:200,
	                              title: 'Envoi en cours', 
	                              content : '<div style="width:50%;height:20%;margin:auto;text-align:center;">Envoi des mails en cours.<br><div><div id="compteur" style="float:left;">0</div><div style="float:left;"> sur '+nbTo+' envoyés.</div></div></div>'
	                          });

			$("#listto").children().each(function() {
				idTo = this.id;
				idTo = idTo.split('-');
				if (idTo[0]=="categ")
				{
					$.getJSON('includes/newsletter_ajax.php?action=playerFromCateg&categ='+idTo[1],function(data){
						$.each(data, function(key,val){
							maj('includes/newsletter_ajax.php?action=sendmail&m='+message+'&to='+val['idPlayer'],"count","indentLoader();");
						});
					});
				}
				else
				{
					maj('includes/newsletter_ajax.php?action=sendmail&m='+message+'&to='+idTo[1],"count","indentLoader();");
				}
				
			})
		}
		else
		{
			$.Notify({
	            content : 'Veuillez sélectionner des destinataires',
	            position : 'bottom-right'
	        })
		}
	}

	function indentLoader()
	{
		$("#compteur").html(parseFloat($("#compteur").html())+parseFloat(1));

		if (parseFloat($("#compteur").html())==nbTo)
		{
			$.Dialog.close();
			$.Notify({
	            content : 'Mails envoyés',
	            position : 'bottom-right'
	        })
		}
	}
	tinymce.init({
		selector:"textarea",
		menubar : false,
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
	});
	listPlayers(" ");
	listCateg();
</script>
	<div class="page" >
	<div class="page-region">
	    <div class="page-region-content">
	   		<h1>
                <a href="<?= $_SERVER['HTTP_REFERER']; ?>"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Newsletter
            </h1>

            <div class="example">

            <div style="text-align:center;">Destinataires : </div>
            <fieldset>
            	<input type="text" id="searchPlayer" placeholder="Tapez votre recherche" onkeyup="listPlayers(this.value);" style="width:45%;" /><br>
            	<br>
            	<div class="listview-outlook" id="listcategory" style="margin-left:10px;float:left;height:200px;width:30%;overflow:auto;border-style:solid;border-width:2px;border-color:#f5923D;padding:5px;">
            		
            	</div>
            	<div class="listview-outlook" id="listplayer" style="margin-left:10px;float:left;height:200px;width:30%;overflow:auto;border-style:solid;border-width:2px;border-color:#f5923D;padding:5px;">
            		
            	</div>
            	<div class="listview-outlook" id="listto" style="margin-left:10px;float:left;height:200px;width:30%;overflow:auto;border-style:solid;border-width:2px;border-color:#f5923D;">
            		Sélectionnés
            	</div>
            <div style="clear:both;"></div>
            <br>
            <br>
            <div style="text-align:center;">Message : </div>
            <textarea style ="width:100%;height:200px;" id="message">Votre message</textarea>
            <br>
            <br>
            <div style="text-align:center;"><input type="submit" value="Envoyer" style="width:100px;height:50px;" onClick="sendMail();"/></div>
            </fieldset>

            </div>
        </div>
    </div>
    </div>
<?php
}
else
{
    echo 'Accès réservé aux administrateurs';
}
}
else
{
    echo 'Accès direct non autorisé';
}
?>