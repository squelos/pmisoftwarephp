<?php include_once('header.php'); ?>
<script type="text/javascript">

//Probleme event ->position souris sous Firefox, OK sur chrome...
     function selectField(id)
    {
        var mapP = $("#content");
        var mapPosition = mapP.position(); 
        var position = $("#field"+id).attr('coords').split(',');
        $("#infoBook").css({left:(parseFloat(position[4])+parseFloat(mapPosition.left))+'px',top:(parseFloat(position[5])+parseFloat(mapPosition.top))+'px'});
        //$("#infoBook").css({left:position[4]+'px',top:position[5]+'px'});
        $("#infoBook").show();
    }

    function closeCalendar()
    {
        $("#infoBook").hide();
    }

    function validBook()
    {
        console.log($("#calendar").val());
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
                    <div id='calendar' class='calendar'></div>
                    <input id='connectsubmit' onClick="validBook()" type="submit" value="Réserver" >
                </div>
                <div class="example" id="content">
                    <map name="map" id="fieldMap">
                        <area shape="poly" id="field1" coords="565,32,460,75,672,183,738,122,565,32" onclick="selectField(1);" href="#" />
                        <area shape="poly" id="field2" coords="494,115,650,196,587,245,426,158,494,115" onclick="selectField(2);"  href="#"/>
                        <area shape="poly" id="field3" coords="303,217,367,253,227,356,143,315,303,217" onclick="selectField(3);"  href="#"/>
                    </map>
					<img src="images/terrains.jpg" usemap="#map" />
                </div>

<script src="includes/calendar.js"></script>
            </div>
        </div>
<?php include_once('footer.php'); ?>