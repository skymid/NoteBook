<!DOCTYPE html>

<?php
	include_once 'conn.php';
	$sql="select * from notebook order by id desc ";
	//$rs=mysql_query($sql);
?>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>NoteBook_mobile</title>  
	<?php
		require_once("../inc.js");
	?>
<script type="text/javascript" charset="utf-8" src="ueditor1_4_3-utf8-php/ueditor.config.js"  Charset="UTF-8"></script>
<script type="text/javascript" charset="utf-8" src="ueditor1_4_3-utf8-php/ueditor.all.min.js"  Charset="UTF-8"> </script>   
<script type="text/javascript" charset="utf-8" src="ueditor1_4_3-utf8-php/lang/zh-cn/zh-cn.js"  Charset="UTF-8"></script>
<script type="text/javascript">
$(function () {
	$('#dl').datalist({
		url : 'mobile_nr_data.php',
		loadMsg: '正在加载信息...',
		//method : 'get',
		fit : true,
		//striped:true,
		//rownumbers:true,
		checkbox : false,
		border : false,
		lines : true,
		textField : 'title',
		groupField : 'sj_lb',
		textFormatter : function (value, row) {
			return '<span style="padding:25px;">' + row.title.substr(0,30) + '</span>'
			 + '<span style="float:right;color:#999">' + row.sj.substr(11,19) + '</span>';
		},
		groupFormatter : function (value, row) {
			return '<span style="font-size:12px;color:#999;padding:5px;">' + value + '</span>'
			 + '<span class="m-badge c1" style="float:right;margin:5px 10px">'+ row.length +'</span>';
		},
		onClickRow : function (index, row) {
			//console.log(row);
			data_nr=row;
			$('#p2-title').html(row.title.substr(0,15));
			$('#p2-nr').html(row.nr)
			$('#p2-fb').html(row.sj)
			$.mobile.go('#p2');
		}
		
	})
	//查询
	$('#find_nr').textbox({    
		buttonText:'Search',    
		iconCls:'icon-search', 
		iconAlign:'left',
		onClickButton:function(){
			$('#dl').datalist('load',{
				 zd:'nr',
				 q:$('#find_nr').textbox('getText')
			})
		}	
	})	
});

////////////////////////////////////////////////
var ue = UE.getEditor('editor',{
	 autoHeight: true,
	 catchRemoteImageEnable: true,
	 toolbars: [
		['attachment','fullscreen', 'source', 'bold','fontfamily','forecolor',
		'fontsize', 'simpleupload','scrawl','horizontal']
	 ],
	 initialFrameHeight:300,
	 enableAutoSave:false,
	 saveInterval: 5000000
});

var data_nr    //单击行时，保存后台返回的数据

//分类显示
function dis_type(f,t_nr){
	$('#dl').datalist('load',{
		 zd:'pid',
		 q:f
	})
	$('#title_title').html(t_nr)
		
}

function dis_Collect(){
	$('#dl').datalist('load',{
		 zd:'collect',
		 q:'1'
	})	
}

function openit(target,n){
	var text = $(target).text();
	$('#p2-title').html(text);
		$.ajax({
			url:'mobile_nr.php?id='+n,
			success:function(data){
			   data_nr = eval('(' + data + ')'); 
			   $('#p2-nr').html(data_nr.nr)
			   $('#p2-fb').html(data_nr.fb)
			}
		});						
	
	$.mobile.go('#p2');
}

function go_p3(){
	$('#p3_title_').textbox('setText',data_nr.title);
	ue.setContent(data_nr.nr);
	$.mobile.go('#p3');
}

//修改保存
function nr_save(){
	var data = { 					
		nr_id:data_nr.id,
		pid:data_nr.pid,
		title_:$('#p3_title_').textbox('getText'),
		nr: ue.getContent(),
		bz:'xg',
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
			//$.mobile.back()
			//$('#note_edit').dialog('close');
			//$('#dg').datagrid('load');									
		}							
	})	
}
//删除
function removeit(){		
	$.messager.confirm('确定操作', '您正在要删除所选的记录吗？', function (flag) {
		if (flag) {			
			$.ajax({
				url : 'save.php?option=del&id='+data_nr.id,
				type : 'post',				
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
					//$('#dg').datagrid('reload');	
					//$.mobile.back(2)
					window.location = "mobile.php";									
				}				
			});

		}
	})
} 

</script>	
</head>

 <body>
	<div class="easyui-navpanel">
		<header>
			<div class="m-toolbar">
				<div class="m-left">
                    <a href="add_w.php" class="easyui-linkbutton" data-options="iconCls:'icon-edit',plain:true"></a>
                </div>
                <div class="m-right">
					<a onclick="$('#dl').datalist('load',{nr: '',zd:'nr'})" class="easyui-linkbutton" data-options="iconCls:'icon-reload',plain:true"></a>
                    <a href="javascript:void(0)" class="easyui-menubutton" data-options="iconCls:'icon-more',plain:true,hasDownArrow:false,menu:'#mm',menuAlign:'right'"></a>
					<a href="plan/index.php" class="easyui-linkbutton" data-options="iconCls:'icon-filter',plain:true"></a>
                </div>				
				
				<div id="mm" class="easyui-menu" style="width:150px;" data-options="itemHeight:30,noline:true">
					<?php
						include_once 'conn.php';
						$sql="select * from note_menu";
						$rs=mysql_query($sql);
					?>						
					<div onclick="dis_Collect()" data-options="iconCls:'icon-tip'">收藏</div>
					<div class="menu-sep"></div>
					
					<?php while($row = mysql_fetch_array($rs)){ ?>
						<div onclick="dis_type(<?php echo $row["mid"] ?>,'<?php echo $row["text"] ?>')" data-options="iconCls:'<?php echo $row["iconCls"] ?>'"><?php echo $row["text"] ?></div>
					<?php }?>					
				</div>				
				<span id="title_title" class="m-title">NoteCloud</span>
			</div>
		</header>
		
		<div id="dl"></div>
		
		<!--<ul class="m-list">
			<?php while($row = mysql_fetch_array($rs)){ ?>
				<li><a href="javascript:void(0)" onclick="openit(this,<?php echo $row["id"] ?>)"><?php echo $row["title"] ?></a></li>
		    <?php }?>
		</ul>-->
		<footer style="padding:10px">
            <input id="find_nr" class="easyui-textbox" style="width:100%;height:32px;" data-options="prompt:'输入查询内容',buttonText:'<span style=\'padding:0 15px\'>Find</span>'">
        </footer>
	</div>
	<!--disp-->
	<div id="p2" class="easyui-navpanel">
		<header>
			<div class="m-toolbar">
				<span id="p2-title" class="m-title">panel-linklist</span>
                <div class="m-left">					
                    <a href="javascript:void(0)" class="easyui-linkbutton m-back" plain="true" outline="true" onclick="$.mobile.back()">Back</a>
                </div>
				 <div class="m-right">
					<a onclick="go_p3()" class="easyui-linkbutton" iconCls="icon-edit" plain="true" outline="true">Edit</a>
                    <a onclick="removeit()" class="easyui-linkbutton" iconCls="icon-clear" plain="true" outline="true">Del</a>
                </div>	
               
			</div>
		</header>
        <div id="p2-nr" style="padding:20px"></div>
		<footer>
			<div style="padding:5px;text-align:center" >
				<div id="p2-fb" ></div>
			</div>
		</footer>		
	</div>
	<!--edit-->
	<div id="p3" class="easyui-navpanel">
        <header>
            <div class="m-toolbar">
                <div class="m-title" >Note_Edit</div>
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
                <td width="70">标题：</td>
                <td><input id="p3_title_" class="easyui-textbox" data-options="required:true"  style="width:100%;" />  </td>
              </tr>
			  
              <tr>
                <td colspan="2"> 
					<script id="editor" type="text/plain" style="width:100%;height:300px;"></script>					
				</td>
              </tr>
			  
				<tr>
					<td colspan="2" align="center"></td>
				</tr>
            </table>              
        </form>			
		
        <footer style="padding:2px 3px">
			<div class="m-center" style="vertical-align: middle;text-align:center">
				 <input onclick="nr_save()" class="easyui-linkbutton" style="width:100%;height:50px;" data-options="buttonText:'<span style=\'padding:0 15px\'></span>'">
			</div>
        </footer>
    </div>
</body>	

</html>
