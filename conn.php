<?
Session_Start();
$conn = @mysql_connect('127.0.0.1','root','jsdwzx.net');
if (!$conn) {
	die('Could not connect: ' . mysql_error());
}
mysql_query("SET NAMES UTF8"); 
mysql_select_db('book', $conn);

	
	function getIP()
	{
/* 		global $ip;

		if (getenv("HTTP_CLIENT_IP"))
		$ip = getenv("HTTP_CLIENT_IP");
		else if(getenv("HTTP_X_FORWARDED_FOR"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if(getenv("REMOTE_ADDR"))
		$ip = getenv("REMOTE_ADDR");
		else
		$ip = "Unknow"; */

		return $_COOKIE["locat_ip"];;
	} 
	

	function getip_out(){ 
		$ip=false; 
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){ 
			$ip = $_SERVER["HTTP_CLIENT_IP"]; 
		} 
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
			//$ips教程 = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']); 
			if ($ip) { array_unshift($ips, $ip); $ip = FALSE; } 
			for ($i = 0; $i < count($ips); $i++) { 
				if (!eregi ("^(10│172.16│192.168).", $ips[$i])) { 
					$ip = $ips[$i]; 
					break; 
				} 
			} 
		} 
	return ($ip ? $ip : $_SERVER['REMOTE_ADDR']); 
} 	

?>