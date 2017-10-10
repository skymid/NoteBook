<?php
Session_Start();
$conn = @mysql_connect('127.0.0.1','root','jsdwzx.net');
if (!$conn) {
	die('Could not connect: ' . mysql_error());
}
mysql_query("SET NAMES UTF8"); 
mysql_select_db('book', $conn);

$strsql="select * from notebook where id=".$_GET['id'];    
$rs=mysql_query($strsql);	
$row = mysql_fetch_object($rs);
	
	
require_once('../tcpdf/tcpdf.php'); 
//实例化 
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false); 
 
// 设置文档信息 
$pdf->SetCreator('skymid'); 
$pdf->SetAuthor('skymid'); 
$pdf->SetTitle($row->title); 
$pdf->SetSubject($row->sj); 
$pdf->SetKeywords($row->tag); 
 
// 设置页眉和页脚信息 
$pdf->SetHeaderData('logo.png', 10, $row->title, $row->sj, array(0,64,255), array(0,64,128)); 
$pdf->setFooterData(array(0,64,0), array(0,64,128)); 
 
// 设置页眉和页脚字体 
$pdf->setHeaderFont(Array('stsongstdlight', '', '10')); 
$pdf->setFooterFont(Array('helvetica', '', '8')); 
 
// 设置默认等宽字体 
$pdf->SetDefaultMonospacedFont('courier'); 
 
// 设置间距 
$pdf->SetMargins(15, 27, 15); 
$pdf->SetHeaderMargin(5); 
$pdf->SetFooterMargin(10); 
 
// 设置分页 
$pdf->SetAutoPageBreak(TRUE, 25); 
 
// set image scale factor 
$pdf->setImageScale(1.25); 
 
// set default font subsetting mode 
$pdf->setFontSubsetting(true); 
 
//设置字体 
$pdf->SetFont('stsongstdlight', '', 12); 
 
$pdf->AddPage(); 
 
$str1 = $row->nr; 
$pdf->writeHTML($str1);

//$pdf->Write(0,$str1,'', 0, 'L', true, 0, false, false, 0); 
 
//输出PDF 
$pdf->Output('t.pdf', 'I');   
//I，默认值，在浏览器中打开；D，点击下载按钮， PDF文件会被下载下来；F，文件会被保存在服务器中；S，PDF会以字符串形式输出；E：PDF以邮件的附件输出
?>