<?php

// 引入人脸检测Face SDK
require_once 'AipFace.php';

// 定义常量
const APP_ID = '10208287';
const API_KEY = 'ZX9Sx2u4zUg6b0CKgzDvU9b2';
const SECRET_KEY = 'GGh7utdqYnSZaCyjwRp5rV509NLGElE5';

// 初始化
 $aipFace = new AipFace(APP_ID, API_KEY, SECRET_KEY);

 
 //人脸检测 获取所有属性
/*  echo json_encode($aipFace->detect(file_get_contents('test.jpg'), array(
    'face_fields' => 'age,beauty,expression,faceshape,gender,glasses,landmark,race,qualities',
	'max_face_num' => '3',
)));  */
 
 
 
 
/* $option = array(
	'image_liveness' =>'faceliveness,faceliveness',  
);

echo json_encode($aipFace->match(array(
    file_get_contents('ren/a1.jpg'),
    file_get_contents('ren/d.jpg'),	
),$option));  
  */
  
  
  
  
//人脸识别		要认证一张图片在指定group中是否为uid1的用户	
//可得出上面 “人脸信息”/
/* $options = array(
  'user_top_num' => 1,
  'face_top_num' => 2,
);
echo json_encode($aipFace->identifyUser(
    'man', //分组
    file_get_contents('ren/b.jpg') //人脸
,$options));  */  


echo json_encode($aipFace->getGroupUsers('man'));