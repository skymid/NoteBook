<?php
include '../conn.php';

$result = array();

	if($_GET['xg']){
		
		$sql2 = "update upfile set fileName='".$_POST['file']."' where id='".$_POST["id"]."'";
		mysql_query($sql2);
	
		$result["message"] ="修改成功";	
		$result["success"] =true;	
		$result["sql"] =$sql2;			
	
	}else{
		
		$sql = "delete from upfile where id='".$_POST["id"]."'";
		mysql_query($sql);	

		$p=$_POST["p"];
		$p=str_replace('/notebook/up/','',$p);	
		unlink($p); //删除文件
			
		$result["message"] =$p;		
		//$result["message"] ="删除成功";	
		$result["success"] =true;	
		$result["sql"] =$sql;		
	}

	
	echo json_encode($result);
	mysql_close($conn);



?>