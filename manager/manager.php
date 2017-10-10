<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>user_manger</title>

<?
require_once("../../inc.js");
//require_once("init.php")
?>

<script type="text/javascript">
$(function () {
	
	$('#dg').datagrid({
		url : 'manager_data.php',
		fit : true,
		fitColumns : true,
		striped : true,
		rownumbers : true,
		border : true,
		pagination : true,
		pageSize : 20,
		pageList : [10, 20, 30, 40, 50],			
		sortName : 'mid',
		onClickCell:onClickCell,
		onEndEdit: onEndEdit,
		sortOrder : 'desc',
		toolbar : '#dg_tool',
		columns : [[
			{
				field : 'mid',
				title : '自动编号',
				width : 35,
				checkbox : true,
			},
			{
				field : 'pid',
				title : 'Fid',
				width : 30,
				//editor:'numberbox'
				editor:{
					type:'combotree',
					options:{
						panelWidth:400,
						panelHeight:500,
						checkbox:true,
						//multiple : true,		
						lines:true,
						//onlyLeafCheck : true,
						textField:'text',
						valueField:'pid',	
						url:'../tree_list.php', 
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
					}					
				} 
				
			},
			{
				field : 'text',
				title : '名称',
				width : 100,
				editor:'textbox'
			},
			{
				field : 'href',
				title : '链接',
				width : 100,
				editor:'textbox'
			},
			{
				field : 'iconCls',
				title : '图标',
				width : 80,
				editor:{
					type:'combobox',
					options:{
						data : themes,
						showItemIcon: true,
						panelHeight: 'auto',		
					}
				}
			},
			{
				field : 'issort',
				title : '排序',
				width : 30,
				editor:'numberbox'
			},
			{
				field : 'seq',
				title : 'seq',
				width : 30,
				editor:'numberbox'
			},
			{
				field : 'status',
				title : '权限',
				width : 100,
				editor:'numberbox'
			},
		]],
		
	});

	$('#find_text').textbox({
		iconCls:'icon-man',
		onChange:function(newValue, oldValue){
			console.log(newValue);
			$('#dg').datagrid('load',{
				q: newValue				
			});
			
		}
	});		
	
	
});

///
var editIndex = undefined;
function endEditing(){
	if (editIndex == undefined){return true}
	if ($('#dg').datagrid('validateRow', editIndex)){
		$('#dg').datagrid('endEdit', editIndex);
		editIndex = undefined;
		return true;
	} else {
		return false;
	}
}
function onClickCell(index, field){
	if (editIndex != index){
		if (endEditing()){
			$('#dg').datagrid('selectRow', index)
					.datagrid('beginEdit', index);
			var ed = $('#dg').datagrid('getEditor', {index:index,field:field});
			if (ed){
				($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
			}
			editIndex = index;
		} else {
			setTimeout(function(){
				$('#dg').datagrid('selectRow', editIndex);
			},0);
		}
	}
}
function onEndEdit(index, row){
	var ed = $(this).datagrid('getEditor', {
		index: index,
		field: 'mid'
	});
	//row.ks_lb = $(ed.target).combobox('getText');
}

function append(){
	if (endEditing()){
		$('#dg').datagrid('appendRow',{lb:''});
		editIndex = $('#dg').datagrid('getRows').length-1;
		$('#dg').datagrid('selectRow', editIndex)
				.datagrid('beginEdit', editIndex);
	}
}
	
function removeit(){
	//console.log($('#dg').datagrid('getChecked'));
	//console.log($('#dg').datagrid('getRowIndex',$('#dg').datagrid('getChecked')[0]));
	
	len=$('#dg').datagrid('getChecked').length;
	for(var i=0;i<len;i++){
		row=$('#dg').datagrid('getRowIndex',$('#dg').datagrid('getChecked')[i]);
		console.log(row);
		$('#dg').datagrid('deleteRow',row);
	}
	
}
	
function accept(){
	if (endEditing()){

		if ($("#dg").datagrid('getChanges').length) {
			
			var inserted = $("#dg").datagrid('getChanges', "inserted");	
			var deleted  = $("#dg").datagrid('getChanges', "deleted");
			var updated  = $("#dg").datagrid('getChanges', "updated"); 
			
			var effectRow = new Object();
			if (inserted.length) {
				effectRow["inserted"] = JSON.stringify(inserted);
			}
			if (deleted.length) {
				effectRow["deleted"] = JSON.stringify(deleted);
			}
			if (updated.length) {
				effectRow["updated"] = JSON.stringify(updated);
			} 

			//console.info(effectRow);
			$.ajax({
				url:'manager_code_add_edit.php',
				type:'post',
				data:effectRow,
				dataType:'json',
				success:function(data){
					  // var data = eval('(' + data + ')'); 
					   $.messager.show({
						   title:'消息',
						   msg:data.message
					   });	
				}
			});						
			
			$('#dg').datagrid('acceptChanges');
						
		}
	}
}
function reject(){
	$('#dg').datagrid('rejectChanges');
	editIndex = undefined;
}


var themes = [{
				value : 'icon-blank',
				text : 'icon-blank',
				iconCls:'icon-blank'
			}, {
				value : 'icon-add',
				text : 'icon-add',
				iconCls:'icon-add'
			}, {
				value : 'icon-edit',
				text : 'icon-edit',
				iconCls:'icon-edit'
			}, {
				value : 'icon-clear',
				text : 'icon-clear',
				iconCls:'icon-clear'
			}, {
				value : 'icon-remove',
				text : 'icon-remove',
				iconCls:'icon-remove'
			}, {
				value : 'icon-save',
				text : 'icon-save',
				iconCls:'icon-save'
			}, {
				value : 'icon-cut',
				text : 'icon-cut',
				iconCls:'icon-cut'
			}, {
				value : 'icon-ok',
				text : 'icon-ok',
				iconCls:'icon-ok'
			}, {
				value : 'icon-no',
				text : 'icon-no',
				iconCls:'icon-no'
			}, {
				value : 'icon-cancel',
				text : 'icon-cancel',
				iconCls:'icon-cancel'
			}, {
				value : 'icon-reload',
				text : 'icon-reload',
				iconCls:'icon-reload'
			}, {
				value : 'icon-search',
				text : 'icon-search',
				iconCls:'icon-search'
			}, {
				value : 'icon-print',
				text : 'icon-print',
				iconCls:'icon-print'
			}, {
				value : 'icon-help',
				text : 'icon-help',
				iconCls:'icon-help'
			}, {
				value : 'icon-undo',
				text : 'icon-undo',
				iconCls:'icon-undo'
			}, {
				value : 'icon-redo',
				text : 'icon-redo',
				iconCls:'icon-redo'
			}, {
				value : 'icon-back',
				text : 'icon-back',
				iconCls:'icon-back'
			}, {
				value : 'icon-sum',
				text : 'icon-sum',
				iconCls:'icon-sum'
			}, {
				value : 'icon-tip',
				text : 'icon-tip',
				iconCls:'icon-tip'
			}, {
				value : 'icon-filter',
				text : 'icon-filter',
				iconCls:'icon-filter'
			}, {
				value : 'icon-man',
				text : 'icon-man',
				iconCls:'icon-man'
			}, {
				value : 'icon-more',
				text : 'icon-more',
				iconCls:'icon-more'
			}
		];
</script>
<body>
<table id="dg" style="padding:10px"></table>

<div id="dg_tool" style="padding:5px;">
	<div style="margin:5px;">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="append();">添加</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeit();">删除</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="accept();">保存</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="$('#dg').datagrid('reload');">刷新</a>
		<input id="find_text"  style="height:25px">		
	</div>
	
</div>
</body>
</html>