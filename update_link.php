<?php
//$sql="UPDATE notebook SET link='".substr($_POST['link'],0,-1)."' where id='".$_POST['id']."'";
		
		
		
		include 'conn.php';
		
		
		if($_POST['c']=="true"){		//添加   CONCAT时 link不能为null    sj=sj 是关联时不更新时间
			
			$sql="UPDATE notebook SET link=CONCAT(link,',','".$_POST['link']."'),sj=sj where id='".$_POST['id']."'";	
		}else{
			//第一个以后的 1,xx,2,3		//删除
			$sql="UPDATE notebook SET link=REPLACE(link, ',".$_POST['link']."', ''),sj=sj where id='".$_POST['id']."'";			
			mysql_query($sql);
			//第一个的 xx,1,2,3
			$sql="UPDATE notebook SET link=REPLACE(link, '".$_POST['link'].",', ''),sj=sj where id='".$_POST['id']."'";
		}
		
		mysql_query($sql);
		echo $sql;

		
		
		//相互关联    
		if($_POST['c']=="true"){
			
			$sql="UPDATE notebook SET link=CONCAT(link,',','".$_POST['id']."'),sj=sj where id='".$_POST['link']."'";	
		}else{
			//第一个以后的 1,xx,2,3
			$sql="UPDATE notebook SET link=REPLACE(link, ',".$_POST['id']."', ''),sj=sj where id='".$_POST['link']."'";			
			mysql_query($sql);
			//第一个的 xx,1,2,3
			$sql="UPDATE notebook SET link=REPLACE(link, '".$_POST['id'].",', ''),sj=sj where id='".$_POST['link']."'";
		}
		
		mysql_query($sql);
		echo $sql;		

?>


