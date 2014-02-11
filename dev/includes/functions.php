<?php
@session_start();
include('db.php');

/**
* Fonction cleanGetVar.
*
* @author     	Fred
* @version    	1.0
* @date  	  	26/11/2013
* @Description  Nettoie les variables qu'on recois en GET 
*				et en POST || A verifier / ameliorer
* @return		La variable nettoyee
*
*/ 
 function cleanGetVar($inputVar)
 {
   //$inputVar = mysql_real_escape_string($inputVar); //Obsolète a partir de php 5.5.0
   //$inputVar = htmlspecialchars($inputVar, 'utf-8');
   $inputVar = strip_tags($inputVar);
   $inputVar = stripslashes($inputVar);
   return $inputVar; //enfait la c'est outputVar, mais bon on fais du PHP...
 }
 
 function mailSend($to, $subject, $content){
 	@include_once 'mail/class.phpmailer.php';
 	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
 	
 	$mail->IsSMTP(); // telling the class to use SMTP
 	
 	try {
 		$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
 		$mail->SMTPAuth   = true;                  // enable SMTP authentication
 		$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
 		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
 		$mail->Port       = 25;                   // set the SMTP port for the GMAIL server
 		$mail->Username   = "christopher.robert.test@gmail.com"; 
 		$mail->Password   = "Quickpass54";            
 		$mail->AddAddress($to, '');
 		$mail->SetFrom('contact@tennis-club-portois.fr', 'Tennis Club Portois');
 		$mail->Subject = $subject;
 		$mail->MsgHTML($content);
 		$mail->Send();
 		//echo "Message Sent OK</p>\n";
 	} catch (phpmailerException $e) {
 		echo $e->errorMessage(); //Pretty error messages from PHPMailer
 	} catch (Exception $e) {
 		echo $e->getMessage(); //Boring error messages from anything else!
 	}
 	$mail->SMTPSecure = "ssl";
 }


?>