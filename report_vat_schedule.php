<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VAT Schedule Details Report</title>
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



$txtdes = "VAT Schedule Report From : " . $_GET["repdatefrom"] . "    To: " . $_GET["repdateto"];





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
	
	
	echo "<b>".$txtdes."</b>";
	echo "<table width=\"1000\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
		
      	<tr>
        <th width=\"70\" height=\"23\">Date</th>
        <th width=\"200\">Ref.No</th>
        <th width=\"400\">VAT Barer</th>
       	<th width=\"150\">VATNO</th>
		<th width=\"100\">VAT Amount</th>
        </tr>";
		
		$L_AMOUNT=0;
		
				
		$sql_rsPrInv = "select * from view_paymas_ledger  where  l_CODE='" . trim($_GET["txtAccCode"]) . "' AND   BDATE >='" . $_GET["repdatefrom"] . "' and BDATE <='" . $_GET["repdateto"] . "' order by BDATE";
		$result_rsPrInv=mysql_query($sql_rsPrInv, $dbacc); 
	  	while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)){
		  
		  $vat_barer="";
		  $vat_no="";
		  if ($row_rsPrInv["VATNO"]!=""){
		    if ($row_rsPrInv["bea1"]!=""){
			 $vat_barer=$row_rsPrInv["bea1"]."</br>";
			} else {
			 $vat_barer=$row_rsPrInv["Barer"]."</br>";	
			} 
			 $vat_no=$row_rsPrInv["VATNO"]."</br>";
		  }
		  
		  if ($row_rsPrInv["vat1"]!=""){
			 $vat_barer.= $row_rsPrInv["v_barer1"]."</br>";
			 $vat_no .= $row_rsPrInv["vat1"]."</br>";
		  } 
		  
		  if ($row_rsPrInv["vat2"]!=""){
			 $vat_barer .= $row_rsPrInv["v_barer2"]."</br>";
			 $vat_no .= $row_rsPrInv["vat2"]."</br>";
		  } 
		  
		  if ($row_rsPrInv["vat3"]!=""){
			 $vat_barer .=$row_rsPrInv["v_barer3"]."</br>";
			 $vat_no .= $row_rsPrInv["vat3"];
		  } 
		   	 
					
			
			
			echo "<tr><td>".date("Y-m-d", strtotime($row_rsPrInv["BDATE"]))."</td>
				<td>".$row_rsPrInv["REFNO"]."</td>
				<td>".$vat_barer."</td>
				<td>".$vat_no."</td>";
							
				
				echo "<td align=right>".number_format($row_rsPrInv["L_AMOUNT"], 2, ".", ",")."</td>"; 
				
				echo "</tr>";
				
			
			$L_AMOUNT=$L_AMOUNT+$row_rsPrInv["L_AMOUNT"];
			
		}




        $sql_rsPrInv = "select * from view_bankent_ledger  where  l_CODE='" . trim($_GET["txtAccCode"]) . "' AND   BDATE >='" . $_GET["repdatefrom"] . "' and BDATE <='" . $_GET["repdateto"] . "' order by BDATE";
		$result_rsPrInv=mysql_query($sql_rsPrInv, $dbacc); 
	  	while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)){
		  
		  $vat_barer="";
		  $vat_no="";
		  if ($row_rsPrInv["vatno"]!=""){
		    if ($row_rsPrInv["bea1"]!=""){
			 $vat_barer=$row_rsPrInv["bea1"]."</br>";
			} else {
			 $vat_barer=$row_rsPrInv["heading"]."</br>";	
			} 
			 $vat_no=$row_rsPrInv["vatno"]."</br>";
		  }
		  
		   
		   	 
					
			
			
			echo "<tr><td>".date("Y-m-d", strtotime($row_rsPrInv["bdate"]))."</td>
				<td>".$row_rsPrInv["refno"]."</td>
				<td>".$vat_barer."</td>
				<td>".$vat_no."</td>";
							
				
				echo "<td align=right>".number_format($row_rsPrInv["l_amount"], 2, ".", ",")."</td>"; 
				
				echo "</tr>";
				
			
			$L_AMOUNT=$L_AMOUNT+$row_rsPrInv["l_amount"];
			
		}


		echo "<tr><td colspan=4>&nbsp;</td><td align=right><b>".number_format($L_AMOUNT, 2, ".", ",")."</b></td></tr>";
		
		
	
	
	
	  
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
