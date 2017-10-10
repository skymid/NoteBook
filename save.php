<?php
include 'conn.php';

$save_view='';
$log_lb='';	//add 1 del 2 xg 3 查 4

if($_GET['option']=='del'){
	
	$sql="delete from notebook  where id='".$_GET['id']."'"; 	
	$log_lb='2';
}else{
	
	
	$tag=implode(',',$_POST['tag']);	//增加
	
	if($_POST['bz']=="add"){	
	
		$sql="INSERT INTO notebook(pid,title,nr,tag,sj_lb) VALUES('".$_POST['pid']."','".$_POST['title_']."','".$_POST['nr']."','$tag','".date('Y-m-d')."')"; 
		$log_lb='1';
	}elseif($_POST['bz']=="xg"){	//修改  bz='xg'
	
		if($_POST['nr_id']){
			$nr_id=$_POST['nr_id'];
		}else{
			$nr_id=$_GET['nr_id'];
		}
	
		if($_POST['pid']==""){
			$sql="UPDATE notebook SET title='".$_POST['title_']."',nr='".$_POST['nr']."',tag='$tag' where id='".$nr_id."'"; 
		}else{
			
			//多修改分类【pid】一项
			$sql="UPDATE notebook SET pid='".$_POST['pid']."',title='".$_POST['title_']."',nr='".$_POST['nr']."',tag='$tag' where id='".$nr_id."'"; 
			
			//给返回时看一下数据 pid这类的 主要是不包含 nr 这项
			$save_view="UPDATE notebook SET pid='".$_POST['pid']."',title='".$_POST['title_']."',tag='$tag' where id='".$nr_id."'";
		}
		$log_lb='3';	
		
	}elseif($_POST['bz']=="xg_password"){	//设置密码	
		$sql="UPDATE notebook SET password='".$_POST['password']."',set_lock='1' where id='".$_POST['id']."'"; 		
	}elseif($_POST['bz']=="xg_unpassword"){ 	
		$sql="UPDATE notebook SET password='',set_lock='' where id='".$_POST['id']."'";
		
	}elseif($_POST['bz']=="top"){		//置顶
		$sql="UPDATE notebook SET top=''";
		mysql_query($sql);
		
		$sql="UPDATE notebook SET top='1' where id='".$_POST['nr_id']."'"; 
		
	}elseif($_POST['bz']=="Collect"){	//收藏		
		$sql="UPDATE notebook SET collect='1' where id='".$_POST['nr_id']."'";				
	}elseif($_POST['bz']=="no_Collect"){		
		$sql="UPDATE notebook SET collect='0' where id='".$_POST['nr_id']."'";
				
	}elseif($_POST['bz']=="read"){	//点一行时，记录查看日志	
		
		$sql = "insert into log(nr,ip,s_ip,logtime)values('查看_".$_POST['nr_title']."','".getIP()."','".getip_out()."','".date('Y-m-d H:i:s')."')";
		$log_lb='4';	
	}	
} 


$result = array();
if (!mysql_query($sql))
  {
	$result["success"] =false;
	$result["message"] ="失败!!". mysql_error();	  
	  
	die('Error: ' . mysql_error());
  }

	if($_POST['bz']=="add"){
		$rs = mysql_query("SELECT id from notebook ORDER BY id DESC LIMIT 1");
		$row = mysql_fetch_object($rs);
		$result["max_id"] = $row->id;		//返回给新建->保存后，再保存时用		
	}else{
		$result["max_id"] =$_POST['nr_id'];	//修改的就用原来的
	}

	
	$result["success"] =true;
	$result["message"] ="成功 OK !!!";	
	$result["sql"] =$sql;
	$result["save_view"] =$save_view;
	
	echo json_encode($result);
	
	//日志  查看时有两条日志  1、if (!mysql_query($sql))  2、下面的		
	$sql = "insert into log(ip,s_ip,logtime,nr,lb,book_id,book_nr)values
	('".getIP()."','".getip_out()."','".date('Y-m-d H:i:s')."','".str_replace("'","",$sql)." _".$_POST['nr_del']."','".$log_lb."','".$nr_id."','".$_POST['nr']."')";
	mysql_query($sql);		
	
	
	mysql_close($conn);

	

?>


