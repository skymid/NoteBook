<?
include '../conn.php';


if(isset($_POST["updated"])){ 
	$obj=json_decode($_POST["updated"]);	//把这个json数组转化成array对象 
	
	$n="";
	for($i=0;$i<count($obj);$i++) {
		$sql = "update plan set nr='".$obj[$i]->nr."',lb='".$obj[$i]->lb."',isSort='".$obj[$i]->isSort."' where id='".$obj[$i]->id."'";
		mysql_query($sql);		
		$n=$n.$obj[$i]->id."、";
	}
	$result["message"] =$n."更新成功";

	
	$result["success"] =true;	
	$result["sql"] =$sql;
	
	echo json_encode($result);
	mysql_close($conn);
	
}elseif(isset($_POST["inserted"])){
	
	$obj=json_decode($_POST["inserted"]);	//把这个json数组转化成array对象 
	
	$n="";
	for($i=0;$i<count($obj);$i++) {
		$sql="INSERT INTO plan(nr,lb,sj,isSort) VALUES('".$obj[$i]->nr."','".$obj[$i]->lb."','".date('Y-m-d')."','".$obj[$i]->isSort."')"; 

		mysql_query($sql);		
		$n=$n.$obj[$i]->nr."、";
	}
	$result["message"] =$n."添加成功";

	
	$result["success"] =true;	
	$result["sql"] =$sql;
	
	echo json_encode($result);
	mysql_close($conn);	
	
}elseif($_GET["del_id"]){
	
	$sql = "DELETE FROM plan WHERE id='".$_GET["del_id"]."'";
	mysql_query($sql);
	$result["message"] =$_GET["del_id"]."删除成功";
	$result["success"] =true;	
	$result["sql"] =$sql;
	
}elseif($_POST["ok_id"]){
	
	if($_POST["opertion"]=='1'){
		$sql = "update plan set isok='0' where id='".$_POST["ok_id"]."'";
	}else{
		$sql = "update plan set isok='1' where id='".$_POST["ok_id"]."'";
	}
	mysql_query($sql);		
	
	$result["message"] =$_POST["ok_id"]."计划完成";
	
	$result["success"] =true;	
	$result["sql"] =$sql;
	
	echo json_encode($result);
	mysql_close($conn);	
	
}else{

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	
	$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'isSort';
	$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
		
	$result = array();

	if($_POST["q"]=="all"){
		$sql="SELECT * from plan  order by $sort $order limit $offset,$rows";
		$sq2="SELECT count(*) from plan  ";
	}else{
		$sql="SELECT * from plan where isok <>'1' order by $sort $order limit $offset,$rows ";
		$sq2="SELECT count(*) from plan where isok <>'1'  ";
	}
	$rs = mysql_query($sql);
	
	$rs2 = mysql_query($sq2);
	$row2 = mysql_fetch_row($rs2);
	$result["total"] = $row2[0];		
	
	$rows = array();
	while($row = mysql_fetch_object($rs)){
		array_push($rows, $row);
	}
	$result["rows"] = $rows;
	$result["sql"] = $sql;
	
	echo json_encode($result);
}	


?>