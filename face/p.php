<!DOCTYPE html>  
<html>  
<head>  
	<title>摄像头调试</title>  
	<meta charset="utf-8">  
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

<link href="p.css" rel="stylesheet" type="text/css" >
<script> 
var video;
window.addEventListener("DOMContentLoaded", function() {  
        video = document.getElementById("video"),  
        videoObj = { "video": true },  
        errBack = function(error) {  
            console.log("Video capture error: ", error.code);   
        };  
        if(navigator.webkitGetUserMedia){//navigator.getUsermedia兼容问题
            navigator.webkitGetUserMedia(videoObj, function(stream){  
                video.src = window.URL.createObjectURL(stream); 
                video.play();
            },errBack);
        }else if(navigator.mozGetUserMedia){
            navigator.mozGetUserMedia(videoObj, function(stream){  
                video.src = window.URL.createObjectURL(stream);  
                video.play();  
            }, errBack); 
        }else if(navigator.getUserMedia){
            navigator.getUserMedia(videoObj, function(stream) {  
                video.src = stream;  
                video.play();  
            }, errBack);  
        }
})
function photo(){
	//alert();
	video.stop();
}
</script> 
<div class="video-mod">
	<div class="video-img">
		<video id="video" style="display:block;width:100%;height:100%;" style="background:#000;"></video>
		<img class="js-avatar" style="display:none;transform: scaleX(-1);" src="//uploadfiles.nowcoder.com/images/20160520/56_1463728821615_B856A5CA00C64BEA1A77436F8FE39D5E" />
		<div class="video-img-upload js-get-avatar" onclick="photo()"><i class="icon-camera">点击拍照</i></div>
	</div>
</div>