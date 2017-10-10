<?php
include '../conn.php';

$result = array();

//OK
if(isset($_POST["inserted"])){ 
	$obj=json_decode($_POST["inserted"]);	//把这个json数组转化成array对象 
	
	$n="";
	for($i=0;$i<count($obj);$i++) {
		$sql = "insert into note_menu(pid,text,href,iconCls,issort,seq,status)values
		('".$obj[$i]->pid."','".$obj[$i]->text."','".$obj[$i]->href."',
		'".$obj[$i]->iconCls."','".$obj[$i]->issort."','".$obj[$i]->seq."','".$obj[$i]->status."')";
		mysql_query($sql);		
		$n=$n.$obj[$i]->text."、";
	}	
	$result["message"] =$n."添加成功";
	
}


//ok 但最后一条 传不过来
if(isset($_POST["deleted"])){ 
	$obj=json_decode($_POST["deleted"]);	//把这个json数组转化成array对象 
	
	$n="";
	for($i=0;$i<count($obj);$i++) {
		$sql = "delete from note_menu where mid='".$obj[$i]->mid."'";
		mysql_query($sql);		
		$n=$n.$obj[$i]->text."、";
	}
	$result["message"] =$n."删除成功";
}


//OK
if(isset($_POST["updated"])){ 
	$obj=json_decode($_POST["updated"]);	//把这个json数组转化成array对象 
	
	$n="";
	for($i=0;$i<count($obj);$i++) {
		$sql = "update note_menu set pid='".$obj[$i]->pid."',text='".$obj[$i]->text."',href='".$obj[$i]->href."'
			,iconCls='".$obj[$i]->iconCls."',issort='".$obj[$i]->issort."',seq='".$obj[$i]->seq."',status='".$obj[$i]->status."' where mid='".$obj[$i]->mid."'";
		mysql_query($sql);		
		$n=$n.$obj[$i]->text."、";
	}
	$result["message"] =$n."更新成功";
}
	
	$result["success"] =true;	
	$result["sql"] =$sql;
	
	echo json_encode($result);
	mysql_close($conn);



?>