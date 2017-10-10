<?php
session_start();
require '../conn.php';

/* Session_Start();
$conn = @mysql_connect('112.116.119.47','root','jsdwzx.net');
if (!$conn) {
	die('Could not connect: ' . mysql_error());
}
mysql_query("SET NAMES UTF8"); 
mysql_select_db('book', $conn); */


/*
UploadiFive
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
*/

// Set the uplaod directory
$uploadDir_ = '/notebook/up/uploads/';


// Set the allowed file extensions
$fileTypes = array('jpg', 'jpeg', 'gif', 'png','rar','txt'); // Allowed file extensions

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile   = $_FILES['Filedata']['tmp_name'];
	$uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir_;
	$targetFile = $uploadDir . $_FILES['Filedata']['name'];
	
	
    $FileID=date("Ymd-His") . '-' . rand(100,999);
	$ext=substr(strrchr($_FILES['Filedata']['name'], '.'), 1);
	$targetFile = rtrim($uploadDir,'/') . '/' . $FileID . '.' . $ext;
	move_uploaded_file($tempFile, iconv("UTF-8","gb2312", $targetFile));
	
	
	$result = array();
	$result["success"] = true;
	$result["s_path"] = $uploadDir_. $FileID . '.' . $ext;
	$result["fileName"] =$_FILES['Filedata']['name'];
	
	
/////////////////////
	$f=$_FILES['Filedata']['name'];
	$p=$uploadDir_. $FileID . '.' . $ext;
	$sql = "insert into upfile(fileName,path)values('".$f. "','" .$p. "')";	
	
	
	$result["sql"] = $sql;
	echo json_encode($result);
	
	mysql_query($sql);
}
?>