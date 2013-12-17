function showLogin()
{
	if ( $("#login" ).is( ":hidden" ) ) {
	$( "#login" ).show( "slow" );
	} else {
	$( "#login" ).hide("slow");
	}
}

function maj(url, div, wait)
			{
		  	      $.ajax({
		          url : url,
		          cache:false,
		          success:function(html){
			          $("#"+div).html(html);
			          eval(wait);
		          },
		          error:function(XMLHttpRequest, textStatus, errorThrown){
		         	console.log('error '+errorThrown);
		          }
         		 });
			}