<?php
include 'conn.php';

	$q = isset($_POST['q']) ? $_POST['q'] : '';
	$zd = isset($_POST['zd']) ? $_POST['zd'] : 'pid';
	
	//$sql="select * from notebook order by id desc limit 0,10 ";
	$sql="select * from notebook where ".$zd." like '%$q%' order by id desc ";
	$rs=mysql_query($sql);
	
	$rows = array();
	while($row = mysql_fetch_object($rs)){
		array_push($rows, $row);
	}
	
	echo json_encode($rows);

mysql_close($conn);  


?>


