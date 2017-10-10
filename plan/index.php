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
var lastIndex;	

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
		pagination:true,
		pageSize:10, 
		pageList:[10,20,30],
		view:groupview,
		groupField:'lb',
		groupFormatter:function(value,rows){
			return value + '【' + rows.length + '】';
		},		
		queryParams: {q: ''},		
		header:'#hh',		
		columns:[[    
			{field:'id',title:'ID',width:30,checkbox:true},
			{field:'nr',title:' ',width:200,editor:'text',
				formatter: function(value,row,index){
					if (row.isok=='1'){
						return '<s><font color="#FF0000">'+value+'</font></s>';
					} else {
						return value;
					}
				}
			},
			{field:'lb',title:' ',width:30,editor:'textbox'},
			{field:'isSort',title:' ',width:30,
				editor: {  
				  type: 'numberspinner',  
				  options: {                               
				  editable:true}
				}
			}		
			
		]],
		onCheck: function(index, row){
			console.log(row);
			if(row.isok=='1'){
				p='1';
			}else{
				p='0';
			}
			$.ajax({
				url:'list_data.php',
				type:'post',
				data:{					
					opertion:p,
					ok_id:row.id,
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
		},		
		onClickCell:onClickCell,
		onEndEdit: onEndEdit,		
		/* onClickCell:function(rowIndex, field, value){
			 lastIndex=rowIndex;
			$('#dg').datagrid('endEdit',rowIndex);
			$('#dg').datagrid('beginEdit',rowIndex);
			/*$("input.datagrid-editable-input").val(value).bind("blur",function(evt){
				var dataArry = $('#dg').datagrid('getSelections');
				$('#dg').datagrid('endEdit',lastIndex);
				console.log(lastIndex);
				accept();
			}); 
		}, */
		onClickRow: function(index, row){
			//console.log(row);
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
	//	console.log(row);
	var ed = $(this).datagrid('getEditor', {
		index: index,
		field: 'mid'
	});
	
	
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
	//console.log($('#dg').datagrid('getSelected'));
	$id=$('#dg').datagrid('getSelected').id;
	if($id){   
		$.ajax({
			url:'list_data.php?del_id='+$id,
			type:'post',		
			success:function(data){
			   //var data = eval('(' + data + ')'); 			   
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
			},
			complete:function(){
				$('#dg').datagrid('reload');												
			}
		});	
	}	
}

function reject(){
	if (endEditing()){
		$('#dg').datagrid('acceptChanges');
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
	}	
	//console.log($("#dg").datagrid('getChanges'));
	/* if ($("#dg").datagrid('getChanges').length) {
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
	} */
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
	
	<div class="easyui-navpanel">
		<div id="dg" ></div>
	</div>				
	
    <div id="hh">
        <div class="m-toolbar">
            <div class="m-title">PlanCloud</div>
            <div class="m-left">
                <a class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="add()"></a>
                <a class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="accept()"></a>
				<a class="easyui-linkbutton" data-options="iconCls:'icon-clear',plain:true" onclick="removeit()"></a>
				<a  class="easyui-linkbutton" data-options="iconCls:'icon-reload',plain:true" onclick="$('#dg').datagrid('load',{q:''})"></a>
            </div>
            <div class="m-right">			    
				<a class="easyui-linkbutton" data-options="iconCls:'icon-ok',plain:true" onclick="$('#dg').datagrid('load',{q:'all'})"></a>
				<a href="../mobile.php" class="easyui-linkbutton" data-options="iconCls:'icon-filter',plain:true"></a>
            </div>			
        </div>
    </div>	
</body>    
</html>