<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>treegrid</title>
<link href="images/favicon.ico" mce_href="images/favicon.ico" rel="icon">
<?php
require_once("../../inc.js");

?>

<script type="text/javascript">

$(function(){	

	$('#index_menu').tree({
	url:'tree_data.php',
	lines:true,
	parentField:'pid',
	onClick: function(node){
		//console.log(node.pid);				
		pid_id=node.id;
		
		if(node.url){
			$('#note_manager').dialog('open'); 
		}else{
			$('#dg').datagrid('load',{
				pid:node.id
			})					
		}
		if($('#yn_collapse').switchbutton("options").checked){	//分类 下的'开关'
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
});	
</script>

<body >  
<ul id="index_menu" ></ul>	

</body>  
	
</html>

