<?php

include '../conn.php';	


$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

$result = array();

$strsql="select * from note_menu where pid=".$id." ORDER BY issort asc ";
$rs = mysql_query($strsql);

/* while($row = mysql_fetch_array($rs)){
	$row['state'] = has_child($row['pid']) ? 'closed' : 'open';
	$row['sql'] = $strsql;
	array_push($result, $row);
} */

 while($row = mysql_fetch_array($rs)){
	$node = array();
	$node['id'] = $row['mid'];
	$node['text'] = $row['text'];
	$node['pid'] = $row['pid'];
	$node['href'] = $row['href'];	
	$node['issort']= $row['issort'];	
	$node['seq']= $row['seq'];	
	$node['status']= $row['status'];
	$node['iconCls'] = $row['iconCls'];
	
	if(has_child($row['mid'])){
			$node['state'] = 'closed';
		}						
	
	array_push($result,$node);
} 
	
echo json_encode($result);

function has_child($id){
	//$rs = mysql_query("select count(*) from notebook where pid=$id");
	$rs = mysql_query("select count(*) from note_menu where pid=$id");
	$row = mysql_fetch_array($rs);
	return $row[0] > 0 ? true : false;
}

?>
