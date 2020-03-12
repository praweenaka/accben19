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

            </head>
        </style>
        <body>
            <?php
            include('connection.php');
            date_default_timezone_set('Asia/Colombo');

            $sql = "delete from ledprint ";
            $result = mysql_query($sql, $dbacc);



            $OpDbAmu = 0;
            $OpCrAmu = 0;


            /*

              if ($_SESSION['User_Type'] == "1") {

              $sql_rs="sELECT  l_amount, l_code, l_refno, l_flag1 from ledger where l_flag = 'OPB' and l_code='" . $_GET["txtAccCode"] . "' and l_yearfl = '2' ";
              echo $sql_rs."1</br>";
              $result_rs=mysql_query($sql_rs, $dbacc);
              if ($row_rs = mysql_fetch_array($result_rs)){
              if ($row_rs["l_flag1"] == "CRE") {
              $OpCrAmu = $row_rs["l_amount"];
              } else {
              $OpDbAmu = $row_rs["l_amount"];
              }
              }
              } else { */
            $sql_rs = "sELECT  l_amount, l_code, l_refno, l_flag1 from ledger where l_flag = 'OPB' and l_code='" . $_GET["txtAccCode"] . "' and l_yearfl = '0' ";
//	echo $sql_rs."2</br>";
            $result_rs = mysql_query($sql_rs, $dbacc);
            if ($row_rs = mysql_fetch_array($result_rs)) {

                if ($row_rs["l_flag1"] == "CRE") {
                    $OpCrAmu = $row_rs["l_amount"];
                } else {
                    $OpDbAmu = $row_rs["l_amount"];
                }
            }
//}

            $sql_opCR = "select sum(l_amount)as ctot from ledger where l_flag != 'OPB' and l_yearfl != '2' and  l_yearfl != '1'  AND l_flag1='CRE' and l_code='" . $_GET["txtAccCode"] . "' and (l_date<'" . $_GET["repdatefrom"] . "'  )";
//echo $sql_opCR."</br>";
            $result_opCR = mysql_query($sql_opCR, $dbacc);
            if ($row_opCR = mysql_fetch_array($result_opCR)) {
                $OpCrAmu = $OpCrAmu + $row_opCR["ctot"];
            }

            $sql_opDb = "select sum(l_amount)as dtot from ledger where  l_flag != 'OPB' and l_yearfl != '2' and  l_yearfl != '1' AND l_flag1='DEB' and l_code='" . $_GET["txtAccCode"] . "'  and (l_date<'" . $_GET["repdatefrom"] . "' ) ";
//echo $sql_opDb."</br>";
            $result_opDb = mysql_query($sql_opDb, $dbacc);
            if ($row_opDb = mysql_fetch_array($result_opDb)) {
                $OpDbAmu = $OpDbAmu + $row_opDb["dtot"];
            }


            $bF = $OpBalAm + $OpDbAmu - $OpCrAmu + $OpLnkAmt;

            if ($bF > 0) {
                $bfFlag = "DEB";
            } else {
                $bfFlag = "CRE";
            }

            $sql = "insert into ledprint (sdate, refno, remarks, flag, amount) values('" . $_GET["repdatefrom"] . "', 'B/F', 'Opening Balance ','" . $bfFlag . "', " . abs($bF) . ")";
            $result = mysql_query($sql, $dbacc);



            $sql_rst = "select * from ledger where l_flag != 'OPB' and  l_yearfl != '2' and   l_yearfl != '1' and l_code='" . $_GET["txtAccCode"] . "' and ( l_date >'" . $_GET["repdatefrom"] . "' or l_date ='" . $_GET["repdatefrom"] . "') and  ( l_date < '" . $_GET["repdateto"] . "' or l_date ='" . $_GET["repdateto"] . "')";
//echo $sql_rst;
//echo $sql_rst."</br>";
            $result_rst = mysql_query($sql_rst, $dbacc);
            while ($row_rst = mysql_fetch_array($result_rst)) {
                if ($row_rst["l_flag4"] == "CHQ") {

                    $sql = "insert into ledprint (sdate, refno, remarks, flag, amount) values('" . $row_rst["l_date"] . "', '" . trim($row_rst["l_refno"]) . "', '" . trim($row_rst["l_lmem"]) . " " . trim($row_rst["chno"]) . "', '" . trim($row_rst["l_flag1"]) . "', " . $row_rst["l_amount"] . ")";
                    $result = mysql_query($sql, $dbacc);
                } else {

                    $sql = "insert into ledprint (sdate, refno, remarks, flag, amount) values('" . $row_rst["l_date"] . "', '" . trim($row_rst["l_refno"]) . "', '" . trim($row_rst["l_lmem"]) . "','" . trim($row_rst["l_flag1"]) . "', " . $row_rst["l_amount"] . ")";
                    $result = mysql_query($sql, $dbacc);
                }
            }



            $table = "";


            $table.="<table width=\"922\" border=\"0\">
  <tr>
    <td colspan=\"3\" align=\"center\"><span class=\"companyname\">";
            if ($_SESSION['company'] == "EF") {
                $table.="E-Friendly";
            }

            if ($_SESSION['company'] == "BE") {
                $table.="Benedicsons (Pvt) Ltd";
            }

            if ($_SESSION['company'] == "TH") {
                $table.="Tyre House Trading (Pvt) Ltd";
            }

            $table.="  </span></td>
  </tr>
 
  
  
  <tr>
    <td height=\"21\">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
  <tr>
    <td height=\"199\" colspan=\"3\">";
            $DEB_amt = 0;
            $CRE_amt = 0;


            $table.="<b>Account : </b> " . $_GET["txtAccCode"] . " - " . $_GET["txtAccName"];
            $table.="<table width=\"1000\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
		
      	<tr>
        <th width=\"70\">Date</th>
        <th width=\"200\">Refno</th>
        <th width=\"400\">Naration</th>
        <th width=\"100\">Debit</th>
		<th width=\"100\">Credit</th>
		<th width=\"100\">Balance</th>
        </tr>";

            $debamt = 0;
            $creamt = 0;
            $baltot = 0;

            $totdebamt = 0;
            $totcreamt = 0;
            $refno = "";

            $mst = 0;

            $sql_rsPrInv = "select *  from ledprint order by sdate, refno";
            $result_rsPrInv = mysql_query($sql_rsPrInv, $dbacc);
            while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)) {




                if ($row_rsPrInv["flag"] == "DEB") {
                    $debamt = $row_rsPrInv["amount"];
                } else {
                    $debamt = 0;
                }

                if ($row_rsPrInv["flag"] == "CRE") {
                    $creamt = $row_rsPrInv["amount"];
                } else {
                    $creamt = 0;
                }



                $bal = $debamt - $creamt;
                $baltot = $baltot + $bal;

                //$rem=substr(str_replace("br", "%", $row_rsPrInv["remarks"]), 0, 80);

                $table.="<tr><td>" . $row_rsPrInv["sdate"] . "</td>
				<td>" . $row_rsPrInv["refno"] . "</td>
				<td>" . $row_rsPrInv["remarks"] . "</br></br></td>";

                $table.="<td align=right>" . number_format($debamt, 2, ".", ",") . "</td>";

                $table.="<td align=right>" . number_format($creamt, 2, ".", ",") . "</td>";
                $table.="<td align=right>" . number_format($baltot, 2, ".", ",") . "</td>";
                $table.="</tr>";


                $totdebamt = $totdebamt + $debamt;
                $totcreamt = $totcreamt + $creamt;
            }
            $table.="<tr><td colspan=3>&nbsp;</td><td align=right><b>" . number_format($totdebamt, 2, ".", ",") . "</b></td><td align=right><b>" . number_format($totcreamt, 2, ".", ",") . "</b></td><td align=right><b>" . number_format($baltot, 2, ".", ",") . "</b></td></tr>";







            $table.="</table>
</td>
  </tr>
  <tr>
    <td colspan=\"2\">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan=\"2\">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan=\"2\">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan=\"2\">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>";

            echo $table;


            //WRITE XLS FILE
            $file = "report/rpt_ledger.xls";

            $f = fopen($file, "w+");

            fwrite($f, $table);

            echo "<a href=\"report/rpt_ledger.xls\">Download Excel Report</a>";
            ?>
