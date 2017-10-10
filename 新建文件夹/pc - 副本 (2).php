<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>NoteBook</title>
<?php
require_once("../inc.js");
//require_once("init.php")
?>
<script type="text/javascript" charset="utf-8" src="ueditor1_4_3-utf8-php/ueditor.config.js"  Charset="UTF-8"></script>
<script type="text/javascript" charset="utf-8" src="ueditor1_4_3-utf8-php/ueditor.all.min.js"  Charset="UTF-8"> </script>   
<script type="text/javascript" charset="utf-8" src="ueditor1_4_3-utf8-php/lang/zh-cn/zh-cn.js"  Charset="UTF-8"></script>

<script type="text/javascript" src="/3nd_js/datagrid-groupview.js"  Charset="UTF-8"></script>

<script type="text/javascript" charset="utf-8" src="jquerysession.js"  Charset="UTF-8"></script>
<script type="text/javascript">

if(!$.session.get('user')){
	window.location = "login.php";
}


var ue = UE.getEditor('editor',{
	 autoHeight: true,
	 catchRemoteImageEnable: true
}); 

var row_nr		//单击行时保存一下
var pid_id=0	//tree 所选分类id	
var add_xg		//添加还是修改？

$(function(){
	
	
	$('#index_menu').tree({
	url:'tree.php',
	lines:true,
	parentField:'pid',
	onClick: function(node){
			//console.log(node.pid);				
			pid_id=node.id;
			
			if(node.url){
				$('#note_manager').dialog('open'); 
			}else{
				$('#dg').datagrid('load',{
					pid:node.id,
				})					
			}
			if($('#yn_collapse').switchbutton("options").checked){
				$("#main_layout").layout("collapse", "west");
			}
								
		},
		onDblClick : function(node) {
			if (node.state == 'closed') {
				$(this).tree('expand', node.target);
			} else {
				$(this).tree('collapse', node.target);
			}
		}              						
	})
	
	
	$('#dg').datagrid({
		url:'get_list.php',
		//header:'#hh',
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
		view:groupview,
		groupField:'sj_lb',
		groupFormatter:function(value,rows){
			return value + '【' + rows.length + '】';
		},
		pageSize:15, 
		pageList:[15,30,45],
		queryParams: {q: ''},			
		columns:[[    
			{field:'id',title:'ID',width:100,checkbox:true,sortable:true},  
			{field:'title',title:'标题',width:300,sortable:true},	
			{field:'set_lock',title:'Lock',width:100,formatter:function(value, rec){
				if(value){
					return '<img src="lock.png"/>';
				}				
			}}, 
			//{field:'pid',title:'PID',width:50},
			//{field:'sj',title:'时间',width:100,align:'right'}    
		]],  		
		//toolbar:'#tb',
		onSelect:function(index, row){
			row_nr=row;			//给右键用
			console.log(row_nr);	
		},
		onClickRow:function(index, row){
			if($('#dg').datagrid('getSelected')){
				row_nr=row;
				//console.log(row_nr);
				if(row.set_lock){
					$.messager.prompt('提示', '输入密码：', function(r){
						if (r==row.password){
							//下面有一样的代码
							if($('#edit_read').switchbutton("options").checked){
								//编辑								
								$('#note_edit').panel('open'); 					
								$('#note_edit').panel('setTitle','修改 '+row.title);
								$('#nr_id').textbox('setText',row.id);
								$('#title_').textbox('setText',row.title);
								ue.setContent(row.nr);													
								$('#comb_type').combotree('setValue',row.pid);	//row_nr 单击行时保存过了
								add_xg='xg';
								console.log('编辑');
								$('#note_nr').panel('close');
							} else{
								$('#note_edit').panel('close');
								$('#note_nr').panel('open');	
								$('#note_nr').panel('setTitle',row.title);			
								$("#nr_note").html(row.nr);
								$("#nr_footer").html(row.sj); 
								console.log('只读');		
							}							
						}else{
							$.messager.show({
								title:'Error',
								msg:'密码错误！！',
								showType:'slide',
								style:{
									right:'',
									bottom:''
								}
							});
							$('#note_nr').panel('close');
							//row_nr=0;
						}
					});
				}else{
							if($('#edit_read').switchbutton("options").checked){
								//编辑	
								$('#note_edit').panel('open'); 					
								$('#note_edit').panel('setTitle','修改 '+row.title);
								$('#nr_id').textbox('setText',row.id);
								$('#title_').textbox('setText',row.title);
								ue.setContent(row.nr);	
								console.log(row);
								$('#comb_type').combotree('setValue',row.pid);	//row_nr 单击行时保存过了							
								add_xg='xg';
								console.log('编辑2');
								$('#note_nr').panel('close')
							} else{
								$('#note_edit').panel('close');
								$('#note_nr').panel('open');	
								$('#note_nr').panel('setTitle',row.title);			
								$("#nr_note").html(row.nr);
								$("#nr_footer").html(row.sj); 
								console.log('只读2');		
							}					
				}
			}					
		},
		onRowContextMenu: function(e, index, row){
		    e.preventDefault();		
			$("#dg").datagrid('selectRow',index);	
		    $('#grid_mm').menu('show', {
		        left:e.pageX,
		        top:e.pageY
		    });	
		},
	});
		
	//只读
	$('#note_nr').panel({    
		title: 'nr',
		border:false,
		fit:true,
		closed: true,
		tools:[{
				text:'锁',
				iconCls:'icon-lock',
				handler:function(){
					SetPassword();
					}
				},{
				text:'编辑',
				iconCls:'icon-edit',
				handler:function(){
					$('#note_nr').dialog('close'); 
					 
					$('#note_edit').dialog('open'); 					
					$('#note_edit').dialog('setTitle','修改 '+row_nr.title);
					$('#nr_id').textbox('setText',row_nr.id);
					$('#title_').textbox('setText',row_nr.title);
					ue.setContent(row_nr.nr);	
					console.log(row_nr);
					$('#comb_type').combotree('setValue',row_nr.pid);	//row_nr 单击行时保存过了
					add_xg='xg';
					}
				},{
				text:'关闭',
				iconCls:'icon-clear',
				handler:function(){
					$('#note_nr').dialog('close'); 
				}
		}],
		footer:'#footer'
	});

	//编辑
	$('#note_edit').panel({
		title:'l',
		//iconCls:'icon-edit',
		border:false,
		fit:true,		
   		closed: true,    
		tools:[{
			id:'note_edit_save',
			text:'保存',
			iconCls:'icon-save',				
			handler:function(){	
				nr_save();					
			}
			},{
				text:'关闭',
				iconCls:'icon-clear',
				handler:function(){
					$('#note_edit').dialog('close');
					}
			}]		
	});		
	//add 时 选择分类
	$('#comb_type').combotree({ 
		panelWidth:300,
		panelHeight:500,		
		checkbox:true,
		lines:true,
		textField:'text',
		valueField:'id',	
		url:'tree_list.php', 
		onLoadSuccess : function (node, data) {
			var _this = this;
			if (data) {
				$(data).each(function (index, value) {
					if (this.state == 'closed') {
						$(_this).tree('expandAll');
					}
				});
			}
		},
		onChange:function (newValue, oldValue) {
			console.log(newValue);
			pid_id=newValue;
		}		
	}); 

	//管理菜单
	$('#note_manager').dialog({    
		title: 'manager', 
		width:'90%',
		height:'90%',
		closed: true,   
		content:'<iframe src="manager/manager.php" frameborder="0" style="padding:0px;border:0;width:100%;height:99.4%;"></iframe>',
		modal: true,
		maximizable:true,
	});  
	
	//查找nr
	$('#ss').searchbox({ 
		searcher:function(value,name){ 
			//alert(value + "," + name) 
			$('#dg').datagrid('load',{
				nr: value,
				zd:name
			});			
		}, 
		menu:'#mm', 
		prompt:'请输入值' 
	}); 	
	
	//add 按钮
    $('#btn_add').bind('click', function(){
		$('#note_edit').dialog('setTitle','添加');
		$('#nr_id').textbox('setText','');
		$('#title_').textbox('setText',pid_id);	
		ue.setContent('');		
        $('#note_edit').dialog('open');
		$('#comb_type').combotree('setValue',pid_id);  //pid_id 单击菜单时传过来了
		add_xg='add';
		$('#note_nr').panel('close');
    });

		
	$("#yc" ).css("display", "none");
});	

function edit_nr(){
	$('#note_nr').dialog('close'); 
	 
	$('#note_edit').dialog('open'); 					
	$('#note_edit').dialog('setTitle','修改 '+row_nr.title);
	$('#nr_id').textbox('setText',row_nr.id);
	$('#title_').textbox('setText',row_nr.title);
	ue.setContent(row_nr.nr);	
	console.log(row_nr);
	$('#comb_type').combotree('setValue',row_nr.pid);	//row_nr 单击行时保存过了
	add_xg='xg';		
}
//del 函数
function removeit(){		
	$.messager.confirm('确定操作', '您正在要删除所选的记录吗？', function (flag) {
		if (flag) {			
			console.log($('#dg').datagrid('getChecked')[0].id);		
			$.ajax({
				url : 'save.php?option=del&id='+$('#dg').datagrid('getChecked')[0].id,
				type : 'post',
				data : {
					//id : $('#dg').datagrid('getChecked')[0].id,
				}
			});
			$('#dg').datagrid('reload');	
		}
	})
}	
function nr_save(){
	var data = { 					
		nr_id:$('#nr_id').textbox('getText'),
		title_:$('#title_').textbox('getText'),
		nr: ue.getContent(),
		//pid:pid_id,
		pid:$('#comb_type').combotree('getValue'),
		bz:add_xg,
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
			//$('#note_edit').dialog('close');
			$('#dg').datagrid('load');									
		}							
	})	
}		
//设置密码
function SetPassword(){
	$.messager.prompt('提示', '输入设置密码：', function(r){
		if (r){
			var data = {
				id:row_nr.id,	
				password:r,
				bz:'xg_password',
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
					$('#dg').datagrid('load');									
				}							
			})
		}
	});
}

function UnPassword(){
	$.messager.prompt('提示', '输入原先设置密码：', function(r){
		if (r==row_nr.password){
			var data = {
				id:row_nr.id,	
				password:r,
				bz:'xg_unpassword',
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
					$('#dg').datagrid('load');									
				}							
			})
		}else{
			$.messager.show({
				title:'消息',
				msg:"密码错误！！",
				showType:'slide',
				style:{
					right:'',
					bottom:''
				}
			});				
		}
	});
}
			
</script>

<body id="main_layout" class="easyui-layout">   
    <div data-options="region:'west',collapsible:true,collapsed:true,split:true,title:'功能区'" style="width:230px" >		
		<div id="aa" class="easyui-accordion" >			
			<div title="分类" data-options="iconCls:'icon-save',selected:true" style="overflow:auto;padding:10px;">   
				<input id="yn_collapse" class="easyui-switchbutton" data-options="onText:'叠',offText:'开'">
				<ul id="index_menu" ></ul>  
			</div>   
			<div title="Manager" data-options="iconCls:'icon-reload'" style="padding:10px;">   
				<a id="btn" href="manager/manager.php" class="easyui-linkbutton" data-options="iconCls:'icon-search'">easyui</a>     
			</div>   
			<div title="Title3">   
				content3    
			</div> 
		</div>
	</div>   
    <div data-options="region:'center',border:false" >	

		<div class="easyui-layout" style="width:100%;height:100%;">  
			<div data-options="region:'north'" style="height:80px;">
			 
				<div id="p" class="easyui-panel" style="width:100%;height:100%;padding:20px;background:#fafafa;" data-options='border:false'>   
					<!--<input id="grid_zg_kh" class="easyui-textbox" data-options="iconCls:'icon-search'" style="width:300px"> -->
					
					<input id="ss" style="width:300px"></input> 
					<div id="mm" style="width:300px"> 
						<div data-options="name:'nr',iconCls:'icon-sum'">内容</div> 
						<div data-options="name:'title',iconCls:'icon-ok'">标题</div> 
					</div>					
					
					<a id="btn_add"  class="easyui-linkbutton" data-options="iconCls:'icon-add'">Add</a>  
					<a id="btn_add" onclick="removeit()"  class="easyui-linkbutton" data-options="iconCls:'icon-clear'">Del</a>
					<input id="edit_read" class="easyui-switchbutton" data-options="onText:'编辑',offText:'只读'">
					
					<a onClick="$('#note_manager').dialog('open');" class="easyui-linkbutton" data-options="iconCls:'icon-filter'">管理菜单</a>
					
					<a onclick="$('#dg').datagrid('reload')" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">刷新</a>  
				</div>
				
			</div> 
			
			<div data-options="region:'west',title:'列表',split:true" style="width:250px;">
				<table id="dg"></table> 
			</div>  
			
			<div data-options="region:'center'" >
				 <!-- 只读 -->
				 <div id="note_nr" >
					<div id="nr_note" style="padding:10px;" ></div>
				 </div>	
				<!-- 编辑 -->
				 <div id="note_edit" >
					<form id="it_send_form" method="post"> 		
						<table width="100%" border="0" cellspacing="10">
						  <tr>
							<td>
								<input id="title_" class="easyui-textbox" data-options="label: '标题:'" style="width:98%"> 	
								<div id="yc"><input id="nr_id" class="easyui-textbox"></div>					 					
							</td>
						  </tr>
						  <tr>
							<td > 
								<input id="comb_type" style="width:200px;" value="161"   > 
								<a id="btn_save" onClick="nr_save()" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true">Save</a>  
								<a id="btn_password" onclick="SetPassword()" class="easyui-linkbutton" data-options="iconCls:'icon-lock',plain:true">设置密码</a>  
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
				 
			</div>   
		</div>  
		
	</div>   
</body>  
	

	 
    <div id="footer" style="padding:5px;">
        <div id="nr_footer" style="padding:5px;" >123:123</div>
    </div>	
	
	 <div id="note_manager" ></div>
	 
	<div id="grid_mm" class="easyui-menu" style="width:120px;">
		<div onClick="SetPassword()" data-options="iconCls:'icon-lock'">设置密码</div>
		<div onClick="UnPassword()" data-options="iconCls:'icon-remove'">删除密码</div>
		<div class="menu-sep"></div>
		<div onClick="edit_nr()" data-options="iconCls:'icon-edit'">编辑</div>
		<div onClick="removeit()" data-options="iconCls:'icon-remove'">删除</div>
		<div class="menu-sep"></div>
		<div  data-options="iconCls:'icon-reload'">刷新</div>
	</div>	 
</html>

