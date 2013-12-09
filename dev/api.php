<?php

include_once('includes/functions.php');

(isset($_GET['p']) === true ? '' : die('accès direct interdit'));
$pageDemandee = cleanGetVar($_GET['p']);
if($pageDemandee=='authAsk'){
	$words = preg_split('//', 'abcdefghijklmnopqrstuvwxyz0123456789', -1);
	shuffle($words);
	$buffer='';
	foreach($words as $word) {
		$buffer.=$word;
	}
	$errorBit=0;
	$fp = fopen('mot.txt', 'w');
	fwrite($fp, $buffer)=== FALSE ? '' :  $errorBit=1;
	fclose($fp);
	$errorBit==1 ? $dump['mot']=$buffer : die('erreur');

}
elseif($pageDemandee=='getList'){
	isset($_GET['key']) === true ? $key = cleanGetVar($_GET['key']) : die('key manquante');
	$fp = fopen('mot.txt', 'r');
	$maKey=fgets($fp);
	fclose($fp);
	$errorBit=0;
	$fp = fopen('mot.txt', 'w');
	fwrite($fp, '')=== FALSE ?  $errorBit=1 : '';
	fclose($fp) ? $errorbit=0 : '';
	//print_r($maKey);
	//print_r($key);
	$hash = hash('sha256', 'quickpass' . $maKey . 'quickpass');
	if($key==$hash AND $errorbit==0){
		$bdd = new db();
		$listeBadges = $bdd->listeBadgeActive();
		foreach ($listeBadges as $badge){
			if($badge!='')
			$dump['badges'][]=$badge;
		}
		/*$dump['badges'][]='0004147071';
		$dump['badges'][]='0004086341';
		$dump['badges'][]='0004127606';*/
	}
	else{
		die('erreur');
	}
}
elseif($pageDemandee=='hash'){
	isset($_GET['key']) === true ? $key = cleanGetVar($_GET['key']) : die('key manquante');
	$dump['hash'] =  hash('sha256', 'quickpass' . $key . 'quickpass');
}
else{
die('bien tenté');
}

echo json_encode($dump);



?>