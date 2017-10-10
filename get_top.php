 <?php

                        
	include 'conn.php';											
	
	$rs = array();
	
	$strsql="select * from notebook where top='1'";
    
    $rs=mysql_query($strsql);
	
	$rows = array();
	while($row = mysql_fetch_object($rs)){
		array_push($rows, $row);
	}
	$result["rows"] = $rows;
	$result["sql"] = $strsql;
	echo json_encode($result);
	
    
?>