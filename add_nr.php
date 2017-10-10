<?php
include 'conn.php';

 
//$sql="INSERT INTO notebook(title,note,create_date,sj1,sj2) VALUES('$_POST[send_zt]','$_POST[editorValue]',now(),curdate(),curtime())"; 
//$sql="INSERT INTO notebook(pid,title,nr,sj_lb) VALUES('0','".$_POST[send_zt]."','".$_POST[editorValue]."','".date('Y-m-d')."')"; 
//echo $sql;
$sql="INSERT INTO notebook(title,sj_lb) VALUES('".$_POST['send_zt']."','".date('Y-m-d')."')"; 

$result = array();
if (!mysql_query($sql)
  {
	$result["success"] =false;
	$result["message"] ="Send失败". mysql_error();	  
	  
  die('Error: ' . mysql_error());
  }
	
	$result["success"] =true;
	$result["message"] ="Send成功";	
	
	
	echo json_encode($result);

mysql_close($conn);


?>


