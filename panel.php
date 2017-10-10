<!DOCTYPE html>

<html>
<head>
<meta charset="UTF-8">
    <meta charset="UTF-8">  
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Group DataList</title>  
    <link rel="stylesheet" type="text/css" href="../themes/gray/easyui.css">  
    <link id="uiTheme" rel="stylesheet" type="text/css" href="../themes/mobile.css">  
	<link rel="stylesheet" type="text/css" href="../themes/color.css"> 
    <link rel="stylesheet" type="text/css" href="../themes/icon.css">  
    <script type="text/javascript" src="../jquery.min.js"></script>  
    <script type="text/javascript" src="../jquery.easyui.min.js"></script> 
    <script type="text/javascript" src="../jquery.easyui.mobile.js"></script> 
<script type="text/javascript" src="jquery.cookie.js"></script>

	
</head>
<!-- <script type="text/javascript" src="datagrid-cellediting.js"></script>
 注释内容 -->

 <body>
    <div class="easyui-navpanel">
        <header>
            <div class="m-toolbar">
				<div class="m-left">
                    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-man',plain:true"></a>
                </div>
                <span class="m-title">Group DataList</span>
				<div class="m-right">
                    <!-- <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true"></a>
                     <select id="ith" class="easyui-combobox" name="theme">
						<option value="black">black11111111</option>
				     </select>-->
					<a href="javascript:void(0)" class="easyui-menubutton" data-options="iconCls:'icon-more',plain:true,hasDownArrow:false,menu:'#mm',menuAlign:'right'"></a>
                </div>				
            </div>
        </header>
		<div class="easyui-tabs" data-options="tabHeight:60,fit:true,tabPosition:'bottom',border:false,pill:true,narrow:true,justified:true">
                <div style="padding:0px">
                    <div class="panel-header tt-inner">
                        <img src='images/modem.png'/><br>收件箱
                    </div>										
					<div id="dl" style="padding:50px;height:350px"></div>				
                </div>
				
                <div style="padding:0px">
                    <div class="panel-header tt-inner">
                        <img src='images/tablet.png'/><br>发送
                    </div>
					<iframe src="tz.php" frameborder="0" style="padding:0px;border:0;width:100%;height:97%;"></iframe>
                </div>
				
                <div style="padding:10px">
                    <div class="panel-header tt-inner">
                        <img src='images/pda.png'/><br>日历
                        <span class="m-badge">23</span>
                    </div>
                    <p>A personal digital assistant (PDA), also known as a palmtop computer, or personal data assistant, is a mobile device that functions as a personal information manager. PDAs are largely considered obsolete with the widespread adoption of smartphones.</p>
                </div>
				
                <div style="padding:10px">
                    <div class="panel-header tt-inner">
                        <img src='images/scanner.png'/><br>我的文件夹
                        <span class="m-badge">13</span>
                    </div>
                    <p>A tablet computer, or simply tablet, is a one-piece mobile computer. Devices typically have a touchscreen, with finger or stylus gestures replacing the conventional computer mouse.</p>
                </div>
				
            </div>
     			
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
	
	<div id="mm" class="easyui-menu" style="width:150px;" data-options="itemHeight:30,noline:true">
		<div data-options="iconCls:'icon-undo'">Undo</div>
		<div data-options="iconCls:'icon-redo'">Redo</div>
		<div class="menu-sep"></div>
		<div>Cut</div>
		<div>Copy</div>
		<div>Paste</div>
		<div class="menu-sep"></div>
		<div>Toolbar</div>
		<div data-options="iconCls:'icon-remove'">Delete</div>
		<div>Select All</div>
	</div>	
	<style scoped>
           .tt-inner{
                display:inline-block;
                line-height:12px;
                padding-top:6px;
                position: relative;
            }
            p{
                line-height:150%;
            }
     </style>
    <script>
        var data = [{
        		"sj1" : "FL-DSH-01",
        		"title" : "Tailless"
        	}, {
        		"sj1" : "FL-DSH-01",
        		"title" : "With tail"
        	}, {
        		"sj1" : "FL-DSH-02",
        		"title" : "Adult Female"
        	}, {
        		"sj1" : "FL-DSH-02",
        		"title" : "Adult Male"
        	}
        ];

        $(function () {
        	$('#dl').datalist({
        		// data: data,
        		//url: 'datalist_data.json',
        		url : 'datalist_data.php',
        		method : 'get',
        		fit : true,
        		checkbox : false,
        		border : false,
        		lines : true,
        		textField : 'title',
        		groupField : 'sj1',
        		textFormatter : function (value, row) {
        			return '<span style="font-size:18px;color:#006633;padding:25px;">' + row.title + '</span>'
        			 + '<span style="float:right;color:#999">' + row.sj2 + '</span>';

        			// return '<a href="javascript:void(0)" class="datalist-link">' + value + '</a>';
        			//<span class="m-badge"  小红圆点
        		},
        		groupFormatter : function (value, row) {
        			return '<span style="font-size:19px;height:600px;color:#999;padding:15px;">' + value + '</span>'
        			 + '<span class="m-badge c1" style="float:right;margin:5px 10px">6</span>';
        			//console.log(value);
        		},
        		onClickRow : function (index, row) {
        			console.log(row);
        			$('#p2-title').html(row.title);
        			$('#p2-nr').html(row.note)
        			$('#p2-fb').html(row.create_date)

        			/* 					$.ajax({
        			url:'linklist_nr.php?id='+row.id,
        			success:function(data){
        			var data = eval('(' + data + ')');
        			$('#p2-nr').html(data.message)
        			$('#p2-fb').html(data.fb)
        			}
        			});
        			 */
        			$.mobile.go('#p2');
        		}
        	})

        	var themes = [{
        			value : 'default',
        			text : 'Default',
        			group : 'Base'
        		}, {
        			value : 'gray',
        			text : 'Gray',
        			group : 'Base'
        		}, {
        			value : 'metro',
        			text : 'Metro',
        			group : 'Base'
        		}, {
        			value : 'material',
        			text : 'Material',
        			group : 'Base'
        		}, {
        			value : 'bootstrap',
        			text : 'Bootstrap',
        			group : 'Base'
        		}, {
        			value : 'black',
        			text : 'Black',
        			group : 'Base'
        		}, {
        			value : 'metro-blue',
        			text : 'Metro Blue',
        			group : 'Metro'
        		}, {
        			value : 'metro-gray',
        			text : 'Metro Gray',
        			group : 'Metro'
        		}, {
        			value : 'metro-green',
        			text : 'Metro Green',
        			group : 'Metro'
        		}, {
        			value : 'metro-orange',
        			text : 'Metro Orange',
        			group : 'Metro'
        		}, {
        			value : 'metro-red',
        			text : 'Metro Red',
        			group : 'Metro'
        		}, {
        			value : 'ui-cupertino',
        			text : 'Cupertino',
        			group : 'UI'
        		}, {
        			value : 'ui-dark-hive',
        			text : 'Dark Hive',
        			group : 'UI'
        		}, {
        			value : 'ui-pepper-grinder',
        			text : 'Pepper Grinder',
        			group : 'UI'
        		}, {
        			value : 'ui-sunny',
        			text : 'Sunny',
        			group : 'UI'
        		}
        	];

        	$('#ith').combobox({
        		iconWidth : 18,
        		groupField : 'group',
        		data : themes,
        		editable : false,
        		panelHeight : 'auto',
        		onChange : function (newVal, oldVal) {
        			var oldHref = $('#uiTheme').attr('href');
        			var newHref = oldHref.substring(0, oldHref.indexOf('themes')) + 'themes/' + newVal + '/easyui.css';
        			//console.log(newHref);
        			$('#uiTheme').attr('href', newHref);
        			//设置cookie值，并设置7天有效时间
        			$.cookie('themeName', newVal, {
        				expires : 7
        			})
        		}
        	});
        })
    </script>
</body>    
</html>
