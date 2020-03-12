<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ledger Accounts Details</title>
<style>
body
{
font-size:14px;
}

</head>
</style>
<body>
<?php

include('connection.php');
date_default_timezone_set('Asia/Colombo'); 




?>

<table width="922" border="0">
  <tr>
    <td colspan="3" align="center"><span class="companyname"><?php 
		if ($_SESSION['company']=="EF"){
			echo "E-Friendly";
		}
		
		if ($_SESSION['company']=="BE"){
			echo "Benedicsons (Pvt) Ltd";
		}
		
		if ($_SESSION['company']=="TH"){
			echo "Tyre House Trading (Pvt) Ltd";
		}
	?>
	  </span></td>
  </tr>
 
  
  
  <tr>
    <td height="21">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
  <tr>
    <td height="199" colspan="3"><?php
	$DEB_amt=0;
	$CRE_amt=0;
	
	
	
	echo "<table width=\"1000\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
		
      	<tr>
        <th width=\"70\" colspan=3 >Ledger </th>
        <th width=\"300\">Ledger Name</th>
        <th width=\"100\">Type</th>
		<th width=\"100\">Category</th>
        <th width=\"100\">Group</th>
		<th width=\"100\">Parent Account</th>
		
        </tr>";
		
		
		
		$sql_rsPrInv = "select *  from lcodes order by c_code";
		$result_rsPrInv=mysql_query($sql_rsPrInv, $dbacc); 
	  	while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)){
		  $b=0;
		  $a="";
		  		if ($row_rsPrInv["c_group"]=="E"){
					$b=1;
					$a="E";
				} else if ($row_rsPrInv["c_group"]=="P"){
					$b=1;
					$a="P";
				} else if ($row_rsPrInv["c_group"]=="D"){
					$b=0;
					
				}
				
	
			 if ($b==1){
					if ($a=="E"){
						echo "<tr><td><b>".$row_rsPrInv["c_code"]."</b></td><td>&nbsp;</td><td>&nbsp;</td>";
					}
					if ($a=="P"){
						echo "<tr><td>&nbsp;</td><td><b>".$row_rsPrInv["c_code"]."</b></td><td>&nbsp;</td>";
					}
						
			 } else {
			 	echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>".$row_rsPrInv["c_code"]."</td>";
			 }
			 
			  if ($b==1){
					echo "<td><b>".$row_rsPrInv["c_name"]."</b></td>";
			 } else {
			 	echo "<td>".$row_rsPrInv["c_name"]."</td>";
			 }
				
			
				
				if ($row_rsPrInv["c_type"]=="M"){
				  if ($b==1){
					echo "<td><b>Manufacturing</b></td>";
				  } else {
				  	echo "<td>Manufacturing</td>";
				  }	
				} else if ($row_rsPrInv["c_type"]=="B"){
				  if ($b==1){
					echo "<td><b>Balance Sheet</b></td>";
				  } else {
				  	echo "<td>Balance Sheet</td>";
				  }	
				} else if ($row_rsPrInv["c_type"]=="P"){
				  if ($b==1){
					echo "<td><b>PNL Account</b></td>";
				  } else {
				  	echo "<td>PNL Account</td>";
				  }	
				} else {
					echo "<td>&nbsp;</td>";
				}
				
				if ($row_rsPrInv["cat"]=="B"){
					echo "<td>Bank</td>";
				} else if ($row_rsPrInv["cat"]=="C"){
					echo "<td>Cash</td>";
				} else {
					echo "<td>&nbsp;</td>";
				}
				
				if ($row_rsPrInv["c_group"]=="E"){
					echo "<td><b>Elder</b></td>";
				} else if ($row_rsPrInv["c_group"]=="P"){
					echo "<td><b>Parent</b></td>";
				} else if ($row_rsPrInv["c_group"]=="D"){
					echo "<td>Detail</td>";
				} else {
					echo "<td>&nbsp;</td>";
				}
					
				
				echo "<td>".$row_rsPrInv["paccno"]."</td>";
			
			
				echo "</tr>";
				
					
			
			
		}
		
		
		
	
	
	
	  
	   ?>  
</table>
</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
