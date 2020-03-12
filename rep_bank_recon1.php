<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Bank Reconsilation</title>
<style type="text/css">
<!--
.companyname {
	color: #0000FF;
	font-weight: bold;
	font-size: 24px;
}

.com_address {
	color: #000000;
	font-weight: bold;
	font-size: 18px;
}

.heading {
	color: #000000;
	font-weight: bold;
	font-size: 16px;
}

body {
	color: #000000;
	font-size: 14px;
}


-->
</style>
</head>

<body><center>
<?php 
include('connection.php');

$sql_rs="select sum(l_amount) as mcre  from ledger where rights='0' and  l_flag1 ='CRE' and (l_flag != 'opb') and l_code='" . trim($_GET["txtBankCode"]) . "'   and l_flag2 = '0'  and l_date <= '" . $_GET["dtpDate"] . "'";
$result_rs=mysql_query($sql_rs, $dbacc);
if ($row_rs = mysql_fetch_array($result_rs)){
	if (is_null($row_rs["mcre"])==false) { $mCre = $row_rs["mcre"]; }
}

$sql_rs="select sum(l_amount) as mcre  from ledger where rights='0' and  l_flag1 !='CRE' and (l_flag != 'opb') and l_code='" . trim($_GET["txtBankCode"]) . "'   and l_flag2 = '0'  and l_date <= '" . $_GET["dtpDate"] . "' ";
$result_rs=mysql_query($sql_rs, $dbacc);
if ($row_rs = mysql_fetch_array($result_rs)){
	if (is_null($row_rs["mcre"])==false) { $mDeb = $row_rs["mcre"]; }
}








$txthead= "BANK RECONCILIATION AS AT " . date("Y-m-d", strtotime($_GET["dtpDate"]));

$sql_rscompany="Select * from dep_mas";
$result_rscompany=mysql_query($sql_rscompany, $dbacc);
$row_rscompany = mysql_fetch_array($result_rscompany);

$txtcom = $row_rscompany["description"];
$txtBank= $_GET["txtBankCode"];

$txtBankBal=str_replace(",", "", $_GET["txtBankClosBal"]);
$txtBankBal_org=str_replace(",", "", $_GET["txtBankClosBal"]);

if ($txtBankBal < 0) {
   $txtBankBal= "(" . number_format(abs($txtBankBal), 2, ".", ",") . ")";
} else {
   $txtBankBal= number_format($txtBankBal, 2, ".", ",");
}


$mTot = $_GET["txtBankClosBal"] + $mDeb - $mCre;
if ($mTot < 0) {
   $txtbalChbook="(" . abs($mTot) . ")";
} else {
   $txtbalChbook=$mTot;
}

$txtbot= "Balance as per Cash Book as at " . date("Y-m-d", $_GET["dtpDate"]);

$sql_rsBANKMASTER="select * from bankmaster where  bm_code='" . trim($_GET["txtBankCode"]) . "'";
$result_rsBANKMASTER=mysql_query($sql_rsBANKMASTER, $dbacc);
if ($row_rsBANKMASTER = mysql_fetch_array($result_rsBANKMASTER)){
   $txtBank= " : " . $row_rsBANKMASTER["bm_code"] . ", " . $row_rsBANKMASTER["bm_bank"];
   $txtbrnach= " : " . $row_rsBANKMASTER["bm_branch"];
   $txtaccno= " : " . trim($row_rsBANKMASTER["bm_accno"]);
}

$txtopdate= date("Y-m-d", strtotime($_GET["dtfrom"]));
$txt_bankbal=str_replace(",", "", $_GET["txt_bankbal"]);



if ($_GET["txt_bankbal"] < 0) {
   $txtopbal= "(" . number_format(abs($txt_bankbal), 2, ".", ",") . ")";
} else {
   $txtopbal= number_format($txt_bankbal, 2, ".", ",");
}

$txt_bankbal2=str_replace(",", "", $_GET["txt_bankbal2"]);
if ($_GET["txt_bankbal2"] < 0) {
   $txtopbal2= "(" . number_format(abs($txt_bankbal2), 2, ".", ",") . ")";
} else {
   $txtopbal2= number_format($txt_bankbal2, 2, ".", ",");
}

if ($_GET["txtbankpay"] < 0) {
   $txtless= "(" . number_format(abs($_GET["txtbankpay"]), 2, ".", ",") . ")";
} else {
   $txtless= $_GET["txtbankpay"];
}
if ($_GET["txtbankdepo"] < 0) {
   $txtadd= "(" . number_format(abs($_GET["txtbankdepo"]), 2, ".", ",") . ")";
} else {
   $txtadd= $_GET["txtbankdepo"];
}

$txtclosebal=str_replace(",", "", $_GET["txtclosebal"]);
if ($txtclosebal <= 0) {
	
   $txtclosebal= "(" . number_format(abs($txtclosebal), 2, ".", ",") . ")";
} else {
   $txtclosebal= "" . number_format(abs($txtclosebal), 2, ".", ",") . "";
}

$txtclosebal2=str_replace(",", "", $_GET["txtclosebal2"]);
if ($txtclosebal <= 0) {
	
   $txtclosebal2= "(" . number_format(abs($txtclosebal2), 2, ".", ",") . ")";
} else {
   $txtclosebal2= "" . number_format(abs($txtclosebal2), 2, ".", ",") . "";
}

$txtclosedate= date("Y-m-d", $_GET["dtpDate"]);
	?>
    
<table width="922" height="912" border="0">
  <tr>
    <td height="44" colspan="4" align="center"><span class="companyname">
    <?php
    if ($_SESSION['company']=="TH"){
		echo "Tyre House Trading (Pvt) Ltd.";
	}
	
	if ($_SESSION['company']=="BE"){
		echo "Benedicsons (Pvt) Ltd.";
	}
	
	if ($_SESSION['company']=="EF"){
		echo "E-Friendly.";
	}
	?>
     </span></td>
  </tr>
  <tr>
    <td width="208"><span class="heading">BANK</span></td>
    <td width="358"><span class="heading"><?php echo $txtBank; ?></span></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td><span class="heading">BRANCH</span></td>
    <td><span class="heading"><?php echo $txtbrnach; ?></span></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td><span class="heading">ACCOUNT NO</span></td>
    <td><span class="heading"><?php echo $txtaccno; ?></span></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="208" align="center">    </td>
    <td align="center"></td>
  </tr>
  <tr>
    <td width="208" height="21" colspan="4"><span class="heading"><?php echo $txthead; ?></span></td>
  </tr>
  <tr>
    <td height="34" colspan="2" valign="bottom"><span class="heading">BALANCE AS PER BANK STATEMENT</span></td>
    <td height="34" valign="bottom">&nbsp;</td>
    <td height="34" valign="bottom" align="right"><span class="heading"><?php echo $txtBankBal; ?></span> </td>
  </tr>
  
  <tr>
    <td height="21" colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
  <tr>
    <td height="199" colspan="4"><?php
	$DEB_amt=0;
	$CRE_amt=0;
	
	
	
	echo "<table width=\"904\" height=\"81\" border=\"0\" cellspacing=\"0\">
		<tr >
        <th colspan=4 align=left>Add: Un-Realised Cheques</th>
		</tr>
      	<tr  bgcolor=\"#999999\">
        <th width=\"70\" height=\"23\">Date</th>
        <th width=\"100\">Chq. No</th>
        <th width=\"445\">Description</th>
        <th width=\"100\" >Amount</th>
        </tr>";
	
		$sql_rsPrInv="Select * from op_cheq where (recdate='0' )  and flag='DEB'  and code='" . trim($_GET["txtBankCode"]) . "' order by sdate";
		//echo $sql_rsPrInv;
		$result_rsPrInv=mysql_query($sql_rsPrInv, $dbacc);
	  	while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)){
			echo "<tr><td>".date("Y-m-d", strtotime($row_rsPrInv["sdate"]))."</td>
			<td>".$row_rsPrInv["chno"]."</td>
			<td>&nbsp;</td>
			<td align=right>".number_format($row_rsPrInv["amount"], 2, ".", ",")."</td>
			</tr>";
			
			$DEB_amt=$DEB_amt+$row_rsPrInv["amount"];
		
		}
		echo "<tr><td colspan=3>&nbsp;</td>
			<td align=right><b>".number_format($DEB_amt, 2, ".", ",")."</b></td>
			</tr>";
			
			
		
	$sql_rsPrInv="select * from ledger where  (l_flag != 'opb') and l_code='" . trim($_GET["txtBankCode"]) . "'   and l_flag2 = '0'  and l_date <= '" . $_GET["dtpDate"] . "' and l_flag1='DEB' order by l_flag1 desc, l_date ";
	$result_rsPrInv=mysql_query($sql_rsPrInv, $dbacc);
	  	while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)){
			echo "<tr><td>".$row_rsPrInv["l_date"]."</td>
			<td>".$row_rsPrInv["chno"]."</td>";
			
			$sql_rspaymas="select heading from bankdepmas where refno='" . $row_rsPrInv["l_refno"] . "'";
		   //echo $sql_rspaymas;
	       $result_rspaymas=mysql_query($sql_rspaymas, $dbacc);
	       if ($row_rspaymas = mysql_fetch_array($result_rspaymas)){
		   			 
			 // $ResponseXML .=  " <td>".$row_rspaymas["barer"]."</td>";
			  $descrip=$row_rspaymas["heading"];
		   } 
		   
		   $sql_rspaymas="select heading from bankentmas where refno='" . $row_rsPrInv["l_refno"] . "'";
		   //echo $sql_rspaymas;
	       $result_rspaymas=mysql_query($sql_rspaymas, $dbacc);
	       if ($row_rspaymas = mysql_fetch_array($result_rspaymas)){
		   			 
			 // $ResponseXML .=  " <td>".$row_rspaymas["barer"]."</td>";
			  $descrip=$row_rspaymas["heading"];
		   } 
		   
			echo "<td>".$descrip."</td>
			<td align=right>".number_format($row_rsPrInv["l_amount"], 2, ".", ",")."</td>
			</tr>";
			
			$DEB_amt=$DEB_amt+$row_rsPrInv["l_amount"];
		
		}
		echo "<tr><td colspan=3>&nbsp;</td>
			<td align=right><b>".number_format($DEB_amt, 2, ".", ",")."</b></td>
			</tr></table>";
	 	
	echo "<br>";
	
	echo "<table width=\"904\" height=\"81\" border=\"0\" cellspacing=\"0\">
		<tr >
        <th colspan=4 align=left>Less: Un-Presented Cheques</th>
		</tr>
      	<tr  bgcolor=\"#999999\">
        <th width=\"70\" height=\"23\">Date</th>
        <th width=\"100\">Chq. No</th>
        <th width=\"445\">Description</th>
        <th width=\"100\">Amount</th>
        </tr>";
	
	$sql_rsPrInv="Select * from op_cheq where (recdate='0'  )  and flag='CRE'  and code='" . trim($_GET["txtBankCode"]) . "' order by sdate";
		$result_rsPrInv=mysql_query($sql_rsPrInv, $dbacc);
		//echo $sql_rsPrInv;
	  	while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)){
			echo "<tr><td>".date("Y-m-d", strtotime($row_rsPrInv["sdate"]))."</td>
			<td>".$row_rsPrInv["chno"]."</td>
			<td>&nbsp;</td>
			<td align=right>".number_format($row_rsPrInv["amount"], 2, ".", ",")."</td>
			</tr>";
			
			$CRE_amt=$CRE_amt+$row_rsPrInv["amount"];
		
		}
		echo "<tr><td colspan=3>&nbsp;</td>
			<td align=right><b>".number_format($DEB_amt, 2, ".", ",")."</b></td>
			</tr>";
				
	$sql_rsPrInv="select * from ledger where  (l_flag != 'opb') and l_code='" . trim($_GET["txtBankCode"]) . "'   and l_flag2 = '0'  and l_date <= '" . $_GET["dtpDate"] . "' and l_flag1='CRE' order by l_flag1 desc, l_date ";
	$result_rsPrInv=mysql_query($sql_rsPrInv, $dbacc);
	  	while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)){
			echo "<tr><td>".$row_rsPrInv["l_date"]."</td>
			<td>".$row_rsPrInv["chno"]."</td>
			<td>".$row_rsPrInv["l_lmem"]."</td>
			<td  align=right>".number_format($row_rsPrInv["l_amount"], 2, ".", ",")."</td>
			</tr>";
			
			$CRE_amt=$CRE_amt+$row_rsPrInv["l_amount"];
		
		}
		echo "<tr><td colspan=3>&nbsp;</td>
			<td align=right><b>".number_format($CRE_amt, 2, ".", ",")."</b></td>
			</tr></table>";
	  
	   ?>  
  <tr>
    <td height="18" colspan="3">&nbsp;</td>
    <td height="18" align="right"><strong>__________________</strong></td>
  <tr>
    <td height="20" colspan="3"><b>Balance As per Cash Book as at <?php echo date("Y-m-d", strtotime($_GET["dtpDate"])); ?></b></td>
    <td height="20" align="right"><b><?php echo number_format(($txtBankBal_org+$DEB_amt-$CRE_amt), 2, ".", ","); ?></b></td>
  <tr>
    <td height="19" colspan="3"></td>
    <td height="19" align="right"><strong>================</strong></td>
  <tr>
    <td height="72" colspan="4"><p><strong>Summerized Bank Account</strong></p>
    <fieldset>
      <table width="650" border="0">
        <tr>
          <td colspan="3" scope="col">&nbsp;</td>
          <td scope="col" align="right"><strong>According to Ledger </strong></td>
          <td scope="col" align="right"><strong>According to Last Recon </strong></td>
        </tr>
        <tr>
        <?php
			//$date=date("Y-m-d",$_GET["dtfrom"]);
			
			$date1=date('Y-m-d', strtotime($_GET["dtfrom"]. ' + 1 days'));
		?>
          <td colspan="3" scope="col"><strong>Opening Balance as At <?php echo $date1; ?></strong></td>
          <td width="189" scope="col" align="right"><?php echo $txtopbal2; ?></td>
          <td width="166" scope="col" align="right"><?php echo $txtopbal; ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td align="right">_______________________</td>
          <td align="right">_______________________</td>
        </tr>
        <tr>
          <td width="102">&nbsp;</td>
          <td colspan="2">Add :-  Receipt Cash Book</td>
          <td align="right"><?php echo $txtadd; ?></td>
          <td align="right"><?php echo $txtadd; ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <?php
		  
		  	if ($txtless>0){
				$txtless="(".$txtless.")";
			}
		 
		  ?>
          <td colspan="2">Less :- Payment Cash Book </td>
          <td align="right"><?php echo $txtless; ?></td>
         
          <td align="right"><?php echo $txtless; ?></td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
          <td align="right">_______________________</td>
          <td align="right">_______________________</td>
        </tr>
        <tr>
          <td colspan="3"><strong>Closing Balance As At <?php echo date("Y-m-d", strtotime($_GET["dtpDate"])); ?></strong></td>
          <td align="right"><?php echo $txtclosebal2; ?></td>
          <td align="right"><?php echo $txtclosebal; ?></td>
        </tr>
        <tr>
          <td height="18" colspan="3"></td>
          <td align="right">====================</td>
          <td align="right">====================</td>
        </tr>
      </table>
      </fieldset>      
    <p>&nbsp;</p>              </td>
  <tr>
    <td height="199" colspan="4">
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
