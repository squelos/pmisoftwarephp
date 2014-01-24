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
	function listNews()
	{
		maj('includes/admin_news_ajax.php?action=listnews','news');
	}
	function addNews()
	{
		var title = $("#titleInput").val();
		var message = tinyMCE.activeEditor.getContent();
		message = escape(message);
		var online = $("#online").prop('checked');

		maj("includes/admin_news_ajax.php?action=addnews&title="+title+"+&online="+online+"&message="+message,'divInfo','listNews();');
	}

	function deleteNews(id)
	{
		maj('includes/admin_news_ajax.php?action=deletenews&id='+id,'divInfo',"listNews();");
	}

	function showElement(id)
	{
		$("#"+id).toggle();
	}

	tinymce.init({
		selector:"textarea",
		menubar : false,
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
	});
	
	showElement("addNews");
	listNews();

</script>
<div class="page" >
	<div class="page-region">
	    <div class="page-region-content">
	   		<h1>
                <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Actualités
            </h1>

            <div class="example">
	            <div id="title" onclick="showElement('addNews');" style="cursor:pointer;"><h2>Ajouter une actualité</h2> </div>
	            <br>
	            <div id="addNews" style="display:none;">
		            <input type="text" id="titleInput" size=50 placeholder="Votre titre" />
		            <br><br>
		            <textarea style="width:100%;height:200px;" id="message">Votre message</textarea>
		            <br>
		            <br>
		            <input type="checkbox" id="online" /> Mise en ligne immédiate
		            <br>
		            <br>
		            <input type="submit" value="Envoyer" onClick="addNews();" />
	            </div>
	        </div>
	        <div id="news">

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