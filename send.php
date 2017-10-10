<html>
<head>
	<meta charset="UTF-8">
<script type="text/javascript" src="/js/jquery.min.js"  Charset="UTF-8"></script>
<script type="text/javascript" src="/js/jquery.easyui.min.js"  Charset="UTF-8"></script>
<script type="text/javascript" src="/js/jquery.easyui.mobile.js"></script> 
<script type="text/javascript" src="/js/locale/easyui-lang-zh_CN.js"  Charset="UTF-8"></script>
<link id="easyuiTheme" rel="stylesheet" type="text/css"	href="/js/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="/js/themes/icon.css">
<link rel="stylesheet" type="text/css" href="/js/demo/demo.css">

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
				url:'save.php', 
				onSubmit: function(param){							       
					   //param.nr = UE.getEditor('editor').getContent();
					   param.nr = ue.getContent();
					   param.title=$('#title').textbox('getText');
					   return $(this).form('validate');	  
				   }, 
				success:function(data){
						var data = eval('(' + data + ')'); 
						// console.info(data);
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
  

<div id="it_send" class="easyui-panel" title="发信息" style="width:90%;"   
        data-options="iconCls:'icon-add',        
        	fit:true,        	
        	//closed:true,
			buttons:[{
				text:'发送',
				iconCls: 'icon-save',
				handler:function(){
				
				}
			}]"> 	

        <form id="it_send_form" method="post"> 		
            <table width="100%" border="0" cellspacing="10">

              <tr>
                <td > 
					<input id="title" class="easyui-textbox" data-options="iconCls:'icon-search'" style="width:300px"> 				
				</td>
              </tr> 			  
              <tr>
                <td > 
					<script id="editor" type="text/plain" style="width:100%;height:300px;"></script>					
				</td>
              </tr>
			  
				<tr>
					<td align="center"> <a id="send" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-save',size:'large'">发送</a> </td>
				</tr>
            </table>              
        </form>	
        
        	
</div>  

</body> 
</html>