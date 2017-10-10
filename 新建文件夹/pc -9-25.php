<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>NoteBook</title>
<link href="images/favicon.ico" mce_href="images/favicon.ico" rel="icon">
<?php
require_once("../inc.js");
//require_once("init.php")
?>
<script type="text/javascript" charset="utf-8" src="ueditor1_4_3-utf8-php/ueditor.config.js"  Charset="UTF-8"></script>
<script type="text/javascript" charset="utf-8" src="ueditor1_4_3-utf8-php/ueditor.all.min.js"  Charset="UTF-8"> </script>   
<script type="text/javascript" charset="utf-8" src="ueditor1_4_3-utf8-php/lang/zh-cn/zh-cn.js"  Charset="UTF-8"></script>

<script type="text/javascript" src="/3nd_js/datagrid-groupview.js"  Charset="UTF-8"></script>
<script type="text/javascript" charset="utf-8" src="jquerysession.js"  Charset="UTF-8"></script>

<link rel="stylesheet" href="/3nd_js/layui/css/layui.css">
<script type="text/javascript" src="/3nd_js/layui/layui.js"  Charset="UTF-8"></script>
<!--<script src="/3nd_js/layer/layer/layer.js"></script>-->
 <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<style>
.a_red div{color:red}
.a_black div{color:black}
</style>

<script type="text/javascript">

if(!$.session.get('user')){
	window.location = "login.php";
}


var row_nr='';		//单击行时保存一下
var pid_id=0;	//tree 所选分类id	
var add_xg;		//添加 add 还是修改 xg ？
var data_top;	//top 数据
var nr_save_data;//保存时数据
var add_first=false;	//add_xg=add 时，防止多次新建
var wordcount;
var save_no=false;
var font_size=16;
var ue = UE.getEditor('editor',{
	 autoHeight: true,
	 catchRemoteImageEnable: true,
	 autoFloatEnabled:true	 
}); 

ue.addListener(
	"focus",function(){					
	  // console.log("focus");
	  // console.log(ue.getContentTxt().length);
	   wordcount=ue.getContentTxt().length;
	   
	  //console.log(ue.getContent().length);
	  //console.log(ue.getContentTxt());	  		 
	  
	  //console.log(ue);		  	 
	}
)

ue.addListener(
	"blur",function(){
		// console.log("blur");
		// console.log(ue.getContentTxt().length);
		 
		if(ue.getContentTxt().length!=wordcount){
			save_no=true;
			$('#note_edit').panel({headerCls:"a_red"});
			 // $('#title_').textbox('getText');
			var t='【 ' + $('#title_').textbox('getText')+' 】  - '+'内容有改变，但还没有保存';
			$('#note_edit').panel({title:t});
			$('#tt_center').tabs('update', {
				tab: $('#tt_center').tabs('getSelected'),
				options: {
					title: $('#title_').textbox('getText'),				
					iconCls:'icon-e_update'
				}
			});		 
		 }
	}
)

$(function(){	
	//禁用右键菜单
	$(document).bind("contextmenu",function(e){
      //  return false;
    });

	$('#fl').textbox({width:1})

	$('#fl_nr').switchbutton({
		onText:'+内容',
		offText:'分类',
		width:90,
		checked:false,
		onChange:function(checked){
			if(checked){
				$('#index_menu').tree({url:'tree.php?type=nr'});
				
			}else{
				$('#index_menu').tree({url:'tree.php'});
			}
		}		
	});	
	
	//功能区
	$('#index_menu').tree({
	url:'tree.php',
	lines:true,
	parentField:'pid',
	onClick: function(row){
		console.log(row);				
		pid_id=row.id;
		
		if(row.title){	//单击内容标题时
			$('#note_nr').panel('open');							
			$('#nr_read_title').html(row.title+"   【 "+row.text+" 】"+"      标签："+row.tag);
			//$('#note_nr').panel('setTitle',row.title+"   【 "+row.text+" 】"+"      标签："+row.tag);			
			$("#nr_note").html(row.nr);
			$("#nr_footer").html(row.sj); 
			//console.log('只读2');
			//$('#note_edit').panel('close');
			$('#tt_center').tabs('select',0);
			$('#tt_center').tabs('select',1);		
		}else{
			if(row.url){
				$('#note_manager').dialog('open'); 
			}else{
				$('#dg').datagrid('load',{
					pid:row.id
				})					
			}
			if($('#yn_collapse').switchbutton("options").checked){	//分类 下的'开关'
				$("#main_layout").layout("collapse", "west");
			}			
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
	
	//标题——列表
	$('#dg').datagrid({
		url:'get_list.php',
		//header:'#hh',
		singleSelect:true,
		border:false,
		striped:true,
		fit:true,
		fitColumns:true,
		scrollbarSize:0,
		rownumbers:true,
		sortName:'sj',	//按修改时间显示
		sortOrder:'desc',				
		view:groupview,
		groupField:'sj_lb',
		groupFormatter:function(value,rows){
			return value + '【' + rows.length + '】';
		},
		pagination:true,
		pageSize:10, 
		pageList:[10,20,30],
		queryParams: {q: ''},			
		columns:[[    
			{field:'id',title:'ID',width:100,checkbox:true,sortable:true},  
			{field:'title',title:'标题',width:300,sortable:true,
				formatter:function(value,row){  
					//var content = '<li title="' + row.text + "-\-"+ row.sj+ '" class="tip">' + value + '</li>';  
					var content =  value ;  
					return content;  
				} 			
			},	
			{field:'set_lock',title:' ',width:90,sortable:true,formatter:function(value, row){
				if(row.password){
					return '<img src="images/lock.png"/>';
				}else if(row.top){
					return '<img src="images/top.png"/>';
				}else if(row.collect=="1"){
					return '<img src="images/tip.png"/>';
				}				
			}},
			{field:'sj',title:'sj',hidden:'true'},  			
		]],  		
		toolbar:'#dg_tb',				
		onSelect:function(index, row){
			row_nr=row;			//给右键用
			//console.log();
		},
		onClickRow:function(index, row){
			if($('#dg').datagrid('getSelected')){
				row_nr=row;
				console.log(row_nr);	
				if(row.set_lock){
					$.messager.prompt('提示', '输入密码：', function(r){						
						if (r==row.password){
							//下面有一样的代码
							if($('#edit_read').switchbutton("options").checked){														
								edit_nr(row_nr);								
							} else{
								
								$('#note_nr').panel('open');	
								$('#note_nr').panel('setTitle',row.title+"   【 "+row.text+" 】"+"      标签："+row_nr.tag);			
								$('#note_nr').panel('setTitle',row.title);
								$("#nr_note").html(row.nr);
								$("#nr_footer").html(row.sj); 
								//console.log('只读');
								//$('#note_edit').panel('close');
								$('#tt_center').tabs('select',0);
								$('#tt_center').tabs('select',1);
							}							
						}else{
							$.messager.show({
								title:'Error',
								msg:'密码错误！！',
								showType:'slide',
								style:{
									right:'',
									bottom:''
								}
							});
							$('#note_nr').panel('close');
							$('#note_edit').panel('close');							
						}
					});
				}else{
					//和上面一样的代码
					if($('#edit_read').switchbutton("options").checked){
						edit_nr(row_nr);						
					} else{						
						$('#note_nr').panel('open');							
						$('#nr_read_title').html(row.title+"   【 "+row.text+" 】"+"      标签："+row.tag);
						//$('#note_nr').panel('setTitle',row.title+"   【 "+row.text+" 】"+"      标签："+row.tag);			
						$("#nr_note").html(row.nr);
						$("#nr_footer").html(row.sj); 
						//console.log('只读2');
						//$('#note_edit').panel('close');
						$('#tt_center').tabs('select',0);
						$('#tt_center').tabs('select',1);
					}					
				}
				$('#cc_link').combobox({			
					url:'list_link.php?link_id='+row_nr.link,    
					valueField:'title',    
					textField:'title',
					editable:false,
					panelWidth:250,
					panelHeight:'auto',
					onClick:function(r){
						new_windows(r);
					}	
				});					
			}					
		},
		onRowContextMenu: function(e, index, row){
		    e.preventDefault();		
			$("#dg").datagrid('selectRow',index);	
		    $('#grid_mm').menu('show', {
		        left:e.pageX,
		        top:e.pageY
		    });	
		},
		onLoadSuccess:function(data){
			data_top=data.row_top;
			//console.log(data);
			
			$("#p_nr_top_").html(data_top.nr);   //保存后会自动更新
			
			//top foot sj
			$("#nr_footer_top").html(data_top.sj);
			
			//保存后 是否自动更新【只读】Read 的内容
			if(nr_save_data){
				//console.log(nr_save_data);
				
				if($('#update_to_read').switchbutton("options").checked){
					$('#note_nr').panel('setTitle',nr_save_data.title_+"   【 "+nr_save_data.pid+" 】");			
					$("#nr_note").html(nr_save_data.nr);
					$("#nr_footer").html(nr_save_data.sj); 					
				}
			//	$('#p_nr_top').panel('setText',nr_save_data.title_);	
			}
		}
	});

	var pager = $("#dg").datagrid("getPager");      
	pager.pagination({        
		//layout : ['first','prev','links','next','last']      
		showPageList: false,
		//showRefresh: false,
		displayMsg: ''
	});
		
	
	//north 按标题或内容查询
	$('#ss').searchbox({ 
		searcher:function(value,name){ 
			//alert(value + "," + name) 
			$('#dg').datagrid('load',{
				nr: value,
				zd:name
			});			
		}, 
		menu:'#mm', 
		prompt:'按标题或内容查询...' 
	}); 	
	
	//add 按钮
    $('#btn_add_nr').bind('click', function(){
		save_no=true;
		$('#note_edit').panel('setTitle','添加');
		$('#nr_id').textbox('setText','');
		$('#title_').textbox('setText',pid_id);	
		ue.setContent('');		
        $('#note_edit').panel('open');
		$('#comb_type').combotree('setValue',pid_id);  //pid_id 单击菜单时传过来了
		add_xg='add';
		add_first=true;
		//$('#note_nr').panel('close');
		$('#tt_center').tabs('select',2);
    });	
	
	//列表 表头（右边）按钮
	$('#left_menuPanel').panel({
		tools : [
		/* {
			iconCls : 'icon-reload',
			handler : function() {				
				$('#dg').datagrid('load',{
					nr: '',
					zd:'id'				
				});	
			}
		}, */
		{
			iconCls : 'icon-list',
			handler : function() {				
				$('#dg').datagrid('sort',{
					sortName:'id',	//为什么不能以其他字段
					sortOrder: 'desc'				
				});	
			}
		}, {
			iconCls : 'icon-time',
			handler : function() {
				$('#dg').datagrid('sort', {	        // 指定了排序顺序的列
					sortName: 'sj',
					sortOrder: 'desc'
				});
			}
		}, {
			iconCls : 'icon-tip',
			handler : function() {				
				$('#dg').datagrid('load',{
					nr: '1',
					zd:'collect'
				});	
			}
		}, {
			iconCls : 'icon-top',
			handler : function() {
				$('#dg').datagrid('load',{
					nr: '1',
					zd:'top'
				});	
			}
		} ]
	});
	
	//列表 下的 按标题查询
	$('#dg_v_find').textbox({
		iconCls:'icon-search',
		prompt:'按标题查询',		
		width:185,
		onChange:function(newValue, oldValue){	
			//console.log(newValue);
			$('#dg').datagrid('load',{				
				nr: newValue,	
				zd:'title'	
			});			
		}
	});	
	
	// Top 里面的 pencel
	$('#p_nr_top').panel({
		title: ' ',
		border:false,
		maximized:true,		
		tools: [{    
			iconCls:'icon-page',    
			handler:function(){
				edit_nr(data_top);				
			}    
		}],
		footer:'#nr_footer_top'   
	}); 
	
	//只读 Read 里面的 pencel
	$('#note_nr').panel({    
		title: 'nr',
		border:false,
		fit:true,
		closed: true,
		header:'#nr_read_hh', 		
		footer:'#footer_read'
	});

	//编辑 Edit 里面的 pencel
	$('#note_edit').panel({
		title:'l',
		//headerCls:'a_red',
		border:false,
		fit:true,		
   		closed: true,    
		tools:[{
			id:'note_edit_save',
			text:'保存',
			iconCls:'icon-save',				
			handler:function(){
				add_xg='xg';		
				nr_save();					
				}
			}
/* 			,{
				iconCls:'icon-clear',
				handler:function(){
					$('#note_edit').dialog('close');
				}
			} */
		],		
		onBeforeClose:function(){  
			//add_xg='xg'; 
			//nr_save();			   
			//console.log("onBeforeClose");
		},
		onOpen:function(){
				$('#cc_link2').combobox({			
					url:'list_link.php?link_id='+row_nr.link,    
					valueField:'title',    
					textField:'title',
					editable:false,
					panelWidth:250,
					panelHeight:'auto',
					onClick:function(r){
						new_windows(r);
					}	
				});			
		},
		footer:'#footer_edit'		
	});	
	
	
	//add 时 选择分类  ( Edit 分类选择)
	$('#comb_type').combotree({ 
		panelWidth:300,
		panelHeight:'auto',		
		checkbox:true,
		lines:true,
		textField:'text',
		valueField:'id',	
		url:'tree_list.php', 
		onLoadSuccess : function (node, data) {
			var _this = this;
			if (data) {
				$(data).each(function (index, value) {
					if (this.state == 'closed') {
						$(_this).tree('expandAll');   //自动展开
					}
				});
			}
		},
		onChange:function (newValue, oldValue) {
			//console.log(newValue);
			pid_id=newValue;
		}		
	}); 
	
	$("#yc" ).css("display", "none");	
	
	$('#tb_TagBox').tagbox({    
		valueField:'id',    
		textField:'tag',
		panelHeight:'auto',	
		prompt: '输入后回车添加'
		
		//limitToList: true,
		//hasDownArrow: true,					
		//value:['Apple', 'Orange'] 
		// value: '3,4',
		// buttonText: 'Button',
		//	onClickButton: function(){
	//			console.log($('#tb_TagBox').tagbox('getValues'));
		//	}
	});	
	
	
	//layui 框架
	layui.use('layer', function(){
	  var layer = layui.layer;	  
		$('#parentIframe1').on('click', function(){
			  layer.open({
			  type: 2,
			  title: '管理菜单',
			  maxmin: true,
			  shadeClose: true, //点击遮罩关闭层
			  area : ['80%' , '620px'],
			  content: ['tree_edit_dnd/tree2.html','no']	
			  });
			  
		});	 
		$('#web_disk').on('click', function(){
			  layer.open({
			  type: 2,
			  title: 'web_Disk',
			  maxmin: true,
			  shadeClose: true, 
			  area : ['40%' , '370px'],
			  content: ['up/index.php','no']	
			  });
			  
		});			
		$('#plan').on('click', function(){
			  layer.open({
			  type: 2,
			  title: '计划',
			  maxmin: true,
			  shadeClose: true, 
			  area : ['50%' , '460px'],
			  content: ['plan/index.php','no']	
			  });
			  
		});	
		$('#link_treegrid').on('click', function(){
			  layer.open({
			  type: 2,
			  title: '链接',
			  maxmin: true,
			  shadeClose: true, 
			  area : ['50%' , '460px'],
			  content: ['treegrid/index.php','no']	
			  });
			  
		});		
	});
	
	
	/* $('#parentIframe1').on('click', function(){
	  layer.open({
	  type: 2,
	  title: '管理菜单',
	  maxmin: true,
	  shadeClose: true, //点击遮罩关闭层
	  area : ['80%' , '620px'],
	  content: ['tree_edit_dnd/tree2.html','no']	
	  //content:'<iframe src="tree_edit_dnd/tree2.html" frameborder="0" style="padding:0px;border:0;width:100%;height:99.4%;"></iframe>',
	  });
	});
	
	layui.use('layer', function(){
	  var layer = layui.layer;	  
	 // layer.msg('hello');
		$('#parentIframe1').on('click', function(){
		  layer.open({
		  type: 2,
		  title: '管理菜单',
		  maxmin: true,
		  shadeClose: true, //点击遮罩关闭层
		  area : ['80%' , '620px'],
		  content: ['tree_edit_dnd/tree2.html','no']	
		  });
		});	 
	}); */

	
	$('#new_win').dialog({    
		width:600,    
		height:300,
		border:'thick',
		resizable:true,
		closed:true,
		buttons:[{
			text:'关闭',
			iconCls:'icon-clear',
			handler:function(){$('#new_win').dialog('close')}
		}]   
	});  

	
	$('#link_dd').dialog({ 
		//title:'all_nr',
		width:600,    
		height:600,
		border:'thick',
		resizable:true,
		closed:true,
		onOpen:function(){
			$('#all_menu').tree({
				'url':'treegrid/tree_data.php'
			});
		}  
	}); 
	
	$('#all_menu').tree({	
		//url:'treegrid/tree_data.php',
		cascadeCheck:false,
		checkbox:true,
		lines:true,
		parentField:'pid',		
		onCheck:function(node, checked){
			var t=$('#all_menu').tree('getChecked');
			//console.log(t);
			var pid='';
			 for (i = 0; i < t.length; i++){
				pid=pid+t[i].id+',';
			 }
			 //console.log(pid);	
			 //console.log(row_nr.id);	
			 $.ajax({							
				url:'update_link.php',
				type:'post',
				data:{
					id:row_nr.id,
					link:pid
				}							
			 })			 
		},
		onClick: function(node){							
					
			/* $('#note_nr').panel('open');
				
			$('#nr_read_title').html(node.title+"   【 "+node.text+" 】"+"      标签："+node.tag);
			$("#nr_note").html(node.nr);
			$("#nr_footer").html(node.sj); 
			$('#tt_center').tabs('select',0);
			$('#tt_center').tabs('select',1);	 */		
									
		},
		onDblClick : function(node) {
				
		}              						
	})	
	
	$('#all_menu_find').textbox({
		width:'93%',
		buttonText:'Search',    
		//iconCls:'icon-man', 
		iconAlign:'left',
		onClickButton:function(){
			$('#all_menu').tree({
				queryParams:{
					q: $('#all_menu_find').textbox('getText')					
				}
			});
		}	
	})	
	
});	

//-------------------------------------end --------------------------------------------------
function linke_windows(){
	$('#link_dd').dialog('open');
	$('#link_dd').dialog('setTitle',row_nr.title);
}
function new_windows(data){
	//console.log(data);
	$("#new_nr").html(data.nr);
	$('#new_win').dialog('open');
	$('#new_win').panel('setTitle',data.title+"   【 "+data.text+" 】"+"      标签："+data.tag);
	
/* 	layer.open({
	  type: 1, 
	  content: data.nr //这里content是一个普通的String
	}); */
}

//管理菜单
function gl(){	
	$('#note_manager').dialog({    
		title: 'manager', 
		width:'90%',
		height:'90%',
		//closed: true,   
		//content:'<iframe src="manager/manager.php" frameborder="0" style="padding:0px;border:0;width:100%;height:99.4%;"></iframe>',
		content:'<iframe src="tree_edit_dnd/tree2.html" frameborder="0" style="padding:0px;border:0;width:100%;height:99.4%;"></iframe>',
		modal: true,
		maximizable:true			
	});  
}


function Read_TO_Edit(){
	//str = ue.getContentTxt();  
	//alert(str.length);
	
	edit_nr(row_nr);
	var a=UE.getEditor('editor');
	//console.log(a);
	//a.setHide();
	//alert(UE.getEditor('container').wordCount);
	
	//$('#tt_center').tabs('select',2);
	
}

//编辑
function edit_nr(data){
	//console.log(data);
	//$('#note_nr').panel('close'); 	
	//console.log(save_no);
	
	//$('#note_edit').panel('close');
	
	if(save_no){
		//console.log("执行保存");
		nr_save();
	}
	
	
	if(data){
		$('#note_edit').panel('open'); 
		$('#note_edit').panel('setTitle',data.title+"   【 "+data.text+" 】");
		
		$('#nr_id').textbox('setText',data.id);
		$('#title_').textbox('setText',data.title);
		ue.setContent(data.nr);
		
		//分类	
		$('#comb_type').combotree('setValue',data.mid);	// 单击行时是mid;  top的是 pid	
		$("#nr_footer_edit").html(data.sj);
		
		add_xg='xg';
		$('#tt_center').tabs('select',0);
		$('#tt_center').tabs('select',2);
		
		//更新tab edit的面板的新标题
		$('#tt_center').tabs('update', {
			tab: $('#tt_center').tabs('getSelected'),
			options: {
				title: data.title,
				//iconCls:'icon-e_update'
				width:500
			}
		}); 
		
		//标签
		if(data.tag){
			$('#tb_TagBox').tagbox('setValues',data.tag);
		}else{
			$('#tb_TagBox').tagbox('setValues','');
		}		
	}else{
		layer.msg('没有编辑内容');
	}		
}

function nr_save(){
	if(add_xg=='xg'){
		if($('#nr_id').textbox('getText').length==0){			
			$.messager.show({
				title:'消息',
				msg:"新建内容，只能保存一次。请重新打开再编辑！！",
				showType:'slide',
				style:{
					right:'',
					bottom:''
				}
			});	
			return;			
		}
	}
	if($('#comb_type').combotree('getValue')!='0'){
		nr_save_data = { 					
			nr_id:$('#nr_id').textbox('getText'),
			title_:$('#title_').textbox('getText'),
			nr: ue.getContent(),
			pid:$('#comb_type').combotree('getValue'),
			tag:$('#tb_TagBox').tagbox('getValues'),
			bz:add_xg	//通过 add_xg 判断是添加,还是更新		
			
		};						
		$.ajax({							
			//url:'save.php',
			url:'save.php?nr_id='+$('#nr_id').textbox('getText'),
			type:'post',
			data:nr_save_data,
			success:function(data){
			   add_xg='xg';
			   save_no=false;
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
				
				$('#note_edit').panel({
						headerCls:"a_black",
						title:$('#title_').textbox('getText')
					}
				);
				// $('#note_edit').panel({
					// title:$('#title_').textbox('getText')
					// }
				// );	

				$('#tt_center').tabs('update', {
					tab: $('#tt_center').tabs('getSelected'),
					options: {
						title: 'Edit',
						iconCls:'icon-page'
					}
				});			
			},
			complete:function(){
				//$('#note_edit').dialog('close');
				$('#dg').datagrid('load');									
			}							
		})
		//console.log(save_no);			
	}else{
		layui.use(['layer', 'form'], function(){
		  var layer = layui.layer
		  ,form = layui.form();		  
		  layer.msg('没有选择分类！！');		  
		});	
	}

}

//del 函数
function removeit(){
	//console.log(row_nr);
	//console.log($('#dg').datagrid('getSelected'));
	
	if($('#dg').datagrid('getSelected')){
		$.messager.confirm('确定操作', '您确定要删除【'+row_nr.title+'】的记录吗？', function (flag) {
			if (flag) {			
				//console.log($('#dg').datagrid('getChecked')[0].id);		
				$.ajax({
					url : 'save.php?option=del&id='+$('#dg').datagrid('getChecked')[0].id,
					type : 'post',
					data : {
						//id : $('#dg').datagrid('getChecked')[0].id,
					}
				});
				$('#dg').datagrid('reload');	
			}
		})		
	}else{
		
		layui.use(['layer', 'form'], function(){
		  var layer = layui.layer
		  ,form = layui.form();		  
		  layer.msg('还没有选择删除内容！！');	

		});
		
 /*		$.messager.show({
			title:'消息',
			msg:"还没有选择删除内容！！",
			showType:'slide',
			style:{
				right:'',
				bottom:''
			}
		});	 */			
	}

}
function tool_nr_save(){
	//add_xg='xg';
	nr_save();
	
}	
		
//设置密码
function SetPassword(){
	$.messager.prompt('提示', '输入设置密码：', function(r){
		if (r){
			var data = {
				id:row_nr.id,	
				password:r,
				bz:'xg_password'
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
					$('#dg').datagrid('load');									
				}							
			})
		}
	});
}

function UnPassword(){
	$.messager.prompt('提示', '输入原先设置密码：', function(r){
		if (r==row_nr.password){
			var data = {
				id:row_nr.id,	
				password:r,
				bz:'xg_unpassword'
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
					$('#dg').datagrid('load');									
				}							
			})
		}else{
			$.messager.show({
				title:'消息',
				msg:"密码错误！！",
				showType:'slide',
				style:{
					right:'',
					bottom:''
				}
			});				
		}
	});
}
	
function setTop(){
	var data = { 					
		nr_id:row_nr.id,
		bz:'top'
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
<!--收藏-->
function setCollect(){
	if(row_nr.collect=='1'){
		n="no_Collect";
	}else{
		n="Collect";
	}
		
	var data = { 					
		nr_id:row_nr.id,
		bz:n
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
<!--改变 read div 字体大小-->
function div_font(v){	
	if(v=='add'){
		font_size=font_size+5;
	}else{
		font_size=font_size-5;
	}
	
	document.getElementById('nr_note').style.fontSize=font_size+'pt'	
}
</script>

<body id="main_layout" class="easyui-layout">  
	<!-- 一、分类 隐藏 -->
    <div data-options="region:'west',collapsible:true,collapsed:true,split:true,title:'菜单_分类'" style="width:230px" >		
		<div id="aa" class="easyui-accordion" >			
			<div title="分类" data-options="iconCls:'icon-sum',selected:true" style="overflow:auto;padding:10px;">   
				<input id="yn_collapse" class="easyui-switchbutton" data-options="onText:'叠',offText:'开'">
				<input id="fl_nr" >
				<ul id="index_menu" ></ul>  
			</div>   
			<div title="Manager" data-options="iconCls:'icon-man'" style="padding:10px;">   
				<a id="btn" href="manager/manager.php" class="easyui-linkbutton" data-options="iconCls:'icon-search'">easyui</a>     
			</div>   
			<div title="Title3">   
				content3    
			</div> 
		</div>
	</div> 
	<!-- 二、列表+中间 -->
    <div data-options="region:'center',border:false" >	

		<div class="easyui-layout" style="width:100%;height:100%;">  
			<!-- 1、项 add del 管理 -->
			<div data-options="region:'north'" style="height:80px;">
			 
				<div  class="easyui-panel" style="width:99%;height:99%;padding:15px;background:#fafafa;" data-options='border:false'>   
					<div style="float:left">
						<button class="layui-btn  layui-btn-radius" onClick="location.reload()">
							<i class="layui-icon">&#xe63d;</i>
						</button>					
						<!--查询-->
						<input id="ss" style="width:300px" /> 
						<div id="mm" style="width:300px"> 
							<div data-options="name:'nr',iconCls:'icon-sum'">内容</div> 
							<div data-options="name:'title',iconCls:'icon-ok'">标题</div> 
						</div>			

						<div class="layui-btn-group">
						  <button class="layui-btn layui-btn-big layui-btn-warm " id="btn_add_nr" >
							<i class="layui-icon">&#xe654;</i> Add
						  </button>
						  <button class="layui-btn layui-btn-big  layui-btn-normal" onclick="removeit()">
							<i class="layui-icon">&#xe640;</i> Del
						  </button>

						  <button class="layui-btn layui-btn-big" onclick="$('#dg').datagrid('reload')">
							<i class="layui-icon">&#x1002;</i> 刷新
						  </button>
						</div>
						
						<button class="layui-btn layui-btn-big  layui-btn-danger" id="parentIframe1">
							<i class="layui-icon">&#xe614;</i> 管理菜单
						</button>					
					</div>
					
					<div style="float:right">
						<div class="layui-btn-group">
							<button class="layui-btn  layui-btn-primary" id="web_disk">
								<i class="layui-icon">&#xe609;</i> 网盘
							</button>
							
							<button class="layui-btn  layui-btn-primary" id="plan">
								<i class="layui-icon">&#xe637;</i> 计划
							</button>
						</div>
					</div>
				</div>						
			
				
			</div> 
			
			<!-- 2、左列表-->
			<div id="left_menuPanel" data-options="region:'west',title:'列表',split:true" style="width:260px;">
				<table id="dg"></table> 
				   <!-- <div class="easyui-panel">
						<div class="easyui-pagination" data-options="
									total: 114,
									showPageList: false,showRefresh: false,
									displayMsg: ''"></div>
					</div>-->
			</div>  
			
			<!-- 3、TOP Read Edit-->
			<div data-options="region:'center'" >

				<div id="tt_center" class="easyui-tabs" data-options="border:false,justified:false,tabWidth:250,narrow:true,pill:true,plain:true" style="width:100%;height:100%;">  
					<!--TAB top-->
					<div title="TOP" data-options="iconCls:'icon-lock'" style="padding:0px;display:none;">   
						<div id="p_nr_top" > 
							<div id="p_nr_top_" style="padding:15px;" ></div>
						</div>  
					</div>  
					<!--TAB Read 只读-->
					<div title="Read" data-options="closable:false,iconCls:'icon-read',tools:'#tab_readToedit'" style="overflow:auto">   
						 <div id="note_nr" >
							<div id="nr_note" style="padding:15px 30px;font-size:20px" ></div>
						 </div>								  
					</div> 
					<!--TAB Edit 编辑-->
					<div title="Edit" data-options="iconCls:'icon-page'" style="padding:0px;display:none;">   
						 <div id="note_edit" style="padding:10px">
							<form id="it_send_form" method="post"> 
									<div style="padding:10px">
										<input id="title_" class="easyui-textbox"  data-options="label: ' 标题：',labelWidth:50" style="width:94%"> 																 					
										<input id="nr_id" class="easyui-textbox" data-options="editable:false" style="width:4%" >
									</div>	
									
									<div style="padding:10px;height:80px;width:99%">
										<div class="easyui-panel" style="padding:9px;background:#fafafa;" data-options="fit:true,border:true">	
											<a id="btn_save" onClick="tool_nr_save()" class="easyui-linkbutton" data-options="iconCls:'icon-save24',plain:true">Save</a> 
											<input id="fl">
											分类：<input id="comb_type" style="width:200px;" value="161"   > 										 										
											
											标签：<input id="tb_TagBox" type="text" style="width:35%"> 
											同步更新Read：<input id="update_to_read" class="easyui-switchbutton" data-options="onText:'同步更新到Read',offText:'不更新',width:120">
											<a id="btn_password" onclick="SetPassword()" class="easyui-linkbutton" data-options="iconCls:'icon-lock',plain:true">设置密码</a>  
											<div id="yc"></div>
										</div>
									</div>
									
									<div style="padding:0 10px 0 10px">
										<script id="editor" type="text/plain" style="width:99.8%;height:300px;"></script>	
									</div>										
							</form>	
						 </div>	 						
					</div>  
					
				</div> 							
				 
			</div>   
		</div>  
		
	</div> 

</body>  
	
    <div id="tab_readToedit"> 
        <a class="icon-mini-edit" onclick="Read_TO_Edit()"></a>
    </div>	
	
	<!--列表 下面的 查询 Read edit-->
	<div id="dg_tb">		
		<div id="dg_v_find"> </div>
		<input id="edit_read" class="easyui-switchbutton" data-options="onText:'Edit',offText:'Read'">
	</div>
	
    <div id="footer_top" style="padding:3px;">
        <div id="nr_footer_top" style="padding:4px;text-align:center" >123:123</div>
    </div>	
	 
    <div id="footer_read" style="padding:3px;">	
        
        <div class="m-toolbar">
            <div id="nr_footer" style="padding:4px;text-align:center" >123:123</div>           
            <div class="m-right" style="padding:5px;">
				<input id="cc_link" > 		
			</div>			
        </div>		
    </div>	
	<!--只读 tab panc head -->	
    <div id="nr_read_hh">
        <div class="m-toolbar">
            <div class="m-title" id="nr_read_title"></div>
            <div class="m-left">
                <a class="easyui-linkbutton" data-options="iconCls:'icon-page',plain:true" onclick="Read_TO_Edit()">Edit</a>                
            </div>
            <div class="m-right">
				<a class="easyui-linkbutton" data-options="iconCls:'icon-page',plain:true" onclick="Read_TO_Edit()"></a> 
				<a class="easyui-linkbutton" data-options="iconCls:'icon-font_add',plain:true" onclick="div_font('add');"></a>
				<a class="easyui-linkbutton" data-options="iconCls:'icon-font_Less',plain:true" onclick="div_font('Less');"></a>
				<a class="easyui-linkbutton" data-options="iconCls:'icon-link',plain:true" onClick="linke_windows()" ></a>				
				<a class="easyui-linkbutton" data-options="iconCls:'icon-pdf',plain:true" onclick="window.open('pdf.php?id='+row_nr.id);"></a>
				<a class="easyui-linkbutton" data-options="iconCls:'icon-lock',plain:true" onclick="SetPassword();"></a>
				<a class="easyui-linkbutton" data-options="iconCls:'icon-clear',plain:true" onclick="$('#note_nr').panel('close'); "></a>
            </div>			
        </div>
    </div>		
	<!--edit foot-->
    <div id="footer_edit" style="padding:0 5px 0;">
        <div class="m-toolbar">
            <div class="m-title" id="nr_footer_edit">123:123</div>
            <div class="m-left">
                <a onClick="nr_save()" class="easyui-linkbutton" data-options="iconCls:'icon-save24',plain:true">Save</a>
            </div>
            <div class="m-right" style="padding:5px;">
				<input id="cc_link2" > 		
			</div>			
        </div>
    </div>	
	
	 <div id="note_manager" ></div>
	 
	 <!--列表 右键菜单-->
	<div id="grid_mm" class="easyui-menu" style="width:150px;">
		<div onClick="edit_nr(row_nr)" data-options="iconCls:'icon-page'">编辑</div>
		<div onClick="removeit()" data-options="iconCls:'icon-clear'">删除</div>	
		<div class="menu-sep"></div>
		<div onClick="new_windows(row_nr)" data-options="iconCls:'icon-redo'">在新窗口中打开</div>
		<div class="menu-sep"></div>
		<div onClick="SetPassword()" data-options="iconCls:'icon-lock'">设置密码</div>
		<div onClick="UnPassword()" data-options="iconCls:'icon-remove'">删除密码</div>
		<div class="menu-sep"></div>
		<div onClick="setTop()" data-options="iconCls:'icon-top'">Top</div>
		<div onClick="setCollect()" data-options="iconCls:'icon-tip'">收藏</div>
	</div>	
	
	<!--新窗口中打开-->
	<div id="new_win">  
		<div id="new_nr" style="padding:10px;"></div>
	</div>  

	<div id="link_dd">
         <footer style="padding:5px">           
           <input id="all_menu_find" type="text" > 
		   <a onClick="$('#link_dd').dialog('close')" class="easyui-linkbutton" data-options="iconCls:'icon-clear',plain:true"></a> 
		 </footer>	
		<ul id="all_menu" ></ul>	
	</div>  
</html>

