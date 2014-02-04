<nav class="sidebar" style="width:275px;position:absolute; padding-top:100px; padding-left: 10px;">
<ul>
<li ><a href="index.php"><i class="icon-home"></i>Accueil</a></li>
<li ><a href="booking.php?p=fields"><i class="icon-calendar"></i>Réservation</a></li>
<!--<li ><a href="news.php"><i class="icon-newspaper"></i>Actualités</a></li>-->

<?php if(isset($_SESSION['isConnected']) === true){ ?>
<li ><a href="profile.php"><i class="icon-cog"></i>Profil</a></li>
<li ><a href="stats.php"><i class="icon-stats"></i>Statistiques</a></li>
<li>
	<a class="dropdown-toggle" href="#"><i class="icon-key"></i>Administration</a>
		<ul class="dropdown-menu">
		<li ><a href="newsletter.php">Newsletter</a></li>
		<!--<li ><a href="admin_news.php">Actualités</a></li>-->
		</ul>
</li>
<?php } ?>
</ul>
</nav>

<div class="logButton">
<div class="tile bg-tcpOrange" onClick="showLogin();">
            <div class="tile-content icon">
                <i class="icon-user"></i>
            </div>
            <div class="tile-status">
                <span class="name">Profil</span>
            </div>
        </div>
</div>
