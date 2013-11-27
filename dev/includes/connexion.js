
/**
* Description de la fonction jsconnect.
*
* @author     	Fred
* @Modified by	
* @version    	1.0
* @date  	  	26/11/2013
* @Description  Tente de connecter l'utilisateur
*				connexion réussie
* @return		rien, mais apelle loginFieldRefresh
*				en cas de succes
*/

function jsconnect () {
	$("#ajaxload").show().fadeIn();
	var login;
	var	mdp;
	login = $('#mailinput').val();
	mdp = $('#mdpinput').val();
	$.ajax({
	  type: "POST",
	  url: "includes/connexion.php",
	  data: { mail: login, pass: mdp }
	})
	  .done(function( msg ) {
		var response =  jQuery.parseJSON(msg);
		if(response.etatconnexion =="succes"){
			$(".text-warning").hide();
			loginFieldRefresh();
		}
		else if(response.etatconnexion =="erreur"){
			$("#ajaxload").show().fadeOut();
			$(".text-warning").show();
		}
		else if(response.etatconnexion =="deconnecte"){
			loginFieldRefresh();
		}
	  });
}

function loginFieldRefresh(){
	$.get( "includes/fieldlogin.php", function( data ) {
	  $( "#fieldsetlogin" ).html( data );
	});
}