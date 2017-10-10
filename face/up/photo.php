<!DOCTYPE html>  
<html>  
<head>  
	<title>photo</title>  
	<meta charset="utf-8">  
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<script src="a/jquery.min.js"></script>
	<script src="a/jquery.Jcrop.min.js"></script>
	
</head>  
<body>  
<video id="video" width="640" height="480" autoplay onclick="scamera()"></video>	
<canvas id="canvas" width="640" height="480" style="display:none;"></canvas>

 <script > 
var canvasObj;
navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia||
	 navigator.mozGetUserMedia || navigator.msGetUserMedia;			 

navigator.getUserMedia({ video: true }, successsCallback, errorCallback);		


function successsCallback(stream) {
	document.getElementById('video').src = 
		(window.URL && window.URL.createObjectURL) ? window.URL.createObjectURL(stream) : stream;
	}

function errorCallback(err) {

}


function scamera() {
	
 	var videoElement = document.getElementById('video');
	canvasObj = document.getElementById('canvas');
	var context1 = canvasObj.getContext('2d');
	context1.fillStyle = "#ffffff";
	context1.fillRect(0, 0,640,480);
	context1.drawImage(videoElement, 0, 0,640,480);
	//alert("PaiZhaoSuccess");
	
	var imgData=canvasObj.toDataURL();
	var imgData=imgData.substring(22);
	//alert(data);
	
	$.ajax({
		type: "POST",
		url: "save1.php",
		data: {
			data:imgData,id:'d'
		},
		success: function(msg){
			var msg = eval('(' + msg + ')');
			console.log(msg);
			}
	});

}	


 
</script>  
</body>  
</html>