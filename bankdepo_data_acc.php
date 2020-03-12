<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
include('connection.php');

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_GET["Command"] == "get_bank") {
    $sql = "select * from bankmas where bcode='" . $_GET["bankcode"] . "'";
    $result = mysql_query($sql, $dbinv);
    if ($row = mysql_fetch_array($result)) {
        echo $row["bname"];
    }
}

if ($_GET["Command"] == "setamt") {
    $sql = "update tmp_bankdepo_account set amt=" . $_GET["amt"] . " where  entno='" . $_GET["txt_entno"] . "' and accno='" . $_GET["accno"] . "' and tmp_no= '" . $_SESSION['tmp_no_bankdepo_acc'] . "'";
    //echo $sql;
    $result = mysql_query($sql, $dbacc);

    $sql = "select sum(amt) as totamt from tmp_bankdepo_account where  entno='" . $_GET["txt_entno"] . "' and tmp_no= '" . $_SESSION['tmp_no_bankdepo_acc'] . "'";
    //echo $sql;
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    echo $row["totamt"];
}


if ($_GET["Command"] == "setamt2") {
    $sql = "update tmp_bankdepo_chq set amt=" . $_GET["amt"] . " where  chqno='" . $_GET["chqno"] . "' and tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "'";
    //echo $sql;
    $result = mysql_query($sql, $dbacc);

    $sql = "select sum(amt) as totamt from tmp_bankdepo_chq where  chqno='" . $_GET["chqno"] . "' and tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "'";
    //echo $sql;
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    echo $row["totamt"];
}



if ($_GET["Command"] == "addchq_cash_rec1") {

    //echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec
    //$sql="delete from tmp_bankdepo_account where accno='".$_GET["accno1"]."' and tmp_no='".$_SESSION['tmp_no_bankdepo_acc']."'";
    //$result=mysql_query($sql, $dbacc);

    $descript1 = str_replace("~", "&", $_GET["descript1"]);

    $TXT_DETAILS = str_replace("~", "&", $descript1);
    $TXT_DETAILS = str_replace("&nbsp;", " ", $TXT_DETAILS);


    $sql = "insert into tmp_bankdepo_account(entno, accno, accname, descript, amt, tmp_no) values ('" . $_GET["txt_entno"] . "', '" . $_GET["accno1"] . "', '" . $_GET["acc_name1"] . "', '" . $TXT_DETAILS . "', " . $_GET["amt1"] . ", '" . $_SESSION['tmp_no_bankdepo_acc'] . "')";
    $result = mysql_query($sql, $dbacc);

    $totamt = 0;
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"100\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"200\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";

    $i = 1;
    $sql = "select * from tmp_bankdepo_account where tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "' ";
    $result = mysql_query($sql, $dbacc);
    while ($row = mysql_fetch_array($result)) {
        $accno = "accno_acc" . $i;
        $accname = "accname_acc" . $i;
        $descript = "descript_acc" . $i;
        $amt = "amt_acc" . $i;

        $ResponseXML .= "<tr>
					<td><input type=\"text\" name=\"" . $accno . "\" id=\"" . $accno . "\" onblur=\"set_acc('" . $row["accno"] . "', '" . $i . "');\" value=\"" . $row["accno"] . "\" /></td>
					<td><input type=\"text\" name=\"" . $accname . "\" id=\"" . $accname . "\" value=\"" . $row["accname"] . "\" /></td>";
        $descript_txt = str_replace("~", "&", $row["descript"]);
        $ResponseXML .= "<td><input type=\"text\" name=\"" . $descript . "\" id=\"" . $descript . "\" value=\"" . $row["descript"] . "\" />" . $descript_txt . "</td>
					<td align=right><input type=\"text\" name=\"" . $amt . "\" id=\"" . $amt . "\" onblur=\"setamt_opr('" . $i . "');\" value=\"" . number_format($row["amt"], 2, ".", "") . "\" /></td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['accno'] . "  name=" . $row['accno'] . " onClick=\"del_item1('" . $row['accno'] . "');\"></td></tr>";


        $totamt = $totamt + $row["amt"];
        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></chq_table>";
    $ResponseXML .= "<totamt><![CDATA[" . number_format($totamt, 2, ".", "") . "]]></totamt>";

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "addchq_cash_rec2") {

    //echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec

    $sql = "delete from tmp_bankdepo_chq where chqno='" . $_GET["chqno"] . "' and tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "'";
    $result = mysql_query($sql, $dbacc);

    if ($_GET["narration"] == "") {
        $narration = str_replace("~", "&", $_GET["TXT_HEADING"]);
    } else {
        $narration = str_replace("~", "&", $_GET["narration"]);
    }

    $TXT_DETAILS = str_replace("~", "&", $narration);
    $TXT_DETAILS = str_replace("&nbsp;", " ", $TXT_DETAILS);

    $sql = "insert into tmp_bankdepo_chq(id, entno, chqno, chqdate, narration, bank, amt, tmp_no) values ('" . $_GET["id"] . "', '" . $_GET["txt_entno"] . "', '" . $_GET["chqno"] . "', '" . $_GET["chqdate"] . "', '" . $TXT_DETAILS . "', '" . $_GET["bank"] . "', " . $_GET["chqamt"] . ", '" . $_SESSION['tmp_no_bankdepo_acc'] . "')";
    $result = mysql_query($sql, $dbacc);

    $totamt = 0;
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Narration</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Bank</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					<td width=\"0\"  background=\"images/headingbg.gif\"></td>
					<td width=\"0\"  background=\"images/headingbg.gif\"></td>
					</tr>";

    $i = 1;
    $sql = "select * from tmp_bankdepo_chq where tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "' ";
    $result = mysql_query($sql, $dbacc);
    while ($row = mysql_fetch_array($result)) {

        $amt = "amteditchq" . $i;

        $ResponseXML .= "<tr>
					<td>" . $row["chqno"] . "</td>
					<td>" . $row["chqdate"] . "</td>
					<td>" . $row["narration"] . "</td>
					<td>" . $row["bank"] . "</td>
					<td>" . number_format($row["amt"], 2, ".", "") . "</td>
					
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['chqno'] . "  name=" . $row['chqno'] . " onClick=\"del_item2('" . $row['chqno'] . "');\"></td>
					<td>" . $row["id"] . "</td></tr>";


        $totamt = $totamt + $row["amt"];
        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></chq_table>";
    $ResponseXML .= "<totamt><![CDATA[" . number_format($totamt, 2, ".", "") . "]]></totamt>";

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "del_item2") {

    //echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec

    $sql = "delete from tmp_bankdepo_chq where chqno='" . $_GET["accno1"] . "' and tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "'";
    $result = mysql_query($sql, $dbacc);

    //echo $sql;

    $totamt = 0;
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Narration</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Bank</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					<td width=\"0\"  background=\"images/headingbg.gif\"></td>
					<td width=\"0\"  background=\"images/headingbg.gif\"></td>
					</tr>";

    $sql = "select * from tmp_bankdepo_chq where tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "' ";
    $result = mysql_query($sql, $dbacc);
    while ($row = mysql_fetch_array($result)) {
        $ResponseXML .= "<tr>
					<td>" . $row["chqno"] . "</td>
					<td>" . $row["chqdate"] . "</td>
					<td>" . $row["narration"] . "</td>
					<td>" . $row["bank"] . "</td>
					<td align=right>" . number_format($row["amt"], 2, ".", ",") . "</td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['chqno'] . "  name=" . $row['chqno'] . " onClick=\"del_item2('" . $row['chqno'] . "');\"></td>
					<td>" . $row["id"] . "</td></tr>";


        $totamt = $totamt + $row["amt"];
    }

    $ResponseXML .= "   </table>]]></chq_table>";
    $ResponseXML .= "<totamt><![CDATA[" . $totamt . "]]></totamt>";

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "addchq_cash_rec3") {

    //echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec

    $sql = "delete from tmp_bankdepo_depo where accno='" . $_GET["accno1"] . "' and tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "'";
    $result = mysql_query($sql, $dbacc);

    $sql = "insert into tmp_bankdepo_depo(entno, accno, accname, descript, amt, tmp_no) values ('" . $_GET["txt_entno"] . "', '" . $_GET["accno1"] . "', '" . $_GET["acc_name1"] . "', '" . $_GET["descript1"] . "', " . $_GET["amt1"] . ", '" . $_SESSION['tmp_no_bankdepo_acc'] . "')";
    $result = mysql_query($sql, $dbacc);

    $totamt = 0;
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";

    $sql = "select * from tmp_bankdepo_account where tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "' ";
    $result = mysql_query($sql, $dbacc);
    while ($row = mysql_fetch_array($result)) {
        $ResponseXML .= "<tr>
					<td>" . $row["accno"] . "</td>
					<td>" . $row["accname"] . "</td>
					<td>" . $row["descript"] . "</td>
					<td align=right>" . number_format($row["amt"], 2, ".", ",") . "</td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['accno'] . "  name=" . $row['accno'] . " onClick=\"del_item('" . $row['accno'] . "');\"></td></tr>";


        $totamt = $totamt + $row["amt"];
    }

    $ResponseXML .= "   </table>]]></chq_table>";
    $ResponseXML .= "<totamt><![CDATA[" . $totamt . "]]></totamt>";

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "del_item1") {

    $sql = "delete from tmp_bankdepo_account where accno='" . $_GET["accno1"] . "' and tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "'";
    $result = mysql_query($sql, $dbacc);



    $totamt = 0;
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"100\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"200\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";

    $sql = "select * from tmp_bankdepo_account where tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "' ";
    $result = mysql_query($sql, $dbacc);
    while ($row = mysql_fetch_array($result)) {
        $ResponseXML .= "<tr>
					<td>" . $row["accno"] . "</td>
					<td>" . $row["accname"] . "</td>
					<td>" . $row["descript"] . "</td>
					<td align=right>" . number_format($row["amt"], 2, ".", ",") . "</td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['accno'] . "  name=" . $row['accno'] . " onClick=\"del_item1('" . $row['accno'] . "');\"></td></tr>";


        $totamt = $totamt + $row["amt"];
    }

    $ResponseXML .= "   </table>]]></chq_table>";
    $ResponseXML .= "<totamt><![CDATA[" . $totamt . "]]></totamt>";

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "del_item") {


    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    $sql = "delete from tmp_cash_pay where accno='" . $_GET["accno"] . "' and tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "'";
    $result = mysql_query($sql, $dbacc);


    $ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"100\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"200\"  background=\"images/headingbg.gif\">Account Name</td>
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
					<td><input type=\"text\" name=\"" . $accname . "\" id=\"" . $accname . "\" value=\"" . $row["accname"] . "\" /></td>";
        $descript_txt = str_replace("~", "&", $row["descript"]);
        $ResponseXML .= "<td><input type=\"text\" name=\"" . $descript . "\" id=\"" . $descript . "\" value=\"" . $row["descript"] . "\" />" . $descript_txt . "</td>
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



    $sql = "select * from dep_mas";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    $tmprecno = "000000" . $row["bankdep"];
    $lenth = strlen($tmprecno);
    $recno = $_SESSION['company'] . "/" . date("y") . "/R/" . substr($tmprecno, $lenth - 7);




    $sql = "SELECT bankdep FROM  tmpdep_mas";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    $tmprecno = "000000" . $row["bankdep"];
    $lenth = strlen($tmprecno);
    $_SESSION["tmp_no_bankdepo_acc"] = $_SESSION['company'] . "/" . date("y") . "/R/" . substr($tmprecno, $lenth - 7);

    $sql = "update tmpdep_mas set bankdep=bankdep+1";
    $result = mysql_query($sql, $dbacc);

    $sql = "delete from tmp_bankdepo_chq where tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "'";
    $result = mysql_query($sql, $dbacc);

    $sql = "delete from tmp_bankdepo_account where tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "'";
    $result = mysql_query($sql, $dbacc);

    $_SESSION["txt_stat"] = "new";
    $_SESSION["m_stat"] = "new";

    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<current_date><![CDATA[" . date("Y-m-d") . "]]></current_date>";
    $ResponseXML .= "<recno><![CDATA[" . $recno . "]]></recno>";
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}


if ($_GET["Command"] == "save_crec") {
    include('connection.php');

    //$ResponseXML = "";
    //$ResponseXML .= "<salesdetails>";
    //echo $_SESSION["m_stat"];

    if ($_SESSION['company'] == "") {
        exit("Please login again");
    }


    $sql = "select * from  dep_mas";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    if (($row["datefrom"] <= $_GET["Calendar1"]) and ($_GET["Calendar1"] <= $row["dateto"])) {
        
    } else {
        exit("Out of Current Accounting Year");
    }


    $sql = "Select * from lock_table";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    if ($row["lock_date"] >= $_GET["Calendar1"]) {
        exit("Can't EDIT. This Transaction id Locked!!!");
    }

    //////////////////
    //Call SETTOTAL
    if (($_SESSION["m_stat"] == "new") or ($_SESSION["m_stat"] == "edit")) {
        
    } else {
        exit("Invalid Option, Please Select Option 'New' and Save Entry");
    }

    if ($_GET["txtCreTot"] != $_GET["txtDebTot"]) {
        exit("Cheque Deposit Account Total and ,Cheque Total Not Tallying");
    }







    if ($_SESSION["m_stat"] == "new") {

        $sql = "select * from dep_mas";
        $result = mysql_query($sql, $dbacc);
        $row = mysql_fetch_array($result);
        $tmprecno = "000000" . $row["bankdep"];
        $lenth = strlen($tmprecno);
        $recno = $_SESSION['company'] . "/" . date("y") . "/R/" . substr($tmprecno, $lenth - 7);

        $sql_rec = "select * from ledger where l_refno='" . trim($recno) . "'";
        $result_rec = mysql_query($sql_rec, $dbacc);
        if ($row_rec = mysql_fetch_array($result_rec)) {
            exit("Entry No is Already Exist !!!");
        }
    } else {
        $recno = $_GET["txt_entno"];
    }

    $sql1 = "Select * from lock_bank_rec where bank_code='" . $_GET["Com_bank"] . "'";
    //echo $sql1;
    $result1 = mysql_query($sql1, $dbacc);
    $row1 = mysql_fetch_array($result1);
    if (strtotime($row1["lock_date_to"]) >= strtotime($_GET["Calendar1"])) {

        $sql_p = "Select * from ledger where l_refno='" . $_GET["txt_entno"] . "'";
        //echo $sql_p;
        $result_p = mysql_query($sql_p, $dbacc);
        if ($row_p = mysql_fetch_array($result_p)) {

            if (strtotime($row_p["l_date"]) > strtotime($row1["lock_date_to"])) {
                exit("Can't EDIT Date. Reconciliation is Completed!!!");
            }
        }
    } else {
        $sql_p = "Select * from ledger where l_refno='" . $_GET["txt_entno"] . "'";
        //echo $sql_p;
        $result_p = mysql_query($sql_p, $dbacc);
        if ($row_p = mysql_fetch_array($result_p)) {
            if (strtotime($row_p["l_date"]) <= strtotime($row1["lock_date_to"])) {
                exit("Can't EDIT Date. Reconciliation is Completed!!!");
            }
        }
    }

    if ($recno == "") {
        $m_ok = "Reference No Not Entered";
    }

    if (($_GET["txtCreTot"] == 0) and ($_GET["txtDebTot"] == 0) and ($_GET["txtcash"] == 0)) {
        $m_ok = "Entry Is Incomplete";
    }


    $sql_rspaymas = "Select sum(l_amount) as tot_l_amount from ledger where l_refno='" . trim($recno) . "' and lock1='1' and l_code='" . $_GET["Com_bank"] . "'";
    //echo $sql_rspaymas;
    $result_rspaymas = mysql_query($sql_rspaymas, $dbacc);
    $row_rspaymas = mysql_fetch_array($result_rspaymas);
    if ($row_rspaymas["tot_l_amount"] > 0) {
        if (($_GET["txtDebTot"] != $row_rspaymas["tot_l_amount"]) or ($_GET["txtCreTot"] != $row_rspaymas["tot_l_amount"])) {
            exit("Sorry You Have Changed The Cheque Value");
        }
    }

    $sql_rspaymas = "Select * from ledger where l_refno='" . trim($recno) . "' and lock1='1' and l_code='" . $_GET["Com_bank"] . "'";
    $result_rspaymas = mysql_query($sql_rspaymas, $dbacc);
    if ($row_rspaymas = mysql_fetch_array($result_rspaymas)) {
        if ($_GET["Calendar1"] != $row_rspaymas["l_date"]) {
            exit("Sorry You Have Changed The Date");
        }
    }


    if ($m_ok != "") {
        exit($m_ok);
    }

    mysql_query("START TRANSACTION", $dbacc);

    if ($_SESSION["m_stat"] == "new") {
        $sql = "update dep_mas set bankdep=bankdep+1 where code='" . $_SESSION['company'] . "'";
        $result = mysql_query($sql, $dbacc);
    }


    $sql = "Delete from bankdepmas where refno = '" . $recno . "'";
    $result = mysql_query($sql, $dbacc);

    //	$sql="Delete from bankdeptrn where refno = '" . $_GET["txt_entno"] . "'";
    //	$result=mysql_query($sql, $dbacc);

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

    $sql = "Delete from ledger where l_refno = '" . $recno . "'";
    $result = mysql_query($sql, $dbacc);

    $sql = "Delete from bankdepche where refno = '" . $recno . "'";
    $result = mysql_query($sql, $dbacc);

    $sql = "Update s_invcheq  set ret_refno='0' where ret_refno='" . trim($recno) . "'";
    $result = mysql_query($sql, $dbinv);

    $sql = "delete from s_invcheq_tmp  where ret_refno='" . trim($recno) . "'";
    $result = mysql_query($sql, $dbinv);



    $sql_rsBANKDEPTRNp = "select * from bankdeptrn where refno = '" . $recno . "'";
    $result_rsBANKDEPTRNp = mysql_query($sql_rsBANKDEPTRNp, $dbacc);
    $row_rsBANKDEPTRNp = mysql_fetch_array($result_rsBANKDEPTRNp);

    $m_flag1 = "";

    $sql_rst = "select * from ledger where l_refno = '" . $recno . "'";
    $result_rst = mysql_query($sql_rst, $dbacc);
    while ($row_rst = mysql_fetch_array($result_rst)) {
        $m_amount = $row_rst["l_amount"];
        $m_account = $row_rst["l_code"];

        if (is_null($row_rst["l_flag1"]) == false) {
            $m_flag1 = $row_rst["l_flag1"];
        }
        $m_flag1 = "";
    }

    $sql_rst = "Delete   from ledger where l_refno = '" . $recno . "'";
    $result_rst = mysql_query($sql_rst, $dbacc);

    $sql_rst = "Delete   from bankdeptrn where refno = '" . $recno . "'";
    $result_rst = mysql_query($sql_rst, $dbacc);


    $m_ok = "";

    $TXT_DETAILS = str_replace("~", "&", $_GET["TXT_HEADING"]);
    $TXT_DETAILS = str_replace("&nbsp;", " ", $TXT_DETAILS);
    //$TXT_DETAILS=str_replace("'", "''", $TXT_DETAILS);	

    if ($m_ok == "") {


        if (trim($TXT_DETAILS) != "") {
            $mHead = trim($TXT_DETAILS);
        }
        if (trim($_GET["Com_bank"]) != "") {
            $mCode = trim($_GET["Com_bank"]);
        }

        $sql = "select * from bankmaster where bm_code='" . $mCode . "'";
        $result = mysql_query($sql, $dbacc);
        $row = mysql_fetch_array($result);

        //if (trim($_GET["Com_bank"]) != "") { $mName = trim($_GET["Com_bank"]); }
        if ($_GET["totval"] > 0) {
            $mAmount = $_GET["totval"];
        }
        if ($_GET["txtcash"] > 0) {
            $mCash = $_GET["txtcash"];
        }
        $mAmount = $_GET["totval"];

        $sql_rst = "Insert into bankdepmas (refno, bdate, heading, code, name, amount, cash, comcode, cancel, type, tmp_no) Values ('" . trim($recno) . "', '" . $_GET["Calendar1"] . "', '" . $mHead . "', '" . $mCode . "', '" . $row["bm_bank"] . "', " . $mAmount . ", 0,'" . $_SESSION['company'] . "', '0', 'D', '" . $_SESSION['tmp_no_bankdepo_acc'] . "')";
        //echo $sql_rst;
        $result_rst = mysql_query($sql_rst, $dbacc);


        if ($_GET["txtCreTot"] > 0) {
            $mAmount = $_GET["TXT_DEBTOT"];
        }



        // if (is_null(trim($TXT_DETAILS))==false) { $mHead = trim($TXT_DETAILS); }
        //if (is_null(trim($m_nara))==false) { $mNara = trim($m_nara); }



        $sql_rst = "select * from tmp_bankdepo_account where tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "'";
        $result_rst = mysql_query($sql_rst, $dbacc);
        while ($row_rst = mysql_fetch_array($result_rst)) {

            $mCode = $row_rst["accno"];
            $mHead = $row_rst["accname"];
            //$mNara = $row_rst["descript"];
            $mAmount = $row_rst["amt"];

            $mNara = str_replace("~", "&", $row_rst["descript"]);
            $mNara = str_replace("&nbsp;", " ", $mNara);
            $mNara = str_replace("'", "''", $mNara);


            if (($mCode != "") and ($mAmount != 0)) {
                $sql = "Insert into bankdeptrn(refno, bdate, code, amount, flag, nara, comcode, tmp_no) Values ('" . trim($recno) . "', '" . $_GET["Calendar1"] . "', '" . trim($mCode) . "', " . $mAmount . ", 'CRE', '" . trim($mNara) . "' ,'" . $_SESSION['company'] . "', '" . $row_rst["tmp_no"] . "')";
                $result = mysql_query($sql, $dbacc);
                //echo $sql;


                if ($_GET["txtDebTot"] > 0) {
                    $mAmount = $mAmount;
                }

                // if (is_null(trim($mNara))==false) { $mNara = trim($mNara); }
                if (is_null(trim($TXT_DETAILS)) == false) {
                    $mHead = trim($TXT_DETAILS);
                }



                $sql = "Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1,  l_lmem, l_head, comcode, l_flag2, l_flag3, l_flag4, l_yearfl, l_bank, rights, chno, l_year, op_bal1, l_month, recdate, user, ent_datetime) Values ( '" . trim($recno) . "', '" . $_GET["Calendar1"] . "', '" . trim($mCode) . "', " . $mAmount . ", 'BDE', 'CRE', '" . $TXT_DETAILS . "', '" . $TXT_DETAILS . "',  '" . $_SESSION['company'] . "', '', 'R', '', 0 , '" . $_GET["Com_bank"] . "', '0', '', '" . date("Y") . "', 0, '" . $l_month . "', '" . $recdate . "', '" . $_SESSION['UserName'] . "', '" . date("Y-m-d H:i:s") . "')";
                $result = mysql_query($sql, $dbacc);
                //echo "1-".$sql;
            }
        }

        $sql = "delete   from bankdepche  where refno='" . trim($recno) . " '";
        $result = mysql_query($sql, $dbacc);



        $mAmount = 0;
        $sql_rst = "select * from tmp_bankdepo_chq where tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "'";
        $result_rst = mysql_query($sql_rst, $dbacc);
        while ($row_rst = mysql_fetch_array($result_rst)) {

            $mAmount = $row_rst["amt"];

            $mNara = str_replace("~", "&", $row_rst["narration"]);
            $mNara = str_replace("&nbsp;", " ", $mNara);
            $mNara = str_replace("'", "''", $mNara);

            if (($row_rst["entno"] != "") and ($row_rst["amt"] > 0)) {

                $sql = "Insert into bankdeptrn(refno, bdate, code, amount, flag, comcode, tmp_no) Values ('" . trim($recno) . "', '" . $_GET["Calendar1"] . "', '" . trim($_GET["Com_bank"]) . "', " . $mAmount . ", 'DEB','" . $_SESSION['company'] . "', '" . $row_rst["tmp_no"] . "' )";
                $result = mysql_query($sql, $dbacc);
                //echo $sql;


                if ($row_rst["id"] != "") {
                    $sql = "Update s_invcheq  set ret_refno='" . trim($recno) . "' where id=" . $row_rst["id"] . "";
                    $result = mysql_query($sql, $dbinv);

                    $sql = "insert into s_invcheq_tmp  (id, ret_refno) values (" . $row_rst["id"] . ", '" . trim($recno) . "')";
                    $result = mysql_query($sql, $dbinv);
                    //echo $sql;
                }

                $sql = "Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_flag2, l_flag3, l_flag4, l_bank, l_head, l_lmem, rights, chno, comcode, l_year, l_month, recdate, user, ent_datetime) Values ('" . trim($recno) . "', '" . $_GET["Calendar1"] . "', '" . trim($_GET["Com_bank"]) . "', " . $mAmount . ", 'BDE', 'DEB', '0', 'R', 'CHQ', '" . trim($_GET["Com_bank"]) . "', '" . trim($TXT_DETAILS) . "', '" . trim($TXT_DETAILS) . "', '" . $mUserWrite . "', '" . $row_rst["chqno"] . "','" . $_SESSION['company'] . "', " . date("Y") . ", '" . $l_month . "', '" . $recdate . "', '" . $_SESSION['UserName'] . "', '" . date("Y-m-d H:i:s") . "')";
                //echo "2-". $sql;
                $result = mysql_query($sql, $dbacc);

                $sql = "Insert into bankdepche(refno, cheno, bdate, ven_code, ven_name, bank, amount ,comcode, id  ) Values ('" . trim($recno) . "', '" . $row_rst["chqno"] . "', '" . $_GET["Calendar1"] . "', '" . $mNara . "', '" . trim($TXT_DETAILS) . "', '" . $row_rst["bank"] . "', " . $mAmount . ",'" . $_SESSION['company'] . "', " . $row_rst["id"] . " )";
                //echo $sql;
                $result = mysql_query($sql, $dbacc);
            }
        }



        $sql_rst = "select * from tmp_bankdepo_depo where tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "'";
        $result_rst = mysql_query($sql_rst, $dbacc);
        while ($row_rst = mysql_fetch_array($result_rst)) {

            $mCode = $row_rst["accno"];
            $mHead = $row_rst["accname"];
            // $mNara = $row_rst["descript"];
            $mAmount = $row_rst["amt"];
            if (($mCode != "") and ($mAmount != 0)) {


                $sql = "Insert into bankdeptrn(refno, bdate, code, amount, flag, nara, comcode, tmp_no) Values ('" . trim($recno) . "', '" . $_GET["Calendar1"] . "', '" . trim($mCode) . "', " . $mAmount . ", 'DEB', '" . trim($mNara) . "',  '" . $_SESSION['company'] . "', '" . $row_rst["tmp_no"] . "')";
                //echo $sql;
                $result = mysql_query($sql, $dbacc);


                if ($_GET["txtcash"] > 0) {
                    $mAmount = $mAmount;
                }

                //   if (is_null(trim($mNara))==false) { $mNara = trim($mNara); }
                //  if (is_null(trim($TXT_DETAILS))==false ) { $mHead = trim($TXT_DETAILS); }



                $sql = "Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_flag2, l_flag3, l_flag4, l_lmem, l_head, l_bank, rights, comcode, l_month, recdate) Values ('" . trim($recno) . "', '" . $_GET["Calendar1"] . "', '" . trim($mCode) . "', " . $mAmount . ", 'BDE', 'CRE', '', 'R', '', '" . $mNara . "', '" . $mHead . "', '" . trim($_GET["Com_bank"]) . "', '" . $mUserWrite . "', '" . $_SESSION['company'] . "', '" . $l_month . "', '" . $recdate . "')";
                //echo "3-". $sql;
                $result = mysql_query($sql, $dbacc);

                $sql = "Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_flag2, l_flag3, l_flag4, l_lmem, l_head, l_bank, rights, comcode, chno, l_month, recdate) Values ('" . trim($recno) . "', '" . $_GET["Calendar1"] . "', '" . trim($_GET["txtBankCode"]) . "', " . $mAmount . ", 'BDE', 'DEB', '0', 'R', 'CAS', '" . $mNara . "', '" . $mHead . "', '" . trim($_GET["txtBankCode"]) . "', '" . $mUserWrite . "', '" . $_SESSION['company'] . "','Cash', '" . $l_month . "', '" . $recdate . "')";
                //echo "4-". $sql;
                $result = mysql_query($sql, $dbacc);
            }
        }
    }

    /*   if ($_SESSION["m_stat"] == "new") {

      $sql="Update dep_mas set bankdep= bankdep + 1 where code='" . $_SESSION['company'] . "'";
      $result=mysql_query($sql, $dbacc);

      $sql="Update bankmaster set dep_no= dep_no + 1 where bm_code='" . $_GET["txtBankCode"] . "'";
      $result=mysql_query($sql, $dbacc);
      } */




    $_SESSION["m_stat"] = "";

    mysql_query("COMMIT", $dbacc);


    echo $recno;
    //echo  "Records are saved";
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



    $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"250\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ref No</font></td>
                              <td width=\"124\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Date</font></td>
							   <td width=\"124\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Code</font></td>
							   <td width=\"224\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Amount</font></td>
							   
                             
   							</tr>";

    if ($_GET["mfield"] == "recno") {
        $letters = $_GET['recno'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        //$letters="/".$letters;
        //$a="SELECT * from s_salma where REF_NO like  '$letters%'";
        //echo $a;
        echo $sql;
        $sql = "select * from bankdepmas where cancel!='1' and refno like '$letters%' ORDER BY bdate desc limit 50";
        $result = mysql_query($sql, $dbacc);
    } /* else if ($_GET["mstatus"]=="recdate"){
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
        $REF_NO = $row['CA_REFNO'];
        $stname = $_GET["mstatus"];
        $ResponseXML .= "<tr>
                           	  <td onclick=\"recno('" . $row['refno'] . "');\">" . $row['refno'] . "</a></td>
                              <td onclick=\"recno('" . $row['refno'] . "');\">" . date("Y-m-d", strtotime($row["bdate"])) . "</a></td>
							  <td onclick=\"recno('" . $row['refno'] . "');\">" . $row["code"] . "</a></td>
							  <td onclick=\"recno('" . $row['refno'] . "');\">" . $row['amount'] . "</a></td>
                            </tr>";
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


if ($_GET["Command"] == "pass_edit_rec") {
    $_SESSION["m_stat"] = "edit";
}


if ($_GET["Command"] == "pass_recno") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $_SESSION["m_stat"] = "";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    //Call setGrid
    $sql_bankdepmas = "select * from bankdepmas where refno='" . $_GET["recno"] . "'";
    $result_bankdepmas = mysql_query($sql_bankdepmas, $dbacc);

    if ($row_bankdepmas = mysql_fetch_array($result_bankdepmas)) {

        $_SESSION['tmp_no_bankdepo_acc'] = $row_bankdepmas["tmp_no"];

        $ResponseXML .= "<refno><![CDATA[" . $row_bankdepmas["refno"] . "]]></refno>";
        $ResponseXML .= "<bdate><![CDATA[" . date("Y-m-d", strtotime($row_bankdepmas["bdate"])) . "]]></bdate>";
        $ResponseXML .= "<code><![CDATA[" . $row_bankdepmas["code"] . "]]></code>";

        $heading = str_replace("~", "&", $row_bankdepmas["heading"]);
        $ResponseXML .= "<heading><![CDATA[" . $heading . "]]></heading>";

        if ($row_bankdepmas["cancel"] == '1') {
            $ResponseXML .= "<cancel><![CDATA[Cancel]]></cancel>";
        } else {
            $ResponseXML .= "<cancel><![CDATA[]]></cancel>";
        }

        $sql_ledg = "select * from ledger where l_refno = '" . trim($_GET["recno"]) . "' and l_flag1='DEB'";
        $result_ledg = mysql_query($sql_ledg, $dbacc);
        if ($row_ledg = mysql_fetch_array($result_ledg)) {

            $ResponseXML .= "<l_code><![CDATA[" . $result_ledg["l_code"] . "]]></l_code>";
        } else {
            $ResponseXML .= "<l_code><![CDATA[]]></l_code>";
        }
    }
    ///////////////////

    $sql = "delete from tmp_bankdepo_account where tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "'";
    $result = mysql_query($sql, $dbacc);


    $sql_cre = "Select * from bankdeptrn where refno = '" . $_GET["recno"] . "' and flag='CRE'";
    $result_cre = mysql_query($sql_cre, $dbacc);
    while ($row_cre = mysql_fetch_array($result_cre)) {

        $sql_lcodes = "select * from lcodes where c_code = '" . $row_cre["code"] . "'";
        $result_lcodes = mysql_query($sql_lcodes, $dbacc);
        $row_lcodes = mysql_fetch_array($result_lcodes);

        $mNara = str_replace("~", "&", $row_cre["nara"]);
        $mNara = str_replace("&nbsp;", " ", $mNara);
        $mNara = str_replace("'", "''", $mNara);

        $sql = "insert into tmp_bankdepo_account(entno, accno, accname, descript, amt, tmp_no) values ('" . $_GET["recno"] . "', '" . $row_cre["code"] . "', '" . $row_lcodes["c_name"] . "', '" . $mNara . "', " . $row_cre["amount"] . ", '" . $_SESSION['tmp_no_bankdepo_acc'] . "')";
        $result = mysql_query($sql, $dbacc);
    }


    $totamt = 0;

    $ResponseXML .= "<acc_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"100\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"200\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";

    $i = 1;
    $sql = "select * from tmp_bankdepo_account where tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "' ";
    $result = mysql_query($sql, $dbacc);
    while ($row = mysql_fetch_array($result)) {

        $accno = "accno_acc" . $i;
        $accname = "accname_acc" . $i;
        $descript = "descript_acc" . $i;
        $amt = "amt_acc" . $i;

        $ResponseXML .= "<tr>
					<td><input type=\"text\" name=\"" . $accno . "\" id=\"" . $accno . "\" onblur=\"set_acc('" . $row["accno"] . "', '" . $i . "');\" value=\"" . $row["accno"] . "\" /></td>
					<td><input type=\"text\" name=\"" . $accname . "\" id=\"" . $accname . "\" value=\"" . $row["accname"] . "\" /></td>";
        $descript_txt = str_replace("~", "&", $row["descript"]);
        $ResponseXML .= "<td><input type=\"text\" name=\"" . $descript . "\" id=\"" . $descript . "\" value=\"" . $row["descript"] . "\" />" . $descript_txt . "</td>
					<td align=right><input type=\"text\" name=\"" . $amt . "\" id=\"" . $amt . "\" onblur=\"setamt_opr('" . $i . "');\" value=\"" . number_format($row["amt"], 2, ".", "") . "\" /></td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['accno'] . "  name=" . $row['accno'] . " onClick=\"del_item1('" . $row['accno'] . "');\"></td></tr>";

        $totamt = $totamt + $row["amt"];
        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></acc_table>";
    $ResponseXML .= "<acc_totamt><![CDATA[" . $totamt . "]]></acc_totamt>";



    /////////////////////	



    $sql = "delete from tmp_bankdepo_chq where tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "'";
    $result = mysql_query($sql, $dbacc);

    $sql_deb = "select * from bankdepche where refno='" . trim($_GET["recno"]) . "'";
    $result_deb = mysql_query($sql_deb, $dbacc);
    while ($row_deb = mysql_fetch_array($result_deb)) {

        $mNara = str_replace("~", "&", $row_deb["ven_code"]);
        $mNara = str_replace("&nbsp;", " ", $mNara);
        $mNara = str_replace("'", "''", $mNara);

        $sql = "insert into tmp_bankdepo_chq(id, entno, chqno, chqdate, narration, bank, amt, tmp_no) values ('" . $row_deb["id"] . "', '" . $row_deb["refno"] . "', '" . $row_deb["cheno"] . "', '" . $row_deb["bdate"] . "', '" . $mNara . "', '" . $row_deb["bank"] . "', " . $row_deb["amount"] . ", '" . $_SESSION['tmp_no_bankdepo_acc'] . "')";
        //echo $sql;
        $result = mysql_query($sql, $dbacc);
    }

    $totamt = 0;


    $ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Narration</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Bank</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					<td width=\"0\"  background=\"images/headingbg.gif\"></td>
					<td width=\"0\"  background=\"images/headingbg.gif\"></td>
					</tr>";

    $sql = "select * from tmp_bankdepo_chq where tmp_no='" . $_SESSION['tmp_no_bankdepo_acc'] . "' ";
    $result = mysql_query($sql, $dbacc);
    while ($row = mysql_fetch_array($result)) {
        $ResponseXML .= "<tr>
					<td>" . $row["chqno"] . "</td>
					<td>" . date("Y-m-d", strtotime($row["chqdate"])) . "</td>";

        $narration = str_replace("~", "&", $row["narration"]);
        $ResponseXML .="<td>" . $narration . "</td>
					<td>" . $row["bank"] . "</td>
					<td align=right>" . $row["amt"] . "</td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['chqno'] . "  name=" . $row['chqno'] . " onClick=\"del_item2('" . $row['chqno'] . "');\"></td>
					<td>" . $row["id"] . "</td></tr>";


        $totamt = $totamt + $row["amt"];
    }

    $ResponseXML .= "   </table>]]></chq_table>";
    $ResponseXML .= "<chq_totamt><![CDATA[" . $totamt . "]]></chq_totamt>";






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

        $sql1 = "update tmp_bankdepo_account set accno='" . trim($row_rst["c_code"]) . "', accname='" . trim($row_rst["c_name"]) . "', descript='" . trim($_GET["TXT_NARA"]) . "' where entno='" . trim($_GET["txt_entno"]) . "' and accno='" . $_GET["old_accno"] . "'";
        $result1 = mysql_query($sql1, $dbacc);

        $ResponseXML .= "<c_code><![CDATA[" . $row_rst["c_code"] . "]]></c_code>";
        $ResponseXML .= "<c_name><![CDATA[" . $row_rst["c_name"] . "]]></c_name>";
        $ResponseXML .= "<TXT_NARA><![CDATA[" . trim($_GET["TXT_NARA"]) . "]]></TXT_NARA>";
        $ResponseXML .= "<i><![CDATA[" . $_GET["i"] . "]]></i>";
    }
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "delete_rec") {
    $ResponseXML = "";

    //if ($_GET["invdate"]==date("Y-m-d")){

    $sql = "Select * from lock_table";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    if ($row["lock_date"] >= $_GET["Calendar1"]) {
        exit("Can't DELETE. This Transaction id Locked!!!");
    }

    $sql = "Select * from lock_bank_rec where bank_code='" . $_GET["Com_bank"] . "'";
    $result = mysql_query($sql, $dbacc);
    $row = mysql_fetch_array($result);
    if ($row["lock_date_to"] >= $_GET["Calendar1"]) {
        exit("Can't Add NEW Transaction. Reconciliation is Completed!!!");
    }

    mysql_query("START TRANSACTION", $dbacc);





    $sql = "Update bankdepmas set cancel = '1' where refno='" . trim($_GET["txt_entno"]) . "'";
    $result = mysql_query($sql, $dbacc);

    // $sql="Delete from bankdeptrn where refno = '" . $_GET["txt_entno"] . "'";
    // $result=mysql_query($sql, $dbacc);

    $sql = "Delete  from ledger where l_refno ='" . trim($_GET["txt_entno"]) . "'";
    $result = mysql_query($sql, $dbacc);

    $sql = "Update s_invcheq  set ret_refno='0' where ret_refno='" . trim($_GET["txt_entno"]) . "'";
    $result = mysql_query($sql, $dbinv);

    $sql = "delete from s_invcheq_tmp  where ret_refno='" . trim($_GET["txt_entno"]) . "'";
    $result = mysql_query($sql, $dbinv);

    mysql_query("COMMIT", $dbacc);

    $ResponseXML = "Canceled";

    //} else {
    //	$ResponseXML = "Sorry Cant Cancel.... please check reciept date";
    //}

    echo $ResponseXML;
}
?>