<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jounal/Transactions/Deposits/Cheque Pay Report</title>
<style>
body
{
font-size:14px;
}

</head>
</style>
<body>
<?php


date_default_timezone_set('Asia/Colombo'); 


if ($_GET["op_bankwise"] == "true") { bankwise(); }
if ($_GET["opdatewise"] == "true") { datewise(); }


//$txtdes = "VAT Schedule Report From : " . $_GET["repdatefrom"] . "    To: " . $_GET["repdateto"];

function bankwise(){

include('connection.php');
$table ="";
$table .= "<table width=\"922\" border=\"0\">
  <tr>
    <td colspan=\"3\" align=\"center\"><span class=\"companyname\">"; 
		if ($_SESSION['company']=="EF"){
			$table .= "E-Friendly";
		}
		
		if ($_SESSION['company']=="BE"){
			$table .= "Benedicsons (Pvt) Ltd";
		}
		
		if ($_SESSION['company']=="TH"){
			$table .= "Tyre House Trading (Pvt) Ltd";
		}
	
	$table .= "  </span></td>
  </tr>
 
  
  
  <tr>
    <td height=\"21\">Cheque Report (Bank Wise) Date From - ".$_GET["repdatefrom"]." To - ".$_GET["repdateto"]."</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
  <tr>
    <td height=\"199\" colspan=\"3\">";
	
	$DEB_amt=0;
	$CRE_amt=0;
	
	
	$table .= "<b>".$txtdes."</b>";
	$table .= "<table width=\"1000\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
		
      	<tr>
        <th width=\"70\" height=\"23\">Date</th>
        <th width=\"70\">Cheque No</th>
       	<th width=\"350\">Naration</th>
		<th width=\"100\">Amount</th>
        </tr>";
		
		$L_AMOUNT=0;
		$i=0;
		
		$sql_rsPrInv = "select * from view_paymas_lcoes where cancel='0' and code != '' and  bdate >='" . $_GET["repdatefrom"] . "' and bdate <='" . $_GET["repdateto"] . "' order by code, bdate ";
				
		//$table .= $sql_rsPrInv;
		$result_rsPrInv=mysql_query($sql_rsPrInv, $dbacc); 
	  	while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)){
		  
		 if ($row_rsPrInv["code"]!=$code){
		 	if ($i==1){	
				$table .= "<tr><td   colspan=3></td><td align=right><b>".number_format($L_AMOUNT_bank, 2, ".", ",")."</b></td></tr>";
			}
			
		 	$table .= "<tr><td  colspan=4><b>".$row_rsPrInv["code"]." - ".$row_rsPrInv["name"]."</b></td></tr>";
				
				
				$code=$row_rsPrInv["code"];
				$L_AMOUNT_bank=0;
				$i=1;
		 }
		 
			$table .= "<tr><td>".date("Y-m-d", strtotime($row_rsPrInv["bdate"]))."</td>
				<td>".$row_rsPrInv["cheno"]."</td>
				<td>".$row_rsPrInv["naration"]."</td>";
				
				$table .= "<td align=right>".number_format($row_rsPrInv["amount"], 2, ".", ",")."</td>"; 
				
				$table .= "</tr>";
				
			
			$L_AMOUNT=$L_AMOUNT+$row_rsPrInv["amount"];
			$L_AMOUNT_bank=$L_AMOUNT_bank+$row_rsPrInv["amount"];
			
			
			
			
		}
		$table .= "<tr><td colspan=3>&nbsp;</td><td align=right><b>".number_format($L_AMOUNT, 2, ".", ",")."</b></td></tr>";
		
		
	
	
	
	  
	   
$table .= "</table>
</td>
  </tr>
 
</table>";

echo $table;
$file="report/rpt_chq_datewise.xls";
   
    $f = fopen($file, "w+");
  
    fwrite($f,$table);
  
	echo "<a href=\"report/rpt_chq_datewise.xls\">Download Excel Report</a>";
}



function datewise(){

include('connection.php');
$table ="";
$table .= "<table width=\"922\" border=\"0\">
  <tr>
    <td colspan=\"3\" align=\"center\"><span class=\"companyname\">"; 
		if ($_SESSION['company']=="EF"){
			$table .= "E-Friendly";
		}
		
		if ($_SESSION['company']=="BE"){
			$table .= "Benedicsons (Pvt) Ltd";
		}
		
		if ($_SESSION['company']=="TH"){
			$table .= "Tyre House Trading (Pvt) Ltd";
		}
	
	$table .= "  </span></td>
  </tr>
 
  
  
  <tr>
    <td height=\"21\">Cheque Report Date From - ".$_GET["repdatefrom"]." To - ".$_GET["repdateto"]."</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
  <tr>
    <td height=\"199\" colspan=\"3\">";
	
	$DEB_amt=0;
	$CRE_amt=0;
	
	
	$table .= "<b>".$txtdes."</b>";
	$table .= "<table width=\"1000\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
		
      	<tr>
        <th width=\"70\" height=\"23\">Date</th>
        <th width=\"70\">Cheque No</th>
        <th width=\"200\">Bank</th>
       	<th width=\"350\">Naration</th>
		<th width=\"100\">Amount</th>
        </tr>";
		
		$L_AMOUNT=0;
		
		$sql_rsPrInv = "select * from view_paymas_lcoes  where cancel='0' and code != '' and  bdate >='" . $_GET["repdatefrom"] . "' and bdate <='" . $_GET["repdateto"] . "' order by bdate ";
		
		//$table .= $sql_rsPrInv;
		$result_rsPrInv=mysql_query($sql_rsPrInv, $dbacc); 
	  	while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)){
		  
		 
			$table .= "<tr><td>".date("Y-m-d", strtotime($row_rsPrInv["bdate"]))."</td>
				<td>".$row_rsPrInv["cheno"]."</td>
				<td>".$row_rsPrInv["name"]." - ".$row_rsPrInv["code"]."</td>
				<td>".$row_rsPrInv["naration"]."</td>";
							
				
				$table .= "<td align=right>".number_format($row_rsPrInv["amount"], 2, ".", ",")."</td>"; 
				
				$table .= "</tr>";
				
			
			$L_AMOUNT=$L_AMOUNT+$row_rsPrInv["amount"];
			
			
			
			
		}
		$table .= "<tr><td colspan=4>&nbsp;</td><td align=right><b>".number_format($L_AMOUNT, 2, ".", ",")."</b></td></tr>";
		
		
	
	
	
	  
	   
$table .= "</table>
</td>
  </tr>
 
</table>";

echo $table;
$file="report/rpt_chq_datewise.xls";
   
    $f = fopen($file, "w+");
  
    fwrite($f,$table);
  
	echo "<a href=\"report/rpt_chq_datewise.xls\">Download Excel Report</a>";
}



?>
</body>
</html>
