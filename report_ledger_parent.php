<?php session_start(); 
?>
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

a:link, a:visited {
	
	text-decoration: none;
	color:#000000;
}

a:hover {
	text-decoration: underline;
}

</style>
</head>
<body>
<?php

include('connection.php');
date_default_timezone_set('Asia/Colombo'); 

	$sql="delete from ledprint_parent ";
	$result=mysql_query($sql, $dbacc);
	


$OpDbAmu = 0;
$OpCrAmu = 0;

	
$txtAccCode=$_GET["txtAccCode"];

if ($_SESSION['User_Type'] == "1") {
  
   $sql_rs="sELECT  l_amount, l_code, l_refno, l_flag1 from ledger where l_flag = 'OPB' and l_code like '$txtAccCode%' and l_yearfl = '2' ";
  // echo $sql_rs."</br>";
	$result_rs=mysql_query($sql_rs, $dbacc);
 	while ($row_rs = mysql_fetch_array($result_rs)){
      if ($row_rs["l_flag1"] == "CRE") {
         $OpCrAmu = $OpCrAmu + $row_rs["l_amount"];
      } else {
         $OpDbAmu = $OpDbAmu + $row_rs["l_amount"];
      }
   }
} else {
	$sql_rs="sELECT  l_amount, l_code, l_refno, l_flag1 from ledger where l_flag = 'OPB' and l_code like '$txtAccCode%' and l_yearfl = '0' ";
	//echo $sql_rs."</br>";
	$result_rs=mysql_query($sql_rs, $dbacc);
 	while ($row_rs = mysql_fetch_array($result_rs)){
	
      if ($row_rs["l_flag1"]== "CRE") {
         $OpCrAmu = $OpCrAmu + $row_rs["l_amount"];
      } else {
         $OpDbAmu = $OpDbAmu + $row_rs["l_amount"];
      }
   }
}

$sql_opCR="select sum(l_amount) as ctot from ledger where l_flag != 'OPB' and l_yearfl != '2' and  l_yearfl != '1'  AND l_flag1='CRE' and l_code like '$txtAccCode%' and (l_date<'" . $_GET["repdatefrom"].  "'  )";
//echo $sql_opCR."</br>";
$result_opCR=mysql_query($sql_opCR, $dbacc);
while ($row_opCR = mysql_fetch_array($result_opCR)){
	$OpCrAmu = $OpCrAmu + $row_opCR["ctot"];
}

$sql_opDb="select sum(l_amount) as dtot from ledger where  l_flag != 'OPB' and l_yearfl != '2' and  l_yearfl != '1' AND l_flag1='DEB' and l_code like '$txtAccCode%'  and (l_date<'" . $_GET["repdatefrom"].  "' ) ";
//echo $sql_opDb."</br>";
$result_opDb=mysql_query($sql_opDb, $dbacc);
while ($row_opDb = mysql_fetch_array($result_opDb)){
	$OpDbAmu = $OpDbAmu + $row_opDb["dtot"];
}


$bF = $OpBalAm + $OpDbAmu - $OpCrAmu + $OpLnkAmt;

if ($bF > 0) {
   $bfFlag = "DEB";
} else {
   $bfFlag = "CRE";
}

$sql="insert into ledprint_parent (l_code, l_name, flag, amount) values('B/F', 'Opening Balance ','" . $bfFlag . "', " . abs($bF) . ")";
$result=mysql_query($sql, $dbacc);


$sql_lcode="select * from lcodes where c_code like '$txtAccCode%'  order by c_code";
//$sql_lcode="select * from lcodes where paccno = '".$txtAccCode."' order by c_code"; 
//echo $sql_lcode."</br>";
$result_lcode=mysql_query($sql_lcode, $dbacc);
while ($row_lcode = mysql_fetch_array($result_lcode)){

 		
	$Flag="";
	
	if ($row_lcode["c_group"]=="D"){
	
		$sql_rst="select sum(l_amount) as sum_amt from ledger where l_flag != 'OPB' and  l_yearfl != '2' and   l_yearfl != '1' and l_code='" . $row_lcode["c_code"] . "' and ( l_date >'" . $_GET["repdatefrom"]. "' or l_date ='" . $_GET["repdatefrom"]."') and  ( l_date < '" . $_GET["repdateto"] . "' or l_date ='" . $_GET["repdateto"] . "') and l_flag1='DEB'";
		
	} else {
		
		$c_code=$row_lcode["c_code"];
		
		$sql_rst="select sum(l_amount) as sum_amt from ledger where l_flag != 'OPB' and  l_yearfl != '2' and   l_yearfl != '1' and l_code like '$c_code%' and ( l_date >'" . $_GET["repdatefrom"]. "' or l_date ='" . $_GET["repdatefrom"]."') and  ( l_date < '" . $_GET["repdateto"] . "' or l_date ='" . $_GET["repdateto"] . "') and l_flag1='DEB'";
		
	}	
	//echo $sql_rst;
//echo $sql_rst."</br>";
	$result_rst=mysql_query($sql_rst, $dbacc);
	$row_rst = mysql_fetch_array($result_rst);
    
	$deb_tot=$row_rst["sum_amt"];
	//echo $deb_tot;
	
	if ($row_lcode["c_group"]=="D"){
		
		$sql_rst="select sum(l_amount) as sum_amt from ledger where l_flag != 'OPB' and  l_yearfl != '2' and   l_yearfl != '1' and l_code='" . $row_lcode["c_code"] . "' and ( l_date >'" . $_GET["repdatefrom"]. "' or l_date ='" . $_GET["repdatefrom"]."') and  ( l_date < '" . $_GET["repdateto"] . "' or l_date ='" . $_GET["repdateto"] . "') and l_flag1='CRE'";
	
	} else {
		
		$c_code=$row_lcode["c_code"];
		
		$sql_rst="select sum(l_amount) as sum_amt from ledger where l_flag != 'OPB' and  l_yearfl != '2' and   l_yearfl != '1' and l_code like '$c_code%' and ( l_date >'" . $_GET["repdatefrom"]. "' or l_date ='" . $_GET["repdatefrom"]."') and  ( l_date < '" . $_GET["repdateto"] . "' or l_date ='" . $_GET["repdateto"] . "') and l_flag1='CRE'";
	
	}	
	//echo $sql_rst;
//echo $sql_rst."</br>";
	$result_rst=mysql_query($sql_rst, $dbacc);
	$row_rst = mysql_fetch_array($result_rst);
    
	$cre_tot=$row_rst["sum_amt"];
	
	//echo "/".$cre_tot;
	$tot=$deb_tot-$cre_tot;
	
	if ($tot > 0) {
   		$Flag = "DEB";
	} else {
   		$Flag = "CRE";
	}
	
		$sql="insert into ledprint_parent (l_code, l_name, flag, amount, paccno) values('" . $row_lcode["c_code"] . "', '" . trim($row_lcode["c_name"]) . "', '".$Flag."', " . $tot . ", '".$row_lcode["paccno"]."')";
		$result=mysql_query($sql, $dbacc);
		
		
  
}




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
	
	
	echo "<b>Account : </b> ".$_GET["txtAccCode"]." - ".$_GET["txtAccName"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Date From </b> ".$_GET["repdatefrom"]." <b>To</b> ".$_GET["repdateto"];
	echo "<table width=\"1000\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
		
      	<tr>
        <th width=\"70\" height=\"23\">Code</th>
        <th width=\"200\">Name</th>
        <th width=\"100\">Debit</th>
		<th width=\"100\">Credit</th>
		<th width=\"100\">Balance</th>
        </tr>";
		
		$debamt=0;
		$creamt=0;
		$baltot=0;
		
		$totdebamt=0;
		$totcreamt=0;
		$refno="";
		
		$mst=0;
	
	$sql_rsPrInv2 = "select *  from ledprint_parent where l_code = 'B/F'";
		//echo $sql_rsPrInv1;
	$result_rsPrInv2=mysql_query($sql_rsPrInv2, $dbacc); 
	$row_rsPrInv2 = mysql_fetch_array($result_rsPrInv2);
	
			if ($row_rsPrInv2["amount"]>=0){
				$debamt=abs($row_rsPrInv2["amount"]);
			}
			
			if ($row_rsPrInv2["amount"]<0){
				$creamt=abs($row_rsPrInv2["amount"]);
			}
			
			
			$bal=$debamt-$creamt;
			$baltot = $baltot + $bal;
			
			$totdebamt=$totdebamt+$debamt;
			$totcreamt=$totcreamt+$creamt;
			
	echo "<tr><td>B/F</td>
				<td>Opening Balance </td>";
				
			
				echo "<td align=right>".number_format($debamt, 2, ".", ",")."</td>"; 
			
				echo "<td align=right>".number_format($creamt, 2, ".", ",")."</td>"; 
				echo "<td align=right>".number_format($baltot, 2, ".", ",")."</td>";
				echo "</tr>";
				
						
	$sql_lcode="select * from lcodes where paccno = '".$txtAccCode."' order by c_code";
	//echo $sql_lcode;
	$result_lcode=mysql_query($sql_lcode, $dbacc); 
	while ($row_lcode = mysql_fetch_array($result_lcode)){
		
		$debamt=0;
		$creamt=0;
		
		
		$l_code=$row_lcode["c_code"];
		
	//	if ($row_lcode["c_group"]=="D"){
			$sql_rsPrInv = "select sum(amount) as amt  from ledprint_parent where l_code = '".$l_code."'";
	//	} else {
	//		$sql_rsPrInv = "select sum(amount) as amt  from ledprint_parent where l_code like '$l_code%'";
	//	}	
		//echo $sql_rsPrInv;
		$result_rsPrInv=mysql_query($sql_rsPrInv, $dbacc); 
	  	$row_rsPrInv = mysql_fetch_array($result_rsPrInv);
		
		$sql_rsPrInv1 = "select *  from ledprint_parent where l_code = '".$l_code."'";
		//echo $sql_rsPrInv1;
		$result_rsPrInv1=mysql_query($sql_rsPrInv1, $dbacc); 
	  	if ($row_rsPrInv1 = mysql_fetch_array($result_rsPrInv1)){
		
			/*if ($row_rsPrInv["flag"]=="DEB") {
				$debamt=abs($row_rsPrInv["amount"]);
			} else {
				$debamt=0;
			}
			
			if ($row_rsPrInv["flag"]=="CRE") {
				$creamt=abs($row_rsPrInv["amount"]);
			} else {
				$creamt=0;
			}*/
			
			if ($row_rsPrInv["amt"]>=0){
				$debamt=abs($row_rsPrInv["amt"]);
			}
			
			if ($row_rsPrInv["amt"]<0){
				$creamt=abs($row_rsPrInv["amt"]);
			}
			
			
			$bal=$debamt-$creamt;
			$baltot = $baltot + $bal;
			
			
				
		if ($row_lcode["c_group"]=="D"){		
			$url="report_ledger_link.php?txtAccCode=".$l_code."&txtAccName=".$row_lcode["c_name"]."&repdatefrom=".$_GET["repdatefrom"]."&repdateto=".$_GET["repdateto"];
		} else {
			$url="report_ledger_parent.php?txtAccCode=".$l_code."&txtAccName=".$row_lcode["c_name"]."&repdatefrom=".$_GET["repdatefrom"]."&repdateto=".$_GET["repdateto"];
		}
			
			echo "<tr><td><a target=\"_blank\" href=\"".$url."\">".$l_code."</a></td>
				<td><a target=\"_blank\" href=\"".$url."\">".$row_lcode["c_name"]."</a></td>";
				
			
				echo "<td align=right><a target=\"_blank\" href=\"".$url."\">".number_format($debamt, 2, ".", ",")."</a></td>"; 
			
				echo "<td align=right><a target=\"_blank\" href=\"".$url."\">".number_format($creamt, 2, ".", ",")."</a></td>"; 
				
				if ($baltot>0){
					echo "<td align=right><a target=\"_blank\" href=\"".$url."\">".number_format($baltot, 2, ".", ",")."</a></td>";
				} else {
					echo "<td align=right><a target=\"_blank\" href=\"".$url."\">(".number_format((-1*$baltot), 2, ".", ",").")</a></td>";
				}	
				echo "</tr>";
				
			
			$totdebamt=$totdebamt+$debamt;
			$totcreamt=$totcreamt+$creamt;
			
		} else {
			
			$nullamt=0;
			echo "<tr><td>".$l_code."</td>
				<td>".$row_lcode["c_name"]."</td>";
				
			
				echo "<td align=right>".number_format($nullamt, 2, ".", ",")."</td>"; 
			
				echo "<td align=right>".number_format($nullamt, 2, ".", ",")."</td>"; 
				echo "<td align=right>".number_format($nullamt, 2, ".", ",")."</td>";
				echo "</tr>";
				
		}	
			
			
	}
		echo "<tr><td colspan=2>&nbsp;</td><td align=right><b>".number_format($totdebamt, 2, ".", ",")."</b></td><td align=right><b>".number_format($totcreamt, 2, ".", ",")."</b></td>";
		
		if ($baltot>0){
			echo "<td align=right><b>".number_format($baltot, 2, ".", ",")."</b></td></tr>";
		} else {
			echo "<td align=right><b>(".number_format((-1*$baltot), 2, ".", ",").")</b></td></tr>";
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
