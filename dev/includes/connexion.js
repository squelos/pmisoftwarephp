
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
						$.Notify({
				style : {background: 'green', color: 'black'},
				position : 'bottom-right',
				content:  "<p style='font-size:150%;'><i class='icon-checkmark'></i> L'indentification a réussi.</p>"
			});
		}
		else if(response.etatconnexion =="erreur"){
			$("#ajaxload").show().fadeOut();
			$.Notify({
				style : {background: 'red', color: 'black'},
				position : 'bottom-right',
				content:  "<p style='font-size:150%;'><i class='icon-warning'></i> L'indentification a échoué.</p>"
			});
			$(".text-warning").show();
		}
		else if(response.etatconnexion =="deconnecte"){
			loginFieldRefresh();
		}
	  });
}

/**
* Description de la fonction loginFieldRefresh.
*
* @author     	Fred
* @Modified by	
* @version    	1.0
* @date  	  	27/11/2013
* @Description  Refraichi le contenu du formulaire de connexion
*				
* @return		rien
*				
*/
function loginFieldRefresh(){
	$.get( "index.php", function( data ) {
	  $( "body" ).html( data );
	});
}



/**
* Description de la fonction loginFieldRefresh.
*
* @author     	Fred
* @Modified by	
* @version    	1.0
* @date  	  	27/11/2013
* @Description  Gêre le type qui tape la touche entrée
*				dans le input password
* @return		rien
*				
*/
 function enterHandler(event) {
        if (event.which == 13 || event.keyCode == 13) {
            jsconnect();
            return false;
        }
        return true;
}