<!DOCTYPE html>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<?php
	require_once("../inc.js");
	//require_once("init.php")
?>
	

<script type="text/javascript">
var editor
var f_pid=90  //分类ID 
$(function(){

	// 全局配置
	// ___E.config.menus = ['bold', 'color', 'quote'];

	// 生成编辑器
	editor = new ___E('textarea1');

	// 自定义配置
	editor.config.uploadImgUrl = '/wangEditor/test/upload';

	// editor.config.menus = ['bold', 'quote', 'list','img'];

	// 初始化
	editor.init(); 
	
	
  
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
function nr_save(){
	var data = { 					
		pid:f_pid,
		title_:$('#title_').textbox('getText'),
		//nr: ue.getContent(),
		nr:editor.$txt.html(),
		bz:'add',
	};						
	$.ajax({							
		url:'save.php',
		type:'post',
		data:data,
		success:function(data){
			   var data = eval('(' + data + ')'); 
	   
				$.messager.show({
					title:'消息',
					msg:data.message,
					showType:'slide',
					style:{
						right:'',
						bottom:''
					}
				});			   
		},
		complete:function(){
			window.location = "mobile.php";
		}							
	})	
}

function dis_type(f,t){
	f_pid=f;
	$('#f_id').textbox('setText',t);	
}		
</script>
<title>Note_Add</title>
</head>
<body > 
    <div class="easyui-navpanel">
        <header>
            <div class="m-toolbar">
                <div class="m-title">Note_Add</div>
                <div class="m-left">
                    <a href="mobile.php" class="easyui-linkbutton m-back" plain="true" outline="true">Back</a>
                </div>
                <div class="m-right">
                    <a onclick="nr_save()" class="easyui-linkbutton" iconCls="icon-save" plain="true" outline="true">Save</a>
                </div>					
            </div>
        </header>
		
        <form id="it_send_form" method="post"> 		
            <table width="100%" border="0" cellspacing="10">
              <tr>
               
                <td>
					<input id="title_" class="easyui-textbox" data-options="required:true"  style="width:50%;" />  
					<a href="javascript:void(0)" class="easyui-menubutton" data-options="iconCls:'icon-more',plain:true,hasDownArrow:false,menu:'#mm',menuAlign:'right'"></a>
					<div id="mm" class="easyui-menu" style="width:150px;" data-options="itemHeight:30,noline:true">
						<?php
							include_once 'conn.php';
							$sql="select * from note_menu";
							$rs=mysql_query($sql);
						?>						
						<div onclick="alert()" data-options="iconCls:'icon-undo'">Undo</div>
						<div class="menu-sep"></div>
						
						<?php while($row = mysql_fetch_array($rs)){ ?>
							<div onclick="dis_type(<?php echo $row["mid"] ?>,'<?php echo $row["text"] ?>')" data-options="iconCls:'<?php echo $row["iconCls"] ?>'"><?php echo $row["text"] ?></div>
						<?php }?>					
					</div>
					<input id="f_id" class="easyui-textbox" data-options="editable:false" > 		
				</td>
              </tr>
			  
              <tr>
                <td colspan="2"> 
					<textarea id="textarea1" style="width:100%;height:100%;">
						<p>...</p>
					</textarea>
				</td>
              </tr>
			  
				<tr>
					<td colspan="2" align="center"></td>
				</tr>
            </table>              
        </form>			
		
        <footer style="padding:2px 3px">
			<div class="m-center" style="vertical-align: middle;text-align:center" >
				<a onclick="nr_save()" class="easyui-linkbutton" iconCls="icon-save" plain="true" outline="true">Save</a>
			</div>
        </footer>
    </div>
	
	<script type="text/javascript" src="dist/js/lib/zepto.js"></script>
	<script type="text/javascript" src="dist/js/lib/zepto.touch.js"></script>
	<script type="text/javascript" src="dist/js/wangEditor-mobile.js"></script>	

</body> 
</html>