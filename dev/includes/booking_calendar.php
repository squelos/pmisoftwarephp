<?php 
@session_start();


$_SESSION['isAdmin'] = "false";
if (isset($_SESSION['isConnected']))
{
	include_once('header.php'); 
	include_once('functions.php');

    $db = new db();
    $result = $db->query('SELECT statusName FROM StatusSet,PlayerJeu WHERE StatusSet.Id=PlayerJeu.Status_Id AND PlayerJeu.ID='.$_SESSION['id'],'droits admin');
    
    if (mssql_result($result, 0, 'statusName')=="Administrateur")
    {
        $_SESSION['isAdmin'] = "true";
    }
?>
<link rel='stylesheet' type='text/css' href='fullcalendar-1.6.4/fullcalendar/fullcalendar.css' />
<script type='text/javascript' src='fullcalendar-1.6.4/lib/jquery.min.js'></script>
<script type='text/javascript' src='fullcalendar-1.6.4/lib/jquery-ui.custom.min.js'></script>
<script type='text/javascript' src='fullcalendar-1.6.4/fullcalendar/fullcalendar.js'></script>
<script src="js/metro/metro-calendar.js"></script>
<script src="js/metro/metro-datepicker.js"></script>
<script src="js/metro/metro-dialog.js"></script>
<script src="js/metro/metro-notify.js"></script>
<script type="text/javascript">
/////////////////////////////////////////
//TODO : MODIFICATION EVENT RECURRENTS
/////////////////////////////////////////
var courtParam =  new RegExp('[\\?&]field=([^&#]*)').exec(window.location.href);
var selectedEvent;
var isAdmin = false;

<?php
    if ($_SESSION['isAdmin']=="true")
    {
        echo 'isAdmin=true;';
    }
?>

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
            allDaySlot : false,
            axisFormat : 'HH:mm',
            slotEventOverlap : false,


			dayClick : function(date,allDay,jsEvent,view) {
                var endDate = new Date(date);
                endDate.setHours(endDate.getHours()+1);
               
                var todaysEvents = $('#calendar').fullCalendar('clientEvents', function(event) {
                       return checkAvailable(date,endDate,event.start,event.end);
                });

                if (todaysEvents.length>0)
                {
                   $("#notifDiv").html('Créneau indisponible');
                   notifyUser();
                   fetchEvents();
                }
                else
                {
                    if (isAdmin==true)
                    {
                        $("#recurrent").show();
                        $("#checkRecurrent").prop('checked',false);
                        $("#recurrentDate").hide();
                    }
                    else{
                        $("#recurrent").hide();
                    }
                    $("#bookOk").html('');
                    $("#newEvent").show();
                    $("#players").show();
                    $("#modifyEvent").hide();
    				$("#infoBook").css({top : jsEvent.pageY+15,left : jsEvent.pageX-30});
    				$("#infoBook").show();
                    var hour = date.getHours();

                    $("#hour option").remove();
                    
                    for (var i = (hour); i <= 23 ; i++) {
                        $("#hour").append("<option value='"+i+"'>"+i+"</option>");
                    };
                    

                    $("#recurrentEndHour option").remove();
                    
                    for (var i = (hour+1); i <= 23 ; i++) {
                        $("#recurrentEndHour").append("<option value='"+i+"'>"+i+"</option>");
                    };

                    var minute = date.getMinutes();
                    $("#recurrentEndMinute").val(minute);
                    $("#minute").val(minute);
                   
    			
    				var day = date.getDate();
    				day=day.toString();
    				if (day.length<2) day="0"+day;
    				var month = date.getMonth()+1;
    				month = month.toString();
    				if (month.length<2) month = "0"+month;
    				var year = date.getFullYear();
    				var displayDate = day+"/"+month+"/"+year;
    				
    				$("#date").val(displayDate);
    				
                }
			},

            eventClick : function(date,allDay,jsEvent,view) {
                var sessionId = <?php echo $_SESSION['id']; ?>;
                var eventId = date['id'];
                eventId = eventId.split('-');

                 $("#recurrent").hide();

                $("#hour option").remove();
                    
                for (var i = 8; i <= 23 ; i++) {
                    $("#hour").append("<option value='"+i+"'>"+i+"</option>");
                };
                $("#hour").val(date['start'].getHours());

                $("#recurrentEndHour option").remove();
                
                for (var i = (date['start'].getHours()+1); i <= 23 ; i++) {
                    $("#recurrentEndHour").append("<option value='"+i+"'>"+i+"</option>");
                };
                $("#recurrentEndHour").val(date['end'].getHours());
                        
                 if ((eventId[4]!=0) && (isAdmin==true))
                 {
                    $("#hour").prop('disabled',false);
                    $("#minute").prop('disabled',false);

                    $("#recurrentEndHour").prop('disabled',false);
                    $("#recurrentEndMinute").prop('disabled',false);

                    $("#bookName").val(date['title'])
                    $("#players").hide();
                    $("#recurrentDate").show();
                 }
                 else
                 {

                    if ((sessionId==eventId[1]) || (isAdmin==true))
                    {
                        if (eventId[3]==0)
                        {
                            $("#camera").prop('checked',false);
                        }
                        else
                        {
                            $("#camera").prop('checked',true);
                        }

                        $("#hour").prop('disabled',true);
                        $("#minute").prop('disabled',true);

                        $("#recurrentEndHour").prop('disabled',true);
                        $("#recurrentEndMinute").prop('disabled',true);
                        
                        $("#player2").val(eventId[2]);
                        $("#players").show();
                        $("#recurrentDate").hide();
                    }
                $("#bookOk").html("");
                $("#newEvent").hide();
                $("#modifyEvent").show();                 
                selectedEvent = date['id'];
                $("#recurrentEndMinute").val(date['start'].getMinutes());
                $("#minute").val(date['start'].getMinutes());
                $("#date").val(date['start'].toString("dd/MM/yyyy"));
                $("#infoBook").css({top : allDay.pageY+15,left : allDay.pageX-30});
                $("#infoBook").show();
                }
            /*$("#bookOk").html("");
            $("#newEvent").hide();
            $("#modifyEvent").show();                 
            selectedEvent = date['id'];
            $("#recurrentEndMinute").val(date['start'].getMinutes());
            $("#minute").val(date['start'].getMinutes());
            $("#date").val(date['start'].toString("dd/MM/yyyy"));
            $("#infoBook").css({top : allDay.pageY+15,left : allDay.pageX-30});
            $("#infoBook").show();*/
            },

            eventDrop : function(date,allDay,jsEvent,view) {
                closeCalendar();
                var start = date['start'].toString("yyyy-MM-dd HH:mm:ss");
                var end = date['end'].toString("yyyy-MM-dd HH:mm:ss");

              //  maj("update_booking.php?action=start&s="+start+"&e="+end+"&i="+date['id'],"notifDiv","notifyUser();");
                var eventId = date['id'];
                eventId = eventId.split('-');
                var id = date['id'];

                 var todaysEvents = $('#calendar').fullCalendar('clientEvents', function(event) {
                        return checkAvailable(date['start'],date['end'],event.start,event.end);
                   });

                 if (todaysEvents.length>1)
                 {
                    $("#notifDiv").html('Créneau indisponible');
                    notifyUser();
                    fetchEvents();
                 }
                 else
                 {
                    if (eventId[4]==0)
                    {
                        upStart('unique',start,end,id);
                    }
                    else 
                    {
                        //Aggregation d'events, demander confirmation si modif unique ou aggreg
                        $.Dialog({
                              overlay: true,
                              shadow: true,
                              flat: true,
                              padding : 20,
                              title: 'Confirmation', 
                              content : 'Souhaitez-vous appliquer la modification à un seul événement ou à toute la collection ?<br><br><div style="margin:auto;text-align:center;"><input type="submit" value="Unique" onclick="upStart(\'unique\',\''+start+'\',\''+end+'\',\''+id+'\');" />    <input type="submit" value="Tous" onclick="upStart(\'all\',\''+start+'\',\''+end+'\',\''+id+'\');" /></div>',
                              sysButtons:{
                                  btnClose : true
                              }  
                          });
                    }
                }
                
            },
		})
        fetchEvents();
	});
    
    function checkAvailable(start,end,start2,end2)
    {
        var available = false;
        if (((start>=start2)&&(start<end2))||((end>start2)&&(end<end2)))
        {
            available = true;
        }
        return available;
    }
    function upStart(type,start,end,id)
    {
        $.Dialog.close();
        maj("includes/update_booking.php?action=start&type="+type+"&s="+start+"&e="+end+"&i="+id,"notifDiv","notifyUser();");
    }

    function notifyUser()
    {
        var contentUser = $("#notifDiv").html();
        $.Notify({
            content : contentUser,
            position : 'bottom-right'
        })
    }

	function closeCalendar()
    {
        $("#recurrent").hide();
        $("#infoBook").hide();
        $("#remove").hide();
    }

    function deleteEvent()
    {
        var eventId = selectedEvent.split('-');
        if (eventId[4]==0)
        {
            del('unique',selectedEvent);  
        }
        else 
        {
            //Aggregation d'events, demander confirmation si modif unique ou aggreg
              $.Dialog({
                    overlay: true,
                    shadow: true,
                    flat: true,
                    padding : 20,
                    title: 'Confirmation', 
                    content : 'Souhaitez-vous appliquer la modification à un seul événement ou à toute la collection ?<br><br><div style="margin:auto;text-align:center;"><input type="submit" value="Unique" onclick="del(\'unique\',\''+selectedEvent+'\');" />    <input type="submit" value="Tous" onclick="del(\'all\',\''+selectedEvent+'\');" /></div>',
                    sysButtons:{
                        btnClose : true
                    }
                  
                });
        }        
    }

    function del(type,id)
    {
        maj('includes/update_booking.php?action=delete&type='+type+'&id='+id,"notifDiv","fetchEvents();closeCalendar();notifyUser();");
        $.Dialog.close();
    }

    function updateEvent()
    {
        var player1 = $("#player1").val();
        var player2 = $("#player2").val();
        var date = $("#date").val();
        var selectHour = $("#hour").val();
        var selectMinute = $("#minute").val();
        if (selectMinute==null) selectMinute="00";
        var hour = selectHour.replace("null","00")+":"+selectMinute;

        selectHour = $("#recurrentEndHour").val();
        selectMinute = $("#recurrentEndMinute").val();
        if (selectMinute==null) selectMinute="00";
        var endHour = selectHour.replace("null","00")+":"+selectMinute;

        var court = $("#field").val();
        var camera = $("#camera").prop("checked");

        if (camera==undefined) camera=0;

        maj('includes/update_booking.php?action=update&id='+selectedEvent+'&p1='+player1+'&p2='+player2+'&d='+date+'&h='+hour+'&endhour='+endHour+'&c='+court+'&cam='+camera,"notifDiv","fetchEvents();notifyUser();");
        
    }

    function validBook()
    {
    	var player1 = $("#player1").val();
    	var player2 = $("#player2").val();
    	var date = $("#date").val();
        var selectHour = $("#hour").val();
        var selectMinute = $("#minute").val();
        if (selectMinute==null) selectMinute="00";
    	var hour = selectHour.replace("null","00")+":"+selectMinute;
        selectHour = $("#recurrentEndHour").val();
        selectMinute = $("#recurrentEndMinute").val();
        if (selectMinute==null) selectMinute="00";
        var endHour = selectHour.replace("null","00")+":"+selectMinute;
    	var court = $("#field").val();
        var camera = $("#camera").prop("checked");
        var recurrent = $("#checkRecurrent").prop("checked");

        if (camera==undefined) camera=0;

        if(recurrent==true)
        {
            var dateRecurrent = $("#recurrentPicker").val();
            var bookName = $("#bookName").val();
            maj("includes/check_booking.php?action=recurrent&endhour="+endHour+"&dr="+dateRecurrent+"&bn="+bookName+"&p1="+player1+"&p2="+player2+"&d="+date+"&h="+hour+"&c="+court+"&cam="+camera,"notifDiv","checkBook();notifyUser();fetchEvents();");
     
        }
        else
        {
    	   maj("includes/check_booking.php?action=classic&endhour="+endHour+"&p1="+player1+"&p2="+player2+"&d="+date+"&h="+hour+"&c="+court+"&cam="+camera,"notifDiv","checkBook();notifyUser();fetchEvents();");
        }
    }

    function checkBook()
    {
    	var content = "";

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
    function showRecurrent(object)
    {
        var val = $("#"+object.id).prop('checked');

        if (val==true)
        {
            $("#recurrentDate").show();
            $("#recurrentEndHour").prop('disabled',false);
            $("#recurrentEndMinute").prop('disabled',false);
            $("#players").hide();
        }
        else
        {
            $("#players").show();
            $("#recurrentEndHour").prop('disabled',true);
            $("#recurrentEndMinute").prop('disabled',true);
            $("#recurrentDate").hide();
        }
    }

    /*$(".btn-close").on('click',function() {
        fetchEvents();
        console.log('bite');
    });*/

    function updateSelectEnd(object)
    {
        $("#recurrentEndHour option").remove();
                    
        for (var i = (parseFloat($("#"+object.id).val())+1); i <= 23 ; i++) {
            $("#recurrentEndHour").append("<option value='"+i+"'>"+i+"</option>");
        };
    }

    function updatePlayer2(search)
    {
        maj("includes/update_booking.php?action=listeplayer2&search="+search,"player2");
    }

</script>
<div class="page" >
	<div class="page-region">
	    <div class="page-region-content">
	   		<h1>
                <a href="<?= $_SERVER['HTTP_REFERER']; ?>"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Réservation - Court n°<?php echo $_GET['field']; ?>
            </h1>
            <div id="notifDiv" style="display:none;"></div>
           <!--<div id="notifDiv" ></div>-->
            <div id="infoBook" class="balloon bottom" style="padding:20px;">
            	<input type="text" id="field" value="<?php echo $_GET['field']; ?>" style="display:none;"/>
                <a href="#" onclick="closeCalendar();"><i class="icon-cancel" style="float:right"></i></a>
                <br>
                <input type="text" placeholder="Date" size=10 name='date' id='date' disabled />
                <select id="hour" onchange="updateSelectEnd(this);" disabled>

                </select>
                H
                <select id="minute" disabled>
                    <option value="00">00</option>
                    <option value="30">30</option>
                </select>
                <br>
                Heure de fin : 
                <select id="recurrentEndHour" disabled>

                </select>
                H
                <select id="recurrentEndMinute" disabled>
                     <option value="00">00</option>
                     <option value="30">30</option>
                 </select>
                <br>
                <br>
                <div style="float:left;" id="players">
                <label>Joueur 1</label>
                <?php 
                $db = new db();

                $queryName = $db->query("SELECT firstName,lastName FROM PlayerJeu WHERE ID=".$_SESSION['id'],"player name");
                $playerFirstname = mssql_result($queryName, 0, 'firstName');
                $playerLastname = mssql_result($queryName, 0, 'lastName');

                $playerName = $playerLastname.' '.$playerFirstname;
                ?>
                <input type="text" placeholder="player1" name="player1" id="player1name" value="<?php echo $playerName; ?>" disabled/>
                <input type="text" placeholder="player1" name="player1" id="player1" value="<?php echo $_SESSION['id']; ?>" disabled style="display:none;"/>
                <label>Joueur 2</label>
                <input type="text" onkeyup="updatePlayer2(this.value);" placeholder="Rechercher" />
                <select id="player2">
                	<?php
                	
                		$players = $db->listEnabledPlayers();
  
                		while($result=mssql_fetch_array($players))
                		{
                			echo '<option value="'.$result['ID'].'">'.$result['lastName']." ".$result['firstName'].'</option>';
                		}
                	?>
                </select>
                </div>
                <?php
                if ($_GET['field']=="1")
                {
                    echo '<div style="float:left">
                    	<input type="checkbox" id="camera" name="video" style="vertical-align:middle;"> Séance filmée
                    </div>';
                }
                ?>
                <div style="clear:both;"></div>
                <?php
                if ($_SESSION['isAdmin']==true)
                {
                    echo '<div id="recurrent" style="display:none;width:90%;">
                            <input type="checkbox" id="checkRecurrent" style="vertical-align:middle;" onChange="showRecurrent(this);">Réservation récurrente
                            </div>
                           <div id="recurrentDate"  style="display:none;">
                           Nom réservation :
                           <input type="text" id="bookName" />
                           <br>
                           
                           <br>
                                Jusqu\'à : 
                            <br>
                            <div class="input-control text" id="timePicker" >
                                <input type="text" id="recurrentPicker">
                                <button class="btn-date"></button>
                            </div>
                            
                            </div>';
                }
                ?>
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
            	
			<div id="calendar" style="height:600px;"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
var d = new Date();

    $("#timePicker").datepicker({
        date:d,
        format:"dd/mm/yyyy",
        locale:'fr',
        start:1
    });

    $("#timePickerSlide").datepicker({
        date:d,
        format:"dd/mm/yyyy",
        locale:'fr',
        start:1
    });
</script>
<?php
}
else
{
    echo 'Accès direct non autorisé';
}