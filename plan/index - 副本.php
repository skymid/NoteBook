<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta charset="UTF-8">  
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>NoteBook_plan</title>  
	<?php
		require_once("../../inc.js");
	?>
	<script type="text/javascript" src="/3nd_js/datagrid-groupview.js"  Charset="UTF-8"></script>

<script>
$(function(){
	
	$('#aa').accordion({    
		animate:false ,
		fit:true,
		border:true,
		selected:0,
	}); 	
	
	$('#dg').datagrid({
		url : 'list_data.php',
		fit: true,
		fitColumns:true,
		border: false,
		checkbox: false,
		singleSelect: true,
		checkOnSelect:false,
		selectOnCheck:false,
		view:groupview,
		groupField:'lb',
		groupFormatter:function(value,rows){
			return value + '【' + rows.length + '】';
		},		
		queryParams: {q: ''},		
		header:'#hh',
		onClickRow: onClickRow,
		columns:[[    
			{field:'id',title:'ID',width:30,checkbox:true},
			{field:'nr',title:' ',width:200,editor:'textbox',
				formatter: function(value,row,index){
					if (row.isok=='1'){
						return '<s><font color="#FF0000">'+value+'</font></s>';
					} else {
						return value;
					}
				}
			},
			{field:'lb',title:' ',width:30,editor:'textbox'},
		]],
		onCheck: function(index, row){
			console.log(row);
			if(row.isok=='1'){
				p='1';
			}else{
				p='0';
			}
			$.ajax({
				url:'list_data.php?del_id='+row.id+'opertion=',
				type:'post',
				data:{					
					opertion:p,
					del_id:row.id,
				},
				success:function(data){
				   var data = eval('(' + data + ')'); 			   
					$.messager.show({
						title:'消息',
						msg:data.message,
						showType:'slide',
						style:{
							right:'',
							top:document.body.scrollTop+document.documentElement.scrollTop,
							bottom:''
						}
					});
					$('#dg').datagrid('load');  
				}
			});				
		}
		
	});
	
	$('#p').panel({    
		content:'<iframe src="../mobile.php" frameborder="0" style="padding:0px;border:0;width:100%;height:99.4%;"></iframe>',		 
	}); 	
	
});

////////////////////////////////////////

var editIndex = undefined;
var add_update;
function endEditing(){
	if (editIndex == undefined){return true}
	if ($('#dg').datagrid('validateRow', editIndex)){
		$('#dg').datagrid('endEdit', editIndex);
		editIndex = undefined;
		//console.log("ddd");
		return true;
	} else {
		return false;
	}
}
function onClickRow(index){
	if (editIndex != index){
		if (endEditing()){
			$('#dg').datagrid('selectRow', index)
					.datagrid('beginEdit', index);
			editIndex = index;
		} else {
			$('#dg').datagrid('selectRow', editIndex);
		}
	}
}
function removeit(){
	// if (editIndex == undefined){return}
	// $('#dg').datagrid('cancelEdit', editIndex)
			// .datagrid('deleteRow', editIndex);
	// editIndex = undefined;
}
function reject(){
	if (endEditing()){
		$('#dg').datagrid('acceptChanges');
	}
}
function accept(){
	if ($("#dg").datagrid('getChanges').length) {
		if(add_update=="inserted"){
			var inserted  = $("#dg").datagrid('getChanges', "inserted"); 				
			var effectRow = new Object();				
			if (inserted.length) {
				effectRow["inserted"] = JSON.stringify(inserted);
			}			
		}else{
			var updated  = $("#dg").datagrid('getChanges', "updated"); 				
			var effectRow = new Object();				
			if (updated.length) {
				effectRow["updated"] = JSON.stringify(updated);
			}			
		}			
 
		$.ajax({
			url:'list_data.php',
			type:'post',
			data:effectRow,
			success:function(data){
			   var data = eval('(' + data + ')'); 			   
				$.messager.show({
					title:'消息',
					msg:data.message,
					showType:'slide',
					style:{
						right:'',
						top:document.body.scrollTop+document.documentElement.scrollTop,
						bottom:''
					}
				});						
			}
		});	
		$('#dg').datagrid('acceptChanges');		
	}
	editIndex = undefined;
}
function add(){
	add_update="inserted";
	$('#dg').datagrid('insertRow',{
		index: 0,
		row: {
			nr: '',
			lb: '工作',
		}
	});
}
	
</script>
</head>
<body>

	<div id="aa" >
		<div title="Note" data-options="iconCls:'icon-mini-edit'"  style="padding:0px">
			<div id="p" style="height:100%"></div>			
		</div>
		
		<div title="Plan" data-options="iconCls:'icon-edit'">
			<div class="easyui-navpanel">
				<div id="dg" ></div>
			</div>				
		</div>		
	</div>
	
    <div id="hh">
        <div class="m-toolbar">
            <div class="m-title">PlanCloud</div>
            <div class="m-left">
                <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="add()"></a>
                <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="accept()"></a>
				<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-clear',plain:true" onclick="removeit()"></a>
            </div>
            <div class="m-right">
			    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-reload',plain:true" onclick="$('#dg').datagrid('load',{q:''})"></a>
				<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-ok',plain:true" onclick="$('#dg').datagrid('load',{q:'all'})"></a>
            </div>			
        </div>
    </div>	
</body>    
</html>