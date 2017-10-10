<html>
<head>
	<meta charset="UTF-8">
	<?php
	require_once("../inc.js");
	//require_once("init.php")
	?>
<script type="text/javascript" charset="utf-8" src="ueditor1_4_3-utf8-php/ueditor.config.js"  Charset="UTF-8"></script>
<script type="text/javascript" charset="utf-8" src="ueditor1_4_3-utf8-php/ueditor.all.min.js"  Charset="UTF-8"> </script>   
<script type="text/javascript" charset="utf-8" src="ueditor1_4_3-utf8-php/lang/zh-cn/zh-cn.js"  Charset="UTF-8"></script>

<script type="text/javascript">
var ue = UE.getEditor('editor',{
	 autoHeight: false,
	 catchRemoteImageEnable: true
});  
$(function(){
	      
    //发送
    $('#send').bind('click', function(){    
			console.info (ue.getContent());			
			$('#it_send_form').form('submit', {    
				url:'add_nr.php', 
				onSubmit: function(param){							       
					   //param.nr = UE.getEditor('editor').getContent();
					   param.nr = ue.getContent();					   
					   return $(this).form('validate');	  
				   }, 
				success:function(data){
						var data = eval('(' + data + ')'); 
						if (data.success){  
							console.info("OK");
							$('#send_zt').val('');						 
					   }
					  $.messager.show({
						  title:'消息',
						  msg:data.message
					 });	
				}    
			});    
    });    
    
});

//////////////////////////
		
</script>
<title>send</title>
</head>
<body > 
  
<div id="it_send" class="easyui-panel" title="添加" style="width:100%;Height:100%"   
        data-options="iconCls:'icon-add',        
        	fit:true,
			border: true,	
			"> 	

        <form id="it_send_form" method="post"> 		
            <table width="100%" border="0" cellspacing="10">
              <tr>
                <td width="70">标题：</td>
                <td><input class="easyui-textbox" data-options="required:true,iconCls:'icon-remove'" id="send_zt" name="send_zt" style="width:100%;" />  </td>
              </tr>
			  
              <tr>
                <td colspan="2"> 
					<script id="editor" type="text/plain" style="width:100%;height:300px;"></script>					
				</td>
              </tr>
			  
				<tr>
					<td colspan="2" align="center"> <a id="send" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-save',size:'large'">发送</a> </td>
				</tr>
            </table>              
        </form>	
        
</div>  

</body> 
</html>