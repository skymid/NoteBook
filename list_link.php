 <?php

                        
	include 'conn.php';											
	
	
	$rs = array();	
	
	if(substr($_GET['link_id'],0,1)==','){		
		$strsql="SELECT * from notebook where id in(".substr($_GET['link_id'], 1,strlen($_GET['link_id'])).")";
	}else{
		$strsql="SELECT * from notebook where id in(".$_GET['link_id'].")";
	}
		
	$strsql="select * from notebook as n,note_menu as m where n.pid=m.mid and n.id in(".substr($_GET['link_id'], 1,strlen($_GET['link_id'])).")";
	    
    $rs=mysql_query($strsql);
	
	$rows = array();
	while($row = mysql_fetch_object($rs)){
		array_push($rows, $row);
	}
	$result["rows"] = $rows;
	$result["sql"] = $strsql;
	echo json_encode($rows);
	
    
?>