<?php include_once('header.php'); ?>
<script type="text/javascript">
var selectDate;
var cal;

  /*   function selectField(id)
    {
        var mapP = $("#content");
        var mapPosition = mapP.position(); 
        var position = $("#field"+id).attr('coords').split(',');
        $("#infoBook").css({left:(parseFloat(position[4])+parseFloat(mapPosition.left))+'px',top:(parseFloat(position[5])+parseFloat(mapPosition.top))+'px'});
        $("#infoBook").show();
    }*/

    function closeCalendar()
    {
        $("#infoBook").hide();
    }

    function validBook()
    {
        cal.calendar('getDates');
        console.log(selectDate);
    }
</script>
    <div class="page">
        <div class="page-region">
            <div class="page-region-content">
                <h1>
                    <a href="<?= $_SERVER['HTTP_REFERER']; ?>"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Réservation
                </h1>
                
                <div class="example" id="content">
                    <map name="map" id="fieldMap">
                        <area shape="poly" id="field1" coords="565,32,460,75,672,183,738,122,565,32" href="./booking.php?p=calendar&field=1" />
                        <area shape="poly" id="field2" coords="494,115,650,196,587,245,426,158,494,115" href="./booking.php?p=calendar&field=2"/>
                        <area shape="poly" id="field3" coords="303,217,367,253,227,356,143,315,303,217" href="./booking.php?p=calendar&field=3"/>
                    </map>
					<img src="images/terrains.jpg" usemap="#map" />
                </div>

<script src="includes/calendar.js"></script>
            </div>
        </div>
    </div>
<?php include_once('footer.php'); ?>