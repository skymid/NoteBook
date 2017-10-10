<?php

		
		//$p=str_replace('notebook\up','','notebook\up\book');
		
		$p='/notebook/up/uploads/20170904-095613-349.xlsx';
		$p=str_replace('/notebook/up/','',$p);	
		unlink($p); //删除文件
//echo $p;

?>