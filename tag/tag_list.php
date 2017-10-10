 <?php

                        
	include '../conn.php';						
	

	$rows = array();


	if($_GET['opt']=='add'){
		
		for($x=0;$x<count($_POST['data']);$x++) {			
		
			$strsql="select * from tag where id=".$_POST['data'][$x];    
			$rs=mysql_query($strsql);
			$row=mysql_fetch_array($rs);
			if(!$row){
				$rows['OK']="ok";
				$strsql2="INSERT INTO tag(text)values('".$_POST['data'][$x]."')";
				mysql_query($strsql2);
			}
		}
		$rows['result']=true;
		$rows['sql']=$strsql;
		
		//$rows['rs']=$row;			
	}else{
		
		$strsql="select * from tag ";    
		$rs=mysql_query($strsql);
		
		
		while($row = mysql_fetch_object($rs)){
			array_push($rows, $row);
		}
	
	}
	

	echo json_encode($rows);
	
	
		
    
?>