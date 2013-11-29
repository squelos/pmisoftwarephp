<nav class="sidebar" style="width:275px;position:absolute; padding-top:100px; padding-left: 10px;">
<ul>

<br>
<br>
<li class="active"><a href="#"><i class="icon-home"></i>Accueil</a></li>
<li ><a href="#"><i class="icon-cog"></i>Profil</a></li>
<li ><a href="booking.php"><i class="icon-calendar"></i>Réservation</a></li>
<!--<li >
	<a class="dropdown-toggle" href="#"><i class="icon-calendar"></i>Réservation</a>
		<ul class="dropdown-menu">
		<li><a href="">Subitem 1</a></li>
		<li><a href="">Subitem 2</a></li>
		<li><a href="">Subitem 3</a></li>
		<li class="divider"></li>
		<li><a href="">Subitem 4</a></li>
		</ul>
</li>-->
<li ><a href="#"><i class="icon-newspaper"></i>Actualités</a></li>

<?php if(isset($_SESSION['isConnected']) === true){ ?>
<li>
	<a class="dropdown-toggle" href="#"><i class="icon-key"></i>Administration</a>
		<ul class="dropdown-menu">
		<li><a href="admin.php?p=planning">Planning</a></li>
		<li><a href="admin.php?p=newsletter">Newsletter</a></li>
		</ul>
</li>
<?php } ?>
 <!--
<li class="title">Items Group 2</li>
<li><a href="#">Other Item 1</a></li>
<li><a href="#">Other item 2</a></li>
<li><a href="#">Other item 3</a></li>
<li>
<a class="dropdown-toggle" href="#">Sub menu 2</a>
<ul class="dropdown-menu">
<li><a href="">Subitem 1</a></li>
<li><a href="">Subitem 2</a></li>
<li><a href="">Subitem 3</a></li>
</ul>
</li>-->
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
