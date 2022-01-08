<?php
/*
	myLOG(__FILE__.print_r($var),TRUE));
	mylog.txt is stored at web root folder.
*/

function myLOG($word='') {
	$fp = fopen($_SERVER['DOCUMENT_ROOT']."/mylog.txt","a") or die("Unable to open file!");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"<".strftime("%Y%m%d%H%M%S",time()).">\n".$word."\n") or die("unable to write");
	flock($fp, LOCK_UN);
	fclose($fp);
}
?>
