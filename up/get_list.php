 <?php

                        
	include '../conn.php';											

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	
	$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
	$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
	
	$q = isset($_POST['q']) ? $_POST['q'] : '';
	
	$rs = array();

		
	$where = " fileName like '%$q%' ";
	
	$rs = mysql_query("select count(*) from upfile where ".$where." ");
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	
	$strsql="select * from upfile where ".$where." order by $sort $order limit $offset,$rows";

    
    $rs=mysql_query($strsql);
	
	$rows = array();
	while($row = mysql_fetch_object($rs)){
		array_push($rows, $row);
	}
	$result["rows"] = $rows;
	$result["sql"] = $strsql;
	echo json_encode($result);
	
    
?>