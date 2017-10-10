<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Log</title>
<?php
require_once("../../inc.js");
//require_once("init.php")
?>

<body>
	<div class="easyui-navpanel"  style="padding:0px">
		<table id="dg">  
			<thead data-options="frozen:true">
				<tr>
					<th data-options="field:'logtime'">时间</th>
					<th data-options="field:'lb'">类型</th>					
					<th data-options="field:'ip',align:'left'">IP</th>
				 </tr>
			</thead>
			<thead>  
				<tr> 
					<th data-options="field:'nr',align:'left'">内容</th>					
					
				</tr>
			</thead>  
		</table>
	</div>

	
	<div id="tb" style="padding:10px">		
		<input id="grid_zg_kh"  style="width:90%"> 
		<select id="cc" class="easyui-combobox"  data-options="editable:false,panelHeight:'auto'" name="dept" style="width:8%;">   
			<option select value="">all</option> 
			<option value="1">增</option>   
			<option value="2">删</option>  
			<option value="3">修</option>  
			<option value="4">查</option>  		
		</select> 		
	</div>	
</div>


<script>
	
$(function(){
	$('#dg').datagrid({
		url:'log_list.php',
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
		pageSize:10, 
		pageList:[10,20,30],
		queryParams: {q: ''},
		onHeaderContextMenu: function(e, field){
			e.preventDefault();
			if (!cmenu){
				createColumnMenu();
			}
			cmenu.menu('show', {
				left:e.pageX,
				top:e.pageY
			});
		},
/* 				toolbar: [{
				iconCls: 'icon-excel',
				handler: function(){dc_excel();}
			},'-',{
				iconCls: 'icon-help',
				handler: function(){alert('帮助按钮')}
		}] */
		toolbar:'#tb'

	});
	
	//查找学号
	$('#grid_zg_kh').textbox({
		//iconCls:'icon-man',
		onPropertyChange:function(e){
			console.log(e);
		},
		onChange:function(newValue, oldValue){	
			console.log(newValue);
			$('#dg').datagrid('load',{
				q: newValue				
			});			
		},
		onClickIcon:function(index){
			//console.log(index);
		}
	});	
	
	$('#cc').combobox({		 
		valueField:'id',    
		textField:'text',
		onSelect: function(rec){    
			console.log(rec);   
			$('#dg').datagrid({
				queryParams:{
					lb:rec.id
				}
			});
		}
	});

});	
/////////
var cmenu;
function createColumnMenu(){
	cmenu = $('<div/>').appendTo('body');
	cmenu.menu({
		onClick: function(item){
			if (item.iconCls == 'icon-ok'){
				$('#dg').datagrid('hideColumn', item.name);
				cmenu.menu('setIcon', {
					target: item.target,
					iconCls: 'icon-empty'
				});
			} else {
				$('#dg').datagrid('showColumn', item.name);
				cmenu.menu('setIcon', {
					target: item.target,
					iconCls: 'icon-ok'
				});
			}
		}
	});
	var fields = $('#dg').datagrid('getColumnFields');
	console.log(fields);
	for(var i=0; i<fields.length; i++){
		var field = fields[i];
		var col = $('#dg').datagrid('getColumnOption', field);
		cmenu.menu('appendItem', {
			text: col.title,
			name: field,
			iconCls: 'icon-ok'
		});
	}
}		

///////
function dc_excel(){
	var sql="select * from stu_base LIMIT 1000";
	var s="../PHPExcel/dc_excel.php?s_sql="+sql+"&s_dname=stu_base";
	document.location.href = s;
	
	//alert(s);
}		
</script>
</body>	
</html>

