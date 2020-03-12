<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
include('connection.php');

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');
date_default_timezone_set('Asia/Colombo');


/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////



if ($_GET["Command"] == "lastmonthcal") {


    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    $sql = "Select * from bank_bal where bdate <'" . $_GET["dtpDate"] . "' and code='" . trim($_GET["txtBankCode"]) . "'  order by bdate desc";
    //echo $sql;
    $OpCrAmu = 0;
    $OpDbAmu = 0;
    $bF = 0;

    $result = mysql_query($sql, $dbacc);
    if ($row = mysql_fetch_array($result)) {
        $ResponseXML .= "<txt_bankbal><![CDATA[" . number_format($row['close_balance'], 2, ".", ",") . "]]></txt_bankbal>";
        $ResponseXML .= "<dtfrom><![CDATA[" . $row['bdate'] . "]]></dtfrom>";
        $bdate = $row['bdate'];
    }

    $sql_rs = "sELECT  l_amount, l_code, l_refno, l_flag1 from ledger where l_flag = 'OPB' and l_code='" . trim($_GET["txtBankCode"]) . "' and l_yearfl = '0' ";
    //echo $sql_rs."</br>";
    $result_rs = mysql_query($sql_rs, $dbacc);
    if ($row_rs = mysql_fetch_array($result_rs)) {

        if ($row_rs["l_flag1"] == "CRE") {
            $OpCrAmu = $row_rs["l_amount"];
        } else {
            $OpDbAmu = $row_rs["l_amount"];
        }
    }
//}

    $sql_opCR = "select sum(l_amount)as ctot from ledger where l_flag != 'OPB' and l_yearfl != '2' and  l_yearfl != '1'  AND l_flag1='CRE' and l_code='" . trim($_GET["txtBankCode"]) . "' and (l_date<='" . $bdate . "'  )";
//echo $sql_opCR."</br>";
    $result_opCR = mysql_query($sql_opCR, $dbacc);
    if ($row_opCR = mysql_fetch_array($result_opCR)) {
        $OpCrAmu = $OpCrAmu + $row_opCR["ctot"];
    }

    $sql_opDb = "select sum(l_amount)as dtot from ledger where  l_flag != 'OPB' and l_yearfl != '2' and  l_yearfl != '1' AND l_flag1='DEB' and l_code='" . trim($_GET["txtBankCode"]) . "'  and (l_date<='" . $bdate . "' ) ";
//echo $sql_opDb."</br>";
    $result_opDb = mysql_query($sql_opDb, $dbacc);
    if ($row_opDb = mysql_fetch_array($result_opDb)) {
        $OpDbAmu = $OpDbAmu + $row_opDb["dtot"];
    }
    /*
      echo $OpBalAm."/";
      echo $OpCrAmu."/";
      echo $OpDbAmu."/";
      echo $OpLnkAmt."/"; */

    $bF = $OpDbAmu - $OpCrAmu;

    $ResponseXML .= "<txt_bF><![CDATA[" . number_format($bF, 2, ".", ",") . "]]></txt_bF>";

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}



if ($_GET["Command"] == "display") {
    $txtFinalBal = 0;
    $txtCre = 0;
    $txtDeb = 0;

    $txtBankClosBal = 0;
    $txt_bankbal = 0;
    $txtclosebal = 0;
    $b_pay = 0;
    $b_depo = 0;
    $txt_bankbal2 = 0;
    $txt_bankbal2 = 0;
    $txtBankClosBal = 0;
    $txttot = 0;


    $sql = "delete from tmpbankrecon_deb where user='" . $_SESSION['UserName'] . "'";
    $result = mysql_query($sql, $dbacc);

    $sql = "delete from tmpbankrecon_cre where user='" . $_SESSION['UserName'] . "'";
    $result = mysql_query($sql, $dbacc);


    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $txtBankCode = $_GET["txtBankCode"];

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    ////////// DEBIT /////////////////////////////
    $mRow = 1;
    $txtDeb = 0;
    $ResponseXML .= "<debtable><![CDATA[<table width=\"625\" border=\"1\" cellspacing=\"0\">
         <tr>
          <td background=\"images/headingbg.gif\" width=\"100\" height=\"25\">Ref No</td>
          <td background=\"images/headingbg.gif\" width=\"75\">Date</td>
          <td background=\"images/headingbg.gif\" width=\"75\">Cheque No</td>
          <td background=\"images/headingbg.gif\" width=\"300\">Name</td>
          <td background=\"images/headingbg.gif\" width=\"50\">Amount</td>
          <td background=\"images/headingbg.gif\" width=\"5\">F</td>
		  <td background=\"images/headingbg.gif\" width=\"10\"></td>
		  <td background=\"images/headingbg.gif\" width=\"10\"></td>
         
        </tr>";

    $sql_opCh = "Select * from op_cheq where (recdate='0'  OR (year(sdate)='" . date("Y", strtotime($_GET["dtpDate"])) . "' and recmonth='" . date("m", strtotime($_GET["dtpDate"])) . "'))  and flag='DEB'  and code='" . trim($_GET["txtBankCode"]) . "' order by sdate";

    $result_opCh = mysql_query($sql_opCh, $dbacc);
    while ($row_opCh = mysql_fetch_array($result_opCh)) {

        $ResponseXML .= "<tr>
          <td>" . $row_opCh["refno"] . "</td>
          <td>" . date("Y-m-d", strtotime($row_opCh["sdate"])) . "</td>
          <td>" . $row_opCh["chno"] . "</td>
		  <td>&nbsp;</td>
          <td align=right>" . number_format($row_opCh["amount"], 2, ".", ",") . "</td>";

        if ($row_opCh["recdate"] != "0000-00-00") {
            $ResponseXML .= "<td>" . $row_opCh["recdate"] . "</td>";
            $txtDeb = $txtDeb + $row_opCh["amount"];
            $txtFinalBal = $txtDeb + $txtCre;
            $F = $row_opCh["recdate"];
        } else {
            $ResponseXML .= "<td>0</td>";
            $F = 0;
        }


        if ($row_opCh["recdate"] != "0") {
            $ResponseXML .= "<td><input type=\"checkbox\" name=\"" . $row_opCh["refno"] . "\" id=\"" . $row_opCh["refno"] . "\" onclick=\"checkdb('" . $row_opCh["refno"] . "', '" . $row_opCh["id"] . "', 'DEB');\" checked=\"checked\" /></td>";
            $l_flag2 = "1";
        } else {
            $ResponseXML .= "<td><input type=\"checkbox\" name=\"" . $row_opCh["refno"] . "\" id=\"" . $row_opCh["refno"] . "\" onclick=\"checkdb('" . $row_opCh["refno"] . "', '" . $row_opCh["id"] . "', 'DEB');\" /></td>";
            $l_flag2 = "0";
        }
        $ResponseXML .= "<td>&nbsp;</td>";
        $ResponseXML .= "</tr>";

        $sql = "insert into tmpbankrecon_deb (ref_no, trn_date, chq_no, name, heading, amt, f, descrip, chk, id, user) values ('" . $row_opCh["refno"] . "', '" . $row_opCh["sdate"] . "', '" . $row_opCh["chno"] . "', '', '', " . $row_opCh["amount"] . ", '" . $F . "', 'Last Year Balance', '" . $row_opCh["recdate"] . "', " . $row_opCh["id"] . ", '" . $_SESSION['UserName'] . "')";

        $result = mysql_query($sql, $dbacc);
    }


    //$sql_strsql="Select * from ledger where rights='0' and l_date <= '" . $_GET["dtpDate"] . "' and l_flag!='OPB' and l_flag1 = 'DEB' and l_flag3='R' and l_code='" . trim($_GET["txtBankCode"]) . "' order by l_date";
    $sql_strsql = "Select * from ledger where l_date <= '" . $_GET["dtpDate"] . "' and l_flag!='OPB' and l_flag1 = 'DEB' and l_flag3='R' and l_code='" . trim($_GET["txtBankCode"]) . "' order by l_date";
    //echo $sql_strsql;
    $result_strsql = mysql_query($sql_strsql, $dbacc);
    while ($row_strsql = mysql_fetch_array($result_strsql)) {

        if (($row_strsql["l_flag2"] == "0") or (date("m", strtotime($row_strsql["l_date"])) == date("m", strtotime($_GET["dtpDate"]))) and (date("Y", strtotime($row_strsql["l_date"])) == date("Y", strtotime($_GET["dtpDate"])))) {

            $ResponseXML .= "<tr>
          <td>" . $row_strsql["l_refno"] . "</td>
          <td>" . $row_strsql["l_date"] . "</td>
          <td>" . $row_strsql["chno"] . "</td>";


            $F = "";

            if (($row_strsql["l_flag2"] == "1") or ($row_strsql["l_flag4"] == "CAS")) {
                $F = "1";

                $txtDeb = $txtDeb + $row_strsql["l_amount"];
                $txtFinalBal = $txtDeb + $txtCre;
            } else {
                $F = "0";
            }

            if (is_null($row_strsql["recdate"]) == false) {
                $F = $row_strsql["recdate"];
            }

            if ($row_strsql["l_flag4"] == "CAS") {
                $F = $row_strsql["l_date"];
            }



            $descrip = "";

            $sql_rspaymas = "select barer, heading from paymas where refno='" . $row_strsql["l_refno"] . "'";
            // echo $sql_rspaymas;
            $result_rspaymas = mysql_query($sql_rspaymas, $dbacc);
            if ($row_rspaymas = mysql_fetch_array($result_rspaymas)) {
                // $ResponseXML .=  " <td>".$row_rspaymas["barer"]." ".$row_rspaymas["heading"]."</td>";
                //$descrip=$row_rspaymas["barer"]." ".$row_rspaymas["heading"];
                $descrip = str_replace("~", "&", $row_rspaymas["barer"]);
                $descrip = str_replace("&nbsp;", " ", $descrip);

                $ResponseXML .= " <td>" . $descrip . "</td>";
            } else {

                $descrip = str_replace("~", "&", $row_strsql["l_lmem"]);
                $descrip = str_replace("&nbsp;", " ", $descrip);

                $ResponseXML .= " <td>" . $descrip . "</td>";
            }

            $ResponseXML .= "<td align=right>" . number_format($row_strsql["l_amount"], 2, ".", ",") . "</td>";

            $ResponseXML .= "<td>" . $F . "</td>";

            $refno = $row_strsql["l_refno"] . $row_strsql["id"];

            if ($row_strsql["l_flag2"] != "0") {
                $ResponseXML .= "<td><input type=\"checkbox\" name=\"" . $refno . "\" id=\"" . $refno . "\" onclick=\"checkdb('" . $refno . "', '" . $row_strsql["id"] . "', 'DEB');\" checked=\"checked\" /></td>";
                $l_flag2 = "1";
            } else {
                $ResponseXML .= "<td><input type=\"checkbox\" name=\"" . $refno . "\" id=\"" . $refno . "\" onclick=\"checkdb('" . $refno . "', '" . $row_strsql["id"] . "', 'DEB');\" /></td>";
                $l_flag2 = "0";
            }

            $ResponseXML .= " <td>" . $row_strsql["id"] . "</td></tr>";

            $sql = "insert into tmpbankrecon_deb (ref_no, trn_date, chq_no, name, heading, amt, f, descrip, chk, id, user) values ('" . $row_strsql["l_refno"] . "', '" . $row_strsql["l_date"] . "', '" . $row_strsql["chno"] . "', '', '', " . $row_strsql["l_amount"] . ", '" . $F . "', '" . $descrip . "', '" . $l_flag2 . "', " . $row_strsql["id"] . ", '" . $_SESSION['UserName'] . "')";


            $result = mysql_query($sql, $dbacc);
        }
    }

    $ResponseXML .= "</table>]]></debtable>";


    $ResponseXML .= "<cretable><![CDATA[<table width=\"625\" border=\"1\" cellspacing=\"0\">
         <tr>
          <td background=\"images/headingbg.gif\" width=\"100\" height=\"25\">Ref No</td>
          <td background=\"images/headingbg.gif\" width=\"75\">Date</td>
          <td background=\"images/headingbg.gif\" width=\"75\">Cheque No</td>
          <td background=\"images/headingbg.gif\" width=\"300\">Name</td>
          <td background=\"images/headingbg.gif\" width=\"50\">Amount</td>
          <td background=\"images/headingbg.gif\" width=\"5\">F</td>
		  <td background=\"images/headingbg.gif\" width=\"10\"></td>
		  <td background=\"images/headingbg.gif\" width=\"10\"></td>
          
        </tr>";


    //////// CREDIT /////////////////
    //$sql_opCh="Select * from op_cheq where (recdate='0'  OR recmonth='" . date("m", strtotime($_GET["dtpDate"])) . "')  and flag='CRE'  and code='" . trim($_GET["txtBankCode"]) . "'  order by sdate";
    $sql_opCh = "Select * from op_cheq where (recdate='0'  OR (year(sdate)='" . date("Y", strtotime($_GET["dtpDate"])) . "' and recmonth='" . date("m", strtotime($_GET["dtpDate"])) . "'))  and flag='CRE'  and code='" . trim($_GET["txtBankCode"]) . "'  order by sdate";
    //echo $sql_opCh;
    $result_opCh = mysql_query($sql_opCh, $dbacc);
    while ($row_opCh = mysql_fetch_array($result_opCh)) {
        $ResponseXML .= "<tr>
          <td>" . $row_opCh["refno"] . "</td>
          <td>" . date("Y-m-d", strtotime($row_opCh["sdate"])) . "</td>
          <td>" . $row_opCh["chno"] . "</td>
		  <td>&nbsp;</td>
	      <td align=right>" . number_format($row_opCh["amount"], 2, ".", ",") . "</td>
		  <td>&nbsp;</td>";


        if ($row_opCh["recdate"] != "0") {
            $ResponseXML .= "<td><input type=\"checkbox\" name=\"" . $row_opCh["refno"] . "\" id=\"" . $row_opCh["refno"] . "\" onclick=\"checkdb('" . $row_opCh["refno"] . "', '" . $row_opCh["id"] . "', 'CRE');\" checked=\"checked\"/></td>";
        } else {
            $ResponseXML .= "<td><input type=\"checkbox\" name=\"" . $row_opCh["refno"] . "\" id=\"" . $row_opCh["refno"] . "\" onclick=\"checkdb('" . $row_opCh["refno"] . "', '" . $row_opCh["id"] . "', 'CRE');\" /></td>";
        }
        $ResponseXML .= "</tr>";

        $sql = "insert into tmpbankrecon_cre (ref_no, trn_date, chq_no, name, heading, amt, f, descrip, chk, id, user) values ('" . $row_opCh["refno"] . "', '" . $row_opCh["sdate"] . "', '" . $row_opCh["chno"] . "', '', '', " . $row_opCh["amount"] . ", '', 'Last Year Balance', '" . $row_opCh["recdate"] . "', " . $row_opCh["id"] . ", '" . $_SESSION['UserName'] . "')";
        $result = mysql_query($sql, $dbacc);
    }


    //$sql_strsql="Select * from ledger where rights='0' and  l_date<='" . $_GET["dtpDate"] . "' and l_flag!='OPB' and  l_flag1='CRE' and l_flag3='R' and l_code='" . trim($_GET["txtBankCode"]) . "' order by l_date";
    $sql_strsql = "Select * from ledger where   l_date<='" . $_GET["dtpDate"] . "' and l_flag!='OPB' and  l_flag1='CRE' and l_flag3='R' and l_code='" . trim($_GET["txtBankCode"]) . "' order by l_date";
    $result_strsql = mysql_query($sql_strsql, $dbacc);
    while ($row_strsql = mysql_fetch_array($result_strsql)) {

        $F = "";

        if (($row_strsql["l_flag2"] == "0") or (date("m", strtotime($row_strsql["l_date"])) == date("m", strtotime($_GET["dtpDate"]))) and (date("Y", strtotime($row_strsql["l_date"])) == date("Y", strtotime($_GET["dtpDate"])))) {
            $ResponseXML .= "<tr>
          <td>" . $row_strsql["l_refno"] . "</td>
          <td>" . $row_strsql["l_date"] . "</td>
          <td>" . $row_strsql["chno"] . "</td>";


            $descrip = "";
            $sql_rspaymas = "select barer, heading from paymas where refno='" . $row_strsql["l_refno"] . "'";
            // echo $sql_rspaymas;
            $result_rspaymas = mysql_query($sql_rspaymas, $dbacc);
            if ($row_rspaymas = mysql_fetch_array($result_rspaymas)) {
                // $ResponseXML .=  " <td>".$row_rspaymas["barer"]." ".$row_rspaymas["heading"]."</td>";
                //$descrip=$row_rspaymas["barer"]." ".$row_rspaymas["heading"];

                $descrip = str_replace("~", "&", $row_rspaymas["barer"]);
                $descrip = str_replace("&nbsp;", " ", $descrip);

                $ResponseXML .= " <td>" . $descrip . "</td>";
                $descrip = $row_rspaymas["barer"];
            } else {

                $descrip = str_replace("~", "&", $row_strsql["l_lmem"]);
                $descrip = str_replace("&nbsp;", " ", $descrip);

                $ResponseXML .= " <td>" . $descrip . "</td>";
                $descrip = $row_strsql["l_lmem"];
            }

            //$ResponseXML .=  "<td>".$descrip."</td>
            $ResponseXML .= "<td align=right>" . number_format($row_strsql["l_amount"], 2, ".", ",") . "</td>";

            if (($row_strsql["l_flag2"] == "1") or ($row_strsql["l_flag4"] == "CAS")) {
                $F = "1";
                $txtCre = $txtCre + $row_strsql["l_amount"];
                $txtFinalBal = $txtDeb + $txtCre;
            } else {
                $F = 0;
            }

            if (is_null($row_strsql["recDate"]) == false) {
                $F = $row_strsql["recdate"];
            }

            if ($row_strsql["l_flag4"] == "CAS") {
                $F = $row_strsql["l_date"];
            }

            $ResponseXML .= "<td>" . $F . "</td>";

            //  $ResponseXML .= "<td>".$row_strsql["l_lmem"]."</td>";

            $refno = $row_strsql["l_refno"] . $row_strsql["id"];
            if ($row_strsql["l_flag2"] != "0") {
                $ResponseXML .= "<td><input type=\"checkbox\" name=\"" . $refno . "\" id=\"" . $refno . "\" onclick=\"checkdb('" . $refno . "', '" . $row_strsql["id"] . "', 'CRE');\" checked=\"checked\" /></td>";
                $l_flag2 = "1";
            } else {
                $ResponseXML .= "<td><input type=\"checkbox\" name=\"" . $refno . "\" id=\"" . $refno . "\" onclick=\"checkdb('" . $refno . "', '" . $row_strsql["id"] . "', 'CRE');\" /></td>";
                $l_flag2 = "0";
            }

            $ResponseXML .= " <td>" . $row_strsql["id"] . "</td></tr>";

            $sql = "insert into tmpbankrecon_cre (ref_no, trn_date, chq_no, name, heading, amt, f, descrip, chk, id, user) values ('" . $row_strsql["l_refno"] . "', '" . $row_strsql["l_date"] . "', '" . $row_strsql["chno"] . "', '', '', " . $row_strsql["l_amount"] . ", '" . $F . "', '" . $descrip . "', '" . $l_flag2 . "', " . $row_strsql["id"] . ", '" . $_SESSION['UserName'] . "')";
            $result = mysql_query($sql, $dbacc);
        }
    }
    $ResponseXML .= "</table>]]></cretable>";


    $b_pay = 0;
    $b_depo = 0;

    //$sql_rst="select * from ledger where rights='0' and  l_yearfl='0' and (l_flag != 'OPB') AND (l_code = '" . trim($_GET["txtBankCode"]) . "') AND (l_flag1 = 'CRE') AND year(l_date)='" . date("Y", strtotime($_GET["dtpDate"])) . "' and month(l_date) ='" . date("m", strtotime($_GET["dtpDate"])) . "' order by l_date";
    $sql_rst = "select * from ledger where  l_yearfl='0' and (l_flag != 'OPB') AND (l_code = '" . trim($_GET["txtBankCode"]) . "') AND (l_flag1 = 'CRE') AND year(l_date)='" . date("Y", strtotime($_GET["dtpDate"])) . "' and month(l_date) ='" . date("m", strtotime($_GET["dtpDate"])) . "' order by l_date";
    $result_rst = mysql_query($sql_rst, $dbacc);
    while ($row_rst = mysql_fetch_array($result_rst)) {

        if ($row_rst["l_date"] <= $_GET["dtpDate"]) {
            $b_pay = $b_pay + $row_rst["l_amount"];
        }
    }

    $ResponseXML .= "<txtbankpay><![CDATA[" . $b_pay . "]]></txtbankpay>";

    //$sql_rst="select * from ledger where rights='0' and  l_yearfl='0' and (l_flag != 'OPB') AND (l_code = '" . trim($_GET["txtBankCode"]) . "') AND (l_flag1 = 'DEB') AND year(l_date)='" . date("Y", strtotime($_GET["dtpDate"])) . "' and month(l_date) ='" . date("m", strtotime($_GET["dtpDate"])) . "' order by l_date ";
    $sql_rst = "select * from ledger where l_yearfl='0' and (l_flag != 'OPB') AND (l_code = '" . trim($_GET["txtBankCode"]) . "') AND (l_flag1 = 'DEB') AND year(l_date)='" . date("Y", strtotime($_GET["dtpDate"])) . "' and month(l_date) ='" . date("m", strtotime($_GET["dtpDate"])) . "' order by l_date ";
    $result_rst = mysql_query($sql_rst, $dbacc);
    while ($row_rst = mysql_fetch_array($result_rst)) {

        if ($row_rst["l_date"] <= $_GET["dtpDate"]) {
            $b_depo = $b_depo + $row_rst["l_amount"];
        }
    }

    $ResponseXML .= "<txtbankdepo><![CDATA[" . number_format($b_depo, 2, ".", ",") . "]]></txtbankdepo>";

    $ResponseXML .= "<txtFinalBal><![CDATA[" . number_format($txtFinalBal, 2, ".", ",") . "]]></txtFinalBal>";


    $sql = "select sum(amt) as tot_deb from tmpbankrecon_deb where chk='1' and user='" . $_SESSION['UserName'] . "'";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    $txtDeb = $row["tot_deb"];


    $sql = "select sum(amt) as tot_cre from tmpbankrecon_cre where chk='1' and user='" . $_SESSION['UserName'] . "'";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    $txtCre = $row["tot_cre"];

    $ResponseXML .= "<txtCre><![CDATA[" . $txtCre . "]]></txtCre>";
    $ResponseXML .= "<txtDeb><![CDATA[" . $txtDeb . "]]></txtDeb>";

    $txt_bankbal = str_replace(",", "", $_GET["txt_bankbal"]);
    //echo "FFFFFFFFFFFFFF ".$txt_bankbal;
    $txtclosebal = $txt_bankbal - $b_pay + $b_depo;
    //$txttot = $txtclosebal + $txtDeb - $txtCre;

    $txt_bankbal2 = str_replace(",", "", $_GET["txt_bankbal2"]);
    $txtclosebal2 = $txt_bankbal2 - $b_pay + $b_depo;

    $txtBankClosBal = str_replace(",", "", $_GET["txtBankClosBal"]);
    $txttot = $txtBankClosBal + $txtDeb - $txtCre;


    $ResponseXML .= "<txtclosebal><![CDATA[" . number_format($txtclosebal, 2, ".", ",") . "]]></txtclosebal>";
    $ResponseXML .= "<txttot><![CDATA[" . number_format($txttot, 2, ".", ",") . "]]></txttot>";

    $ResponseXML .= "<txtclosebal2><![CDATA[" . number_format($txtclosebal2, 2, ".", ",") . "]]></txtclosebal2>";

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}



if ($_GET["Command"] == "checkdb") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $txtBankCode = $_GET["txtBankCode"];

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    if ($_GET["type"] == "CRE") {
        if ($_GET["chk"] == "true") {
            $sql = "update tmpbankrecon_cre set chk='1' where id=" . $_GET["id"] . " and user='" . $_SESSION['UserName'] . "'";
            //echo $sql;
            $result = mysql_query($sql, $dbacc);
        }


        if ($_GET["chk"] == "false") {
            $sql = "update tmpbankrecon_cre set chk='0' where id=" . $_GET["id"] . " and user='" . $_SESSION['UserName'] . "'";
            //echo $sql;
            $result = mysql_query($sql, $dbacc);
        }
    } else if ($_GET["type"] == "DEB") {

        if ($_GET["chk"] == "true") {
            $sql = "update tmpbankrecon_deb set chk='1' where id=" . $_GET["id"] . " and user='" . $_SESSION['UserName'] . "'";
            //	echo $sql;
            $result = mysql_query($sql, $dbacc);
        }


        if ($_GET["chk"] == "false") {
            $sql = "update tmpbankrecon_deb set chk='0' where id=" . $_GET["id"] . " and user='" . $_SESSION['UserName'] . "'";
            //	echo $sql;
            $result = mysql_query($sql, $dbacc);
        }
    }

    $b_pay = 0;
    $b_depo = 0;

    //$sql_rst="select * from ledger where rights='0' and  l_yearfl='0' and (l_flag != 'OPB') AND (l_code = '" . trim($_GET["txtBankCode"]) . "') AND (l_flag1 = 'CRE') AND year(l_date)='" . date("Y", strtotime($_GET["dtpDate"])) . "' and month(l_date) ='" . date("m", strtotime($_GET["dtpDate"])) . "' order by l_date";
    $sql_rst = "select * from ledger where   l_yearfl='0' and (l_flag != 'OPB') AND (l_code = '" . trim($_GET["txtBankCode"]) . "') AND (l_flag1 = 'CRE') AND year(l_date)='" . date("Y", strtotime($_GET["dtpDate"])) . "' and month(l_date) ='" . date("m", strtotime($_GET["dtpDate"])) . "' order by l_date";
    $result_rst = mysql_query($sql_rst, $dbacc);
    while ($row_rst = mysql_fetch_array($result_rst)) {

        if ($row_rst["l_date"] <= $_GET["dtpDate"]) {
            $b_pay = $b_pay + $row_rst["l_amount"];
        }
    }

    $ResponseXML .= "<txtbankpay><![CDATA[" . number_format($b_pay, 2, ".", ",") . "]]></txtbankpay>";

    //$sql_rst="select * from ledger where rights='0' and  l_yearfl='0' and (l_flag != 'OPB') AND (l_code = '" . trim($_GET["txtBankCode"]) . "') AND (l_flag1 = 'DEB') AND year(l_date)='" . date("Y", strtotime($_GET["dtpDate"])) . "' and month(l_date) ='" . date("m", strtotime($_GET["dtpDate"])) . "' order by l_date ";

    $sql_rst = "select * from ledger where  l_yearfl='0' and (l_flag != 'OPB') AND (l_code = '" . trim($_GET["txtBankCode"]) . "') AND (l_flag1 = 'DEB') AND year(l_date)='" . date("Y", strtotime($_GET["dtpDate"])) . "' and month(l_date) ='" . date("m", strtotime($_GET["dtpDate"])) . "' order by l_date ";
    $result_rst = mysql_query($sql_rst, $dbacc);
    while ($row_rst = mysql_fetch_array($result_rst)) {

        if ($row_rst["l_date"] <= $_GET["dtpDate"]) {
            $b_depo = $b_depo + $row_rst["l_amount"];
        }
    }

    $ResponseXML .= "<txtbankdepo><![CDATA[" . number_format($b_depo, 2, ".", ",") . "]]></txtbankdepo>";

    $ResponseXML .= "<txtFinalBal><![CDATA[" . number_format($txtFinalBal, 2, ".", ",") . "]]></txtFinalBal>";


    $sql = "select sum(amt) as tot_deb from tmpbankrecon_deb where chk='1' and user='" . $_SESSION['UserName'] . "'";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    $txtDeb = $row["tot_deb"];


    $sql = "select sum(amt) as tot_cre from tmpbankrecon_cre where chk='1' and user='" . $_SESSION['UserName'] . "'";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    $txtCre = $row["tot_cre"];

    $ResponseXML .= "<txtCre><![CDATA[" . $txtCre . "]]></txtCre>";
    $ResponseXML .= "<txtDeb><![CDATA[" . $txtDeb . "]]></txtDeb>";

    $txt_bankbal = str_replace(",", "", $_GET["txt_bankbal"]);
    $txtclosebal = $txt_bankbal - $b_pay + $b_depo;

    $txtBankClosBal = str_replace(",", "", $_GET["txtBankClosBal"]);
    $txttot = $txtBankClosBal + $txtDeb - $txtCre;

    $ResponseXML .= "<txtclosebal><![CDATA[" . number_format($txtclosebal, 2, ".", ",") . "]]></txtclosebal>";
    $ResponseXML .= "<txttot><![CDATA[" . number_format($txttot, 2, ".", ",") . "]]></txttot>";

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}





if ($_GET["Command"] == "save_customer") {

    $sql = "select * from  dep_mas";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    if (($row["datefrom"] <= $_GET["dtpDate"]) and ($_GET["dtpDate"] <= $row["dateto"])) {
        
    } else {
        exit("Out of Current Accounting Year");
    }


    $sql_rst = "select * from tmpbankrecon_deb where user='" . $_SESSION['UserName'] . "'";

    $result_rst = mysql_query($sql_rst, $dbacc);
    while ($row_rst = mysql_fetch_array($result_rst)) {

        if ($row_rst["chk"] == "1") {
            //$sql="Update ledger set l_month ='" . date("m", strtotime($_GET["dtpDate"])) . "', recdate='" . $row_rst["f"] . "' where id='" . $row_rst["id"] . "' and l_refno='" . trim($row_rst["ref_no"])  . "'";
            $sql = "Update ledger set l_month ='" . date("m", strtotime($_GET["dtpDate"])) . "', recdate='1' where id='" . $row_rst["id"] . "' and l_refno='" . trim($row_rst["ref_no"]) . "'";
            $result = mysql_query($sql, $dbacc);

            $sql = "Update ledger set l_flag2 ='1' where id='" . $row_rst["id"] . "' and l_refno='" . trim($row_rst["ref_no"]) . "'";
            $result = mysql_query($sql, $dbacc);

            $sql = "update op_cheq set recdate='1', recmonth='" . date("m", strtotime($row_rst["trn_date"])) . "'  where id='" . $row_rst["id"] . "' and refno='" . trim($row_rst["ref_no"]) . "'";
            //echo $sql;
            $result = mysql_query($sql, $dbacc);
        } else {

            $sql = "Update ledger set l_month ='0', recdate='0' where id='" . $row_rst["id"] . "' and l_refno='" . trim($row_rst["ref_no"]) . "'";
            $result = mysql_query($sql, $dbacc);

            $sql = "Update ledger set l_flag2 ='0' where id='" . $row_rst["id"] . "' and l_refno='" . trim($row_rst["ref_no"]) . "'";
            $result = mysql_query($sql, $dbacc);

            $sql = "update op_cheq set recdate='0',recmonth='0' where id='" . $row_rst["id"] . "' and refno='" . trim($row_rst["ref_no"]) . "'";
            //echo $sql;
            $result = mysql_query($sql, $dbacc);
        }
    }


    $sql_rst = "select * from tmpbankrecon_cre where user='" . $_SESSION['UserName'] . "'";
    $result_rst = mysql_query($sql_rst, $dbacc);
    while ($row_rst = mysql_fetch_array($result_rst)) {

        if ($row_rst["chk"] == "1") {
            //$sql="Update ledger set l_month ='" . date("m", strtotime($_GET["dtpDate"])) . "', recdate='" . $row_rst["f"] . "' where id='" . $row_rst["id"] . "' and l_refno='" . trim($row_rst["ref_no"])  . "' and l_flag1='CRE' and (chno='" . $row_rst["chq_no"] . "' or l_flag4='CAS')";
            $sql = "Update ledger set l_month ='" . date("m", strtotime($_GET["dtpDate"])) . "', recdate='1' where id='" . $row_rst["id"] . "' and l_refno='" . trim($row_rst["ref_no"]) . "' and l_flag1='CRE' and (chno='" . $row_rst["chq_no"] . "' or l_flag4='CAS')";
            //echo $sql;
            $result = mysql_query($sql, $dbacc);

            $sql = "Update ledger set l_flag2 ='1' where  id='" . $row_rst["id"] . "' and l_refno='" . trim($row_rst["ref_no"]) . "' and (chno='" . $row_rst["chq_no"] . "' or l_flag4='CAS')";
            //echo $sql;
            $result = mysql_query($sql, $dbacc);

            $sql = "update op_cheq set recdate = '1', recmonth = '" . date("m", strtotime($row_rst["trn_date"])) . "'  where  id='" . $row_rst["id"] . "' and  refno = '" . trim($row_rst["ref_no"]) . "' ";
            //echo $sql;
            $result = mysql_query($sql, $dbacc);
        } else {
            $sql = "Update ledger set l_month ='0', recdate='0' where id='" . $row_rst["id"] . "' and l_refno='" . trim($row_rst["ref_no"]) . "' and l_flag1='CRE' and (chno='" . $row_rst["chq_no"] . "' or l_flag4='CAS')";
            //echo $sql;
            $result = mysql_query($sql, $dbacc);

            $sql = "Update ledger set l_flag2 ='0' where  id='" . $row_rst["id"] . "' and l_refno='" . trim($row_rst["ref_no"]) . "' and (chno='" . $row_rst["chq_no"] . "' or l_flag4='CAS')";
            //echo $sql;
            $result = mysql_query($sql, $dbacc);

            $sql = "update op_cheq set recdate='0', recmonth='0'  where   id='" . $row_rst["id"] . "' and refno='" . trim($row_rst["ref_no"]) . "'";
            //echo $sql;
            $result = mysql_query($sql, $dbacc);
        }
    }

    echo "Saved";
}

if ($_GET["Command"] == "update_customer") {

    $sql = "select * from  dep_mas";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    if (($row["datefrom"] <= $_GET["dtpDate"]) and ($_GET["dtpDate"] <= $row["dateto"])) {
        
    } else {
        exit("Out of Current Accounting Year");
    }

    $sql = "delete from  bank_bal where code = '" . trim($_GET["txtBankCode"]) . "' and bdate = '" . $_GET["dtpDate"] . "'";
    $result = mysql_query($sql, $dbacc);

    $sql = "select * from  bankmaster where bm_code = '" . trim($_GET["txtBankCode"]) . "'";
    $result = mysql_query($sql, $dbacc);
    $row_rst = mysql_fetch_array($result);

    $txt_bankbal = str_replace(",", "", $_GET["txt_bankbal"]);
    $txtclosebal = str_replace(",", "", $_GET["txtclosebal"]);

    $sql = "Insert into bank_bal(code, bank, bdate, open_balance, close_balance, bmonth, byear) Values ('" . trim($_GET["txtBankCode"]) . "', '" . trim($row_rst["bm_bank"]) . "', '" . $_GET["dtpDate"] . "', " . $txt_bankbal . ", " . $txtclosebal . ", '" . date("m", strtotime($_GET["dtpDate"])) . "', '" . date("Y", strtotime($_GET["dtpDate"])) . "')";
    $result = mysql_query($sql, $dbacc);
    // echo $sql;  

    $sql = "select * from  ledger where l_code = '" . $_GET["txtBankCode"] . "' and l_date>='" . $_GET["dtfrom"] . "' and l_date<='" . $_GET["dtpDate"] . "' and recdate='1'";
    $result = mysql_query($sql, $dbacc);
    while ($row_rst = mysql_fetch_array($result)) {
        $sql1 = "update ledger set lock1='1' where l_refno='" . $row_rst["l_refno"] . "'";
        $result1 = mysql_query($sql1, $dbacc);
    }

    $sql_rec = "select * from lock_bank_rec where bank_code = '" . $_GET["txtBankCode"] . "'";
    $result_rec = mysql_query($sql_rec, $dbacc);
    if ($row_rec = mysql_fetch_array($result_rec)) {
        $sql = "update lock_bank_rec set lock_date_from='" . $_GET["dtfrom"] . "', lock_date_to='" . $_GET["dtpDate"] . "' where bank_code= '" . $_GET["txtBankCode"] . "'";
        $result = mysql_query($sql, $dbacc);
    } else {
        $sql = "insert into lock_bank_rec (bank_code, lock_date_from, lock_date_to) values ('" . $_GET["txtBankCode"] . "', '" . $_GET["dtfrom"] . "', '" . $_GET["dtpDate"] . "')";
        $result = mysql_query($sql, $dbacc);
    }
    echo "Updated";
}


if ($_GET["Command"] == "new_inv") {

    $_SESSION["print"] = 0;
    $_SESSION["save_sales_inv"] = 1;
    /* 	$sql="Select CAS_INV_NO_m from invpara";
      $result =$db->RunQuery($sql);
      $row = mysql_fetch_array($result);
      $tmpinvno="000000".$row["CAS_INV_NO_m"];
      $lenth=strlen($tmpinvno);
      $invno="INV".substr($tmpinvno, $lenth-7);
      echo $invno; */

    /* 	$sql="Select SPINV, CRE_INV_NO, CAS_INV_NO from invpara";
      $result =$db->RunQuery($sql);
      $row = mysql_fetch_array($result);
      $tmpinvno="000000".$row["CAS_INV_NO_m"];
      $lenth=strlen($tmpinvno);
      //echo $tmpinvno;
      $invno=trim("CRI/ ").substr($tmpinvno, $lenth-7);
      $_SESSION["invno"]=$invno; */

    $_SESSION["brand"] = "";

    $sql = "Select SPINV from tmpinvpara";
    $result = $db->RunQuery($sql);
    $row = mysql_fetch_array($result);
    $_SESSION["tmp_no_salinv"] = "CRI/" . $row["SPINV"];
    //echo $_SESSION["tmp_no_salinv"];
    $sql = "delete from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "'";
    $result = $db->RunQuery($sql);

    $sql = "update tmpinvpara set SPINV=SPINV+1";
    $result = $db->RunQuery($sql);





    $sql = "Select SPINV, CRE_INV_NO, CAS_INV_NO from invpara";
    $result = $db->RunQuery($sql);
    $row = mysql_fetch_array($result);
    if ($_SESSION['dev'] == "1") {

        $tmpinvno = "000000" . ($row["SPINV"] + 1);
        $lenth = strlen($tmpinvno);

        $invno = trim("CRI/ ") . substr($tmpinvno, $lenth - 7) . "/5";
        $_SESSION["invno"] = $invno;
        $txtdono = $row["CAS_INV_NO"] + 1;
    } else {

        $tmpinvno = "000000" . ($row["SPINV"] + 1);
        $lenth = strlen($tmpinvno);

        $invno = trim("CRI/ ") . substr($tmpinvno, $lenth - 7) . "/" . $_GET["salesrep"];
        $_SESSION["invno"] = $invno;
        $txtdono = $row["CRE_INV_NO"] + 1;
    }

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
    $ResponseXML .= "<txtdono><![CDATA[" . $txtdono . "]]></txtdono>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "cancel_inv") {
    $sql = "select last_update from invpara";
    $result = $db->RunQuery($sql);
    $row = mysql_fetch_array($result);

    $sqlinv = "select * from s_salma where REF_NO='" . $_GET["invno"] . "' ";
    $resultinv = $db->RunQuery($sqlinv);
    if ($rowinv = mysql_fetch_array($resultinv)) {
        if (($rowinv["TOTPAY"] == 0) and ($rowinv["SDATE"] > $row["last_update"])) {
            $sql2 = "update s_salma set CANCELL='1' where REF_NO='" . $_GET["invno"] . "'";
            $result2 = $db->RunQuery($sql2);

            $sql2 = "update vendor set CUR_BAL=CUR_BAL-" . $rowinv["GRAND_TOT"] . " where CODE='" . $_GET["customer_code"] . "'";
            $result2 = $db->RunQuery($sql2);

            $sql2 = "update br_trn set credit=credit-" . $rowinv["GRAND_TOT"] . " where CODE='" . $_GET["customer_code"] . "' and cus_code='" . $_GET["customer_code"] . "' and Rep='" . $_GET["salesrep"] . "'";
            $result2 = $db->RunQuery($sql2);

            $sqltmp = "select * from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "' ";
            $resulttmp = $db->RunQuery($sqltmp);
            while ($rowtmp = mysql_fetch_array($resulttmp)) {
                $sql2 = "update s_invo set CANCELL='1' where REF_NO='" . $_GET['invno'] . "'";
                $resul2 = $db->RunQuery($sql2);

                $sql2 = "update s_mas set QTYINHAND=QTYINHAND+" . $rowtmp["cur_qty"] . " where STK_NO='" . $rowtmp['str_code'] . "'";
                $resul2 = $db->RunQuery($sql2);

                $sql2 = "update s_submas set QTYINHAND=QTYINHAND+" . $rowtmp["cur_qty"] . " where STO_CODE='" . $_GET['department'] . "' and STK_NO='" . $rowtmp['str_code'] . "'";
                $resul2 = $db->RunQuery($sql2);

                $sql2 = "delete from s_trn where REFNO='" . $_GET['invno'] . "'";
                $resul2 = $db->RunQuery($sql2);

                $sql2 = "delete from s_led where REF_NO='" . $_GET['invno'] . "'";
                $resul2 = $db->RunQuery($sql2);
            }
            echo "Canceled";
        } else {
            echo "Can't Cancel";
        }
    }
}


if ($_GET["Command"] == "chk_ad") {
    if ($_GET["chk"] == "false") {
        $chk = 0;
    } else {
        $chk = 1;
    }
    $sql = "update tmp_inv_data set ad='" . $chk . "' where id=" . $_GET["id"] . " and str_code='" . $_GET['itemcode'] . "' and tmp_no= '" . $_SESSION["tmp_no_salinv"] . "'";
    echo $sql;
    $result = $db->RunQuery($sql);
}


if ($_GET["Command"] == "add_tmp") {

    $department = $_GET["department"];

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    //echo $_SESSION["tmp_no_salinv"];
    //$sql="delete from tmp_inv_data where str_code='".$_GET['itemcode']."' and tmp_no='".$_SESSION["tmp_no_salinv"]."' ";
    //$ResponseXML .= $sql;
    //$result =$db->RunQuery($sql);
    //echo $_GET['rate'];
    //echo $_GET['qty'];
    $rate = str_replace(",", "", $_GET["rate"]);
    $actual_selling = str_replace(",", "", $_GET["actual_selling"]);

    $qty = str_replace(",", "", $_GET["qty"]);
    $discount = str_replace(",", "", $_GET["discount"]);
    $subtotal = str_replace(",", "", $_GET["subtotal"]);

    if ($_GET['ad'] == "true") {
        $ad = "1";
    } else {
        $ad = "0";
    }
    $sql = "Insert into tmp_inv_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, actual_selling, brand, tmp_no)values 
			('" . $_GET['invno'] . "', '" . $_GET['itemcode'] . "', '" . $_GET['item'] . "', " . $rate . ", " . $qty . ", " . $_GET["discountper"] . ", " . $discount . ", " . $subtotal . ", " . $actual_selling . ", '" . $_GET['brand'] . "', '" . $_SESSION["tmp_no_salinv"] . "') ";
    //$ResponseXML .= $sql;
    $result = $db->RunQuery($sql);


    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"0\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"></font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\"></font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">AD</font></td>
							  
                            </tr>";

    $i = 1;
    $sql = "Select * from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "'";
    $result = $db->RunQuery($sql);
    while ($row = mysql_fetch_array($result)) {

        $id = "id" . $i;
        $code = "code" . $i;
        $itemd = "itemd" . $i;
        $rate = "rate" . $i;
        $actual_selling = "actual_selling" . $i;
        $qty = "qty" . $i;
        $discountper = "discountper" . $i;
        $subtotal = "subtotal" . $i;
        $discount = "discount" . $i;
        $ad = "ad" . $i;

        $ResponseXML .= "<tr>                              
                             <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $id . "'>" . $row['id'] . "</div></td>
							 <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $code . "'>" . $row['str_code'] . "</div></td>
							 <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $itemd . "'>" . $row['str_description'] . "</div></td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $rate . "\" id=\"" . $rate . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" /></td>
							  <td align=right ><input type=\"text\"  class=\"text_purchase3\" name=\"" . $actual_selling . "\" id=\"" . $actual_selling . "\" size=\"15\"  value=\"" . number_format($row['actual_selling'], 2, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"   /></td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $qty . "\" id=\"" . $qty . "\" size=\"15\"  value=\"" . number_format($row['cur_qty'], 0, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" />    </td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $discountper . "'>" . number_format($_GET["discountper"], 6, ".", ",") . "</div><input type=\"hidden\"  class=\"text_purchase3\" name=\"" . $discount . "\" id=\"" . $discount . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"    /></td>
							 
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $subtotal . "'>" . number_format($row['cur_subtot'], 2, ".", ",") . "</div></td>
							 <td><input type=\"checkbox\" onClick=\"chk_ad('" . $i . "');\" name='" . $ad . "' id='" . $ad . "'></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>
							 
							
						
							
							 
                            </tr>";
        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";

    $sql = "Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "'";
    $result = $db->RunQuery($sql);
    $row = mysql_fetch_array($result);
    $ResponseXML .= "<subtot><![CDATA[" . number_format($row['tot_sub'], 2, ".", ",") . "]]></subtot>";
    $ResponseXML .= "<tot_dis><![CDATA[" . number_format($row['tot_dis'], 2, ".", ",") . "]]></tot_dis>";

    $vatrate = 0.12;

    if ($_GET["vatmethod"] == "vat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "svat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "evat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "non") {
        //$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
        $ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";

        $invtot = number_format($row['tot_sub'], 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    }

    $ResponseXML .= " </salesdetails>";

    //	}	


    echo $ResponseXML;
}


if ($_GET["Command"] == "add_tmp_edit_rate") {

    $department = $_GET["department"];

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_inv_data where str_code='" . $_GET['itemcode'] . "' and tmp_no='" . $_SESSION["tmp_no_salinv"] . "' ";
    //$ResponseXML .= $sql;
    $result = $db->RunQuery($sql);

    //echo $_GET['rate'];
    //echo $_GET['qty'];
    $rate = str_replace(",", "", $_GET["rate"]);
    $qty = str_replace(",", "", $_GET["qty"]);
    $discount = str_replace(",", "", $_GET["discount"]);
    $subtotal = str_replace(",", "", $_GET["subtotal"]);

    $sql = "Insert into tmp_inv_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand, tmp_no)values 
			('" . $_GET['invno'] . "', '" . $_GET['itemcode'] . "', '" . $_GET['item'] . "', " . $rate . ", " . $qty . ", " . $_GET["discountper"] . ", " . $discount . ", " . $subtotal . ", '" . $_GET['brand'] . "', '" . $_SESSION["tmp_no_salinv"] . "') ";
    //echo $sql;
    $result = $db->RunQuery($sql);


    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  
                            </tr>";

    $i = 1;
    $sql = "Select * from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "' order by str_code";
    $result = $db->RunQuery($sql);
    while ($row = mysql_fetch_array($result)) {

        $code = "code" . $i;
        $itemd = "itemd" . $i;
        $rate = "rate" . $i;
        $qty = "qty" . $i;
        $discountper = "discountper" . $i;
        $subtotal = "subtotal" . $i;
        $discount = "discount" . $i;

        $ResponseXML .= "<tr>                              
                             <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $code . "'>" . $row['str_code'] . "</div></td>
							 <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $itemd . "'>" . $row['str_description'] . "</div></td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $rate . "\" id=\"" . $rate . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" /></td>
							  <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $qty . "\" id=\"" . $qty . "\" size=\"15\"  value=\"" . number_format($row['cur_qty'], 0, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" />    </td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $discountper . "'>" . number_format($_GET["discountper"], 6, ".", ",") . "</div><input type=\"hidden\"  class=\"text_purchase3\" name=\"" . $discount . "\" id=\"" . $discount . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"    /></td>
							 
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $subtotal . "'>" . number_format($row['cur_subtot'], 2, ".", ",") . "</div></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>
							 
							
						
							
							 
                            </tr>";
        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";

    $sql = "Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "'";
    $result = $db->RunQuery($sql);
    $row = mysql_fetch_array($result);
    $ResponseXML .= "<subtot><![CDATA[" . number_format($row['tot_sub'], 2, ".", ",") . "]]></subtot>";
    $ResponseXML .= "<tot_dis><![CDATA[" . number_format($row['tot_dis'], 2, ".", ",") . "]]></tot_dis>";

    $vatrate = 0.12;

    if ($_GET["vatmethod"] == "vat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "svat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "evat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "non") {
        //$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
        $ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";

        $invtot = number_format($row['tot_sub'], 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    }

    $ResponseXML .= " </salesdetails>";

    //	}	


    echo $ResponseXML;
}



if ($_GET["Command"] == "add_tmp_edit_discount") {

    $department = $_GET["department"];

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "' ";
    //$ResponseXML .= $sql;
    $result = $db->RunQuery($sql);

    //echo $_GET['rate'];
    //echo $_GET['qty'];
    //echo "count :".$_GET["item_count"];
    $i = 1;
    while ($_GET["item_count"] > $i) {


        $code = "code" . $i;
        $itemd = "itemd" . $i;
        $discountper = "discountper" . $i;
        $srate = "rate" . $i;
        $rate = str_replace(",", "", $_GET[$srate]);

        $sactual_selling = "actual_selling" . $i;
        $actual_selling = str_replace(",", "", $_GET[$sactual_selling]);

        $sqty = "qty" . $i;
        $qty = str_replace(",", "", $_GET[$sqty]);
        $sdiscount = "discount" . $i;
        $discount = str_replace(",", "", $_GET[$sdiscount]);
        $ssubtotal = "subtotal" . $i;
        $subtotal = str_replace(",", "", $_GET[$ssubtotal]);

        $sql = "Insert into tmp_inv_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand, actual_selling, tmp_no)values 
			('" . $_GET['invno'] . "', '" . $_GET[$code] . "', '" . $_GET[$itemd] . "', " . $rate . ", " . $qty . ", " . $_GET[$discountper] . ", " . $discount . ", " . $subtotal . ", '" . $_GET['brand'] . "', '" . $actual_selling . "', '" . $_SESSION["tmp_no_salinv"] . "') ";
        //echo $sql;
        $result = $db->RunQuery($sql);
        $i = $i + 1;
    }
    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
							  <td width=\"0\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\"></font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  
                            </tr>";

    $i = 1;
    $sql = "Select * from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "'";
    $result = $db->RunQuery($sql);
    while ($row = mysql_fetch_array($result)) {

        $code = "code" . $i;
        $itemd = "itemd" . $i;
        $rate = "rate" . $i;
        $actual_selling = "actual_selling" . $i;
        $qty = "qty" . $i;
        $discountper = "discountper" . $i;
        $subtotal = "subtotal" . $i;
        $discount = "discount" . $i;

        $ResponseXML .= "<tr>                              
                             <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $code . "'>" . $row['str_code'] . "</div></td>
							 <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $itemd . "'>" . $row['str_description'] . "</div></td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $rate . "\" id=\"" . $rate . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" /></td>
							 <td align=right ><input type=\"hidden\"  class=\"text_purchase3\" name=\"" . $actual_selling . "\" id=\"" . $actual_selling . "\" size=\"15\"  value=\"" . number_format($row['actual_selling'], 2, ".", ",") . "\"   /></td>
							  <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $qty . "\" id=\"" . $qty . "\" size=\"15\"  value=\"" . number_format($row['cur_qty'], 0, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" />    </td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $discountper . "'>" . number_format($row["dis_per"], 6, ".", ",") . "</div><input type=\"hidden\"  class=\"text_purchase3\" name=\"" . $discount . "\" id=\"" . $discount . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"    /></td>
							 
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $subtotal . "'>" . number_format($row['cur_subtot'], 2, ".", ",") . "</div></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>
							 
							
						
							
							 
                            </tr>";
        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";

    $sql = "Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "'";
    $result = $db->RunQuery($sql);
    $row = mysql_fetch_array($result);
    $ResponseXML .= "<subtot><![CDATA[" . number_format($row['tot_sub'], 2, ".", ",") . "]]></subtot>";
    $ResponseXML .= "<tot_dis><![CDATA[" . number_format($row['tot_dis'], 2, ".", ",") . "]]></tot_dis>";

    $vatrate = 0.12;

    if ($_GET["vatmethod"] == "vat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "svat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "evat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "non") {
        //$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
        $ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";

        $invtot = number_format($row['tot_sub'], 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    }

    $ResponseXML .= " </salesdetails>";

    //	}	


    echo $ResponseXML;
}

if ($_GET["Command"] == "disp_qty") {
    include_once("connection.php");

    $sqlqty = mysql_query("select QTYINHAND from s_submas where STK_NO='" . $_GET["it_code"] . "' AND STO_CODE='" . $_GET["department"] . "'") or die(mysql_error());
    if ($rowqty = mysql_fetch_array($sqlqty)) {
        $qty = $rowqty['QTYINHAND'];
    } else {
        $qty = 0;
    }
    echo $qty;
}

if ($_GET["Command"] == "setord") {

    include_once("connection.php");



    $len = strlen($_GET["salesord1"]);
    $need = substr($_GET["salesord1"], $len - 7, $len);
    $salesord1 = trim("ORD/ ") . $_GET["salesrep"] . trim(" / ") . $need;

    $sql = mysql_query("Select SPINV, CRE_INV_NO, CAS_INV_NO from invpara") or die(mysql_error());
    $row = mysql_fetch_array($sql);
    if ($_SESSION['dev'] == "1") {

        $tmpinvno = "000000" . ($row["SPINV"] + 1);
        $lenth = strlen($tmpinvno);

        $invno = trim("CRI/ ") . substr($tmpinvno, $lenth - 7) . "/5";
        $_SESSION["invno"] = $invno;
        $txtdono = $row["CAS_INV_NO"] + 1;
    } else {

        $tmpinvno = "000000" . ($row["SPINV"] + 1);
        $lenth = strlen($tmpinvno);

        $invno = trim("CRI/ ") . substr($tmpinvno, $lenth - 7) . "/" . $_GET["salesrep"];
        $_SESSION["invno"] = $invno;
        $txtdono = $row["CRE_INV_NO"] + 1;
    }


    $_SESSION["custno"] = $_GET['custno'];
    $_SESSION["brand"] = $_GET["brand"];
    $_SESSION["department"] = $_GET["department"];



    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
    $ResponseXML .= "<txtdono><![CDATA[" . $txtdono . "]]></txtdono>";

    $cuscode = $_GET["custno"];
    $salesrep = $_GET["salesrep"];
    $brand = $_GET["brand"];

    //		$ResponseXML .= "<salesord><![CDATA[".$salesord1."]]></salesord>";
    //Call SETLIMIT ====================================================================



    /* 	$sql = mysql_query("DROP VIEW view_s_salma") or die(mysql_error());
      $sql = mysql_query("CREATE VIEW view_s_salma
      AS
      SELECT     s_salma.*, brand_mas.class AS class
      FROM         brand_mas RIGHT OUTER JOIN
      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysql_error()); */

    $OutpDAMT = 0;
    $OutREtAmt = 0;
    $OutInvAmt = 0;
    $InvClass = "";

    $sqlclass = mysql_query("select class from brand_mas where barnd_name='" . trim($brand) . "'") or die(mysql_error());
    if ($rowclass = mysql_fetch_array($sqlclass)) {
        if (is_null($rowclass["class"]) == false) {
            $InvClass = $rowclass["class"];
        }
    }

    $sqloutinv = mysql_query("select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='" . trim($cuscode) . "' and SAL_EX='" . trim($salesrep) . "' and class='" . $InvClass . "'") or die(mysql_error());
    if ($rowoutinv = mysql_fetch_array($sqloutinv)) {
        if (is_null($rowoutinv["totout"]) == false) {
            $OutInvAmt = $rowoutinv["totout"];
        }
    }

    $sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'" . date("Y-m-d") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='REC' and sal_ex='" . trim($salesrep) . "'") or die(mysql_error());
    while ($rowinvcheq = mysql_fetch_array($sqlinvcheq)) {

        $sqlsttr = mysql_query("select * from s_sttr where ST_REFNO='" . trim($rowinvcheq["refno"]) . "' and ST_CHNO ='" . trim($rowinvcheq["cheque_no"]) . "'") or die(mysql_error());
        while ($rowsttr = mysql_fetch_array($sqlsttr)) {
            $sqlview_s_salma = mysql_query("select class from view_s_salma where REF_NO='" . trim($rowsttr["ST_INVONO"]) . "'") or die(mysql_error());
            if ($rowview_s_salma = mysql_fetch_array($sqlview_s_salma)) {

                if (trim($rowview_s_salma["class"]) == $InvClass) {
                    $OutpDAMT = $OutpDAMT + $rowsttr["ST_PAID"];
                }
            }
        }
    }



    $pend_ret_set = 0;

    $sqlinvcheq = mysql_query("SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'" . date("Y-m-d") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='RET'") or die(mysql_error());
    if ($rowinvcheq = mysql_fetch_array($sqlinvcheq)) {
        if (is_null($rowinvcheq["che_amount"]) == false) {
            $pend_ret_set = $rowinvcheq["che_amount"];
        }
    }


    $sqlcheq = mysql_query("Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='" . trim($salesrep) . "'") or die(mysql_error());
    if ($rowcheq = mysql_fetch_array($sqlcheq)) {
        if (is_null($rowcheq["tot"]) == false) {
            $OutREtAmt = $rowcheq["tot"];
        } else {
            $OutREtAmt = 0;
        }
    }





    $ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutREtAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutpDAMT, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt + $OutREtAmt + $OutpDAMT + $pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table_acc>";




    $sqlbr_trn = mysql_query("select * from br_trn where Rep='" . trim($salesrep) . "' and brand='" . trim($InvClass) . "' and cus_code='" . trim($cuscode) . "'") or die(mysql_error());
    if ($rowbr_trn = mysql_fetch_array($sqlbr_trn)) {

        if (is_null($rowbr_trn["credit_lim"]) == false) {
            $crLmt = $rowbr_trn["credit_lim"];
        } else {
            $crLmt = 0;
        }


        if (is_null($rowbr_trn["tmpLmt"]) == false) {
            $tmpLmt = $rowbr_trn["tmpLmt"];
        } else {
            $tmpLmt = 0;
        }

        if (is_null($rowbr_trn["CAT"]) == false) {
            $cuscat = trim($rowbr_trn["CAT"]);
            if ($cuscat == "A") {
                $m = 2.5;
            }
            if ($cuscat == "B") {
                $m = 2.5;
            }
            if ($cuscat == "C") {
                $m = 1;
            }
            if ($cuscat == "D") {
                $m = 0;
            }

            $txt_crelimi = 0;
            $txt_crebal = 0;
            $txt_crelimi = number_format($crLmt, 2, ".", ",");
            //$crebal=$crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            $txt_crebal = $crLmt * $m - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            $crebal = $crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;


            //$txt_crebal = number_format($crebal, "2", ".", ",");
        } else {
            $txt_crelimi = 0;
            $txt_crebal = 0;
        }
        $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;
    }
    $ResponseXML .= "<txt_crelimi><![CDATA[" . $txt_crelimi . "]]></txt_crelimi>";
    $ResponseXML .= "<txt_crebal><![CDATA[" . number_format($txt_crebal, "2", ".", ",") . "]]></txt_crebal>";

    $ResponseXML .= "<creditbalance><![CDATA[" . number_format($txt_crebal, "2", ".", ",") . "]]></creditbalance>";



    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "del_item") {


    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_inv_data where str_code='" . $_GET['code'] . "' and str_invno='" . $_GET['invno'] . "' ";

    $result = $db->RunQuery($sql);

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";


    $sql = "Select * from tmp_inv_data where str_invno='" . $_GET['invno'] . "'";
    $result = $db->RunQuery($sql);
    while ($row = mysql_fetch_array($result)) {
        $ResponseXML .= "<tr>
                              
                             <td >" . $row['str_code'] . "</a></td>
							 <td>" . $row['str_description'] . "</a></td>
							 <td >" . $row['cur_rate'] . "</a></td>
							 <td  >" . $row['cur_qty'] . "</a></td>
							 <td  >" . $row['cur_discount'] . "</a></td>
							 <td  >" . $row['cur_subtot'] . "</a></td>
							 <td  ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>";

        include_once("connection.php");

        $sqlqty = mysql_query("select QTYINHAND from s_submas where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $_GET["department"] . "'") or die(mysql_error());
        if ($rowqty = mysql_fetch_array($sqlqty)) {
            $qty = $rowqty['QTYINHAND'];
        } else {
            $qty = 0;
        }

        $ResponseXML .= "<td  >" . $qty . "</a></td>
                            </tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $sql = "Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_inv_data where str_invno='" . $_GET['invno'] . "'";
    $result = $db->RunQuery($sql);
    $row = mysql_fetch_array($result);
    $ResponseXML .= "<subtot><![CDATA[" . number_format($row['tot_sub'], 2, ".", ",") . "]]></subtot>";
    $ResponseXML .= "<tot_dis><![CDATA[" . number_format($row['tot_dis'], 2, ".", ",") . "]]></tot_dis>";

    $vatrate = 0.12;

    if ($_GET["vatmethod"] == "vat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "svat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "evat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "non") {
        //$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
        $ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";

        $invtot = number_format($row['tot_sub'], 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    }

    $ResponseXML .= " </salesdetails>";


    //	}	


    echo $ResponseXML;
}



if ($_GET["Command"] == "save_item") {

    //include_once("connection.php");
    //	$_SESSION["CURRENT_DOC"] = 1;      //document ID
    //	$_SESSION["VIEW_DOC"] = false ;     //view current document
    //	$_SESSION["FEED_DOC"] = true;       //save  current document
    //	$_GET["MOD_DOC"] = false  ;         //delete   current document
    //	$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
    //	$_GET["PRICE_EDIT"] = false ;       //edit selling price
    //	$_GET["CHECK_USER"] = false ;       //check user permission again


    if ($_SESSION["save_sales_inv"] == 1) {
        $_SESSION["brand"] = "";

        $insuf_qty = "";
        $sqltmp1 = "select * from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "'";
        $resulttmp1 = $db->RunQuery($sqltmp1);
        while ($rowtmp1 = mysql_fetch_array($resulttmp1)) {
            $sqlqty1 = "select QTYINHAND from s_submas where STK_NO='" . $rowtmp1['str_code'] . "' AND STO_CODE='" . $_GET["department"] . "'";
            $resultqty1 = $db->RunQuery($sqlqty1);
            //	 $sqlqty1 = mysql_query("select QTYINHAND from s_submas where STK_NO='".$rowtmp1['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysql_error());
            if ($rowqty1 = mysql_fetch_array($resultqty1)) {
                if ($rowqty1["QTYINHAND"] < $rowtmp1["cur_qty"]) {
                    $insuf_qty = $rowtmp1['str_code'];
                }
            }
        }


        if ($insuf_qty == "") {

            $ResponseXML .= "";
            $ResponseXML .= "<salesdetails>";


            $sql = "Select SPINV, CRE_INV_NO, CAS_INV_NO from invpara";
            $result = $db->RunQuery($sql);
            $row = mysql_fetch_array($result);
            if ($_SESSION['dev'] == "1") {

                $tmpinvno = "000000" . ($row["SPINV"] + 1);
                $lenth = strlen($tmpinvno);

                $invno = trim("CRI/ ") . substr($tmpinvno, $lenth - 7) . "/5";
                $_SESSION["invno"] = $invno;
                $txtdono = $row["CAS_INV_NO"] + 1;
            } else {

                $tmpinvno = "000000" . ($row["SPINV"] + 1);
                $lenth = strlen($tmpinvno);

                $invno = trim("CRI/ ") . substr($tmpinvno, $lenth - 7) . "/" . $_GET["salesrep"];
                $_SESSION["invno"] = $invno;
                $txtdono = $row["CRE_INV_NO"] + 1;
            }


            $sql = "delete from s_salma where REF_NO='" . $invno . "' ";
            $result = $db->RunQuery($sql);


            $cre_balance = str_replace(",", "", $_GET["balance"]);
            $totdiscount = str_replace(",", "", $_GET["totdiscount"]);
            $subtot = str_replace(",", "", $_GET["subtot"]);
            $invtot = str_replace(",", "", $_GET["invtot"]);
            $tax = str_replace(",", "", $_GET["tax"]);

            // Insert s_salma ============================================================ 

            $sql = "select * from vendor where CODE = '" . trim($_GET["customercode"]) . "'";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                if ($row["blacklist"] == "1") {
                    $sqlapp = "select * from s_cusordmas where ref_no='" . trim($_GET["salesord1"]) . "'";
                    $resultapp = $db->RunQuery($sqlapp);
                    if ($rowapp = mysql_fetch_array($resultapp)) {
                        if ($rowapp["approveby"] == "0") {
                            exit("Invoice Facilitey Stoped for This Customer,Please Invoice For Approved Sales Order");
                        } else {
                            exit("Invoice Facilitey Stoped for This Customer,Please Invoice For Approved Sales Order");
                        }
                        $_SESSION["print"] = 0;
                    }
                }
            }



///////////////////////////   Call checkcreditlimit

            if (trim($_GET["customercode"]) != "") {
                if (cuscat == "A") {
                    if ($invtot > $cre_balance) {
                        $ResponseXML .= "<msg_crelimi><![CDATA[Credit Limit Exceed]]></msg_crelimi>";
                    }
                }

                if (cuscat == "B") {
                    if ($invtot > $cre_balance) {
                        $ResponseXML .= "<msg_crelimi><![CDATA[Credit Limit Exceed]]></msg_crelimi>";
                    }
                }

                if (cuscat == "C") {
                    if ($invtot > $cre_balance) {
                        $ResponseXML .= "<msg_crelimi><![CDATA[Credit Limit Exceed]]></msg_crelimi>";
                    }
                }

                if (cuscat == "D") {
                    $ResponseXML .= "<msg_crelimi><![CDATA[Customer Deleted]]></msg_crelimi>";
                }

                if ((cuscat != "D") and (cuscat != "A") and (cuscat != "B") and (cuscat != "C")) {
                    $ResponseXML .= "<msg_crelimi><![CDATA[Customer Catogory Not Entered]]></msg_crelimi>";
                }
            } else {
                $ResponseXML .= "<msg_crelimi><![CDATA[no]]></msg_crelimi>";
            }


//====================================== End Checking credit limit



            /*
              Dim rst As New ADODB.Recordset
              rst.Open "SELECT REF_NO FROM S_SALMA WHERE REF_NO='" & Trim(txt_invno) & "'", dnINV.Coninv

              If SAVEOK = False Then
              m_ok = ""
              If txt_cuscode = "" Then m_ok = "Customer Not Selected"
              If Me.txt_stat <> "NEW" Then m_ok = "Invalid Option"
              If Me.txt_ordno = "" Then m_ok = "Enter Order No"
              If cmbbrand = "" Then m_ok = "Select Brand name"
              If Not rst.EOF Then m_ok = "Invoice No Already exists"
              rst.Close
              Set rst = Nothing
              If m_ok <> "" Then
              MsgBox m_ok
              Else
              dnINV.Coninv.BeginTrans
              dnINV.Coninv.Execute "update vendor set Over_DUE_IG_Date='" & Date - 1 & "'  where code='" & Trim(txt_cuscode) & "' " */


//==============================================================



            $sql = "select * from s_salma_order where REF_NO= '" . trim($_GET["salesord1"]) . "'";

            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                $sqlord = "UPDATE s_salma_order SET CANCELL='1' WHERE (((REF_NO)='" . trim($_GET["salesord1"]) . "'))";
                $resultord = $db->RunQuery($sqlord);

                $sqltmp = "select * from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "'";
                $resulttmp = $db->RunQuery($sqltmp);
                while ($rowtmp = mysql_fetch_array($resulttmp)) {
                    $sqlinord = "update s_mas set QTYINHAND= QTYINHAND+" . $_GET["cur_qty"] . " where STK_NO='" . $rowtmp["str_code"] . "'";
                    $resultinord = $db->RunQuery($sqlinord);

                    $sqlinord = "update s_submas set QTYINHAND= QTYINHAND+" . $_GET["cur_qty"] . " where sto_code= '" . $_GET["department"] . "' and stk_no= '" . $rowtmp["str_code"] . "'";
                    $resultinord = $db->RunQuery($sqlinord);
                }

                $sqlinord = "delete  from s_led where REF_NO='" . trim($_GET["salesord1"]) & "'";
                $resultinord = $db->RunQuery($sqlinord);
            }

            //============
            $vat = "";
            if (($_GET["vatmethod"] == "vat") or ($_GET["vatmethod"] == "svat") or ($_GET["vatmethod"] == "evat")) {
                $vat = "1";
            } else {
                $vat = "0";
            }



//    totpay = Val(Format(txt_chetot, General)) + Val(Format(txt_cash, General))
            $svat = 0;
            if ($_GET["vatmethod"] == "svat") {
                $svat = $_GET["tax"];
            }



            /*   REFNO = Trim(txt_invno)
              xx = getauth(CURRENT_DOC, VIEW_DOC, FEED_DOC, MOD_DOC, PRINT_DOC, PRICE_EDIT, CHECK_USER, REFNO)
              If Not AUTH_OK Then Exit Sub */


            //================discount


            $d1 = str_replace(",", "", $_GET["discount1"]);
            $d2 = str_replace(",", "", $_GET["discount2"]);
            $d3 = str_replace(",", "", $_GET["discount3"]);

            if ($d1 == "") {
                $d1 = 0;
            }
            if ($d2 == "") {
                $d2 = 0;
            }
            if ($d3 == "") {
                $d3 = 0;
            }


            $d = 100 - (100 - $d3) * (100 - $d2) * (100 - $d1) / 100;
            //===============================================

            $cre_balance = str_replace(",", "", $_GET["balance"]);
            $totdiscount = str_replace(",", "", $_GET["totdiscount"]);
            $subtot = str_replace(",", "", $_GET["subtot"]);
            $invtot = str_replace(",", "", $_GET["invtot"]);
            $tax = str_replace(",", "", $_GET["tax"]);

            $mvatrate = 12;
            //if ($_GET["brand"]=="TRANSKING" and $d > 35){
            $sqlcus = "select * from vendor where CODE='" . trim($_GET["customercode"]) . "'";
            $resultcus = $db->RunQuery($sqlcus);
            $rowcus = mysql_fetch_array($resultcus);

            $sqlisalma = "Insert into s_salma  (REF_NO, TRN_TYPE, SDATE, C_CODE, Brand, CUS_NAME, VAT, VAT_VAL, TYPE, DISCOU, AMOUNT, GRAND_TOT,  TOTPAY, ORD_NO, ORD_DA,  DEPARTMENT, SAL_EX, BTT, cre_pe, GST, DIS, DIS1, DIS2, SVAT, Account, TOTPAY1, REMARK, REQ_DATE, CANCELL, DEV, tmp_no, DIS_RUP, CASH, SETTLED, DES_CAT, Accname, Costcenter, RET_AMO, Comm, red, seri_no, points, LOCK1, deliin) values('" . $invno . "', 'INV', '" . $_GET["invdate"] . "', '" . trim($_GET["customercode"]) . "', '" . trim($_GET["brand"]) . "', '" . trim($rowcus["NAME"]) . "','" . $vat . "', " . $tax . ", '" . $_GET["paymethod"] . "'," . $totdiscount . ", " . $subtot . " , " . $invtot . ", 0, '" . trim($_GET["salesord1"]) . "', '" . $_GET["deldate"] . "', '" . trim($_GET["department"]) . "', '" . trim($_GET["salesrep"]) . "', " . $tax . ", " . $_GET["credper"] . " , " . $mvatrate . ", " . $d1 . ", " . $d2 . ", " . $d3 . ", '" . $svat . "', 'NOTAUTH', '0',  '" . $invno . "', '" . $_GET["deldate"] . "', '0', '" . $_SESSION['dev'] . "', '" . $_SESSION["tmp_no_salinv"] . "', 0, 0, '0', 'N', 'OFFICE', '', 0, 'N', '0', '', '0', '0', '')";
            //echo $sqlisalma;
            $resultsalma = $db->RunQuery($sqlisalma);

            if ($_SESSION['dev'] == "0") {
                $sqlisalma = "Update invpara  set SPINV=SPINV+1";
                $resultsalma = $db->RunQuery($sqlisalma);
            }

            //==============Update credit limit==========================================

            $sqlisalma = "update vendor set CUR_BAL= CUR_BAL+" . $invtot . " where CODE='" . trim($_GET["customercode"]) . "'";
            $resultsalma = $db->RunQuery($sqlisalma);

            $sqlisalma = "update br_trn set credit= credit+" . $invtot . " where cus_code='" . trim($_GET["customercode"]) . "'";
            $resultsalma = $db->RunQuery($sqlisalma);


            $sqltmp = "select * from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "'";
            $resulttmp = $db->RunQuery($sqltmp);
            while ($rowtmp = mysql_fetch_array($resulttmp)) {
                $dis_per = $sqltmp["cur_rate"] * $sqltmp["cur_qty"] * $sqltmp["dis_per"] * 0.01;

                $sqlmas = "select * from s_mas where STK_NO='" . trim($rowtmp["str_code"]) . "'";
                $resultmas = $db->RunQuery($sqlmas);
                $rowmas = mysql_fetch_array($resultmas);

                $sql_invo = "Insert into s_invo  (REF_NO, SDATE, STK_NO, DESCRIPT, PART_NO, COST, PRICE, QTY, DEPARTMENT, DIS_per, DIS_rs, REP, TAX_PER, BRAND, vatrate, Print_dis1, Print_dis2, Print_dis3, subtot, ret_qty, DEV, CANCELL, c_code, seri_no, ad) values ('" . $invno . "', '" . $_GET["invdate"] . "', '" . trim($rowtmp["str_code"]) . "', '" . trim($rowtmp["str_description"]) . "', '" . $rowmas["PART_NO"] . "', " . $rowmas["COST"] . ", " . $rowtmp["cur_rate"] . ", " . $rowtmp["cur_qty"] . ", '" . $department . "', '" . $rowtmp["dis_per"] . "', " . $dis_per . ", '" . $_GET["salesrep"] . "', '12', '" . $_GET["brand"] . "', " . $mvatrate . ", " . $d1 . ", " . $d2 . ", " . $d3 . ", " . $rowtmp["cur_subtot"] . ", '0', '', '0', '', '', '" . $rowtmp["ad"] . "')";
                //echo $sql_invo;
                $result_invo = $db->RunQuery($sql_invo);

                $sqls_trn = "Insert into s_trn (STK_NO, SDATE, REFNO, QTY, LEDINDI, DEPARTMENT, Dev, seri_no, SAL_EX, ACTIVE, DONO) values('" . trim($rowtmp["str_code"]) . "','" . $_GET["invdate"] . "','" . trim($_GET["invno"]) . "', " . $rowtmp["cur_qty"] . ", 'INV', '" . trim($_GET["department"]) . "', '" . $_SESSION['dev'] . "', '', '', '1', '')";
                $results_trn = $db->RunQuery($sqls_trn);

                $sqls_trn = "update s_mas set QTYINHAND= QTYINHAND-" . $rowtmp["cur_qty"] . " where STK_NO='" . trim($rowtmp["str_code"]) . "'";
                $results_trn = $db->RunQuery($sqls_trn);

                // Call upsales(dtdate, Val(MSFlexGrid1.TextMatrix(i, 3)), Trim(MSFlexGrid1.TextMatrix(i, 0)))
                //m_STK_NO = Trim(MSFlexGrid1.TextMatrix(i, 0))
                //M_STOCODE = Trim(Mid(Me.com_dep, 1, 5))

                $sqls_submas = "update s_submas set QTYINHAND=QTYINHAND- " . $rowtmp["cur_qty"] . " where stk_no= '" . trim($rowtmp["str_code"]) . "' and sto_code= '" . $_GET["department"] . "'";
                $results_submas = $db->RunQuery($sqls_submas);
            }


            $sqlpara = "delete from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "'";
            $resultpara = $db->RunQuery($sqlpara);

            $sqls_submas = "Insert into s_led(REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT) values('" . trim($_GET["invno"]) . "', '" . $_GET["invdate"] . "', '" . trim($_GET["customercode"]) . "', " . $invtot . ", 'INV', '" . $_GET["department"] . "')";
            $results_submas = $db->RunQuery($sqls_submas);

            if ($_SESSION['dev'] == "1") {
                $sqlpara = "update invpara set CAS_INV_NO=CAS_INV_NO+1";
                $resultpara = $db->RunQuery($sqlpara);
            }

            if ($_SESSION['dev'] == "0") {
                $sqlpara = "update invpara set CRE_INV_NO=CRE_INV_NO+1";
                $resultpara = $db->RunQuery($sqlpara);
            }

            $sqlpara = "update vendor set temp_limit= '0'  where CODE='" . trim($_GET["customercode"]) . "'";
            $resultpara = $db->RunQuery($sqlpara);

            $sqlbrand = "select * from brand_mas where barnd_name='" . trim($_GET["brand"]) . "'";
            $resultbrand = $db->RunQuery($sqlbrand);
            if ($rowbrand = mysql_fetch_array($resultbrand)) {
                $sqlbr_trn = "update br_trn set tmplmt= '0'   where cus_code='" . trim($_GET["customercode"]) . "' and brand='" . trim($rowbrand["class"]) . "' and Rep='" . trim($_GET["salesrep"]) . "'";
                $resultbr_trn = $db->RunQuery($sqlbr_trn);
            }


            $sqlbr_trn = "update s_cusordmas set INVNO= '" . $_GET["invno"] . "' where  REF_NO='" . $_GET["salesord1"] . "'";
            $resultbr_trn = $db->RunQuery($sqlbr_trn);

            /////////////////////////////////////////////////////////////////////////


            $_SESSION["print"] = 1;
            $_SESSION["save_sales_inv"] = 0;

            echo "Saved";
        } else {
            echo "insuficent";
        }
    } else {
        echo "no";
    }
}

if ($_GET["Command"] == "check_print") {

    echo $_SESSION["print"];
}


if ($_GET["Command"] == "tmp_crelimit") {
    echo "abc";
    $crLmt = 0;
    $cat = "";

    $rep = trim(substr($_GET["Com_rep1"], 0, 5));

    $sql = "select * from br_trn where rep='" . $rep . "' and cus_code='" . trim($_GET["txt_cuscode"]) . "' and brand='" . trim($_GET["cmbbrand1"]) . "'";
    echo $sql;
    $result = $db->RunQuery($sql);
    if ($row = mysql_fetch_array($result)) {
        $crLmt = $row["credit_lim"];
        If (is_null($row["cat"]) == false) {
            $cat = trim($row["cat"]);
        } else {
            $crLmt = 0;
        }
    }
    /* 	
      $_SESSION["CURRENT_DOC"] = 66     //document ID
      //$_SESSION["VIEW_DOC"] = true      //  view current document
      $_SESSION["FEED_DOC"] = true      //  save  current document
      //$_SESSION["MOD_DOC"] = true       //   delete   current document
      //$_SESSION["PRINT_DOC"] = true     // get additional print   of  current document
      //$_SESSION["PRICE_EDIT"]= true     // edit selling price
      $_SESSION["CHECK_USER"] = true    // check user permission again
      $crLmt = $crLmt;
      setlocale(LC_MONETARY, "en_US");
      $CrTmpLmt = number_format($_GET["txt_tmeplimit"], 2, ".", ",");

      $REFNO = trim($_GET["txt_cuscode"]) ;

      $AUTH_USER="tmpuser";

      $sql = "insert into tmpCrLmt (sdate, stime, username, tmpLmt, class, rep, cuscode, crLmt, cat) values
      ('".date("Y-m-d")."','".date("H:i:s", time())."' ,'".$AUTH_USER."',".$CrTmpLmt." ,'".trim($_GET["cmbbrand1"])."','".$rep."','".trim($_GET["txt_cuscode"])."',".$crLmt.",'".$cat"' )";
      $result =$db->RunQuery($sql);

      $sql = "select * from  br_trn where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."'";
      $result =$db->RunQuery($sql);
      if ($row = mysql_fetch_array($result)) {
      $sqlbrtrn= "insert into br_trn (cus_code, rep, credit_lim, brand, tmplmt) values ('".trim($_GET["txt_cuscode"])."','".$rep."','0','".trim($_GET["cmbbrand1"])."',".$CrTmpLmt." )";
      $resultbrtrn =$db->RunQuery($sqlbrtrn);

      } else {

      $sqlbrtrn= "update br_trn set tmplmt= ".$CrTmpLmt."  where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."' ";
      $resultbrtrn =$db->RunQuery($sqlbrtrn);

      //	$sqlbrtrn= "update vendor set temp_limit= ".$CrTmpLmt."  where code='".trim($_GET["txt_cuscode"])."' "
      }

      If ($_GET["Check1"] == 1) {
      $sqlblack= "update vendor set blacklist= '1'  where code='".trim($_GET["txt_cuscode"])."' ";
      $resultblack =$db->RunQuery($sqlblack);
      } else {
      $sqlblack= "update vendor set blacklist= '0'  where code='".trim($_GET["txt_cuscode"])."' ";
      $resultblack =$db->RunQuery($sqlblack);
      }

      echo "Tempory limit updated"; */
}
?>