<?php 
	include_once('header.php'); 
	include_once('functions.php');
?>
<link rel='stylesheet' type='text/css' href='fullcalendar-1.6.4/fullcalendar/fullcalendar.css' />
<script type='text/javascript' src='fullcalendar-1.6.4/lib/jquery.min.js'></script>
<script type='text/javascript' src='fullcalendar-1.6.4/fullcalendar/fullcalendar.js'></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#calendar").fullCalendar({
			header: {
				left: 'prev,next, today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			minTime : '8:00',
			maxTime : '23:59',
			editable: true,
			timeFormat: { // for event elements
				'agendaWeek': 'HH(:mm)t',
				'agendaDay': 'HH(:mm)t' 
			},

			dayClick : function(date,allDay,jsEvent,view) {
				//view.name = month OR agendaWeek OR agendaDay
				//Formatage date réservation
				$("#infoBook").css({top : jsEvent.pageY+15,left : jsEvent.pageX-30});
				$("#infoBook").show();
			
				var day = date.getDate();
				day=day.toString();
				if (day.length<2) day="0"+day;
				var month = date.getMonth()+1;
				month = month.toString();
				if (month.length<2) month = "0"+month;
				var year = date.getFullYear();
				var displayDate = day+"/"+month+"/"+year;
				var hour = date.getHours();
				hour = hour.toString();
				if (hour.length<2) hour="0"+hour;
				var minute = date.getMinutes();
				minute = minute.toString();
				if (minute.length<2) minute = "0"+minute;
				var displayHour = hour+":"+minute;
				$("#date").val(displayDate);
				$("#time").val(displayHour);
			}
		})
	});

	function closeCalendar()
    {
        $("#infoBook").hide();
    }

    function validBook()
    {
    	var player1 = $("#player1").val();
    	var player2 = $("#player2").val();
    	var date = $("#date").val();
    	var hour = $("#hour").val();
    	var court = $("#field").val();

    	maj("includes/check_booking.php?p1="+player1+"&p2="+player2+"&d="+date+"&h="+hour+"&c="+court,"bookOk");
    }
</script>
<div class="page">
	<div class="page-region">
	    <div class="page-region-content">
	   		<h1>
                <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Réservation
            </h1>
            <div id="infoBook" class="balloon bottom">
            	<input type="text" id="field" value="<?php echo $_GET['field']; ?>" style="display:none;"/>
                <a href="#" onclick="closeCalendar();"><i class="icon-cancel" style="float:right"></i></a>
                <br>
                <input type="text" placeholder="Date" name='date' id='date' disabled />
                <br>
                <input type="text" placeholder="Heure" name='time' id='time' disabled />
                <br>
                <br>
                <div style="float:left;">
                <label>Joueur 1</label><br>
                <input type="text" placeholder="player1" name="player1" id="player1" value="1" disabled/>
                <label>Joueur 2</label>
                <select>
                	<?php
                	$db = new db();

                		$players = $db->listPlayers();
                		while($result=mssql_fetch_array($players))
                		{
                			echo '<option value="'.$result['ID'].'">'.$result['lastName']." ".$result['firstName'].'</option>';
                		}
                	?>
                </select>
                </div>
                <div style="float:left">
                	<input type="checkbox" id="camera" name="video" style="vertical-align:middle;"> Séance filmée
                </div>
                <div style="clear:both;"> </div>
                <br>
                <br>
                <input id='connectsubmit' onClick="validBook()" type="submit" value="Réserver" >
                <div id="bookOk"></div>
            </div>
			<div id="calendar"></div>
		</div>
	</div>
</div>