<?php

// 引入人脸检测Face SDK
require_once '../AipFace.php';

// 定义常量
const APP_ID = '10208287';
const API_KEY = 'ZX9Sx2u4zUg6b0CKgzDvU9b2';
const SECRET_KEY = 'GGh7utdqYnSZaCyjwRp5rV509NLGElE5';

// 初始化
$aipFace = new AipFace(APP_ID, API_KEY, SECRET_KEY);

//人脸检测 获取所有属性
/*  print_r($aipFace->detect(file_get_contents('a.jpg'), array(
    'face_fields' => 'age,beauty,expression,faceshape,gender,glasses,landmark,race,qualities',
))); 
 */

//----------------------------

//人脸比对
/*  $option = array(
  'image_liveness' =>'faceliveness,faceliveness',  
);

 print_r($aipFace->match(array(
    file_get_contents('b.jpg'),
    file_get_contents('a.jpg'),	
),$option)); 
 
 $option = array(
  'image_liveness' =>'faceliveness,faceliveness',  
);

$a=($aipFace->match(array(
    file_get_contents('b.jpg'),
    file_get_contents('a.jpg'),	
),$option));  
 
print_r($a['result']['0']['score']); 
 */
//返回
//Array ( [result] => Array ( [0] => Array ( [index_i] => 0 [index_j] => 1 [score] => 94.838554382324 ) ) [result_num] => 1 [ext_info] => Array ( [faceliveness] => 0.00080572545994073,0.99999141693115 ) [log_id] => 2454547124100211 ) 
//Array ( [0] => Array ( [index_i] => 0 [index_j] => 1 [score] => 94.838554382324 ) ) 

//----------------------
//人脸注册

/*  var_dump($aipFace->addUser(
    '0609', //人脸ID
    'zhong jie', //人脸信息
    'man', //分组
    file_get_contents('c.jpg') //人脸
)); */

/* var_dump($aipFace->addUser(
    '1234', //人脸ID
    'baby', //人脸信息
    'women', //分组
    file_get_contents('face.jpg') //人脸
));

var_dump($aipFace->addUser(
    '4321', //人脸ID
    'lbn', //人脸信息
    'man', //分组
    file_get_contents('hq/l.jpg') //人脸
));
 */


//人脸认证		推荐得分(result)超过80可认为认证成功
/*  var_dump($aipFace->verifyUser(
    '0609', //人脸ID
    'man', //分组
    file_get_contents('a3.jpg') //人脸
));  */

//人脸识别		要认证一张图片在指定group中是否为uid1的用户	
//可得出上面 “人脸信息”
  // print_r($aipFace->identifyUser(
    // 'man', //分组
    // file_get_contents('b.jpg') //人脸
// )); 

/* $a=($aipFace->identifyUser(
    'man', //分组
    file_get_contents('b.jpg') //人脸
)); 

echo json_encode($a); */

//人脸更新
// var_dump($aipFace->updateUser(
//     '123', //人脸ID
//     'angela babay', //人脸信息
//     'women', //分组
//     file_get_contents('face.jpg') //人脸
// ));

//人脸删除
/*  var_dump($aipFace->deleteUser(
     '663545' //人脸ID
 )); */

//人脸组内删除
// var_dump($aipFace->deleteGroupUser(
//     array('women', 'girls'), //分组
//     '123' //人脸ID
// ));

//人脸组内用户添加
// var_dump($aipFace->addGroupUser(
//     'women', //从这个分组
//     'girls', //到这个分组
//     '123' //复制这个ID的用户
// ));

//人脸ID信息查询
/* print_r($aipFace->getUser(
    '0609' //用户ID
));
 */
//分组信息查询
// var_dump($aipFace->getGroupList());

//组内用户列表查询
/* print_r($aipFace->getGroupUsers(
    'man'
)); */
