<?php
include '../conn.php';

// 引入人脸检测Face SDK
require_once 'AipFace.php';

// 定义常量
const APP_ID = '10208287';
const API_KEY = 'ZX9Sx2u4zUg6b0CKgzDvU9b2';
const SECRET_KEY = 'GGh7utdqYnSZaCyjwRp5rV509NLGElE5';

// 初始化
$aipFace = new AipFace(APP_ID, API_KEY, SECRET_KEY);


if($_POST['bz']=='identifyUser'){
	
	if($_POST['v']!="me"){
		//人脸识别  要计算一张图片与指定组group1内用户相似度：只要已登入的人，都可以登录
		$a=($aipFace->identifyUser(
			'man', 		//分组
			file_get_contents($_POST['pic'])
		)); 		
	}else{
		//人脸认证 要认证一张图片在指定group中是否为uid1的用户   就是说只能我自己登录
		$a=($aipFace->verifyUser(
		'0609', 			//人脸ID
		'man', 				//分组
		file_get_contents($_POST['pic']) //人脸	
		));	
	}
}

$uid=mt_rand(111111111,999999999);
if($_POST['bz']=='addUser'){
	
	$a=($aipFace->addUser(
		$uid, //人脸ID
		$_POST['name'], //人脸信息
		'man', //分组
		file_get_contents($_POST['pic']) //人脸
	));
	
	$sql = "insert into user(user,uid,groud)values('".$_POST['name']."','".$uid."','man')";
	mysql_query($sql);	
}

echo json_encode($a);

?>

