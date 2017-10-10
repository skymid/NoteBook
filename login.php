<!DOCTYPE html>

<html>
<head>
<meta charset="UTF-8">
    <meta charset="UTF-8">  
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login</title>  
	<?php
		require_once("../inc.js");
	?>
<script type="text/javascript" charset="utf-8" src="Jquery.md5.js"  Charset="UTF-8"></script>
<script type="text/javascript" charset="utf-8" src="jquerysession.js"  Charset="UTF-8"></script>
<script type="text/javascript">
$(function(){
	$('#username').textbox().next('span').find('input').focus();

	
	$('#password').textbox('textbox').keydown(function (e) {
		if (e.keyCode == 13) {
			login();
		}
	});

});


function login(){
	
	var user = $.md5($('#username').textbox('getText'));
	var pwd  = $.md5($('#password').textbox('getValue'));
	
	if(user=='fb052373c6d70cc2403a6012285c9df7' && pwd=='2aa4ae3744d9109ae7e8662ef47ba853' ){
		$.messager.show({
			title:' Title',
			msg:'OK',
			showType:'fade',
			style:{
				right:'',
				bottom:''
			}
		});	
		$.session.set('user', $('#username').textbox('getText'))	
		window.location = "pc.php";
	}else{
		$.messager.show({
			title:'Title',
			msg:'Error',
			showType:'fade',
			style:{
				right:'',
				bottom:''
			}
		});		
	}
}

</script>	
</head>

<body>
    <div class="easyui-navpanel">
        <header>
            <div class="m-toolbar">
                <span class="m-title">Login to NoteCloud</span>
            </div>
        </header>
		
        <div style="margin:20px auto;width:100px;height:100px;border-radius:100px;overflow:hidden">
            <img  onClick="location.href='face/index.php'" src="images/face.png" style="margin:0;width:100%;height:100%;">
        </div>
		
        <div style="padding:0 220px">
            <div style="margin-bottom:10px">
                <input id="username" value="skymid" class="easyui-textbox" data-options="prompt:'Type username',iconCls:'icon-man'" style="width:100%;height:38px">
            </div>
			
            <div>
                <input id="password" value="030214" class="easyui-passwordbox" data-options="prompt:'Type password'" style="width:100%;height:38px">
            </div>
			
            <div style="text-align:center;margin-top:30px">
                <a onclick="login()" class="easyui-linkbutton" style="width:100%;height:50px"><span style="font-size:16px">Login</span></a>
            </div>            
        </div>
    </div>
</body> 
  
</html>
