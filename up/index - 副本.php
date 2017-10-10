<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>uploadifive</title>

<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery.uploadifive.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="js/uploadifive.css">

<link rel="stylesheet" href="/3nd_js/layui/css/layui.css">
<script type="text/javascript" src="/3nd_js/layui/layui.js"  Charset="UTF-8"></script>

<style type="text/css">

.uploadifive-button {
	float: left;
	margin-right: 10px;
}
#queue {
	border: 1px solid #E5E5E5;
	height: 250px;
	overflow: auto;
	margin-bottom: 10px;
	padding: 10 3px 3px;
	width: 100%;
}
</style>

<script type="text/javascript">
	<?php $timestamp = time();?>
	$(function() {
		$('#file_upload').uploadifive({
			'auto'             : true,	
			'height'   : 50,
			'fileSizeLimit' : 0,
			'removeCompleted' : false,
			'progressData' : 'speed',
			'formData'         : {
								   'timestamp' : '<?php echo $timestamp;?>',
								   'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
								 },
			'queueID'          : 'queue',
			'uploadScript'     : 'up.php',
			'onUploadComplete' : function(file, data) { console.log(data); },
			'onSelect' : function(file) {
				document.getElementById("queue").style.display="";
			}
		});
	});
	
	layui.use('element', function(){
	  var element = layui.element;
	  
	  //…
	});	
</script>

</head>
<body>

	<div class="layui-tab layui-tab-card">
	
	  <ul class="layui-tab-title">
		<li>UP</li>
		<li class="layui-this">List</li>		
	  </ul>	 
	  
	  <div class="layui-tab-content" style="height: 230px;">
		<div class="layui-tab-item">
			<form>
				<!--<div id="queue" style="display: none"></div>-->	
				<div id="queue" ></div>	
				
				<div style="display: none">			
					<input id="file_upload"  name="file_upload" type="file" multiple="true" >			
				</div>
				<!--<input class="easyui-switchbutton"  style="width:100px;" data-options="onText:'自定上传',offText:'手动上传'">-->
			</form>			
		</div>		
		<div class="layui-tab-item">
			<table class="layui-table" lay-size="sm" >
			  <colgroup>
				<col width="150">
				<col width="200">
				<col>
			  </colgroup>
			  <thead>
				<tr>
				  <th>文件名</th>
				  <th>加入时间</th>
				</tr> 
			  </thead>
			  <tbody>
				<tr>
				  <td>贤心</td>
				  <td>2016-11-29</td>
				</tr>
				<tr>
				  <td>许闲心</td>
				  <td>2016-11-28</td>
				</tr>
			  </tbody>
			</table>
		</div>
	  </div>
	</div>
	
   
</body>
</html>