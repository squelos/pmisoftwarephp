<?php

include_once('includes/functions.php');
include_once('header.php');

?>
    <div class="page">
        <div class="page-region">
            <div class="page-region-content">
                <h1>
                    <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Accueil
                </h1>
				<div class="example">
                    Texte d'accueil
                </div>
				<?php
					if(isset($_GET['loginerror'])){
					?>
				<div class="example" style='border-color:red;'>
					<p>Votre email ou votre mot de passe ne sont pas correct ! </p>
                </div>
					
					<?php
					}
                    else
                    {
				?>

                <div class="example">
					<?php
                        $db = new db();

                        $query = $db->query("SELECT TOP 1 * FROM NewsSet WHERE Visibility='true' ORDER BY PublishDate DESC ","get last news");
                        
                        if (mssql_num_rows($query)>0)
                        {
                            $title = mssql_result($query, 0, "Title");
                            $PublishDate = mssql_result($query, 0, "PublishDate");
                            $date = new DateTime($PublishDate);
                            $date = $date->format('d/m/Y H:i:s');
                            $content = mssql_result($query, 0, "Content");

                            echo '<div class="result"><div style="float:left;"><h2>'.$title.'</h2></div><div style="float:right;"></div><div style="float:right;">'.$date.'</div><div style="clear:both"></div><div style="width:100%;">'.$content.'</div></div>';
                        }
                    ?>
					<p>Dump des sessions : <b><?php print_r($_SESSION);?></b></p>
					<p>mail : <?php //mailSend("frederic.hilpert@gmail.com", "test", "test <b>test</b>"); ?></p>
                </div>
                <?php
                    }
                ?>


            </div>
        </div>
        <script type="text/javascript">
        $("#datepicker").datepicker();</script>
<?php include_once('footer.php'); ?>