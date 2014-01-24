<?php
@session_start();

include_once('includes/functions.php');

if (isset($_SESSION['id']))
{
	include_once('header.php');
	?>
	 <link href="pagination/pagination.css" rel="stylesheet">
	<script type='text/javascript' src='pagination/jquery.pagination.js'></script>
	<script type="text/javascript">
		function pageselectCallback(pageIndex, jq) {
			var items_per_page = $("#nbNews").val();
            var max_elem = Math.min((pageIndex+1) * items_per_page, $('#hiddenData div.result').length);
		    // Clone the record that should be displayed
		    var newContent = "";
		    for(var i=pageIndex*items_per_page;i<max_elem;i++)
                {
                    newContent += "<div class='example'>"+$('#hiddenData div.result:eq('+i+')').html()+"</div>";       
                }
		    
		    // Update the display container
		    $('#display').empty().html(newContent);
		    return false;
		}

		$(document).ready(function(){
			$("#hiddenData").css("display", "none");
                // Create pagination element with options from form
                  var numEntries = $('#hiddenData div.result').length;
                 $("#pagination").pagination(numEntries, {
			        num_edge_entries: 2,
			        num_display_entries: 8, // number of page links displayed 
			        callback: pageselectCallback,
			        items_per_page: $("#nbNews").val()  // Adjust this value if you change the callback!
			    });

                 $("#nbNews").change(function() {

                 	$("#pagination").pagination(numEntries, {
			        num_edge_entries: 2,
			        num_display_entries: 8, // number of page links displayed 
			        callback: pageselectCallback,
			        items_per_page: $("#nbNews").val()	// Adjust this value if you change the callback!
			    });
                 });
            });


</script>

	<div class="page" >
	<div class="page-region">
	    <div class="page-region-content">
	   		<h1>
                <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Actualités
            </h1>
            <div style="float:right;">
            	Nombre d'articles par pages :
            	<select id="nbNews" >
            		<option value="5">5</option>
            		<option value="10">10</option>	
            		<option value="15">15</option>
            		<option value="20">20</option>
            	</select>
            </div>
            <br>
            <br>
            <div id="display">
			    <!-- This is the div where the visible page will be displayed -->
			</div>
            <div id="hiddenData">
            	<?php
            		$db = new db();

            		$query = $db->query("SELECT * FROM NewsSet WHERE Visibility='true' ORDER BY PublishDate DESC","list news");

            		while ($result=mssql_fetch_array($query))
            		{
            			$date = new DateTime($result['PublishDate']);
						$date = $date->format('d/m/Y H:i:s');
            			echo '<div class="result"><div style="float:left;"><h2>'.$result['Title'].'</h2></div><div style="float:right;"></div><div style="float:right;">'.$date.'</div><div style="clear:both"></div><div style="width:100%;">'.$result['Content'].'</div></div><hr>';
            		}
            	?>
            </div>
            <div id="pagination" class="pagination"></div>
        </div>
    </div>
    </div>

<?
}
else
{
	echo "Accès direct non autorisé";
}