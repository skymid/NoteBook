<!DOCTYPE html>

<?php
	include_once 'conn.php';
	//$sql="select * from book order by id desc limit 15";
	$sql="select * from notebook order by id desc ";
	$rs=mysql_query($sql);
?>
<html>
<head>
<meta charset="UTF-8">
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
var ue = UE.getEditor('editor',{
	 autoHeight: false,
	 catchRemoteImageEnable: true
});

var data_nr    //单击行时，保存后台返回的数据


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
			//$('#note_edit').dialog('close');
			$('#dg').datagrid('load');									
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
                    <a href="mobile2.php" class="easyui-linkbutton" data-options="iconCls:'icon-man',plain:true"></a>
                </div>
                <div class="m-right">
                    <a href="add.php" class="easyui-linkbutton" iconCls="icon-edit" plain="true" outline="true">Add</a>
                </div>				
				<span class="m-title">Note</span>
			</div>
		</header>
		<ul class="m-list">
			<?php while($row = mysql_fetch_array($rs)){ ?>
				<li><a href="javascript:void(0)" onclick="openit(this,<?php echo $row["id"] ?>)"><?php echo $row["title"] ?></a></li>
		    <?php }?>
		</ul>
	</div>
	
	<div id="p2" class="easyui-navpanel">
		<header>
			<div class="m-toolbar">
				<span id="p2-title" class="m-title">panel-linklist</span>
                <div class="m-left">					
                    <a href="javascript:void(0)" class="easyui-linkbutton m-back" plain="true" outline="true" onclick="$.mobile.back()">Back</a>
                </div>
                <div class="m-right">
                    <a onclick="go_p3()" class="easyui-linkbutton" iconCls="icon-edit" plain="true" outline="true">Edit</a>
                </div>					
			</div>
		</header>
        <div id="p2-nr" style="padding:20px"></div>
		<footer>
			<div class="m-toolbar">
				<div id="p2-fb"></div>
			</div>
		</footer>		
	</div>
	
	<div id="p3" class="easyui-navpanel">
        <header>
            <div class="m-toolbar">
                <div class="m-title" >Note_Edit</div>
                <div class="m-left">
                    <a href="mobile.php" class="easyui-linkbutton m-back" plain="true" outline="true">Back</a>
                </div>
                <div class="m-right">
                    <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" outline="true">Del</a>
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
			<div class="m-center">
				<a onclick="nr_save()" class="easyui-linkbutton" iconCls="icon-save" plain="true" outline="true">Save</a>
			</div>
        </footer>
    </div>
</body>	

</html>
