<!DOCTYPE html>  
<html>  
<head>  
	<title>face</title>  
	<meta charset="utf-8">  
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
<?
require_once("../../inc.js")
?>
<script src="a/jquery.Jcrop.min.js"></script>
	
</head>  
<body>  

<div id="dd" class="easyui-dialog" title="face" style="width:655px;height:540px;"   
        data-options="modal:true,header:'#tb'">   
	<video id="video" width="640" height="480" autoplay onclick="identify()" style="border:5px solid #fff;"></video>	
	<canvas id="canvas" width="640" height="480" style="display:none;"></canvas>  
</div> 

<script > 

var canvasObj;
navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia||
	 navigator.mozGetUserMedia || navigator.msGetUserMedia;			 

navigator.getUserMedia({ video: true }, successsCallback, errorCallback);		

function successsCallback(stream) {
	document.getElementById('video').src = 
		(window.URL && window.URL.createObjectURL) ? window.URL.createObjectURL(stream) : stream;
	}

function errorCallback(err) {}

$(function(){});

var v='me';	//认证  all 识别
function identify() {
	
 	var videoElement = document.getElementById('video');
	canvasObj = document.getElementById('canvas');
	var context1 = canvasObj.getContext('2d');
	context1.fillStyle = "#ffffff";
	context1.fillRect(0, 0,640,480);
	context1.drawImage(videoElement, 0, 0,640,480);

	var imgData=canvasObj.toDataURL();
	var imgData=imgData.substring(22);
	
	document.getElementById('video').style['border']='5px solid #F00';
	
	$.ajax({
		type: "POST",
		url: "save.php",
		data: {
			data:imgData
		},
		success: function(msg){
			var msg = eval('(' + msg + ')');
			//console.log(msg);
			//$v="me";		//1 只有我可以登录
			$.ajax({							
				url:'face.php',    
				type:'post',
				data : {
					v:v,
					bz:'identifyUser',	
					pic:'face.jpg'
				},
				success:function(data){
				   document.getElementById('video').style['border']='5px solid #fff'	
					
				   var data = eval('(' + data + ')'); 				   
				   console.log(data);

				   if(v=='me'){ 
					   var s=data.result[0];
					   var n='me';		
				   }else{
					   console.log(data.result[0]);				   
					   console.log(data.result[0].uid);
					   console.log(data.result[0].user_info);
					   
					   var s=data.result[0].scores[0];
					   var n=data.result[0].user_info;
				   } 			   						   
				   
				   console.log(s); 
				   if(s>90){
					   alert("匹配成功_ "+s + " _"+ n);
					   $.session.set('user', 'skymid');
					   location.href='../pc.php';
				   }else{
					   alert("匹配不成功_ "+s);
				   }				   
				}										
			})	
		}
	});
}	

function add() {
	
	$.messager.prompt('提示信息', '请输入你的姓名：', function(r){
		if (r){
			
			var videoElement = document.getElementById('video');
			canvasObj = document.getElementById('canvas');
			var context1 = canvasObj.getContext('2d');
			context1.fillStyle = "#ffffff";
			context1.fillRect(0, 0,640,480);
			context1.drawImage(videoElement, 0, 0,640,480);

			var imgData=canvasObj.toDataURL();
			var imgData=imgData.substring(22);
			
			$.ajax({
				type: "POST",
				url: "save.php",
				data: {					
					data:imgData
				},
				success: function(msg){
					var msg = eval('(' + msg + ')');
					console.log(msg);
					
					$.ajax({							
						url:'face.php',    
						type:'post',
						data : {
							name:r,
							bz:'addUser',	
							pic:'face.jpg'
						},
						success:function(data){
						   var data = eval('(' + data + ')'); 				   
						   console.log(data);				   
						}										
					})	
				}
			});
		}
	});

}	
</script>  

</body> 
 	<div id="tb" style="padding:3px 10px;" >
		<div class="m-toolbar">
			<div class="m-left">
				<a  onclick="add()" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true"></a>
				<a  onClick="location.href='../login.php'" class="easyui-linkbutton" data-options="iconCls:'icon-back',plain:true"></a>
			</div>
			
			<div style="font-weight:bold;font-size:15px;color:#32CD32">
				<span class="m-title" id="nr_read_title">基于【baidu AI】的人脸识别</span>
			</div>			
			
			<div class="m-right">
				<input  class="easyui-switchbutton" 
				data-options="onText:'识别',offText:'认证',onChange:function(checked){
					
					if(checked){ v='all'}else{v='me'}
					console.log(v);
				}">
			</div>
		</div>
	</div>
</html>