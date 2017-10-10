<?php

// 引入人脸检测Face SDK
require_once '../AipFace.php';

// 定义常量
const APP_ID = '10208287';
const API_KEY = 'ZX9Sx2u4zUg6b0CKgzDvU9b2';
const SECRET_KEY = 'GGh7utdqYnSZaCyjwRp5rV509NLGElE5';

// 初始化
$aipFace = new AipFace(APP_ID, API_KEY, SECRET_KEY);



$a=($aipFace->identifyUser(
    'man', //分组
    file_get_contents('b.jpg') //人脸
)); 

echo json_encode($a);

