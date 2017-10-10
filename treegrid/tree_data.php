<?

	include '../conn.php'; 
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	Session_Start();
 
	
	
	$sql="select * from note_menu where status=0 ORDER BY issort";

	$result = array();
	$rs = mysql_query($sql);
    while($row = mysql_fetch_array($rs)){
		$node = array();
		$node['id'] = $row['mid'];
		$node['text'] = $row['text'].' ('.child_num($row['mid']).')';
		$node['pid'] = $row['pid'];		
		$node['url']= $row['href'];		
		$node['iconCls'] = $row['iconCls'];
		
		if(has_child($row['mid'])){
				//$node['state'] = 'closed';
				$node['state'] = 'open';
			}						
		$node['children'] = children($row['mid']);
		
		array_push($result,$node);
    }
     
	 
    echo json_encode($result);
  
	function children($id){
		$sql="select * from notebook where title like '%".$_POST['q']."%' and pid=$id";

		$result = array();
		$rs = mysql_query($sql);
		while($row = mysql_fetch_array($rs,MYSQL_ASSOC)){
			$row['text'] = $row['title'];
			
			if($row['link']){
			//	$row['checked']=true;		//勾选全部了 不对
			}			
			
			array_push($result,$row);
			/* $node = array();
			$node['id'] = $row['mid'];
			$node['text'] = $row['title'];
			$node['pid'] = $row['pid'];		

			if(has_child($row['mid'])){
					$node['state'] = 'closed';
				}			
			array_push($result,$node); */
		}
		return $result;
	}  
	 
	 
    function has_child($id){
		$rs = mysql_query("select count(*) from note_menu where pid=$id");
		$row = mysql_fetch_array($rs);
		return $row[0] > 0 ? true : false;
    }
	
    function child_num($id){
		$rs = mysql_query("select count(*) from notebook where pid=$id");
		$row = mysql_fetch_array($rs);
		return $row[0];
    }
	
?>