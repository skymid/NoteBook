 <?php

                        
	include 'conn.php';											

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	
	$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
	$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
	
	$q = isset($_POST['q']) ? $_POST['q'] : '';
	$pid = isset($_POST['pid']) ? $_POST['pid'] : '';
	
	$nr = isset($_POST['nr']) ? $_POST['nr'] : '';
	$zd = isset($_POST['zd']) ? $_POST['zd'] : 'nr';
	
	$rs = array();
			
	$where = $zd ." like '%$nr%' and n.pid like '%$pid%' ";
	
	$rs = mysql_query("select count(*) from notebook as n where ".$where." ");
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];

	$rs = mysql_query("select * from notebook as n,note_menu as m where n.pid=m.mid and n.top='1'");
	$row = mysql_fetch_object($rs);
	$result["row_top"] = $row;

	$rs = mysql_query("SELECT id from notebook ORDER BY id DESC LIMIT 1");
	$row = mysql_fetch_object($rs);
	$result["max_id"] = $row->id;	
	
	//$strsql="select * from notebook as n,note_menu as m where n.pid=m.mid and ".$where." GROUP BY title order by $sort $order limit $offset,$rows ";   
	$strsql="select * from notebook as n,note_menu as m where n.pid=m.mid and ".$where."  order by $sort $order limit $offset,$rows ";    	
    $rs=mysql_query($strsql);
	
	$rows = array();
	while($row = mysql_fetch_object($rs)){
		array_push($rows, $row);
	}
	$result["rows"] = $rows;
	$result["sql"] = $strsql;
	echo json_encode($result);
	
	
$sql = "insert into log(ip,s_ip,logtime,nr)values('".getIP()."','".getip_out()."','".date('Y-m-d H:i:s')."','list')";
mysql_query($sql);		
    
?>