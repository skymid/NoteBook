<?
session_start();
//echo $_SESSION['username'];
if($_SESSION['username']==""){

		echo "<script language='javascript'>";
		echo "location.href='login.php'";
		echo "</script>";
}
?>