<?php
	$Config=array();
	foreach(explode(PHP_EOL, file_get_contents(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'.env')) as $s){
		if(strpos($s,'=')!==false){
			$Config[substr($s, 0, strpos($s,'='))] = substr($s, strpos($s,'=')+1);
		}
	}
?>