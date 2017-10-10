<?php

include '../conn.php';	



if($_GET['opt']=='del'){
	$strsql="DELETE FROM note_menu WHERE mid=".$_POST['id'];
	mysql_query($strsql);	
}

if($_GET['opt']=='add'){

	$strsql=" INSERT INTO note_menu (pid,text) VALUES('".$_POST['data']['pid']."','".$_POST['data']['text']."')";
	mysql_query($strsql);	
}

if($_GET['opt']=='edit'){

	$strsql="UPDATE note_menu SET text='".$_POST['data']['text']."',issort='".$_POST['data']['issort']."'
		,href='".$_POST['data']['href']."',iconCls='".$_POST['data']['iconCls']."'
		,seq='".$_POST['data']['seq']."',status='".$_POST['data']['status']."' 
		WHERE mid=".$_POST['data']['id'];
	mysql_query($strsql);	
}

if($_GET['opt']=='dnd'){

	$strsql="UPDATE note_menu SET pid='".$_POST['destId']."' WHERE mid=".$_POST['srcId'];
	mysql_query($strsql);	
}

$result = array();
$result['result']=true;
$result['sql']=$strsql;	


	
echo json_encode($result);



?>
