<?
include 'conn.php';

	
	$result = array();

	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	$sql="select * from note_menu where pid=".$id;

	$result = array();
	$rs = mysql_query($sql);
     while($row = mysql_fetch_array($rs)){
		$node = array();
		$node['id'] = $row['mid'];
		$node['text'] = $row['text'];
		$node['pid'] = $row['pid'];		
		$node['url']= $row['href'];		
		$node['iconCls'] = $row['iconCls'];
		
		if(has_child($row['mid'])){
				$node['state'] = 'closed';
			}						
		
		array_push($result,$node);
    } 
	
   
	 
    echo json_encode($result);
     	 
	 
	 
    function has_child($id){
		$rs = mysql_query("select count(*) from note_menu where pid=$id");
		$row = mysql_fetch_array($rs);
		return $row[0] > 0 ? true : false;
    }


?>