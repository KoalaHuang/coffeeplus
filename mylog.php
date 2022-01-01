<?php
/**
 * 写日志，方便测试（看网站需求，也可以改成把记录存入数据库）
 * 注意：服务器需要开通fopen配置

 How to use:
 if (JDEBUG) 
	{
		include_once("mylog.php"); //#HHJ#
		myLOG("Match\n" . print_r($matches[0][$i],TRUE));
	}		
 */
function myLOG($word='') {
	$fp = fopen("mylog.txt","a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"<".strftime("%Y%m%d%H%M%S",time()).">\n".$word."\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}
?>