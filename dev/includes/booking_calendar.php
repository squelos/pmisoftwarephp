<?php include_once('header.php'); ?>
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
			
				console.log(date);
				var day = date.getDate();
				if (day.length<2) 
				{
					console.log("bite");
					day="0"+day;
				}
				var month = date.getMonth();
				var year = date.getFullYear();
				var displayDate = day+"/"+month+"/"+year;

				var hour = date.getHours();
				var minute = date.getMinutes();
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
</script>
<div class="page">
	<div class="page-region">
	    <div class="page-region-content">
	   		<h1>
                <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Réservation
            </h1>
            <div id="infoBook" class="balloon bottom">
                <a href="#" onclick="closeCalendar();"><i class="icon-cancel" style="float:right"></i></a>
                <br>
                <input type="text" placeholder="Date" name='date' id='date'>
                <br>
                <input type="text" placeholder="Heure" name='time' id='time'>
                <br>
                <label>Joueur 1</label>
                Jean
                <label>Joueur 2</label>
                <select>
                		<option value="bite">Bono</option>
                		<option value="bite2">Roger</option>
                </select>
                <br>
                <br>
                <input id='connectsubmit' onClick="validBook()" type="submit" value="Réserver" >
            </div>
			<div id="calendar"></div>
		</div>
	</div>
</div>