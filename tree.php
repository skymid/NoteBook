<?

	include 'conn.php'; 
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	Session_Start();
 
	
	
	$sql="select * from note_menu where status=0 ORDER BY issort";
	//$sql="select * from note where status=0 ORDER BY issort";
	//$sql="select * from notebook as n,note_menu as m where n.pid=m.mid and m.status=0 ORDER BY m.issort";
	

	$result = array();
	$rs = mysql_query($sql);
    while($row = mysql_fetch_array($rs)){
		//$node = array();
		$row['id'] = $row['mid'];
		$row['text'] = $row['text'].' ('.child_num($row['mid']).')';
		$row['url']= $row['href'];		
		
		if(has_child($row['mid'])){
				$row['state'] = 'open';
			}	
			
		if($_GET['type']=='nr'){
			//包含列表内容
			$row['children'] = children($row['mid']);			
		}	

		
		array_push($result,$row);
    }
     
	 
    echo json_encode($result);
     	 
	function children($id){
		$sql="select * from notebook where title like '%".$_POST['q']."%' and pid=$id";
		//$sql="select * from notebook as n,note_menu as m where n.pid=m.mid and n.title like '%".$_POST['q']."%' and n.pid=$id";

		$result = array();
		$rs = mysql_query($sql);
		while($row = mysql_fetch_array($rs,MYSQL_ASSOC)){
			$row['text'] = $row['title'];
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