<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cheque Report</title>
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




	include('connection.php');
	
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
 
  
  
  <tr>";
  if ($_GET["optjou"]=="true"){
   $table.=" <td height=\"21\">Journal Report Date From - ".$_GET["repdatefrom"]." To - ".$_GET["repdateto"]."</td>";
  } else if ($_GET["optbanktrans"]=="true"){
   $table.=" <td height=\"21\">Bank Transaction Report Date From - ".$_GET["repdatefrom"]." To - ".$_GET["repdateto"]."</td>";
  } else if ($_GET["optbankdepo"]=="true"){
   $table.=" <td height=\"21\">Bank Deposit Report Date From - ".$_GET["repdatefrom"]." To - ".$_GET["repdateto"]."</td>";
  } else if ($_GET["optchqpay"]=="true"){
   $table.=" <td height=\"21\">Cheque Pay Report Date From - ".$_GET["repdatefrom"]." To - ".$_GET["repdateto"]."</td>";
  } 
    $table.="<td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
  <tr>
    <td height=\"199\" colspan=\"3\">";
	
	
	$table.="<table width=\"904\" height=\"81\" border=\"1\" cellspacing=\"0\">
		
      	<tr>
        <th width=\"70\" height=\"23\">Date</th>
        <th width=\"80\">Ref No</th>
        <th width=\"80\">Code</th>
		<th width=\"200\">Ledger Name</th>
		<th width=\"50\">Debit/Credit</th>
        <th width=\"100\">Amount</th>
		
        </tr>";
	
	
	if ($_GET["optjou"]=="true"){
	    
		$recno= $_SESSION['company'] . "/" . date("y") . "/J/";
		
		if ($_GET["optdate"]=="true"){
   			$strsql = "select * from view_ledger  where  l_yearfl != '2' and  l_yearfl != '1' and  l_date >='" . $_GET["repdatefrom"] . "' and l_date <='". $_GET["repdateto"] . "' and l_refno like '$recno%' order by l_date, l_refno, l_flag1 ";
			
		} else if ($_GET["optrefno"]=="true"){
		
			$strsql = "select * from view_ledger  where  l_yearfl != '2' and  l_yearfl != '1' and  l_date >='" . $_GET["repdatefrom"] . "' and l_date <='". $_GET["repdateto"] . "' and l_refno like '$recno%' order by l_refno, l_flag1 ";
		}
	} else if ($_GET["optbanktrans"]=="true"){
		
		$recno= $_SESSION['company'] . "/" . date("y") . "/P/";
		
		if ($_GET["optdate"]=="true"){
   			$strsql = "select * from view_ledger  where  l_yearfl != '2' and  l_yearfl != '1' and  l_date >='" . $_GET["repdatefrom"] . "' and l_date <='". $_GET["repdateto"] . "' and l_refno like '$recno%' order by l_date, l_refno, l_flag1 ";
			
		} else if ($_GET["optrefno"]=="true"){
		
			$strsql = "select * from view_ledger  where  l_yearfl != '2' and  l_yearfl != '1' and  l_date >='" . $_GET["repdatefrom"] . "' and l_date <='". $_GET["repdateto"] . "' and l_refno like '$recno%' order by l_refno, l_flag1 ";
		}
		
	} else if ($_GET["optbankdepo"]=="true"){
		
		$recno= $_SESSION['company'] . "/" . date("y") . "/R/";
		
		if ($_GET["optdate"]=="true"){
   			$strsql = "select * from view_ledger  where  l_yearfl != '2' and  l_yearfl != '1' and  l_date >='" . $_GET["repdatefrom"] . "' and l_date <='". $_GET["repdateto"] . "' and l_refno like '$recno%' order by l_date, l_refno, l_flag1 ";
			
		} else if ($_GET["optrefno"]=="true"){
		
			$strsql = "select * from view_ledger  where  l_yearfl != '2' and  l_yearfl != '1' and  l_date >='" . $_GET["repdatefrom"] . "' and l_date <='". $_GET["repdateto"] . "' and l_refno like '$recno%' order by l_refno, l_flag1 ";
		}
	} else if ($_GET["optchqpay"]=="true"){
		
		$recno= $_SESSION['company'] . "/" . date("y") . "/PCH/";
		
		if ($_GET["optdate"]=="true"){
   			$strsql = "select * from view_ledger  where  l_yearfl != '2' and  l_yearfl != '1' and  l_date >='" . $_GET["repdatefrom"] . "' and l_date <='". $_GET["repdateto"] . "' and l_refno like '$recno%' order by l_date, l_refno, l_flag1 ";
			
		} else if ($_GET["optrefno"]=="true"){
		
			$strsql = "select * from view_ledger  where  l_yearfl != '2' and  l_yearfl != '1' and  l_date >='" . $_GET["repdatefrom"] . "' and l_date <='". $_GET["repdateto"] . "' and l_refno like '$recno%' order by l_refno, l_flag1 ";
		}
	}	
	//echo $strsql;
	
		$deb=0;
		$cre=0;
	
			$result_strsql=mysql_query($strsql, $dbacc);
			while ($row_strsql = mysql_fetch_array($result_strsql)){
			
			if ($row_strsql["l_refno"]!=$l_refno){	
				$table.="
		
      				<tr>
        <td width=\"70\" height=\"23\" colspan=6>&nbsp;</td>
       
	    </tr>";	
			}
			
	
				$table.="
		
      	<tr>
        <td width=\"70\" height=\"23\">".$row_strsql["l_date"]."</td>
        <td width=\"400\">".$row_strsql["l_refno"]."</td>
        <td width=\"100\">".$row_strsql["l_code"]."</td>
		<td width=\"100\">".$row_strsql["name"]."</td>
		<td width=\"100\">".$row_strsql["l_flag1"]."</td>
        <td width=\"100\">".$row_strsql["l_amount"]."</td>
	    </tr>";	
			
			
			if ($row_strsql["l_flag1"]=="DEB"){
				$deb=$deb+$row_strsql["l_amount"];
			}
			
			if ($row_strsql["l_flag1"]=="CRE"){
				$cre=$cre+$row_strsql["l_amount"];
			}
			
			$l_refno=$row_strsql["l_refno"];
		
		}
		
		$table.="
		
      				<tr>
        <td width=\"70\" height=\"23\" colspan=5><b>Debit Total - ".number_format($deb, 2, ".", ",")."</b></td>
       
	    </tr>";
		
		$table.="
		
      				<tr>
        <td width=\"70\" height=\"23\" colspan=5><b>Credit Total - ".number_format($cre, 2, ".", ",")."</b></td>
       
	    </tr>";	
		echo $table;
$file="report/rpt_jou_datewise.xls";
   
    $f = fopen($file, "w+");
  
    fwrite($f,$table);
  
	echo "<a href=\"report/rpt_jou_datewise.xls\">Download Excel Report</a>";

?>
</body>
</html>
