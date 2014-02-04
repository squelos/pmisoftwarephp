$( "#pwd1" ).keyup(function() {
		mdpCheck();
});

$( "#pwd2" ).keyup(function() {
		mdpCheck();
	});

function mdpCheck(){
	var score=0;
	var match;
	var mdp;
	mdp = $( "#pwd1" ).val();

	match = new RegExp("[a-z]+","");
	if (match.test(mdp))
		score+=1;

	match = new RegExp("[A-Z]+","");
	if (match.test(mdp))
		score+=2;

	match = new RegExp("[0-9]+","");
	if (match.test(mdp))
		score+=2;

	match = new RegExp("[^A-Za-z0-9]+","");
	if (match.test(mdp))
		score+=3;

	score+=mdp.length/4;
	score=score*10;
	if(score>100){
		score=100;
	}
	var couleur;
	if (score<30){
		couleur = "#FF0000";
	}
	else if (score < 50){
		couleur="#FFA500";
	}
	else{
		couleur="#008000";
	}
	
	

	var pb = $("#barreCplxMdp").progressbar();
    pb.progressbar('value', score);
    pb.progressbar('color', couleur);
	//console.log("score="+ score + "couleur=" + couleur);
	$( "#scorediv" ).html(score+"/100");
	if($( "#pwd1" ).val() == $( "#pwd2" ).val() && $( "#pwd1" ).val()!=""){
		var htmltxt = '<p style="font-size:120%;"><span class="icon-checkmark on-left" style="color: green;"></span>Les mots de passe sont identiques.</p>';
		$( "#mdpUniqCheck" ).html(htmltxt);
		$("#submitbtn").removeClass("disabled");
	}
	else{
		var htmltxt = '<p  style="color: red; font-size:120%;"><span class="icon-cancel on-left" style=""></span>Les mots de passe ne sont pas identiques.</p>'
		$( "#mdpUniqCheck" ).html(htmltxt);
		$("#submitbtn").addClass("disabled");
	}
}



function pwdresetvalidate(){
	if($("#submitbtn").hasClass("disabled")){
		alert("Vous devez renseigner deux mots de passe identiques.")
	}
	else if($( "#pwd1" ).val().length <4){
		alert("Le mot de passe doit faire au moins 4 caractères." );
	}
	else {
		var mkey = getUrlVars()["key"];
		if(mkey[mkey.length-1] == "#"){
			mkey=mkey.substr(0, mkey.length-1);
		}
		var jqxhr = $.post( "profile.php?p=pwdset", { uid: getUrlVars()["uid"], key: mkey, pwd: $( "#pwd1" ).val() })
			  .done(function(data ) {
			    if(data=="success"){
			    	window.location.replace("index.php");
			    }
			    else{
			    	alert("Une erreur est survenue");
			    }
			  })
			  .fail(function() {
			    alert( "Une erreur est survenue, vérifiez votre connexion réseau et réessayez." );
			  })
	}
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}




//fonctions pour l'index du profil
function chgPwd(){
	$('#chgMail').hide();
	$('#chgPwd').show();
	$.get( "includes/profile_pwdreset_fromprofile.php", function( data ) {
		  $( "#chgPwd" ).html( data );
		 //alert( "Load was performed." );
		});
}
function chgMail(){
	$('#chgPwd').hide();
	$('#chgMail').show();
}