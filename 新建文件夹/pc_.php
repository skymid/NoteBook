<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Note</title>
<?php
require_once("../inc.js");
//require_once("init.php")
?>
<script type="text/javascript" charset="utf-8" src="ueditor1_4_3-utf8-php/ueditor.config.js"  Charset="UTF-8"></script>
<script type="text/javascript" charset="utf-8" src="ueditor1_4_3-utf8-php/ueditor.all.min.js"  Charset="UTF-8"> </script>   
<script type="text/javascript" charset="utf-8" src="ueditor1_4_3-utf8-php/lang/zh-cn/zh-cn.js"  Charset="UTF-8"></script>

<script>
var ue = UE.getEditor('editor',{
	 autoHeight: false,
	 catchRemoteImageEnable: true
}); 		
$(function(){
	$('#dg').datagrid({
		url:'get_list.php',
		header:'#hh',
		singleSelect:true,
		border:false,
		striped:true,
		fit:true,
		fitColumns:true,
		scrollbarSize:0,
		rownumbers:true,
		sortName:'id',
		sortOrder:'desc',
		pagination:true,
		pageSize:15, 
		pageList:[15,30,45],
		queryParams: {q: ''},			
		toolbar:'#tb',
		onClickRow:function(index, row){
			console.log(row);
			if($('#dg').datagrid('getSelected')){
				$('#studen_edit').dialog('open'); 
				
				$('#studen_edit').dialog('setTitle',row.title);
				$('#nr_id').textbox('setText',row.id);
				$('#title_').textbox('setText',row.title);
				ue.setContent(row.nr);
				//$('#editor').textbox('setText',row.nr);
			}					
		}
	});
	
	//查找nr
	$('#grid_zg_kh').textbox({
		iconCls:'icon-man',
		onChange:function(newValue, oldValue){	
			console.log(newValue);
			$('#dg').datagrid('load',{
				q: newValue				
			});			
		}
	});	
	
    $('#btn_add').bind('click', function(){
		$('#studen_edit').dialog('setTitle','添加');
		$('#nr_id').textbox('setText','');
		$('#title_').textbox('setText','');	
		ue.setContent('');
		
        $('#studen_edit').dialog('open');   
    }); 
	
	$('#studen_edit').dialog({
		title:'l',
		//width: 90%,    
		height:440,
		iconCls:'icon-edit',
		resizable:true,	
   		closed: true,    
		//modal: true,
		buttons:[{
			id:'studen_edit_save',
			text:'保存',
			iconCls:'icon-save',				
			handler:function(){		

					var data = { 					
						nr_id:$('#nr_id').textbox('getText'),
						title_:$('#title_').textbox('getText'),
						nr: ue.getContent(),				
					};						
					$.ajax({							
						url:'save.php',
						type:'post',
						data:data,
						success:function(data){
							   var data = eval('(' + data + ')'); 
							   $.messager.show({
								   title:'消息',
								   msg:data.message								   

							   });	
							   console.log(data)
						},
						complete:function(){
							$('#studen_edit').dialog('close');
							$('#dg').datagrid('load');									
						}							
					})										
			}
			},{
				text:'关闭',
				handler:function(){$('#studen_edit').dialog('close');}
			}]		
		}); 
		
$("#yc" ).css("display", "none");
});	

function removeit(){		
	$.messager.confirm('确定操作', '您正在要删除所选的记录吗？', function (flag) {
		if (flag) {			
			console.log($('#dg').datagrid('getChecked')[0].id);		
			$.ajax({
				url : 'save.php?option=del',
				type : 'post',
				data : {
					id : $('#dg').datagrid('getChecked')[0].id,
				}
			});
			$('#dg').datagrid('reload');	
		}
	})
}			
			
</script>

<body>
	<div class="easyui-navpanel"  style="padding:0px">
		<table id="dg">  			
			<thead>  
				<tr> 
					<th checkbox="true" sortable="true" data-options="field:'id',align:'left'">ID</th>
					<th data-options="field:'title',align:'left'">标题</th>
					<th data-options="field:'sj',align:'left'">时间</th>
				</tr>
			</thead>  
		</table>
	</div>
	<div id="hh">
		<div class="m-toolbar">
			<div class="m-title">Note</div>			
		</div>
	</div>
	
	<div id="tb">		
		<input id="grid_zg_kh" class="easyui-textbox" data-options="iconCls:'icon-search'" style="width:300px"> 
		<a id="btn_add"  class="easyui-linkbutton" data-options="iconCls:'icon-add'">Add</a>  
		<a id="btn_add" onclick="removeit()"  class="easyui-linkbutton" data-options="iconCls:'icon-clear'">Del</a>
	</div>
</body>	
	
 <div id="studen_edit" style="width:90%;height:90%">

	<form id="it_send_form" method="post"> 		
		<table width="100%" border="0" cellspacing="10">
		  <tr>
			<td > 
				<input id="title_" class="easyui-textbox" data-options="iconCls:'icon-man'" style="width:300px"> 	
				<div id="yc"><input id="nr_id" class="easyui-textbox"></div>				
			</td>
		  </tr> 			  
		  <tr>
			<td > 
				<script id="editor" type="text/plain" style="width:100%;height:300px;"></script>					
			</td>
		  </tr>

		</table>              
	</form>	
 </div>
</html>

