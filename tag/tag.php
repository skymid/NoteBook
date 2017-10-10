<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>NoteBook</title>
<link href="images/favicon.ico" mce_href="images/favicon.ico" rel="icon">
<?php
require_once("../../inc.js");
//require_once("init.php")
?>


<link rel="stylesheet" href="/3nd_js/layui/css/layui.css">
<script type="text/javascript" src="/3nd_js/layui/layui.js"  Charset="UTF-8"></script>



<script type="text/javascript">

$(function(){	
	
	$('#tb_TagBox').tagbox({    
		//url:'tag_list.php',    
		valueField:'id',    
		textField:'text',
		panelHeight:'auto',	
		//limitToList: true,
		hasDownArrow: true,
		prompt: '输入后回车添加',			
		//value:['Apple', 'Orange'], 
		//value:'Apple, Orange',
		//value: '3,4',
		 buttonText: 'Button',
			onClickButton: function(row){
				console.log($('#tb_TagBox').tagbox('getValues'));
			
				 $.ajax({ 
				//	url: 'tag_list.php?opt=add', 
					dataType: 'json', 
					type:'post', 
					data: { 
						data: $('#tb_TagBox').tagbox('getValues'), 
					}, 
					success:function(data){ 
						if(data.result) 
						{ 
							//$('#tg').treegrid('reload');    //重新加载treegrid  
							$.messager.show({
								title:'我的消息',
								msg:data.sql							
							});						
					   } 
					} 
				 
				}); 					
			},
		onRemoveTag: function(value){
			console.log(value);
		},
		onClickTag:function(value){
			//console.log(value);
		},
		onLoadSuccess:function(){
			
		}

	});	
	
	$('#tb_TagBox').tagbox('setValues','mysql,vb,c++,abc,skymid,d');
	
		
});	


</script>

<body >   
   
标签：<input id="tb_TagBox" type="text" style="width:50%"> 
									
</body>  
	
  
	
	
</html>

