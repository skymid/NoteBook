<?php
include 'conn.php';


 $sql="select * from notebook where id=$_GET[id]";

    $result = array();
    $rs=mysql_query($sql);
	$row = mysql_fetch_object($rs);
	$result["success"] =true;
	$result["id"] =$row->id;
	$result["pid"] =$row->pid;
	$result["title"] =$row->title;
	$result["nr"] =$row->nr;
	$result["fb"] =$row->sj;
    $result["message"] =$sql;		

	echo json_encode($result);

mysql_close($conn);  

?>


