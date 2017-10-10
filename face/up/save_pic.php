<?php
 
 
$data=(isset($_POST['data']))?$_POST['data']:null;

	if(!file_exists('images'))
	{
	  mkdir('images'); 
	  chmod('images', 0777);
	}	

    $image = base64_decode($data);  
  	$filename=creatImageName();
  	//$filename=$_POST['kh'].'.jpg';
    
	$fp = fopen('images/'.$filename,'w');  
    fwrite($fp, $image);  
    fclose($fp);  

/*
**给图片命名防止文件名重复
*/
function creatImageName(){
    $deftimezone=date_default_timezone_get();//获取原有时区
    date_default_timezone_set("PRC");//设置为中国时区
    $time_filename=date('Ymdhis');//按时间命名
    date_default_timezone_set(deftimezone);//恢复原有时区防止程序混乱
    $finleName=$time_filename.'_'.dechex(mt_rand(65536,1048575)).'.'.'jpg';
    return $finleName;
}
 
 
 
 
	$result = array();
	$result["success"] =true;
	$result["message"] ='images/'.$filename;	

	echo json_encode($result);



?>


