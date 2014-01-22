<?php
@session_start();
include_once('includes/functions.php');
include_once("includes/stats_json.php");

?>
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
 <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

      	//Chart niveau de balle
		<?php echo $balllevel; ?>
        // Set chart options
        var options = {'title':'Niveau de balle des joueurs',
       					'titleTextStyle':{'fontSize':25},
    					'pieHole':0.4,
    					'legend':{
    						'position':'left',
    						'textStyle':{'fontSize':20}
    					},
    					'chartArea':{'height':'275'},
    					'height':'350',
    					'is3D':true
    				};
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('ballLevel_chart'));
        chart.draw(data, options);

        //Chart catégorie
        <?php echo $category; ?>
        // Set chart options
        var options = {'title':'Catégorie des joueurs',
       					'titleTextStyle':{'fontSize':25},
    					'pieHole':0.4,
    					'legend':{
    						'position':'right',
    						'textStyle':{'fontSize':20}
    					},
    					'chartArea':{'height':'275'},
    					'height':'350',
    					'is3D':true
    				};
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('category'));
        chart.draw(data, options);


        //Chart sexe
        <?php echo $sexe; ?>
        // Set chart options
        var options = {'title':'Répartition Hommes/Femmes',
       					'titleTextStyle':{'fontSize':25},
    					'pieHole':0.4,
    					'legend':{
    						'position':'left',
    						'textStyle':{'fontSize':20}
    					},
    					'chartArea':{'height':'275'},
    					'height':'350',
    					'is3D':true
    				};
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('sexe'));
        chart.draw(data, options);

          //Chart origin
        <?php echo $origin; ?>
        // Set chart options
        var options = {'title':'Origine des joueurs',
       					'titleTextStyle':{'fontSize':25},
    					'pieHole':0.4,
    					'legend':{
    						'position':'right',
    						'textStyle':{'fontSize':20}
    					},
    					'chartArea':{'height':'275'},
    					'height':'350',
    					'is3D':true
    				};
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('origine'));
        chart.draw(data, options);


          //Chart terrain par categ
        <?php echo $fieldByCateg; ?>
        // Set chart options
        /*var data = google.visualization.arrayToDataTable([
					['Terrain', '1', '2', '3'{ role: 'annotation' } ],
					['Loisir','163','191','171',''],
					['Compétition','184','180','237',''],
					['Ecole de Tennis','196','212','173',''],
					['Entraînement','3','1','15',''],])*/


        var options = {'title':'Terrain selon les catégories',
       					'titleTextStyle':{'fontSize':25},
    					'legend':{
    						'position':'top',
    						'textStyle':{'fontSize':20}
    					},
    					'chartArea':{'height':'275'},
    					'height':'400',
    					'isStacked':true,

    				};
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.BarChart(document.getElementById('fieldByCateg'));
        chart.draw(data, options);

      }
    </script>
<?php
include_once('header.php');
?>
 <div class="page">
        <div class="page-region">
            <div class="page-region-content">
                <h1>
                    <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Statistiques
                </h1>
				<div class="example" >
 					<div id="ballLevel_chart" ></div>
 					<div id="category" ></div>
 					<div id="sexe" ></div>
 					<div id="origine" ></div>
 					<div id="fieldByCateg" ></div>
 				</div>
 			</div>
 		</div>
 	</div>