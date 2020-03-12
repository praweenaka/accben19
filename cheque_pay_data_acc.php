<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
include('connection.php');

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');



if ($_GET["Command"] == "set_nara_inc") {

    $sql = "select code,name,sum(amount) as amount  from inc_auto_credit_note where myear_mon like '2016%' and active = '1' and code = '" . trim($_GET["Combo3"]) . "' group by code,name";
    //echo $sql;
    $result = mysql_query($sql, $dbinv);
    if ($row = mysql_fetch_array($result)) {
        $month = substr($row["refno"], 0, 7);

        $sql1 = "Select sum(payment) as paid from inc_credit_payment where c_code = '" . trim($_GET["Combo3"]) . "' and cyear = '2016'";
        //echo $sql1;
        $result1 = mysql_query($sql1, $dbinv);
        $row1 = mysql_fetch_array($result1);
        $mpaid = 0;
        if (!is_null($row1['paid'])) {
            $mpaid = $row1['paid'];
        }
        $mNara = "Slab Incentive for " . $row["name"] . " Year 2016 Amount of " . ($row["amount"] - $mpaid);
    }
    echo $mNara;
}


if ($_GET["Command"] == "set_nara_comm") {

    $sql = "Select * from s_commadva where refno = '" . trim($_GET["Combo1"]) . "'";
    //echo $sql;
    $result = mysql_query($sql, $dbinv);
    if ($row = mysql_fetch_array($result)) {
        $month = substr($row["refno"], 0, 7);

        $sql1 = "Select * from s_salrep where REPCODE = '" . trim($row1["rep"]) . "'";
        $result1 = mysql_query($sql1, $dbinv);
        $row1 = mysql_fetch_array($result1);

        if (strtoupper($row["FLAG"]) == "ADV") {
            $adv = "Advance";
        } else {
            $adv = "Balance";
        }
        $mNara = "Sales Commission " . $adv . " for " . $row1["Name"] . " Month " . $month . "  Amount of " . ($row["advance"] - $row["ded"]);
    }
    echo $mNara;
}


if ($_GET["Command"] == "set_nara") {

    $sql = "Select * from ins_payment where id = '" . trim($_GET["Combo2"]) . "'";
    $result = mysql_query($sql, $dbinv);
    if ($row = mysql_fetch_array($result)) {


        if (trim($row["Type"]) == "Tyre") {
            $mNara = " Being Payment of Tyre Target Incentive for the Month of ";
            $msapace = "  ";
            $TXT_NARA = trim($_GET["TXT_NARA"]) . $msapace . $mNara . $msapace . trim($row["I_month"]) . "/" . trim($row["I_year"]) . $msapace . trim($row["Cusname"]) . " Amount of " . number_format($row["amount"], 2, ".", ",") . " Checked by " . trim($row["auth_by"])." " . trim($row["addnote"]);
        } else {
            $mNara = " Being Payment of " . trim($row["Type"]) . " Target Incentive for the Month of ";
            $msapace = "  ";
            $TXT_NARA = trim($_GET["TXT_NARA"]) . $msapace . $mNara . $msapace . trim($row["I_month"]) . "/" . trim($row["I_year"]) . $msapace . trim($row["Cusname"]) . " Amount of " . number_format($row["amount"], 2, ".", ",") . " Checked by " . trim($row["auth_by"])." " . trim($row["addnote"]);
        }
    }

    if ($TXT_NARA != "") {
        echo $TXT_NARA;
    }
}


if ($_GET["Command"] == "get_bank") {
    $sql = "select * from bankmas where bcode='" . $_GET["bankcode"] . "'";
    $result = mysql_query($sql, $dbinv);
    if ($row = mysql_fetch_array($result)) {
        echo $row["bname"];
    }
}


if ($_GET["Command"] == "setamt") {
    //$sql="update tmp_cheque_pay set amt=".$_GET["amt"]." where  entno='".$_GET["txt_entno"]."' and accno='".$_GET["accno"]."' and tmp_no= '".$_SESSION["tmp_no_chequepayacc"]."'";
    $sql = "update tmp_cheque_pay set amt=" . $_GET["amt"] . " where  entno='" . $_GET["txt_entno"] . "' and accno='" . $_GET["accno"] . "' ";
    //echo $sql;	
    $result = mysql_query($sql, $dbacc);

    $sql = "select sum(amt) as totsum from tmp_cheque_pay where  entno='" . $_GET["txt_entno"] . "'";
    //echo $sql;

    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    echo $row["totsum"];
}

if ($_GET["Command"] == "addchq_cash_rec") {

    //echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec
    //$sql="delete from tmp_cheque_pay where accno='".$_GET["accno"]."' and tmp_no='".$_SESSION["tmp_no_chequepayacc"]."'";
    //$result=mysql_query($sql, $dbacc);

    $sql = "insert into tmp_cheque_pay(entno, accno, accname, descript, amt, tmp_no) values ('" . $_GET["txt_entno"] . "', '" . $_GET["accno"] . "', '" . $_GET["acc_name"] . "', '" . $_GET["descript"] . "', " . $_GET["amt"] . ", '" . $_SESSION["tmp_no_chequepayacc"] . "')";
    //echo $sql;
    $result = mysql_query($sql, $dbacc);

    $totamt = 0;
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"100\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"200\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"300\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";

    $i = 1;
    $accno = "";
    $sql = "select * from tmp_cheque_pay where tmp_no='" . $_SESSION["tmp_no_chequepayacc"] . "' ";
    $result = mysql_query($sql, $dbacc);
    while ($row = mysql_fetch_array($result)) {
        if ($row["accno"] == "220303") {
            $accno = $row["accno"];
        }

        $accno = "accno_acc" . $i;
        $accname = "accname_acc" . $i;
        $descript = "descript_acc" . $i;
        $amt = "amt_acc" . $i;

        $ResponseXML .= "<tr>
					<td><input type=\"text\" name=\"" . $accno . "\" id=\"" . $accno . "\" onblur=\"set_acc('" . $row["accno"] . "', '" . $i . "');\" value=\"" . $row["accno"] . "\" /></td>
					<td><input type=\"text\" name=\"" . $accname . "\" id=\"" . $accname . "\" value=\"" . $row["accname"] . "\" /></td>
					<td><input type=\"text\" name=\"" . $descript . "\" id=\"" . $descript . "\" value=\"" . $row["descript"] . "\" />" . $row["descript"] . "</td>
					<td align=right><input type=\"text\" name=\"" . $amt . "\" id=\"" . $amt . "\" onblur=\"setamt_opr('" . $i . "');\" value=\"" . number_format($row["amt"], 2, ".", "") . "\" /></td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['accno'] . "  name=" . $row['accno'] . " onClick=\"del_item('" . $row['accno'] . "');\"></td></tr>";
        //$totchq=$totchq+$row["amt"];


        $i = $i + 1;
        $totamt = $totamt + $row["amt"];
    }

    $ResponseXML .= "   </table>]]></chq_table>";
    $ResponseXML .= "<totamt><![CDATA[" . number_format($totamt, 2, ".", "") . "]]></totamt>";

    $bea1 = "";

    if ($accno != "") {
        $sql123 = "select * from che_customers where chepay='" . $_GET["txt_bea"] . "' and vat!='' and active='1' order by id desc";
        //echo $sql123;
        $result123 = mysql_query($sql123, $dbacc);
        $row123 = mysql_fetch_array($result123);

        $bea1 = $row123["chepay"];



        $ResponseXML .= "<vatno><![CDATA[" . $row123["vat"] . "]]></vatno>";
        $ResponseXML .= "<bea1><![CDATA[" . $bea1 . "]]></bea1>";
    } else {
        $ResponseXML .= "<vatno><![CDATA[]]></vatno>";
        $ResponseXML .= "<bea1><![CDATA[]]></bea1>";
    }


    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "del_item_ledg") {

    //echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec

    $sql = "delete from tmp_cheque_pay where accno='" . $_GET["accno"] . "' and tmp_no='" . $_SESSION["tmp_no_chequepayacc"] . "'";
    $result = mysql_query($sql, $dbacc);

    //echo $sql;

    $totamt = 0;
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";

    $sql = "select * from tmp_cheque_pay where tmp_no='" . $_SESSION["tmp_no_chequepayacc"] . "' ";
    $result = mysql_query($sql, $dbacc);
    while ($row = mysql_fetch_array($result)) {


        $accno = "accno_acc" . $i;
        $accname = "accname_acc" . $i;
        $descript = "descript_acc" . $i;
        $amt = "amt_acc" . $i;

        $ResponseXML .= "<tr>
					<td><input type=\"text\" name=\"" . $accno . "\" id=\"" . $accno . "\" onblur=\"set_acc('" . $row["accno"] . "', '" . $i . "');\" value=\"" . $row["accno"] . "\" /></td>
					<td><input type=\"text\" name=\"" . $accname . "\" id=\"" . $accname . "\" value=\"" . $row["accname"] . "\" /></td>
					<td><input type=\"text\" name=\"" . $descript . "\" id=\"" . $descript . "\" value=\"" . $row["descript"] . "\" />" . $row["descript"] . "</td>
					<td align=right><input type=\"text\" name=\"" . $amt . "\" id=\"" . $amt . "\" onblur=\"setamt_opr('" . $i . "');\" value=\"" . number_format($row["amt"], 2, ".", "") . "\" /></td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['accno'] . "  name=" . $row['accno'] . " onClick=\"del_item('" . $row['accno'] . "');\"></td></tr>";
        //$totchq=$totchq+$row["amt"];

        $totamt = $totamt + $row["amt"];

        $i = $i + 1;
        $amt = $amt + 1;
    }

    $ResponseXML .= "   </table>]]></chq_table>";
    $ResponseXML .= "<totamt><![CDATA[" . $totamt . "]]></totamt>";

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "del_item") {


    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    $sql = "delete from tmp_cash_pay where accno='" . $_GET["accno"] . "' and tmp_no='" . $_SESSION["tmp_no_cashpayacc"] . "'";
    $result = mysql_query($sql, $dbacc);


    $ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";

    $totamt = 0;
    $i = 1;
    $sql = "select * from tmp_cash_pay where tmp_no='" . $_SESSION["tmp_no_cashpayacc"] . "' ";
    $result = mysql_query($sql, $dbacc);
    while ($row = mysql_fetch_array($result)) {
        $accno = "accno_acc" . $i;
        $accname = "accname_acc" . $i;
        $descript = "descript_acc" . $i;
        $amt = "amt_acc" . $i;

        $ResponseXML .= "<tr>
					<td><input type=\"text\" name=\"" . $accno . "\" id=\"" . $accno . "\" onblur=\"set_acc('" . $row["accno"] . "', '" . $i . "');\" value=\"" . $row["accno"] . "\" /></td>
					<td><input type=\"text\" name=\"" . $accname . "\" id=\"" . $accname . "\" value=\"" . $row["accname"] . "\" /></td>
					<td><input type=\"text\" name=\"" . $descript . "\" id=\"" . $descript . "\" value=\"" . $row["descript"] . "\" />" . $row["descript"] . "</td>
					<td align=right><input type=\"text\" name=\"" . $amt . "\" id=\"" . $amt . "\" onblur=\"setamt_opr('" . $i . "');\" value=\"" . number_format($row["amt"], 2, ".", "") . "\" /></td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['accno'] . "  name=" . $row['accno'] . " onClick=\"del_item('" . $row['accno'] . "');\"></td></tr>";

        $i = $i + 1;
        $totamt = $totamt + $row["amt"];
    }

    $ResponseXML .= "   </table>]]></chq_table>";
    $ResponseXML .= "<totamt><![CDATA[" . $totamt . "]]></totamt>";


    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "utilization") {
    require_once("config.inc.php");
    require_once("DBConnector.php");
    $db = new DBConnector();

    $i = 1;
    $a_chq_no = array();
    $a_chq_date = array();
    $a_chq_amt = array();
    $a_chq_bank = array();

    $chq_pay = "";
    $invno = "";
    $delidate = "";
    $available_inv_amt = 0;
    $available_chq_amt = 0;

    $sql = "delete from tmp_utilization where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
    $result = $db->RunQuery($sql);

    $sql = "select * from tmp_cash_chq where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
    $result = $db->RunQuery($sql);
    while ($row = mysql_fetch_array($result)) {

        if (($row["chqdate"] < date("Y-m-d")) or ($row["chqdate"] == date("Y-m-d"))) {

            $date = date('Y-m-d', strtotime(date("Y-m-d") . ' +1 days'));

            $a_chq_date[$i] = $date;
        } else {
            $a_chq_date[$i] = $row["chqdate"];
        }
        $a_chq_no[$i] = $row["chqno"];
        $a_chq_amt[$i] = $row["chqamt"];
        $a_chq_bank[$i] = $row["chqbank"];
        $i = $i + 1;
    }

    $mcou = $i;


    $invset = 0;



    $i = 1;
    $K = 1;
    $invpos = 1;

    while ($mcou >= $i) {

        if ($invset == 0) {
            $j = 1;
        } else {
            $j = $invpos;
        }
        $chqbal = $a_chq_amt[$i];
        $chqval = $a_chq_amt[$i];

        while (($j < $_GET["mcount"]) and ($chqbal > 0)) {

            $chq_pay = "chq_pay" . $j;
            $chq_balance = "chq_balance" . $j;
            $invno = "invno" . $j;
            $delidate = "delidate" . $j;
            $invval = "invval" . $j;

            if ($invset == 0) {
                $invset = $_GET[$chq_pay];
                //datainvlist1.TextMatrix(j, 8) = ""
            }
            if ($invset > 0) {
                if ($invset <= $chqbal) {

                    $chqbal = $chqbal - $invset;


                    $date1 = $_GET[$delidate];
                    $date2 = $a_chq_date[$i];
                    $diff = abs(strtotime($date2) - strtotime($date1));
                    $days = floor($diff / (60 * 60 * 24));

                    $col2 = str_replace(",", "", $_GET[$invval]);

                    $sql1 = "insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, invval, c1, tmp_no) values ('" . $_GET["recno"] . "', '" . $_GET[$invno] . "', '" . $_GET[$delidate] . "', '" . $a_chq_no[$i] . "', '" . $a_chq_date[$i] . "', '" . $a_chq_bank[$i] . "', " . $invset . ", " . $days . ", " . $col2 . ", 0, '" . $_SESSION["tmp_no_cashrec"] . "')";
                    //echo $sql1." 1 /";
                    $result = $db->RunQuery($sql1);
                } else {
                    if ($invset > 0) {
                        $invset = $invset - $chqbal;
                    }

                    $date1 = $_GET[$delidate];
                    $date2 = $a_chq_date[$i];
                    $diff = abs(strtotime($date2) - strtotime($date1));
                    $days = floor($diff / (60 * 60 * 24));

                    $col2 = str_replace(",", "", $_GET[$invval]);

                    $sql1 = "insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, invval, c1, tmp_no) values ('" . $_GET["recno"] . "', '" . $_GET[$invno] . "', '" . $_GET[$delidate] . "', '" . $a_chq_no[$i] . "', '" . $a_chq_date[$i] . "', '" . $a_chq_bank[$i] . "', " . $chqbal . ", " . $days . ", " . $col2 . ", 0, '" . $_SESSION["tmp_no_cashrec"] . "')";
                    //echo $sql1." 2 /";
                    $result = $db->RunQuery($sql1);

                    $chqbal = 0;
                    $invpos = $j;
                }
                $K = $K + 1;
            }
            $j = $j + 1;
        }
        $i = $i + 1;
    }
    $ii = 1;

    while ($_GET["mcount"] > $ii) {

        $cash_pay = "cash_pay" . $ii;
        $invno = "invno" . $ii;
        $delidate = "delidate" . $ii;
        $invval = "invval" . $ii;

        if ($_GET[$cash_pay] != "") {


            if ($_GET["paytype"] == "Cash TT") {
                $chqdate = $_GET["dt"];

                $date1 = $_GET[$delidate];
                $date2 = $chqdate;
                $diff = abs(strtotime($date2) - strtotime($date1));
                $days = floor($diff / (60 * 60 * 24));
            } else {
                $chqdate = date("Y-m-d");

                $date1 = $_GET[$delidate];
                $date2 = date("Y-m-d");
                $diff = abs(strtotime($date2) - strtotime($date1));
                $days = floor($diff / (60 * 60 * 24));
            }


            $col2 = str_replace(",", "", $_GET[$invval]);
            $sql1 = "insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, invval, c1, tmp_no) values ('" . $_GET["recno"] . "', '" . $_GET[$invno] . "', '" . $_GET[$delidate] . "', 'Cash', '" . $chqdate . "', '" . $a_chq_bank[$i] . "', " . $_GET[$cash_pay] . ", " . $days . ", " . $col2 . ", 0, '" . $_SESSION["tmp_no_cashrec"] . "')";
            //echo $sql1." 3 /";
            $result = $db->RunQuery($sql1);
            $K = $K + 1;
        }
        $ii = $ii + 1;
    }

    $invno_0 = array();
    $invdate_1 = array();
    $chqno_2 = array();
    $chqdate_3 = array();
    $settled_4 = array();
    $days_5 = array();


    $r = 1;
    $sql = "select * from tmp_utilization where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
    //echo $sql;
    $result = $db->RunQuery($sql);
    while ($row = mysql_fetch_array($result)) {
        $id[$r] = $row["id"];
        $invno_0[$r] = $row["invno"];
        $invdate_1[$r] = $row["invdate"];
        $chqno_2[$r] = $row["chqno"];
        $chqdate_3[$r] = $row["chqdate"];
        $settled_4[$r] = $row["settled"];
        $days_5[$r] = $row["days"];
        $c1_6[$r] = $row["c1"];
        $r = $r + 1;
    }


    $S = 1;
    while ($_GET["mcount"] > $S) {
        $H = 10;
        while ($H != 0) {

            $invno = "invno" . $S;
            $cash_pay = "cash_pay" . $S;
            $inv_balance = "inv_balance" . $S;

            if ($_GET[$invno] == $invno_0[$H]) {
                if ($invno_0[$H + 1] == $invno_0[$H]) {
                    if (trim($chqno_2[$H]) != "Cash") {
                        $c1_6[$H] = $c1_6[$H + 1] + $settled_4[$H + 1] - $_GET[$cash_pay];
                    } else {
                        $c1_6[$H] = $c1_6[$H + 1] + $settled_4[$H + 1];
                    }

                    $sql11 = "update tmp_utilization set c1=" . $c1_6[$H] . " where id=" . $id[$H];
                    $result1 = $db->RunQuery($sql11);
                } else {
                    if (trim($chqno_2[$H]) != "Cash") {
                        $c1_6[$H] = $_GET[$inv_balance] - $_GET[$cash_pay];
                    } else {
                        $c1_6[$H] = $_GET[$inv_balance];
                    }
                    $sql11 = "update tmp_utilization set c1=" . $c1_6[$H] . " where id=" . $id[$H];
                    $result1 = $db->RunQuery($sql11);
                }
            }
            $H = $H - 1;
        }
        $deutot = $deutot + $_GET[$inv_balance];
        $S = $S + 1;
    }





    /* 		
      while ($mcou>$i){

      $chq_pay="chq_pay".$j;
      $invno="invno".$j;
      $delidate="delidate".$j;

      if ($available_inv_amt==0){
      //if ($_GET[$chq_pay]!=''){
      $available_inv_amt=$_GET[$chq_pay];
      //}
      }

      //echo $a_chq_amt[$i] ." / ". $available_inv_amt;
      // if ($available_inv_amt!=''){
      if($a_chq_amt[$i] > $available_inv_amt){
      //echo $a_chq_amt[$i];
      //echo $available_inv_amt;
      $available_chq_amt=$a_chq_amt[$i]-$available_inv_amt;

      $date1 = $_GET[$delidate];
      $date2 = $a_chq_date[$i];
      $diff = abs(strtotime($date2) - strtotime($date1));
      $days = floor($diff / (60*60*24));


      $sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$available_inv_amt.", ".$days.", '".$_SESSION["tmp_no_cashrec"]."')";
      //echo $sql1." 1 /";
      $result =$db->RunQuery($sql1);

      } else if($a_chq_amt[$i] < $available_inv_amt){


      $date1 = $_GET[$delidate];
      $date2 = $a_chq_date[$i];
      $diff = abs(strtotime($date2) - strtotime($date1));
      $days = floor($diff / (60*60*24));

      $available_inv_amt=$available_inv_amt-$a_chq_amt[$i];
      $sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$a_chq_amt[$i].", ".$days.", '".$_SESSION["tmp_no_cashrec"]."')";
      //echo $sql1." 2 /";
      $result =$db->RunQuery($sql1);

      } else if($a_chq_amt[$i] = $available_inv_amt){

      $available_chq_amt=0;

      $date1 = $_GET[$delidate];
      $date2 = $a_chq_date[$i];
      $diff = abs(strtotime($date2) - strtotime($date1));
      $days = floor($diff / (60*60*24));


      $sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$available_inv_amt.", ".$days.", '".$_SESSION["tmp_no_cashrec"]."')";
      //echo $sql1." 3 /";
      $result =$db->RunQuery($sql1);
      $available_inv_amt=0;


      }
      $j=$j+1;
      echo $available_chq_amt;
      while ($available_chq_amt>0){
      $j=$j+1;
      $chq_pay="chq_pay".$j;
      $invno="invno".$j;
      $delidate="delidate".$j;

      if ($available_chq_amt < $_GET[$chq_pay]){
      $available_inv_amt=$_GET[$chq_pay]-$available_chq_amt;


      $date1 = $_GET[$delidate];
      $date2 = $a_chq_date[$i];
      $diff = abs(strtotime($date2) - strtotime($date1));
      $days = floor($diff / (60*60*24));

      $sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$available_chq_amt.", ".$days.", '".$_SESSION["tmp_no_cashrec"]."')";
      //echo $sql1." 4 /";
      $result =$db->RunQuery($sql1);
      $available_chq_amt=0;

      } else if (($available_chq_amt >= $_GET[$chq_pay]) and ($available_chq_amt >0)){

      $available_chq_amt =$available_chq_amt - $_GET[$chq_pay];

      $date1 = $_GET[$delidate];
      $date2 = $a_chq_date[$i];
      $diff = abs(strtotime($date2) - strtotime($date1));
      $days = floor($diff / (60*60*24));

      $sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$_GET[$chq_pay].", ".$days.", '".$_SESSION["tmp_no_cashrec"]."')";
      //echo $sql1." 5 /";
      $result =$db->RunQuery($sql1);
      }
      }
      // }

      $i=$i+1;
      }


      ////////// Cash Settlement ////////////////////////////////////////////

      $i=1;

      while ($_GET["mcount"]>$i){

      $cash_pay="cash_pay".$i;
      $invno="invno".$i;
      $delidate="delidate".$i;


      if ($_GET[$cash_pay]!=""){

      if ($_GET["paytype"]=="Cash TT"){
      $chqdate=$_GET["dt"];

      $date1 = $_GET[$delidate];
      $date2 = $chqdate;
      $diff = abs(strtotime($date2) - strtotime($date1));
      $days = floor($diff / (60*60*24));
      } else {
      $chqdate=date("Y-m-d");

      $date1 = $_GET[$delidate];
      $date2 = date("Y-m-d");
      $diff = abs(strtotime($date2) - strtotime($date1));
      $days = floor($diff / (60*60*24));
      }

      $invval="invval".$i;
      $col2=str_replace(",", "", $_GET[$invval]);



      $sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, settled, days, c2, tmp_no) values
      ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', 'Cash', '".$chqdate."', ".$_GET[$cash_pay].", ".$days.", ".$col2.", '".$_SESSION["tmp_no_cashrec"]."')";
      echo $sql1." 6 /";
      //$result1 =$db->RunQuery($sql1);
      }
      $i=$i+1;
      } */

    /*
      $i=1;
      while ($_GET["mcount"]>$i){
      $cash_pay="cash_pay".$i;
      $invno="invno".$i;
      $delidate="delidate".$i;

      $sql="select * from tmp_utilization where recno='".$_GET["recno"]."' order by invno desc";
      //echo $sql;
      $result =$db->RunQuery($sql);
      while ($row = mysql_fetch_array($result)){
      if ($_GET[$invno]==$row["invno"]){

      $row_next = mysql_fetch_assoc($result);
      if ($row_next["invno"]==$row["invno"]){

      if (trim($row["chqno"]) != "Cash") {
      $col1= $row_next["c1"] + $row_next["settled"] - $_GET[$cash_pay];
      } else {
      $col1= $row_next["c1"] + $row_next["settled"] ;
      }

      $sql1="update tmp_utilization set c1=".$col1." where  recno='".$_GET["recno"]."' and invno='".$_GET[$invno]."'";
      //echo $sql1." 4 /";
      $result =$db->RunQuery($sql1);

      } else {

      if (trim($row["chqno"]) != "Cash") {
      $col1= $_GET[$inv_balance] - $_GET[$cash_pay];
      } else {
      $col1= $_GET[$inv_balance];
      }

      $sql1="update tmp_utilization set c1=".$col1." where  recno='".$_GET["recno"]."' and invno='".$_GET[$invno]."'";
      //echo $sql1." 4 /";
      $result1 =$db->RunQuery($sql1);


      }
      }
      }


      $i=$i+1;
      } */


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<uti_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Invoice No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Invoice Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Settled</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Days</td>
					</tr>";

    $sql = "select * from tmp_utilization where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
    $result = $db->RunQuery($sql);
    while ($row = mysql_fetch_array($result)) {
        $ResponseXML .= "<tr>
					<td>" . $row["invno"] . "</td>
					<td>" . $row["invdate"] . "</td>
					<td>" . $row["chqno"] . "</td>
					<td>" . $row["chqdate"] . "</td>
					<td align=right>" . number_format($row["settled"], 2, ".", ",") . "</td>
					<td>" . $row["days"] . "</td>
					</tr>";
    }

    $ResponseXML .= "   </table>]]></uti_table>";

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "set_chno") {

    include('connection.php');

    $macccode = trim($_GET["com_cas"]);
    $sql = "Select * from bankmaster where bm_code='" . $macccode . "'";

    $result = mysql_query($sql, $dbacc);
    if ($row = mysql_fetch_array($result)) {
        if (is_null($row["bm_chno"]) == false) {
            $tmprecno = "000000" . $row["bm_chno"];
            $lenth = strlen($tmprecno);
            $recno = substr($tmprecno, $lenth - 7);

            echo $recno;
        }
    }
}


if ($_GET["Command"] == "new_rec") {

    include('connection.php');

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";



    $macccode = trim($_GET["com_cas"]);
    $sql = "Select * from bankmaster where bm_code='" . $macccode . "'";

    $result = mysql_query($sql, $dbacc);
    if ($row = mysql_fetch_array($result)) {
        if (is_null($row["bm_chno"]) == false) {
            $tmprecno = "000000" . $row["bm_chno"];
            $lenth = strlen($tmprecno);
            $recno = substr($tmprecno, $lenth - 7);

            $ResponseXML .= "<txt_cheno><![CDATA[" . $recno . "]]></txt_cheno>";
        }
    }


    $sql = "Select * from dep_mas";
    $result = mysql_query($sql, $dbacc);
    if ($row = mysql_fetch_array($result)) {
        $tmprecno = "000000" . $row["paycheq"];
        $lenth = strlen($tmprecno);

        $recno = $row['code'] . "/" . date("y") . "/PCH/" . substr($tmprecno, $lenth - 7);
        $ResponseXML .= "<txt_entno><![CDATA[" . $recno . "]]></txt_entno>";
    } else {
        $ResponseXML .= "<txt_entno><![CDATA[Not Setuped]]></txt_entno>";
    }

    $sql = "Select * from tmpdep_mas";
    $result = mysql_query($sql, $dbacc);
    if ($row = mysql_fetch_array($result)) {
        $tmprecno = "000000" . $row["paycheq"];
        $lenth = strlen($tmprecno);

        $_SESSION["tmp_no_chequepayacc"] = $_SESSION['company'] . "/" . date("y") . "/PCH/" . substr($tmprecno, $lenth - 7);

        $sql = "update  tmpdep_mas set paycheq=paycheq+1";
        $result = mysql_query($sql, $dbacc);
    }
    //echo $_SESSION["tmp_no_chequepayacc"];

    $ResponseXML .= "<Calendar1><![CDATA[" . date("Y-m-d") . "]]></Calendar1>";
    $ResponseXML .= "<chqdate><![CDATA[" . date("Y-m-d") . "]]></chqdate>";


    $ResponseXML .= " <incentive><![CDATA[<select name=\"Combo2\" id=\"Combo2\" onchange=\"set_nara();\"  class=\"text_purchase3\">
      				<option value=\"\"></option>";

    $sql = "Select * from ins_payment where chno = '0' order by id desc";
    $result = mysql_query($sql, $dbinv);
    while ($row = mysql_fetch_array($result)) {
        $incen = trim($row["id"]) . " " . trim($row["cusCode"]) . " " . trim($row["I_month"]) . " " . trim($row["I_year"]) . "-" . trim($row['Type']);
        //$incen=$row["id"]." ".$row["cuscode"]." ".$row["i_month"]." ".$row["i_year"];
        $ResponseXML .= "<option value=\"" . $row["id"] . "\">" . $incen . "</option>	";
    }


    $ResponseXML .= "</select>]]></incentive>";


    $ResponseXML .= " <commission><![CDATA[ <select name=\"Combo1\" id=\"Combo1\"  onchange=\"set_nara_comm();\" class=\"text_purchase3\">
      		<option value=\"\"></option>";

    //$sql="select * from s_commadva where chno='0' and dev='".$_SESSION["dev"]."'";
    $sql = "select * from s_commadva where chno='0' ";

    $result = mysql_query($sql, $dbinv);
    while ($row = mysql_fetch_array($result)) {
        $ResponseXML .= "<option value=\"" . trim($row["refno"]) . "\">" . trim($row["refno"]) . "</option>	";
    }


    $ResponseXML .= "</select>]]></commission>";

    $ResponseXML .= "</salesdetails>";

    $sql = "delete from tmp_cheque_pay where tmp_no='" . $_SESSION["tmp_no_chequepayacc"] . "'";
    $result = mysql_query($sql, $dbacc);


    $_SESSION["txt_stat"] = "new";
    $_SESSION["mstat"] = "new";
    echo $ResponseXML;
}


if ($_GET["Command"] == "update_vat") {
    include('connection.php');


    $sql = "update che_customers set vat='" . $_GET["txtVATNO"] . "' where chepay='" . $_GET["txt_bea"] . "'";
    $result = mysql_query($sql, $dbacc);
    echo $sql;
}


if ($_GET["Command"] == "edit_rec") {
    $_SESSION["txt_stat"] = "edit";
    $_SESSION["mstat"] = "edit";
    echo $_SESSION["mstat"];
}

if ($_GET["Command"] == "save_crec") {
    include('connection.php');

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql = "select * from  dep_mas";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    if ((strtotime($row["datefrom"]) <= strtotime($_GET["Calendar1"])) and (strtotime($_GET["Calendar1"]) <= strtotime($row["dateto"]))) {
        
    } else {
        exit("Out of Current Accounting Year");
    }

    $sql = "Select * from lock_table";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    if (strtotime($row["lock_date"]) >= strtotime($_GET["Calendar1"])) {
        exit("Can't ADD or EDIT. This Transaction id Locked!!!");
    }


    $sql = "Select * from lock_bank_rec where bank_code='" . $_GET["com_cas"] . "'";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    if (strtotime($row["lock_date_to"]) >= strtotime($_GET["Calendar1"])) {

        $sql_p = "Select * from paymas where refno='" . $_GET["txt_entno"] . "'";
        $result_p = mysql_query($sql_p, $dbacc);
        if ($row_p = mysql_fetch_array($result_p)) {
            if (strtotime($row_p["bdate"]) > strtotime($row["lock_date_to"])) {
                exit("Can't EDIT Date. Reconciliation is Completed!!!");
            }
        }
    }

    $sql = "Select * from lock_bank_rec where bank_code='" . $_GET["com_cas"] . "'";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    if (strtotime($row["lock_date_to"]) >= strtotime($_GET["Calendar1"])) {

        $sql_p = "Select * from paymas where refno='" . $_GET["txt_entno"] . "'";
        $result_p = mysql_query($sql_p, $dbacc);
        if ($row_p = mysql_fetch_array($result_p)) {
            if (strtotime($row_p["bdate"]) >= strtotime($row["lock_date_to"])) {
                exit("Can't EDIT Date. Reconciliation is Completed!!!");
            }
        } else {
            exit("Can't ADD or EDIT. This Transaction id Locked!!!");
        }
    }

    /* 	
      if ($_SESSION["txt_stat"] == "new") {

      $sql="Select * from dep_mas";
      $result=mysql_query($sql, $dbacc);
      $row = mysql_fetch_array($result);

      $tmprecno="000000".$row["paycash"];
      $lenth=strlen($tmprecno);
      $recno=$_SESSION['company']."/".date("y")."/L/".trim("ACC/THT/ ").substr($tmprecno, $lenth-7);
      $_SESSION["recno"]=$recno;

      }
     */
    //////////////////
    if ($_SESSION['company'] == "") {
        exit("Please login again");
    }

    if ($_SESSION["mstat"] == "new") {
        $sql = "Select * from dep_mas";
        $result = mysql_query($sql, $dbacc);
        $row = mysql_fetch_array($result);
        $tmprecno = "000000" . $row["paycheq"];
        $lenth = strlen($tmprecno);

        $recno = $row['code'] . "/" . date("y") . "/PCH/" . substr($tmprecno, $lenth - 7);
    } else {
        $recno = $_GET["txt_entno"];
    }



    //$_SESSION["tmp_no_chequepayacc"]==$_SESSION['company']."/".date("y")."/PCH/".substr($tmprecno, $lenth-7);



    $sql = "Select * from tmp_cheque_pay where tmp_no='" . $_SESSION["tmp_no_chequepayacc"] . "'";
    $result = mysql_query($sql, $dbacc);
    $num_rows = mysql_num_rows($result);
    IF ($num_rows == 0) {
        exit("Please Re-Enter Debit Accounts");
    }

    while ($row = mysql_fetch_array($result)) {
        $m_acode = $row["accno"];
        if (($m_acode == "220303") and ($_GET["txtVATNO"] == "") and ($_GET["txtVATNO1"] == "") and ($_GET["txtVATNO2"] == "") and ($_GET["txtVATNO3"] == "")) {

            exit("VAT Details Not Completed");
        }
    }


    if (($_SESSION["mstat"] == "") or ($_SESSION["mstat"] == "old")) {
        exit("Invalid Option, Please Select Option New and Enter Cheque");
    }

    $macccode = $_GET["com_cas"];

    if ($_GET["txt_cheno"] == "") {
        $m_ok = "Cheque Number Not Selected";
    }
    if ($_GET["txt_entno"] == "") {
        $m_ok = "Jouirnal No Not Entered";
    }
    if (($_GET["TXT_DEBTOT"] == "0") or (trim($_GET["TXT_DEBTOT"]) == "")) {
        $m_ok = "Ledger Entry Is Incomplete";
    }
    if ($_GET["txt_bea"] == "") {
        $m_ok = "Please Enter Barer Name";
    }
    if ($_GET["com_cas"] == "") {
        $m_ok = "Please select Bank";
    }
    if ($m_ok != "") {
        exit($m_ok);
    }


    mysql_query("START TRANSACTION", $dbacc);


    $sql_rspaymas = "Select * from paymas where refno='" . trim($recno) . "'";
    $result_rspaymas = mysql_query($sql_rspaymas, $dbacc);
    if ($row_rspaymas = mysql_fetch_array($result_rspaymas)) {
        /* if ($_GET["TXT_DEBTOT"] != $row_rspaymas["amount"]) {
          exit ("Sorry You Have Changed The Cheque Value");
          } */

        $sql_rst = "Select sum(amount) as totamount from cashpaytrn where refno='" . trim($recno) . "'";
        $result_rst = mysql_query($sql_rst, $dbacc);
        $row_rst = mysql_fetch_array($result_rst);

        if ($_GET["TXT_DEBTOT"] != $row_rst["totamount"]) {
            exit("Sorry You Have Changed The Cheque Value");
        }



        $macccode = $row_rspaymas["code"];

        $sql_rs_bank = "Select * from bankmaster where bm_code = '" . $macccode . "'";
        $result_rs_bank = mysql_query($sql_rs_bank, $dbacc);
        if ($row_rs_bank = mysql_fetch_array($result_rs_bank)) {
            $mName = $row_rs_bank["bm_bank"];
        }
    } else {

        if ($_SESSION["mstat"] == "new") {
            $sql = "Update dep_mas set paycheq=paycheq+1";
            $result = mysql_query($sql, $dbacc);

            $sql = "update bankmaster set pay_no=pay_no+1 where bm_code='" . $macccode . "'";
            $result = mysql_query($sql, $dbacc);


            $sql_rsBank = "Select * from bankmaster where bm_code = '" . $macccode . "'";
            $result_rsBank = mysql_query($sql_rsBank, $dbacc);
            if ($row_rsBank = mysql_fetch_array($result_rsBank)) {
                $sql = "Update bankmaster set bm_chno=bm_chno+1 where bm_code = '" . $macccode . "'";
                $result = mysql_query($sql, $dbacc);

                $mName = $row_rsBank["bm_bank"];
            } else {
                exit("Invalid Bank");
            }
        }
    }



    if ($recno != "") {

        $sql = "Delete  from paymas where refno = '" . trim($recno) . "'";
        $result = mysql_query($sql, $dbacc);

        $sql = "Delete  from cashpaytrn where refno = '" . trim($recno) . "'";
        $result = mysql_query($sql, $dbacc);

        $l_month = "";
        $recdate = "";

        $sql_rec = "select * from ledger where l_refno='" . trim($recno) . "'";
        $result_rec = mysql_query($sql_rec, $dbacc);
        while ($row_rec = mysql_fetch_array($result_rec)) {

            if (($l_month == "") and (is_null($row_rec["l_month"]) == false) and ($row_rec["l_month"] != "0")) {
                $l_month = $row_rec["l_month"];
                $recdate = $row_rec["recdate"];
            }
        }


        $sql = "Select * from ledger where l_refno = '" . trim($recno) . "'";
        $result = mysql_query($sql, $dbacc);
        while ($row = mysql_fetch_array($result)) {
            if (trim($row["l_refno"]) == trim($recno)) {
                $m_amount = $row["l_amount"];
                $m_account = $row["l_code"];
                $m_flag1 = $row["l_flag1"];

                $sql1 = "Delete  from ledger where l_refno = '" . trim($_GET["txt_entno"]) . "'";
                $result1 = mysql_query($sql1, $dbacc);
            }
        }
    }
    //..............................................................................

    $txt_bea = str_replace("~", "&", $_GET["txt_bea"]);
    $txt_bea = str_replace("&nbsp;", " ", $txt_bea);

    $TXT_NARA = str_replace("~", "&", $_GET["TXT_NARA"]);


    $txtvatbea = str_replace("~", "&", $_GET["txtvatbea"]);
    $txtvatbea = str_replace("&nbsp;", " ", $txtvatbea);

    $txt_bea1 = str_replace("~", "&", $_GET["txt_bea1"]);
    $txt_bea1 = str_replace("&nbsp;", " ", $txt_bea1);
    $txt_bea2 = str_replace("~", "&", $_GET["txt_bea2"]);
    $txt_bea2 = str_replace("&nbsp;", " ", $txt_bea2);
    $txt_bea3 = str_replace("~", "&", $_GET["txt_bea3"]);
    $txt_bea3 = str_replace("&nbsp;", " ", $txt_bea3);


    if ($m_ok == "") {

        $mCheNo = trim($_GET["txt_cheno"]);
        $mBarer = trim($txt_bea);
        $mNara = trim($TXT_NARA);
        $mHead = trim($_GET["TXT_HEADING"]);
        $mAmount = $_GET["TXT_DEBTOT"];

        $vatno = $_GET["txtVATNO"];
        if ($_GET["Check1"] == "false") {
            $mTick = 0;
        } else {
            $mTick = 1;
        }



        if ($_GET["Combo1"] != "") {
            $sql = "Insert into paymas(refno, bdate, cheno, code, name, barer, naration, heading, amount, type,  rights, comcode, cancel, ac_payee, invno, vatno, inv_date, bea1, chq_date, v_barer1, vat1, v_barer2, vat2, v_barer3, vat3, user, ent_datetime)
		Values ('" . trim($recno) . "', '" . $_GET["Calendar1"] . "', '" . $mCheNo . "', '" . $macccode . "', '" . $mName . "', '" . $mBarer . "', '" . trim($TXT_NARA) . "', '" . $mHead . "', " . $mAmount . ", 'B', '" . $mUserWrite . "' , '" . $_SESSION['company'] . "', '0', '" . $mTick . "', '" . trim($_GET["Combo1"]) . "', '" . $vatno . "', '" . $_GET["DTinv_date"] . "', '" . $txtvatbea . "', '" . $_GET["chqdate"] . "', '" . $txt_bea1 . "', '" . $_GET["txtVATNO1"] . "', '" . $txt_bea2 . "', '" . $_GET["txtVATNO2"] . "', '" . $txt_bea3 . "', '" . $_GET["txtVATNO3"] . "', '" . $_SESSION['UserName'] . "', '" . date("Y-m-d H:i:s") . "')";
            //echo $sql;
            $result = mysql_query($sql, $dbacc);

            if ($result == false) {
                exit("Transaction NOT Saved !!!");
            }
        } else {
            $sql = "Insert into paymas(refno, bdate, cheno, code, name, barer, naration, heading, amount, type, rights, comcode, cancel, ac_payee, invno, vatno, inv_date, bea1, chq_date, v_barer1, vat1, v_barer2, vat2, v_barer3, vat3, user, ent_datetime)
		 Values ('" . trim($recno) . "', '" . $_GET["Calendar1"] . "', '" . $mCheNo . "', '" . $macccode . "', '" . $mName . "', '" . $mBarer . "', '" . trim($TXT_NARA) . "', '" . $mHead . "', " . $mAmount . ", 'B', '" . $mUserWrite . "' , '" . $_SESSION['company'] . "', '0', '" . $mTick . "', '" . $_GET["txtINVNO"] . "', '" . $vatno . "', '" . $_GET["DTinv_date"] . "', '" . $txtvatbea . "', '" . $_GET["chqdate"] . "', '" . $txt_bea1 . "', '" . $_GET["txtVATNO1"] . "', '" . $txt_bea2 . "', '" . $_GET["txtVATNO2"] . "', '" . $txt_bea3 . "', '" . $_GET["txtVATNO3"] . "', '" . $_SESSION['UserName'] . "', '" . date("Y-m-d H:i:s") . "')";
            // echo $sql;
            $result = mysql_query($sql, $dbacc);
            if ($result == false) {
                exit("Transaction NOT Saved !!!");
            }
        }

        if ($_GET["TXT_DEBTOT"] > 0) {
            $mAmount = $_GET["TXT_DEBTOT"];
        }



        $sql = "Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_flag2, l_flag3, l_flag4, l_head, l_lmem, rights, chno, comcode, chq_date, user, ent_datetime, l_month, recdate) Values ('" . trim($recno) . "', '" . $_GET["Calendar1"] . "', '" . $macccode . "', " . $mAmount . ", 'CAP', 'CRE', '0', 'R', 'CHQ', '" . $mHead . "', '" . trim($TXT_NARA) . "', '" . $mUserWrite . "', '" . trim($_GET["txt_cheno"]) . "', '" . $_SESSION['company'] . "', '" . $_GET["chqdate"] . "', '" . $_SESSION['UserName'] . "', '" . date("Y-m-d H:i:s") . "', '" . $l_month . "', '" . $recdate . "')";
        // echo  $sql;
        $result = mysql_query($sql, $dbacc);
        if ($result == false) {
            exit("Transaction NOT Saved !!!");
        }

        $sql_rsCHE_CUSTOMERS = "select * from che_customers WHERE chepay='" . trim($txt_bea) . "'";
        // echo $sql_rsCHE_CUSTOMERS;
        $result_rsCHE_CUSTOMERS = mysql_query($sql_rsCHE_CUSTOMERS, $dbacc);
        if ($row_rsCHE_CUSTOMERS = mysql_fetch_array($result_rsCHE_CUSTOMERS)) {

            if (trim($_GET["txtVATNO"]) != "") {
                $sql_rsCHE_CUSTOMERS1 = "update che_customers set vat='" . trim($_GET["txtVATNO"]) . "', active='1' where chepay ='" . $txt_bea . "'";
                //	echo $sql_rsCHE_CUSTOMERS1;
                $result_rsCHE_CUSTOMERS1 = mysql_query($sql_rsCHE_CUSTOMERS1, $dbacc);
            }
        } else {
            $sql_rsCHE_CUSTOMERS1 = "insert che_customers (chepay, vat, active) values ('" . $txt_bea . "', '" . trim($_GET["txtVATNO"]) . "', '1')";
            //echo $sql_rsCHE_CUSTOMERS1;
            $result_rsCHE_CUSTOMERS1 = mysql_query($sql_rsCHE_CUSTOMERS1, $dbacc);
        }


        if (trim($_GET["txtVATNO1"]) != "") {
            $sql_rsCHE_CUSTOMERS = "select * from che_customers WHERE chepay='" . trim($txt_bea1) . "'";
            $result_rsCHE_CUSTOMERS = mysql_query($sql_rsCHE_CUSTOMERS, $dbacc);
            if ($row_rsCHE_CUSTOMERS = mysql_fetch_array($result_rsCHE_CUSTOMERS)) {

                $sql_rsCHE_CUSTOMERS = "update che_customers set vat='" . trim($_GET["txtVATNO1"]) . "', active='1' where chepay ='" . trim($txt_bea1) . "'";
                //echo $sql_rsCHE_CUSTOMERS;
                $result_rsCHE_CUSTOMERS = mysql_query($sql_rsCHE_CUSTOMERS, $dbacc);
                if ($result_rsCHE_CUSTOMERS == false) {
                    exit("Transaction NOT Saved !!!");
                }
            } else {
                $sql_rsCHE_CUSTOMERS = "insert che_customers (chepay, vat, active) values ('" . trim($txt_bea1) . "', '" . trim($_GET["txtVATNO1"]) . "', '1')";
                //echo $sql_rsCHE_CUSTOMERS;
                $result_rsCHE_CUSTOMERS = mysql_query($sql_rsCHE_CUSTOMERS, $dbacc);
                if ($result_rsCHE_CUSTOMERS == false) {
                    exit("Transaction NOT Saved !!!");
                }
            }
        }

        if (trim($_GET["txtVATNO2"]) != "") {
            $sql_rsCHE_CUSTOMERS = "select * from che_customers WHERE chepay='" . trim($txt_bea2) . "'";
            $result_rsCHE_CUSTOMERS = mysql_query($sql_rsCHE_CUSTOMERS, $dbacc);
            if ($row_rsCHE_CUSTOMERS = mysql_fetch_array($result_rsCHE_CUSTOMERS)) {
                $sql_rsCHE_CUSTOMERS = "update che_customers set vat='" . trim($_GET["txtVATNO2"]) . "', active='1' where chepay ='" . trim($txt_bea2) . "'";
                //echo $sql_rsCHE_CUSTOMERS;
                $result_rsCHE_CUSTOMERS = mysql_query($sql_rsCHE_CUSTOMERS, $dbacc);
                if ($result_rsCHE_CUSTOMERS == false) {
                    exit("Transaction NOT Saved !!!");
                }
            } else {
                $sql_rsCHE_CUSTOMERS = "insert che_customers (chepay, vat, active) values ('" . trim($txt_bea2) . "', '" . trim($_GET["txtVATNO2"]) . "', '1')";
                //echo $sql_rsCHE_CUSTOMERS;
                $result_rsCHE_CUSTOMERS = mysql_query($sql_rsCHE_CUSTOMERS, $dbacc);
                if ($result_rsCHE_CUSTOMERS == false) {
                    exit("Transaction NOT Saved !!!");
                }
            }
        }

        if (trim($_GET["txtVATNO3"]) != "") {
            $sql_rsCHE_CUSTOMERS = "select * from che_customers WHERE chepay='" . trim($txt_bea3) . "'";
            $result_rsCHE_CUSTOMERS = mysql_query($sql_rsCHE_CUSTOMERS, $dbacc);
            if ($row_rsCHE_CUSTOMERS = mysql_fetch_array($result_rsCHE_CUSTOMERS)) {

                $sql_rsCHE_CUSTOMERS = "update che_customers set vat='" . trim($_GET["txtVATNO3"]) . "', active='1' where chepay ='" . trim($txt_bea3) . "'";
                //echo $sql_rsCHE_CUSTOMERS;
                $result_rsCHE_CUSTOMERS = mysql_query($sql_rsCHE_CUSTOMERS, $dbacc);
                if ($result_rsCHE_CUSTOMERS == false) {
                    exit("Transaction NOT Saved !!!");
                }
            } else {
                $sql_rsCHE_CUSTOMERS = "insert che_customers (chepay, vat, active) values ('" . trim($txt_bea3) . "', '" . trim($_GET["txtVATNO3"]) . "', '1')";
                //echo $sql_rsCHE_CUSTOMERS;
                $result_rsCHE_CUSTOMERS = mysql_query($sql_rsCHE_CUSTOMERS, $dbacc);
                if ($result_rsCHE_CUSTOMERS == false) {
                    exit("Transaction NOT Saved !!!");
                }
            }
        }




        if (trim($_GET["Combo1"]) != "") {

            //$length=strlen(trim($_GET["Combo1"]));
            //$a= substr(trim($_GET["Combo1"]), $length-1);	
            // if ($a!="1"){	
            $sql_rs = "Update s_commadva set chno='" . trim($_GET["txt_cheno"]) . "', Bank = '" . $mName . "', PCHNO = '" . trim($recno) . "' where refno='" . trim($_GET["Combo1"]) . "' ";
            //echo $sql_rs;
            $result_rs = mysql_query($sql_rs, $dbinv);
            if ($result_rs == false) {
                exit("Transaction NOT Saved !!!");
            }

            $sql_rs = "insert into s_commadva_tmp (chno, Bank, PCHNO, refno) values ('" . trim($_GET["txt_cheno"]) . "', '" . $mName . "', '" . trim($recno) . "', '" . trim($_GET["Combo1"]) . "') ";
            $result_rs = mysql_query($sql_rs, $dbinv);
            if ($result_rs == false) {
                exit("Transaction NOT Saved !!!");
            }

            $remark = "";
        }
        //	}	

        if (trim($_GET["Combo2"]) != "") {

            $remark = "CHE NO " . trim($_GET["txt_cheno"]) . " " . date("Y-m-d", strtotime($_GET["chqdate"])) . " " . number_format($_GET["TXT_DEBTOT"], 2, ".", ",");


            $sql_rsins_pay = "Select * from ins_payment where id = '" . trim($_GET["Combo2"]) . "' ";
            //echo $sql_rsins_pay;
            $result_rsins_pay = mysql_query($sql_rsins_pay, $dbinv);
            if ($row_rsins_pay = mysql_fetch_array($result_rsins_pay)) {

                $sql_rs = "Update ins_payment set chno = '" . trim($_GET["txt_cheno"]) . "', remarks = '" . trim($row_rsins_pay["remarks"]) . "&nbsp;&nbsp;" . trim($remark) . "' where id = '" . trim($_GET["Combo2"]) . "' ";
                //	echo "1-".$sql_rs;
                $result_rs = mysql_query($sql_rs, $dbinv);
                if ($result_rs == false) {
                    exit("Transaction NOT Saved !!!");
                }

                $sql_rs = "insert into ins_payment_tmp (chno, remarks, cusCode, I_month, I_year, Type) values ('" . trim($_GET["txt_cheno"]) . "', '" . trim($row_rsins_pay["remarks"]) . "&nbsp;&nbsp;" . trim($remark) . "', '" . $row_rsins_pay["cusCode"] . "', '" . $row_rsins_pay["I_month"] . "', '" . $row_rsins_pay["I_year"] . "', '" . $row_rsins_pay["Type"] . "')";
                //echo "1-".$sql_rs;
                $result_rs = mysql_query($sql_rs, $dbinv);
                if ($result_rs == false) {
                    exit("Transaction NOT Saved !!!");
                }
            } else {
                $sql_rs = "Update ins_payment set chno = '" . trim($_GET["txt_cheno"]) . "', remarks = '" . trim($remark) . "' where id = '" . trim($_GET["Combo2"]) . "' ";
                //echo "2-".$sql_rs;
                $result_rs = mysql_query($sql_rs, $dbinv);
                if ($result_rs == false) {
                    exit("Transaction NOT Saved !!!");
                }

                $sql_rs = "insert into ins_payment_tmp (chno, remarks) values ('" . trim($_GET["txt_cheno"]) . "', '" . trim($remark) . "')";
                //echo "1-".$sql_rs;
                $result_rs = mysql_query($sql_rs, $dbinv);

                if ($result_rs == false) {
                    exit("Transaction NOT Saved !!!");
                }
            }
        }

        if (trim($_GET["Combo3"]) != "") {


            $sql = "delete from inc_credit_payment where ref_no = '" . trim($recno) . "'";
            $result_rs = mysql_query($sql_rs, $dbinv);

            $sql_rs = "insert into inc_credit_payment (c_code, cyear, payment, ref_no,sdate) values ('" . trim($_GET["Combo3"]) . "', '2016', '" . trim($_GET["TXT_DEBTOT"]) . "','" . trim($recno) . "' ,'" . trim($_GET["chqdate"]) . "') ";
            $result_rs = mysql_query($sql_rs, $dbinv);
            if ($result_rs == false) {
                exit("Transaction NOT Saved !!!");
            }

            $remark = "";
        }



        $sql_tmp = "Select * from tmp_cheque_pay where tmp_no = '" . $_SESSION["tmp_no_chequepayacc"] . "' ";
        $result_tmp = mysql_query($sql_tmp, $dbacc);
        while ($row_tmp = mysql_fetch_array($result_tmp)) {

            $m_acode = $row_tmp["accno"];
            $m_ades = $row_tmp["accname"];
            $m_nara = $row_tmp["descript"];
            $m_amount = $row_tmp["amt"];

            if (($m_acode != "") and ($m_amount != 0)) {
                if (is_null(trim($m_nara)) == false) {
                    $mNara = trim($m_nara);
                }

                $sql_rs = "Insert into cashpaytrn(refno, bdate, code, amount, flag, nara, rights, comcode, cancel, user, ent_datetime) Values ('" . trim($recno) . "', '" . $_GET["Calendar1"] . "', '" . trim($m_acode) . "', " . $m_amount . ", 'DEB', '" . $m_nara . "', '" . $mUserWrite . "', '" . $_SESSION['company'] . "', '0', '" . $_SESSION['UserName'] . "', '" . date("Y-m-d H:i:s") . "') ";
                //echo $sql_rs;
                $result_rs = mysql_query($sql_rs, $dbacc);
                if ($result_rs == false) {
                    exit("Transaction NOT Saved !!!");
                }


                if ($_GET["TXT_DEBTOT"] > 0) {
                    $mAmount = $m_amount;
                }
                if (is_null(trim($m_nara)) == false) {
                    $mNara = trim($m_nara);
                }

                $sql_rs = "Insert into ledger(l_refno, l_date, l_code, L_amount, l_flag, l_flag1, l_lmem, rights, comcode, l_flag2, l_flag3, l_flag4, l_yearfl, user, ent_datetime, l_month, recdate) Values ('" . trim($recno) . "', '" . $_GET["Calendar1"] . "', '" . trim($m_acode) . "', " . $mAmount . ", 'CAP', 'DEB', '" . trim($TXT_NARA) . "', '" . $mUserWrite . "', '" . $_SESSION['company'] . "', '1', 'R', 'CHQ', 0, '" . $_SESSION['UserName'] . "', '" . date("Y-m-d H:i:s") . "', '" . $l_month . "', '" . $recdate . "')";
                $result_rs = mysql_query($sql_rs, $dbacc);
                if ($result_rs == false) {
                    exit("Transaction NOT Saved !!!");
                }

                // echo $sql_rs;
            }
        }

        $sql_rs = "update ledger set l_lmem='" . trim($TXT_NARA) . "' where l_refno='" . trim($recno) . "'";
        $result_rs = mysql_query($sql_rs, $dbacc);
        if ($result_rs == false) {
            exit("Transaction NOT Saved !!!");
        }


        mysql_query("COMMIT", $dbacc);


        //echo  "Records are Saved";
        $_SESSION["mstat"] = "";
    }

    echo $recno;
}
////////////		


if ($_GET["Command"] == "vou_print_las") {

    include('connection.php');

    $sql_rsPrInv = "select * from ledger where l_refno='" . $_GET["txt_entno"] . "' and l_flag1='DEB'";
    $result_rsPrInv = mysql_query($sql_rsPrInv, $dbacc);
    $ii = 1;
    while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)) {
        if ($ii == 1) {
            $txtacc1 = number_format($row_rsPrInv["l_amount"], 2, ".", ",");
        }
        if ($ii == 2) {
            $txtacc2 = number_format($row_rsPrInv["l_amount"], 2, ".", ",");
        }
        if ($ii == 3) {
            $txtacc3 = number_format($row_rsPrInv["l_amount"], 2, ".", ",");
        }
        if ($ii == 4) {
            $txtacc4 = number_format($row_rsPrInv["l_amount"], 2, ".", ",");
        }
        if ($ii == 5) {
            $txtacc5 = number_format($row_rsPrInv["l_amount"], 2, ".", ",");
        }
        if ($ii == 6) {
            $txtacc6 = number_format($row_rsPrInv["l_amount"], 2, ".", ",");
        }
        if ($ii == 7) {
            $txtacc7 = number_format($row_rsPrInv["l_amount"], 2, ".", ",");
        }
        if ($ii == 8) {
            $txtacc8 = number_format($row_rsPrInv["l_amount"], 2, ".", ",");
        }

        $ii = $ii + 1;
    }

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<txtacc1><![CDATA[" . $txtacc1 . "]]></txtacc1>";
    $ResponseXML .= "<txtacc2><![CDATA[" . $txtacc2 . "]]></txtacc2>";
    $ResponseXML .= "<txtacc3><![CDATA[" . $txtacc3 . "]]></txtacc3>";
    $ResponseXML .= "<txtacc4><![CDATA[" . $txtacc4 . "]]></txtacc4>";
    $ResponseXML .= "<txtacc5><![CDATA[" . $txtacc5 . "]]></txtacc5>";
    $ResponseXML .= "<txtacc6><![CDATA[" . $txtacc6 . "]]></txtacc6>";
    $ResponseXML .= "<txtacc7><![CDATA[" . $txtacc7 . "]]></txtacc7>";
    $ResponseXML .= "<txtacc8><![CDATA[" . $txtacc8 . "]]></txtacc8>";
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "search_rec") {

    include_once("connection.php");

    $ResponseXML .= "";
    //$ResponseXML .= "<invdetails>";



    $ResponseXML .= "<table width=\"919\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"170\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ref No</font></td>
                              <td width=\"127\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Date</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cheque No</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Bearer</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Amount</font></td>
							   
                             
   							</tr>";

    if ($_GET["mfield"] == "recno") {
        $letters = $_GET['recno'];
        $sql = "select refno, bdate, cheno, name, amount from paymas where type='B' and refno like  '$letters%'  ORDER BY bdate desc limit 50";
    } else if ($_GET["mfield"] == "chqno") {
        $letters = $_GET['chqno'];
        $sql = "select refno, bdate, cheno, name, amount from paymas where type='B' and cheno like  '$letters%'  ORDER BY bdate desc limit 50";
    }

    $result = mysql_query($sql, $dbacc);

    /* 	if ($_GET["mfield"]=="recno"){
      $letters = $_GET['recno'];
      //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
      //$letters="/".$letters;
      //$a="SELECT * from s_salma where REF_NO like  '$letters%'";
      //echo $a;
      $sql="select refno, bdate, cheno, name, amount from paymas where type='B'   ORDER BY bdate desc limit 50";
      $sql="select CA_REFNO, CA_DATE, CA_AMOUNT, cus_ref  from s_crec where DEPARTMENT != 'S' and CANCELL='0' and FLAG = 'REC-A' and CA_REFNO like  '$letters%'  ORDER BY CA_REFNO limit 50";
      $result=mysql_query($sql, $dbinv);

      } else if ($_GET["mstatus"]=="recdate"){
      $letters = $_GET['recdate'];
      //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
      $sql="select CA_REFNO, CA_DATE, CA_AMOUNT, cus_ref  from s_crec where DEPARTMENT != 'S' and CANCELL='0' and FLAG = 'REC-A' and CA_DATE like  '$letters%'  ORDER BY CA_REFNO limit 50";
      $result=mysql_query($sql, $dbinv);

      }else if ($_GET["mstatus"]=="recamt"){
      $letters = $_GET['recamt'];
      //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
      $sql="select CA_REFNO, CA_DATE, CA_AMOUNT, cus_ref  from s_crec where DEPARTMENT != 'S' and CANCELL='0' and FLAG = 'REC-A' and CA_AMOUNT like  '$letters%'  ORDER BY CA_REFNO limit 50";
      $result=mysql_query($sql, $dbinv);

      } else {
      $letters = $_GET['recno'];
      //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
      $sql="select CA_REFNO, CA_DATE, CA_AMOUNT, cus_ref  from s_crec where DEPARTMENT != 'S' and CANCELL='0' and FLAG = 'REC-A' and CA_REFNO like  '$letters%'  ORDER BY CA_REFNO limit 50";
      $result=mysql_query($sql, $dbinv);
      } */



    while ($row = mysql_fetch_array($result)) {
        $ResponseXML .= "<tr>               
                              <td onclick=\"recno('" . $row['refno'] . "','" . $_GET["mstatus"] . "');\">" . $row['refno'] . "</a></td>
                              <td onclick=\"recno('" . $row['refno'] . "','" . $_GET["mstatus"] . "');\">" . date("Y-m-d", strtotime($row["bdate"])) . "</a></td>
							  <td onclick=\"recno('" . $row['refno'] . "','" . $_GET["mstatus"] . "');\">" . $row["cheno"] . "</a></td>
							   <td onclick=\"recno('" . $row['refno'] . "','" . $_GET["mstatus"] . "');\">" . $row["name"] . "</a></td>
                              <td onclick=\"recno('" . $row['refno'] . "','" . $_GET["mstatus"] . "');\">" . $row['amount'] . "</a></td></tr>";
    }

    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}


if ($_GET["Command"] == "search_bank") {

    include_once("connection.php");

    $ResponseXML .= "";
    //$ResponseXML .= "<invdetails>";



    $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Bank Code</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Banl Name</font></td>
							  
                             
   							</tr>";


    if ($_GET["mstatus"] == "cash_rec") {
        if ($_GET["mfield"] == "bcode") {
            $letters = $_GET['bcode'];
            $sql = "SELECT * from bankmas where  bcode like  '$letters%'";
            $result = mysql_query($sql, $dbinv);
        } else if ($_GET["mfield"] == "bank") {
            $letters = $_GET['bank'];
            $sql = "SELECT * from bankmas where  bname like  '$letters%'";
            $result = mysql_query($sql, $dbinv);
        }
    }



    while ($row = mysql_fetch_array($result)) {

        $ResponseXML .= "<tr>
                           	    <td onclick=\"selbank('" . $row["bcode"] . "', '" . $stname . "');\">" . $row["bcode"] . "</a></td>
                              <td onclick=\"selbank('" . $row["bcode"] . "', '" . $stname . "');\">" . $row["bname"] . "</a></td>
				
							                           	
                            </tr>";
    }

    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_selbank") {
    //header('Content-Type: text/xml'); 
    /* echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n"; */

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $sql = "select * from bankmas where bcode='" . $_GET["bcode"] . "'";
    $result = mysql_query($sql, $dbinv);

    if ($row = mysql_fetch_array($result)) {
        $ResponseXML .= "<bname><![CDATA[" . $row["bname"] . "]]></bname>";
    }


    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}


if ($_GET["Command"] == "set_acc") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql_rst = "Select * from lcodes where c_code='" . trim($_GET["accno"]) . "'";
    $result_rst = mysql_query($sql_rst, $dbacc);
    if ($row_rst = mysql_fetch_array($result_rst)) {

        $sql1 = "update tmp_cheque_pay set accno='" . trim($row_rst["c_code"]) . "', accname='" . trim($row_rst["c_name"]) . "', descript='" . trim($_GET["TXT_NARA"]) . "' where entno='" . trim($_GET["txt_entno"]) . "' and accno='" . $_GET["old_accno"] . "'";
        $result1 = mysql_query($sql1, $dbacc);

        $ResponseXML .= "<c_code><![CDATA[" . $row_rst["c_code"] . "]]></c_code>";
        $ResponseXML .= "<c_name><![CDATA[" . $row_rst["c_name"] . "]]></c_name>";
        $ResponseXML .= "<TXT_NARA><![CDATA[" . trim($_GET["TXT_NARA"]) . "]]></TXT_NARA>";
        $ResponseXML .= "<i><![CDATA[" . $_GET["i"] . "]]></i>";
    }
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_recno") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";




    $mTick1 = "0";
    $sql_rst = "Select * from paymas where refno='" . trim($_GET["recno"]) . "'";
    $result_rst = mysql_query($sql_rst, $dbacc);
    if ($row_rst = mysql_fetch_array($result_rst)) {

        $_SESSION["mstat"] = "old";

        $naration = str_replace("&nbsp;", " ", $row_rst['naration']);

        $ResponseXML .= "<txt_entno><![CDATA[" . $_GET["recno"] . "]]></txt_entno>";
        $ResponseXML .= "<labcan><![CDATA[" . $row_rst["cancel"] . "]]></labcan>";
        $ResponseXML .= "<Calendar1><![CDATA[" . date("Y-m-d", strtotime($row_rst["bdate"])) . "]]></Calendar1>";
        $ResponseXML .= "<chqdate><![CDATA[" . date("Y-m-d", strtotime($row_rst["chq_date"])) . "]]></chqdate>";
        $bdate = $row_rst["bdate"];
        $ResponseXML .= "<TXT_HEADING><![CDATA[" . $row_rst["heading"] . "]]></TXT_HEADING>";
        $ResponseXML .= "<TXT_NARA><![CDATA[" . $naration . "]]></TXT_NARA>";
        $ResponseXML .= "<txt_bea><![CDATA[" . $row_rst["barer"] . "]]></txt_bea>";

        //$_SESSION["tmp_no_chequepayacc"]=$row_rst["tmp_no"];
        $_SESSION["tmp_no_chequepayacc"] = $row_rst["refno"];

        if (is_null($row_rst["code"]) == true) {
            exit("Invalid Option on Payment Master File");
        } else {


            $sql_rsBANKMASTER = "select * from lcodes where c_code='" . $row_rst["code"] . "'";
            $result_rsBANKMASTER = mysql_query($sql_rsBANKMASTER, $dbacc);
            if ($row_rsBANKMASTER = mysql_fetch_array($result_rsBANKMASTER)) {

                $com_cas = $row_rsBANKMASTER["c_code"];
                $ResponseXML .= "<com_cas><![CDATA[" . $com_cas . "]]></com_cas>";
            }
        }

        $ResponseXML .= "<txt_cheno><![CDATA[" . $row_rst["cheno"] . "]]></txt_cheno>";
        $ResponseXML .= "<mTick1><![CDATA[" . $row_rst["ac_payee"] . "]]></mTick1>";
        $ResponseXML .= "<txtINVNO><![CDATA[" . $row_rst["invno"] . "]]></txtINVNO>";
        $ResponseXML .= "<txtVATNIO><![CDATA[" . $row_rst["vatno"] . "]]></txtVATNIO>";
        if ($row_rst["inv_date"] != "0000-00-00 00:00:00") {
            $ResponseXML .= "<DTinv_date><![CDATA[" . date("Y-m-d", strtotime($row_rst["inv_date"])) . "]]></DTinv_date>";
        } else {
            $ResponseXML .= "<DTinv_date><![CDATA[]]></DTinv_date>";
        }
        $ResponseXML .= "<txtvatbea><![CDATA[" . $row_rst["bea1"] . "]]></txtvatbea>";
        $ResponseXML .= "<txtVATNO><![CDATA[" . $row_rst["vatno"] . "]]></txtVATNO>";
        $ResponseXML .= "<v_barer1><![CDATA[" . $row_rst["v_barer1"] . "]]></v_barer1>";
        $ResponseXML .= "<vat1><![CDATA[" . $row_rst["vat1"] . "]]></vat1>";
        $ResponseXML .= "<v_barer2><![CDATA[" . $row_rst["v_barer2"] . "]]></v_barer2>";
        $ResponseXML .= "<vat2><![CDATA[" . $row_rst["vat2"] . "]]></vat2>";
        $ResponseXML .= "<v_barer3><![CDATA[" . $row_rst["v_barer3"] . "]]></v_barer3>";
        $ResponseXML .= "<vat3><![CDATA[" . $row_rst["vat3"] . "]]></vat3>";
        $ResponseXML .= "<Combo1><![CDATA[" . $row_rst["invno"] . "]]></Combo1>";

        $sql = "delete from tmp_cheque_pay where entno='" . trim($_GET["recno"]) . "'";
        $result = mysql_query($sql, $dbacc);

        $sql_rst = "Select * from cashpaytrn where refno='" . trim($_GET["recno"]) . "'";
        $result_rst = mysql_query($sql_rst, $dbacc);
        while ($row_rst = mysql_fetch_array($result_rst)) {
            $code = $row_rst["code"];

            $sql_rst1 = "Select * from lcodes where C_CODE='" . $row_rst["code"] . "'";
            $result_rst1 = mysql_query($sql_rst1, $dbacc);
            if ($row_rst1 = mysql_fetch_array($result_rst1)) {
                $c_name = $row_rst1["c_name"];
            }

            $nara = $row_rst["nara"];
            $amount = $row_rst["amount"];

            $sql1 = "insert into tmp_cheque_pay(entno, accno, accname, descript, amt, tmp_no) values ('" . trim($_GET["recno"]) . "', '" . $code . "', '" . $c_name . "', '" . $nara . "', " . $amount . ", '" . $_SESSION["tmp_no_chequepayacc"] . "')";
            $result1 = mysql_query($sql1, $dbacc);
        }




        $ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";


        $i = 1;
        $sql = "select * from tmp_cheque_pay where tmp_no='" . $_SESSION["tmp_no_chequepayacc"] . "' ";
        $result = mysql_query($sql, $dbacc);
        while ($row = mysql_fetch_array($result)) {

            $accno = "accno_acc" . $i;
            $accname = "accname_acc" . $i;
            $descript = "descript_acc" . $i;
            $amt = "amt_acc" . $i;

            $ResponseXML .= "<tr>
					<td><input type=\"text\" name=\"" . $accno . "\" id=\"" . $accno . "\" onblur=\"set_acc('" . $row["accno"] . "', '" . $i . "');\" value=\"" . $row["accno"] . "\" /></td>
					<td><input type=\"text\" name=\"" . $accname . "\" id=\"" . $accname . "\" value=\"" . $row["accname"] . "\" /></td>
					<td><input type=\"text\" name=\"" . $descript . "\" id=\"" . $descript . "\" value=\"" . $row["descript"] . "\" />" . $row["descript"] . "</td>
					<td align=right><input type=\"text\" name=\"" . $amt . "\" id=\"" . $amt . "\" onblur=\"setamt_opr('" . $i . "');\" value=\"" . number_format($row["amt"], 2, ".", "") . "\" /></td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['accno'] . "  name=" . $row['accno'] . " onClick=\"del_item('" . $row['accno'] . "');\"></td></tr>";
            $totchq = $totchq + $row["amt"];

            $i = $i + 1;
            $amt = $amt + 1;
        }

        $ResponseXML .= "   </table>]]></chq_table>";
        $ResponseXML .= "<TXT_DEBTOT><![CDATA[" . number_format($totchq, 2, ".", "") . "]]></TXT_DEBTOT>";
    }

    $sql_rst = "Select * from lock_bank_rec where bank_code='" . trim($com_cas) . "'";
    $result_rst = mysql_query($sql_rst, $dbacc);
    if ($row_rst = mysql_fetch_array($result_rst)) {

        if (strtotime($bdate) <= strtotime($row_rst["lock_date_to"])) {
            $ResponseXML .= "<canedit><![CDATA[0]]></canedit>";
        } else {
            $ResponseXML .= "<canedit><![CDATA[1]]></canedit>";
        }
    } else {
        $ResponseXML .= "<canedit><![CDATA[1]]></canedit>";
    }

    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}


if ($_GET["Command"] == "edit_ch_cus") {


    if ($_GET["checkbox"] == "true") {
        $sql = "Update che_customers set active='1' where chepay='" . $_GET["cus"] . "'";
        echo $sql;
        $result = mysql_query($sql, $dbacc);
    } else {
        $sql = "Update che_customers set active='0' where chepay='" . $_GET["cus"] . "'";
        echo $sql;
        $result = mysql_query($sql, $dbacc);
    }
}


if ($_GET["Command"] == "delete_rec") {
    $ResponseXML = "";

    //if ($_GET["invdate"]==date("Y-m-d")){

    $sql = "Select * from lock_table";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    if ($row["lock_date"] >= $_GET["invdate"]) {
        exit("Can't DELETE. This Transaction id Locked!!!");
    }


    $sql = "Select * from lock_bank_rec where bank_code='" . $_GET["com_cas"] . "'";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    if ($row["lock_date_to"] >= $_GET["invdate"]) {
        exit("Can't Add NEW Transaction. Reconciliation is Completed!!!");
    }


    mysql_query("START TRANSACTION", $dbinv);



    $sql = "Update cashpaytrn set cancel='1' where refno='" . trim($_GET["txt_entno"]) . "'";
    $result = mysql_query($sql, $dbacc);

    $sql = "Update paymas set cancel='1' where refno = '" . trim($_GET["txt_entno"]) . "'";
    $result = mysql_query($sql, $dbacc);

    $sql = "Delete   from ledger where l_refno = '" . trim($_GET["txt_entno"]) . "'";
    $result = mysql_query($sql, $dbacc);




    $ResponseXML = "Canceled";

    //} else {
    //	$ResponseXML = "Sorry Cant Cancel.... please check reciept date";
    //}

    echo $ResponseXML;
}


mysql_close($dbacc);
mysql_close($dbinv);
?>