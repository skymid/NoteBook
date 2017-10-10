<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>uploadifive</title>

<?php
require_once("../../inc.js");
?>

<script src="js/jquery.uploadifive.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="js/uploadifive.css">

<style type="text/css">

.uploadifive-button {
	float: left;
	margin-right: 10px;
}
#queue {
	border: 1px solid #E5E5E5;
	height: 220px;
	//line-height: 250px;
	text-align: center;
	//background-color:#F0F8FF;     
	overflow: auto;
	margin-bottom: 10px;
	padding: 10px 3px 3px;
	width: 98%;
}
</style>

<script type="text/javascript">
<?php $timestamp = time();?>
var path_file;
var row_data;
$(function() {

	
	$('#file_upload').uploadifive({
		'buttonText' : '选择上传文件',
		'auto'             : true,	
		'height'   : 30,
		'fileSizeLimit' : 0,
		'removeCompleted' : false,
		'progressData' : 'speed',
		'formData'         : {
							   'timestamp' : '<?php echo $timestamp;?>',
							   'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
							 },
		'queueID'          : 'queue',
		'uploadScript'     : 'up.php',
		'onUploadComplete' : function(file, data) {
			console.log(data); 
		},
		'onUpload':function() {
			
		},
		'onSelect' : function(file) {
			document.getElementById("queue").style.display="";
			
		}
	});

	$('#dg').datagrid({
		//url: 'get_list.php',	
		//fit: true,
		fitColumns: true,
		striped: true,
		rownumbers: true,
		singleSelect:true,
		border: false,
		pagination: true,
		pageSize: 5,
		pageList: [5,10],			
		sortName: 'id',
		sortOrder: 'desc',
		toolbar:'#tb',	
		columns: [[
			{
				field: 'id',
				align:'center',
				title: 'ID',
				sortable:true,
				width: 50
			},{
				field: 'fileName',
				align:'center',
				//checkbox:true,
				title: '文件名',
				width: 350
			},{
				field: 'path',
				align:'center',
				title: '路径【点击下载】'
			},{
				field: '——',
				align:'center',
				title: '操作',
				width: 50,
				formatter: function(value,row,index){
					//return '<a nmouseover="this.style.cursor=\'hand\'"  onClick="del('+row.id+')"><img src="cancel.png" /></a>';		
					return '<a nmouseover="this.style.cursor=\'hand\'"  onClick="del('+row.id+')"><img src="cancel.png" /></a>';
					//return '<button class="easyui-linkbutton l-btn l-btn-small l-btn-plain" style="width:100%;height:30px" nmouseover="this.style.cursor=\'hand\'" onClick="del('+row.id+')" >删除<button>';
					
				}
			} 			
		]],		
		onClickCell:function(index, field, value){
			 if( field=='path'){
				 document.location.href = value;
			 }
			// console.log(value);
		},
		onClickRow:function(index, row){
			path_file=row.path;
			row_data=row;
			console.log(row_data);
		},
	    onRowContextMenu: function (e, rowIndex, rowData) { //右键时触发事件  
			//id=rowData.id;
			row_data=rowData;
			path_file=rowData.path;
		   //三个参数：e里面的内容很多，真心不明白，rowIndex就是当前点击时所在行的索引，rowData当前行的数据  
		   e.preventDefault(); //阻止浏览器捕获右键事件  
		   $(this).datagrid("clearSelections"); //取消所有选中项  
		   $(this).datagrid("selectRow", rowIndex); //根据索引选中该行  
		   $('#menu_grid').menu('show', {  
			   //显示右键菜单  
			   left: e.pageX,//在鼠标点击处显示菜单  
			   top: e.pageY  
		   });  
		   e.preventDefault();  //阻止浏览器自带的右键菜单弹出  
	   } 		
	});	
	
	var pager = $('#dg').datagrid().datagrid('getPager');	// get the pager of datagrid
	pager.pagination({
		buttons:$('#buttons')
	});	 		
 	
});

function xg(){
	$.messager.prompt(row_data.fileName, '请输入要改为的文件名', function(r){
		if (r){
			 $.ajax({
				url:'del.php?xg=xg',
				type:'post',
				data:{
					id:row_data.id,
					file:r
				},
				success:function(data){
					var data = eval('(' + data + ')'); 
					
					$('#dg').datagrid('reload');
					
					$.messager.show({
					   title:'消息',					   
					   //msg:'<font color=\"yellow\" size=\"8\">'+data.message+'</font>'
					   msg:'<font color=\"red\" ize=\"12\" >'+data.message+'</font>',
					   timeout:800,
						style:{
							right:'',							
							bottom:''
						}					   
					});							
				}
			});			
		}
	});
}

function del(id){
	
	 $.ajax({
		url:'del.php',
		type:'post',
		data:{
			id:id,
			p:path_file
		},
		success:function(data){
			var data = eval('(' + data + ')'); 
			
			$('#dg').datagrid('reload');
			
			$.messager.show({
			   title:'消息',					   
			   //msg:'<font color=\"yellow\" size=\"8\">'+data.message+'</font>'
			   msg:'<font color=\"red\" ize=\"12\" >'+data.message+'</font>',
			   timeout:800,
				style:{
					right:'',							
					bottom:''
				}					   
			});							
		}
	});
	
}
</script>

</head>
<body>

	<div id="tt" class="easyui-tabs" data-options="fit:true,pill:true,justified:true,boolean:true
		,selected:0
		,onSelect:function(title,index){
			if(index==1){
				$('#dg').datagrid({
					url: 'get_list.php'
				});	
			}			
		}	
		" >   
		<div title="UP" style="padding:10px;display:none;">   
			<div style="padding:0px">
				<form>
					<!--<div id="queue" style="display: none"></div>-->	
					<div id="queue" >拖动到这里上传</div>	
					
					<div style="display: block">			
						<input id="file_upload"  name="file_upload" type="file" multiple="true" >			
					</div>
					<!--<input class="easyui-switchbutton"  style="width:100px;" data-options="onText:'自定上传',offText:'手动上传'">-->
				</form>	
				
			</div>	  
		</div>  
		
		<div title="List" data-options="closable:false" style="overflow:auto;padding:0px;display:none;">  			
			<table id="dg"></table>				
		</div>  
		 
	</div>  

	<div id="buttons">
		<table style="border-spacing:0">
			<tr>
				<td>
					<input class="easyui-searchbox" style="width:150px">
				</td>
				<td>
					<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true"></a>
				</td>
			</tr>
		</table>
	</div>	
	
    <div id="tb" style="padding:5px 8px;">
       <input class="easyui-textbox" style="width:100%" data-options="iconCls:'icon-search',prompt:'输入查找内容',
	     onChange:function(newValue, oldValue){
			$('#dg').datagrid({
				queryParams: {
					q: newValue
				}
			});	
		   console.log(newValue);
	   }" >       
    </div>	

	<!--特别修改-->
	<div id="menu_grid" class="easyui-menu" style="width:120px;">			
		<div onclick="xg();" data-options="iconCls:'icon-edit'">修改</div> 		
		<div onclick="del(row_data.id);" data-options="iconCls:'icon-clear'">删除</div> 
		<div class="menu-sep"></div>   
		<div>Exit</div>   
	</div> 	
</body>
</html>