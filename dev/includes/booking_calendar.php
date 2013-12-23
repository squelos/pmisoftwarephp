<?php 
@session_start();

if (isset($_SESSION['isConnected']))
{
	include_once('header.php'); 
	include_once('functions.php');
?>
<link rel='stylesheet' type='text/css' href='fullcalendar-1.6.4/fullcalendar/fullcalendar.css' />
<script type='text/javascript' src='fullcalendar-1.6.4/lib/jquery.min.js'></script>
<script type='text/javascript' src='fullcalendar-1.6.4/lib/jquery-ui.custom.min.js'></script>
<script type='text/javascript' src='fullcalendar-1.6.4/fullcalendar/fullcalendar.js'></script>
<script type="text/javascript">
var courtParam =  new RegExp('[\\?&]field=([^&#]*)').exec(window.location.href);
var selectedEvent;

	$(document).ready(function() {
		$("#calendar").fullCalendar({
            events :
            {
                url:'includes/json_books.php?c='+courtParam[1],
                startEditable:false,
                durationEditable:false
            },
			header: {
				left: 'prev,next, today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			minTime : '8:00',
			maxTime : '23:59',
			timeFormat:'HH:mm',

			dayClick : function(date,allDay,jsEvent,view) {
             
                $("#bookOk").html('');
                $("#newEvent").show();
                $("#modifyEvent").hide();
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
				$("#hour").val(displayHour);
			},

            eventClick : function(date,allDay,jsEvent,view) {
                var sessionId = <?php echo $_SESSION['id']; ?>;
                var eventId = date['id'];
                console.log(eventId);
                eventId = eventId.split('-');

                if (sessionId==eventId[1])
                {
                    if (eventId[3]==0)
                    {
                        $("#camera").prop('checked',false);
                    }
                    else
                    {
                        $("#camera").prop('checked',true);
                    }
                    $("#bookOk").html("");
                    $("#newEvent").hide();
                    $("#player2").val(eventId[2]);
                    $("#modifyEvent").show();                 
                    selectedEvent = date['id'];
                    $("#date").val(date['start'].toString("dd/MM/yyyy"));
                    $("#hour").val(date['start'].toString("HH:mm"));
                    $("#infoBook").css({top : allDay.pageY+15,left : allDay.pageX-30});
                    $("#infoBook").show();
                }
            },

            eventDrop : function(date,allDay,jsEvent,view) {
                var start = date['start'].toString("yyyy-MM-dd HH:mm:ss");
                var end = date['end'].toString("yyyy-MM-dd HH:mm:ss");
              //  maj("update_booking.php?action=start&s="+start+"&e="+end+"&i="+date['id'],"notifDiv","notifyUser();");
                maj("includes/update_booking.php?action=start&s="+start+"&e="+end+"&i="+date['id'],"notifDiv");
                
            },
		})
        fetchEvents();
	});

    function notifyUser()
    {
        var contentUser = $("#notifDiv").html();
        $(document).notify({
            content : contentUser
        })
    }

	function closeCalendar()
    {
        $("#infoBook").hide();
        $("#remove").hide();
    }

    function deleteEvent()
    {
        maj('includes/update_booking.php?action=delete&id='+selectedEvent,"notifDiv","fetchEvents();closeCalendar();");
        
    }

    function updateEvent()
    {
        console.log(selectedEvent);
        var player1 = $("#player1").val();
        var player2 = $("#player2").val();
        var date = $("#date").val();
        var hour = $("#hour").val();
        var court = $("#field").val();
        var camera = $("#camera").prop("checked");

        maj('includes/update_booking.php?action=update&id='+selectedEvent+'&p1='+player1+'&p2='+player2+'&d='+date+'&h='+hour+'&c='+court+'&cam='+camera,"notifDiv","fetchEvents();");
        
    }

    function validBook()
    {
    	var player1 = $("#player1").val();
    	var player2 = $("#player2").val();
    	var date = $("#date").val();
    	var hour = $("#hour").val();
    	var court = $("#field").val();
        var camera = $("#camera").prop("checked");
        
    	maj("includes/check_booking.php?p1="+player1+"&p2="+player2+"&d="+date+"&h="+hour+"&c="+court+"&cam="+camera,"bookOk","checkBook();");
    }

    function checkBook()
    {
    	var content = "";
    	var date = $("#date").val();
    	var hour = $("#hour").val();

    	var dateEvent = date.substr
    	var errorCode = $("#bookOk").html();

    	switch (errorCode)
    	{
    		//Aucune erreur
    		case "0":
    			content = "Ajout effectué.";
                fetchEvents();
                $("#infoBook").hide();
    		break;
    		//Erreur d'autorisation
    		case "1":
    			content = "Erreur : Vous n'avez pas les autorisations nécessaires.";
    		break;
    		//Erreur de quota
    		case "2":
	    		content = "Erreur : Vous avez déjà une réservation cette semaine.";
    		break;
    		//Erreur inconnue
    		case "3":
    			content = "Erreur inconnue.";
    		break;
    		default:
    		
    		break;
    	}
        $("#bookOk").html(content);
    }

    function fetchEvents()
    {
        $("#calendar").fullCalendar('refetchEvents');
    }

</script>
<div class="page">
	<div class="page-region">
	    <div class="page-region-content">
	   		<h1>
                <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Réservation
            </h1>
            <div id="notifDiv" style="display:none;"></div>
           <!--<div id="notifDiv" ></div>-->
            <div id="infoBook" class="balloon bottom">
            	<input type="text" id="field" value="<?php echo $_GET['field']; ?>" style="display:none;"/>
                <a href="#" onclick="closeCalendar();"><i class="icon-cancel" style="float:right"></i></a>
                <br>
                <input type="text" placeholder="Date" name='date' id='date' disabled />
                <br>
                <input type="text" placeholder="Heure" name='time' id='hour' disabled />
                <br>
                <br>
                <div style="float:left;">
                <label>Joueur 1</label><br>

                <input type="text" placeholder="player1" name="player1" id="player1" value="<?php echo $_SESSION['id']; ?>" disabled/>
                <label>Joueur 2</label>
                <select id="player2">
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
                <div id="newEvent">
                    <input id='connectsubmit' onClick="validBook()" type="submit" value="Réserver" >
                </div>
                <div id="modifyEvent" style="display:none;">
                    <input id="update" onClick="updateEvent();" type="submit" value="Modifier" />
                    <input id="delete" onClick="deleteEvent();" type="submit" value="Supprimer" />
                </div>
                <br>
                <div id="bookOk"></div>
            </div> 
            <div>
            	
			<div id="calendar"></div>
		</div>
	</div>
</div>
<?php
}
else
{
    echo 'Accès direct non autorisé';
}