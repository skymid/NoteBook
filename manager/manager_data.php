 <?php
 include '../conn.php';
 
/* 	//include 'mysql.php';
    $servername="127.0.0.1"; //数据库服务器名称
    $username="root"; // 连接数据库用户名
    $password="jsdwzx.net"; // 连接数据库密码
    $dbname="middle"; // 数据库的名字
    
    // 连接到数据库
    $conn=mysql_connect($servername, $username,$password); */
                        
												

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	
	$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'pid';
	$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
	
	$mac = isset($_POST['name']) ? mysql_real_escape_string($_POST['name']) : '';
	$uname = isset($_POST['school']) ? mysql_real_escape_string($_POST['school']) : '';
	
	$q = isset($_POST['q']) ? $_POST['q'] : ''; 
	

	$rs = array();
	
	$where =" text like '%$q%' and CONCAT(`pid`,`seq`) like '%$mac%' and text like '%$uname%'";
	//$where =" fromUserName like '%$uname%'";

	$rs = mysql_query("select count(*) from note_menu where " . $where);
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	
	$strsql="select * from note_menu where " . $where . " order by $sort $order limit $offset,$rows";

    
    $rs=mysql_query($strsql);
	
	$rows = array();
	while($row = mysql_fetch_object($rs)){
		array_push($rows, $row);
	}
	$result["rows"] = $rows;
	$result["sql"] = $strsql;
	echo json_encode($result);
	
    
?>