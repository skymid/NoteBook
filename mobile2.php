<!DOCTYPE html>

<html>
<head>
<meta charset="UTF-8">
    <meta charset="UTF-8">  
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>NoteBook_mobilev Group</title>  
	<?php
		require_once("../inc.js");
	?>

<script>

$(function () {
	$('#dl').datalist({
		url : 'mobile_nr_data.php',
		method : 'get',
		fit : true,
		checkbox : false,
		border : false,
		lines : true,
		textField : 'title',
		groupField : 'sj_lb',
		textFormatter : function (value, row) {
			return '<span style="padding:25px;">' + row.title + '</span>'
			 + '<span style="float:right;color:#999">' + row.sj + '</span>';
		},
		groupFormatter : function (value, row) {
			return '<span style="font-size:12px;height:800px;color:#999;padding:15px;">' + value + '</span>'
			 + '<span class="m-badge c1" style="float:right;margin:5px 10px">6</span>';
		},
		onClickRow : function (index, row) {
			console.log(row);
			$('#p2-title').html(row.title);
			$('#p2-nr').html(row.nr)
			$('#p2-fb').html(row.sj)
			$.mobile.go('#p2');
		}
	})
});
</script>	
</head>
<!-- <script type="text/javascript" src="datagrid-cellediting.js"></script>
 注释内容 -->

 <body>
    <div class="easyui-navpanel">
        <header>
            <div class="m-toolbar">
				<div class="m-left">
                    <a href="mobile.php" class="easyui-linkbutton" data-options="iconCls:'icon-man',plain:true"></a>
                </div>
                <div class="m-right">
                    <a href="add.php" class="easyui-linkbutton" iconCls="icon-edit" plain="true" outline="true">Edit</a>
                </div>					
                <span class="m-title">Group DataList</span>				
            </div>
        </header>
		<div id="dl" style="padding:50px;height:350px"></div>
     			
    </div>
	
    <div id="p2" class="easyui-navpanel">
        <header>
            <div class="m-toolbar">
                <span id="p2-title" class="m-title">Detail</span>
                <div class="m-left">
                    <a href="javascript:void(0)" class="easyui-linkbutton m-back" plain="true" outline="true" onclick="$.mobile.back()">Back</a>
                </div>
            </div>
        </header>
		
        <div >
			<div  id="p2-nr" style="font-size:24px;padding:18px">nr</div>            
        </div>

		<footer>
			<div class="m-toolbar">
				<div id="p2-fb">2016-9-2</div>
			</div>
		</footer>		
    </div>	

   
</body>    
</html>
