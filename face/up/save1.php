<?php
 
 
$data=(isset($_POST['data']))?$_POST['data']:null;



    $image = base64_decode($data);  
  	
	$fp = fopen('face.jpg','w');  
    fwrite($fp, $image);  
    fclose($fp);  

 
 
 
	$result = array();
	$result["success"] =true;

	echo json_encode($result);



?>


