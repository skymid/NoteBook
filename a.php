<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
				<meta name="keywords" content="html5,jquery,ui,widgets,ajax,ria,web framekwork,web development,easy,easyui,datagrid,treegrid,tree">
		<meta name="description" content="jQuery EasyUI works well on mobile devices as the demo shows.">
		<title>Live Demo - jQuery EasyUI</title>
        <link rel="stylesheet" href="/css/kube.css" type="text/css" />
        <link rel="stylesheet" href="/css/main.css" type="text/css" />
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
		<script type="text/javascript" src="/easyui/jquery.min.js"></script>
	</head>
	<body>
		<div id="header" class="group wrap header">
			<div class="content">
	<div class="navigation-toggle" data-tools="navigation-toggle" data-target="#navbar-1">
		<span>EasyUI</span>
	</div>
	<div id="elogo" class="navbar navbar-left">
		<ul>
			<li>
				<a href="/index.php"><img src="/images/logo2.png" alt="jQuery EasyUI"/></a>
			</li>
		</ul>
	</div>
	<div id="navbar-1" class="navbar navbar-right">
		<ul>
			<li><a href="/index.php">Home</a></li>
			<li><a href="/demo/main/index.php">Demo</a></li>
			<li><a href="/tutorial/index.php">Tutorial</a></li>
			<li><a href="/documentation/index.php">Documentation</a></li>
			<li><a href="/download/index.php">Download</a></li>
			<li><a href="/extension/index.php">Extension</a></li>
			<li><a href="/contact.php">Contact</a></li>
			<li><a href="/forum/index.php">Forum</a></li>
		</ul>
	</div>
	<div style="clear:both"></div>
</div>
<script type="text/javascript">
	function setNav(){
		var demosubmenu = $('#demo-submenu');
		if (demosubmenu.length){
			if ($(window).width() < 450){
				demosubmenu.find('a:last').hide();
			} else {
				demosubmenu.find('a:last').show();
			}
		}
		if ($(window).width() < 767){
			$('.navigation-toggle').each(function(){
				$(this).show();
				var target = $(this).attr('data-target');
				$(target).hide();
				setDemoNav();
			});
		} else {
			$('.navigation-toggle').each(function(){
				$(this).hide();
				var target = $(this).attr('data-target');
				$(target).show();
			});
		}
	}
	function setDemoNav(){
		$('.navigation-toggle').each(function(){
			var target = $(this).attr('data-target');
			if (target == '#navbar-demo'){
				if ($(target).is(':visible')){
					$(this).css('margin-bottom', 0);
				} else {
					$(this).css('margin-bottom', '2.3em');
				}
			}
		});
	}
	$(function(){
		setNav();
		$(window).bind('resize', function(){
			setNav();
		});
		$('.navigation-toggle').bind('click', function(){
			var target = $(this).attr('data-target');
			$(target).toggle();
			setDemoNav();
		});
	})
</script>		</div>
		<div id="mainwrap">
			<div id="content">

<link rel="stylesheet" type="text/css" href="/easyui/themes/material/easyui.css">
<link rel="stylesheet" type="text/css" href="/easyui/themes/mobile.css">
<link rel="stylesheet" type="text/css" href="/easyui/themes/color.css">
<link rel="stylesheet" type="text/css" href="/easyui/themes/icon.css">
<link rel="stylesheet" href="/css/demo1.css" type="text/css" />
<link type="text/css" rel="stylesheet" href="../../prettify/prettify.css"></link>
<script src="../../prettify/prettify.js"></script>
<script type="text/javascript" src="/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="/easyui/jquery.easyui.mobile.js"></script>
<script type="text/javascript">
	var width = $(window).width();
	if (width < 600){
		location.href = "mindex.php";
	}
</script>
<style type="text/css">
	.device{
		width: 370px;
		height: 760px;
		background:url('../images/phone.png') no-repeat;
		position:relative;
		margin: 10px auto;
	}
	.demo-wrap{
		position:absolute;
		width:322px;
		height:482px;
		background: #ccc;
		top:117px;
		left:23px;
	}
	.datalist-link:hover{
		color: inherit;
	}
</style>


<div id="demo-submenu" class="content" style="direction:ltr;padding-top:1em;padding-bottom:0">
	<div class="submenu" style="position:relative;margin-bottom:-10px;padding-left:20px">
		<a href="../../demo/main/index.php">Web Demos</a>
		<a href="../../demo-mobile/main/index.php?sort=asc" class="submenu-selected">
			<span>Mobile Demos</span>
			<span class="submenu-sort submenu-sort-"></span>
		</a>
		<a href="../../themebuilder/index.php">Theme Builder</a>
	</div>
	<div style="position:relative;width:20px;height:20px;left:170px;top:1px">
		<div class="submenu-arrow"></div>
		<div class="submenu-arrow-inner"></div>
	</div>
</div>
<div class="content" style="padding-top:0;padding-bottom:0">
	<div class="plugins">
		<ul>
		<li><a href='javascript:void(0)' onclick="open2('Panel')">Panel</a></li><li><a href='javascript:void(0)' onclick="open2('Accordion')">Accordion</a></li><li><a href='javascript:void(0)' onclick="open2('Toolbar')">Toolbar</a></li><li><a href='javascript:void(0)' onclick="open2('Button')">Button</a></li><li><a href='javascript:void(0)' onclick="open2('Tabs')">Tabs</a></li><li><a href='javascript:void(0)' onclick="open2('SimpleList')">SimpleList</a></li><li><a href='javascript:void(0)' onclick="open2('DataList')">DataList</a></li><li><a href='javascript:void(0)' onclick="open2('DataGrid')">DataGrid</a></li><li><a href='javascript:void(0)' onclick="open2('Layout')">Layout</a></li><li><a href='javascript:void(0)' onclick="open2('Menu')">Menu</a></li><li><a href='javascript:void(0)' onclick="open2('Tree')">Tree</a></li><li><a href='javascript:void(0)' onclick="open2('Dialog')">Dialog</a></li><li><a href='javascript:void(0)' onclick="open2('Form')">Form</a></li><li><a href='javascript:void(0)' onclick="open2('Input')">Input</a></li><li><a href='javascript:void(0)' onclick="open2('Badge')">Badge</a></li><li><a href='javascript:void(0)' onclick="open2('Animation')">Animation</a></li>		</ul>
		<div style="clear:both"></div>
	</div>
</div>

<div class="content">
	<div class="navigation-toggle" data-tools="navigation-toggle" data-target="#navbar-demo" style="text-align:left">
		<span>Button</span>
	</div>
	<div class="units-row">
		<div id="navbar-demo" class="unit-30 content-striped" style="direction:ltr;margin-bottom:2.3em">
			<h3 style="border-bottom:1px solid #ddd;padding:18px 0 0 10px">Button</h3>
			<ul class='pitem'><li><a href='javascript:void(0)' onclick="open1('../../easyui/demo-mobile/button/basic.html',this)">Basic</a></li><li><a href='javascript:void(0)' onclick="open1('../../easyui/demo-mobile/button/group.html',this)">Button Group</a></li><li><a href='javascript:void(0)' onclick="open1('../../easyui/demo-mobile/button/style.html',this)">Button Style</a></li><li><a href='javascript:void(0)' onclick="open1('../../easyui/demo-mobile/button/switch.html',this)">Switch Button</a></li></ul>		</div>
		<div class="unit-70" style="position:relative;border:1px solid #ddd;">
			<div id="setting" style="position:absolute;right:5px;top:-33px;z-index:3">
				<table class="table-flat" style="width:auto;">
					<tr>
						<td><span style="color:#999">Themes:</span></td>
						<td>
							<select id="cb-theme" style="width:120px;height:25px"></select>
						</td>
					</tr>
				</table>
			</div>
			<div class="device">
				<div class="demo-wrap">
					<div id="demo" style="position:relative;overflow:hidden;min-height:350px" data-options="
							href:'../../easyui/demo-mobile/button/basic.html',
							fit:true,
							border:false,
							extractor: function(data){	// define how to extract the content from ajax response, return extracted data
								var pattern = /<body[^>]*>((.|[\n\r])*)<\/body>/im;
								var matches = pattern.exec(data);
								if (matches){
									var cc = matches[1];	// only extract body content
									if (matches[0].match(/body class=\Weasyui-layout\W/im)){
										cc = '<div class=\'easyui-layout\' fit=true>'+cc+'</div>'
									}
									return cc;
								} else {
									return data;
								}
							},
							onLoad:onLoad">
					</div>
				</div>
			</div>
			<div style="padding:10px 20px;background:#fafafa;border:1px solid #ddd;border-width:1px 0">
				<h4 style="margin:0;text-align:left">Source Code</h4>
			</div>
			<div id="code" style="height:450px;overflow:auto;direction:ltr;font-size:12px"></div>
		</div>
	</div>
</div>


<script>
	$(function(){
		var themes = [
			{value:'default',text:'Default',group:'Base'},
			{value:'gray',text:'Gray',group:'Base'},
			{value:'metro',text:'Metro',group:'Base'},
			{value:'material',text:'Material',group:'Base'},
			{value:'bootstrap',text:'Bootstrap',group:'Base'},
			{value:'black',text:'Black',group:'Base'},
			{value:'metro-blue',text:'Metro Blue',group:'Metro'},
			{value:'metro-gray',text:'Metro Gray',group:'Metro'},
			{value:'metro-green',text:'Metro Green',group:'Metro'},
			{value:'metro-orange',text:'Metro Orange',group:'Metro'},
			{value:'metro-red',text:'Metro Red',group:'Metro'},
			{value:'ui-cupertino',text:'Cupertino',group:'UI'},
			{value:'ui-dark-hive',text:'Dark Hive',group:'UI'},
			{value:'ui-pepper-grinder',text:'Pepper Grinder',group:'UI'},
			{value:'ui-sunny',text:'Sunny',group:'UI'}
		];
		$('#demo').panel();
		$('#cb-theme').combobox({
			iconWidth:18,
			groupField:'group',
			data: themes,
			editable:false,
			panelHeight:'auto',
			onChange:onChangeTheme,
			onLoadSuccess:function(){
				$(this).combobox('setValue', 'material');
			}
		});
		if ($('#ck-rtl').is(':checked')){
			$('body').addClass('demo-rtl');
		}
		$('#setting').bind('click', function(e){
			e.stopPropagation();
		});
	});
	function onLoad(data){
		data = data.replace(/(\r\n|\r|\n)/g, '\n');
		data = data.replace(/\t/g, '    ');
		$('#code').html('<pre name="code" class="prettyprint linenums" style="border:0"></pre>');
		$('#code').find('pre').text(data);
		prettyPrint();
		$.mobile.init('#demo');
	}
	function onChangeTheme(theme){
		var link = $('#content').find('link:first');
		link.attr('href', '/easyui/themes/'+theme+'/easyui.css');
	}
	var currPlugin = 'Button';
	var currPageItem = 'Basic';
	function open1(url,a){
		currPageItem = $(a).text();
		$('body>div.menu-top').menu('destroy');
		$('body>div.window>div.window-body').window('destroy');
		$('#demo').panel('refresh',url);
	}
	function open2(plugin){
		if (plugin){
			currPlugin = plugin;
			currPageItem = '';
		}
		var href = '?plugin=' + currPlugin + '&theme=' + $('#cb-theme').combobox('getValue');
		href += '&dir=' + ($('#ck-rtl').is(':checked')?'rtl':'ltr');
		href += '&pitem=' + currPageItem;
		href += '&sort=';
		location.href = href;
	}
</script>

﻿			</div>
		</div>
		<div id="footer">
			<div class="units-row text-centered">Copyright © 2010-2017 www.jeasyui.com</div>
		</div>
	</body>
</html>