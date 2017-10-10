<?
Session_Start();
$conn = @mysql_connect('192.168.0.102','root','123456');

if (!$conn) {
	die('Could not connect: ' . mysql_error());
}
mysql_query("SET NAMES UTF8"); 
mysql_select_db('book', $conn);


?>