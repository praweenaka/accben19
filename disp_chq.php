<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cheque Display</title>
</head>


<body>

<style type="text/css">
<!--




</style>



<?php
if ($_GET["chkprint"]==1){
	include('connection.php');
	
	//$ResponseXML = "";
	//$ResponseXML .= "<salesdetails>";
	
	$txt_bea=str_replace("~", "&", $_GET['txt_bea']);
	
	$sql_rspaymas="select * from cheque_setup where bank_code='" . trim($_GET["com_cas"]) . "'";
	$result_rspaymas=mysql_query($sql_rspaymas, $dbacc);
	while($row_rspaymas = mysql_fetch_array($result_rspaymas)){
		echo "<style type=\"text/css\">

.cl".$row_rspaymas["id"]." {
	font-size: ".$row_rspaymas["font_size"]."px;
	left:".$row_rspaymas["left_loc"]."px;
	top:".$row_rspaymas["top_loc"]."px;
	font-family:".$row_rspaymas["font_name"].";
	position:absolute;
}
</style>";
	
	$name="cl".$row_rspaymas["id"];
	
		if ($row_rspaymas["id"]=="1"){
			echo "<div  id=\"".$row_rspaymas["font_name"]."\" class=\"".$name."\" />".substr($_GET["chqdate"], 2, 1)."</div>";
		}
		
		if ($row_rspaymas["id"]=="2"){
			echo "<div  id=\"".$row_rspaymas["font_name"]."\" class=\"".$name."\" />".substr($_GET["chqdate"], 3, 1)."</div>";
		}	
		
		if ($row_rspaymas["id"]=="3"){
			echo "<div  id=\"".$row_rspaymas["font_name"]."\" class=\"".$name."\" />".substr($_GET["chqdate"], 5, 1)."</div>";
		}
		
		if ($row_rspaymas["id"]=="4"){
			echo "<div  id=\"".$row_rspaymas["font_name"]."\" class=\"".$name."\" />".substr($_GET["chqdate"], 6, 1)."</div>";
		}	
		
		if ($row_rspaymas["id"]=="5"){
			echo "<div  id=\"".$row_rspaymas["font_name"]."\" class=\"".$name."\" />".substr($_GET["chqdate"], 8, 1)."</div>";
		}
		
		if ($row_rspaymas["id"]=="6"){
			echo "<div  id=\"".$row_rspaymas["font_name"]."\" class=\"".$name."\" />".substr($_GET["chqdate"], 9, 1)."</div>";
		}	
		
		if ($row_rspaymas["id"]=="7"){
	
			
			if ($_GET["Check1"]=="true"){
				echo "<div  id=\"".$row_rspaymas["font_name"]."\" class=\"".$name."\" />A/C Payee Only</div>";
			}	
		}	
		
		if ($row_rspaymas["id"]=="9"){
			echo "<div  id=\"".$row_rspaymas["font_name"]."\" class=\"".$name."\" />".$txt_bea."</div>";
		}
		
		if ($row_rspaymas["id"]=="10"){
			echo "<div  id=\"".$row_rspaymas["font_name"]."\" class=\"".$name."\" />". wordwrap($_GET["txt_amoinword"], 60,"<br>\n<br>\n") ."</div>";
		}
		
		if ($row_rspaymas["id"]=="12"){
			echo "<div  id=\"".$row_rspaymas["font_name"]."\" class=\"".$name."\" />".number_format($_GET["TXT_DEBTOT"], 2, ".", ",")."</div>";
		}	
	}
} 
 ?>   

</body>
</html>
