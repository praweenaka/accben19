<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once("config.inc.php");
require_once("DBConnector.php");
$db = new DBConnector();

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_GET["Command"] == "view_frame") {
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $_SESSION["i"] = $_GET["i"];
    $_SESSION["j"] = $_GET["j"];

    $sql = "select * from acc_cel_cal where mrow=" . $_SESSION["i"] . " and mcol=" . $_SESSION["j"] . "";
    $result = $db->RunQuery($sql);
    if ($row = mysql_fetch_array($result)) {

        $ResponseXML .= "<cell_type><![CDATA[" . $row["cell_type"] . "]]></cell_type>";

        if ($row["cell_type"] == "text") {
            $ResponseXML .= "<description><![CDATA[" . $row["description"] . "]]></description>";
        }

        if ($row["cell_type"] == "acc") {

            $table = "<table width=\"415\" border=\"1\">
      		<tr>
        		<th width=\"92\">Acc Code</th>
        		<th width=\"307\">Acc Name</th>
      		</tr>";

            $sql1 = "select * from acc_account_data where mrow=" . $_SESSION["i"] . " and mcol=" . $_SESSION["j"] . "";
            $result1 = $db->RunQuery($sql1);
            while ($row1 = mysql_fetch_array($result1)) {
                $table.="<tr><td>" . $row1["acc_code"] . "</td>";
                $table.="<td>" . $row1["acc_name"] . "</td>";
                $table.="<td><img width=\"20\" height=\"20\" onclick=\"del_item('" . $row1['id'] . "','" . $_SESSION["i"] . "','" . $_SESSION["j"] . "');\" name=\'" . $id . "'\" id=\'" . $id . "'\" src=\"images/delete_01.png\"></td></tr>";
            }

            $table.="</table>";

            $ResponseXML .= "<description><![CDATA[" . $table . "]]></description>";
        }

        if ($row["cell_type"] == "opr") {
            $ResponseXML .= "<r1><![CDATA[" . $row["mrow1"] . "]]></r1>";
            $ResponseXML .= "<c1><![CDATA[" . $row["mcol1"] . "]]></c1>";
            $ResponseXML .= "<r2><![CDATA[" . $row["mrow2"] . "]]></r2>";
            $ResponseXML .= "<c2><![CDATA[" . $row["mcol2"] . "]]></c2>";

            $ResponseXML .= "<r3><![CDATA[" . $row["mrow3"] . "]]></r3>";
            $ResponseXML .= "<c3><![CDATA[" . $row["mcol3"] . "]]></c3>";

            $ResponseXML .= "<r4><![CDATA[" . $row["mrow4"] . "]]></r4>";
            $ResponseXML .= "<c4><![CDATA[" . $row["mcol4"] . "]]></c4>";

            $ResponseXML .= "<operat><![CDATA[" . $row["opr"] . "]]></operat>";
        }
    } else {
        $ResponseXML .= "<cell_type><![CDATA[text]]></cell_type>";
        $ResponseXML .= "<description><![CDATA[]]></description>";
    }

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "save_pnldata") {

    $sql = "select * from lcodes where c_code = '" . $_GET['txt_code'] . "'";
    $result = $db->RunQuery($sql);
    while ($row = mysql_fetch_array($result)) {
        $sql = "delete from pnl_notes_data where sdate = '" . $_GET['dtfrom'] . "' and l_code = '" . $row['c_code'] . "'";
        $result_h = $db->RunQuery($sql);
        $sql = "insert into pnl_notes_data (sdate,l_amount,l_code,mrow,l_flag1,l_name) values ('" . $_GET['dtfrom'] . "','" . $_GET['txt_bal'] . "','" . $row['c_code'] . "','" . $row['code1'] . "','" . $row['c_remark'] . "','" . $row['c_name'] . "')";
        $result_h = $db->RunQuery($sql);

        if ($row['c_nod_add'] != "") {


            $sql = "select * from lcodes where c_code = '" . $row['c_nod_add'] . "'";
            $result_b = $db->RunQuery($sql);
            $row_b = mysql_fetch_array($result_b);

            $mdate = strtotime("Y-m-d", $_GET['dtfrom']);


            $mdate = date("Y-m-t", strtotime($_GET["dtfrom"]));
            $caldays = " + 1 day";
            $month2 = date('Y-m-d', strtotime($mdate . $caldays));

            $sql = "delete from pnl_notes_data where sdate = '" . $month2 . "' and l_code = '" . $row_b['c_code'] . "'";
            $result_h = $db->RunQuery($sql);

            $sql = "insert into pnl_notes_data (sdate,l_amount,l_code,mrow,l_flag1,l_name) values ('" . $month2 . "','" . $_GET['txt_bal'] . "','" . $row_b['c_code'] . "','" . $row_b['code1'] . "','" . $row_b['c_remark'] . "','" . $row_b['c_name'] . "')";
            $result_h = $db->RunQuery($sql);
            
        }
    }

    $sql = "select* from pnl_notes_data where l_code = '" . $_GET['txt_code'] . "'";

    $result = $db->RunQuery($sql);
    $mstr = "";
    $mstr .="<table>";
    $mstr .= "<tr>";
    $mstr .= "<th>Date</th>";
    $mstr .= "<th>Amount</th>";
    $mstr .= "<th></th>";
    $mstr .= "</tr>";

    while ($row = mysql_fetch_array($result)) {
        $mstr .= "<tr>";
        $mstr .= "<td>" . $row['sdate'] . "</td>";
        $mstr .= "<td>" . $row['l_amount'] . "</td>";
        $mstr .= "<td><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['l_code'] . " onClick=\"del_pnl_dt('" . $row['id'] . "');\"></td>";
        $mstr .= "</tr>";
    }
    $mstr .="</table>";
    echo $mstr;
}

if ($_GET['Command'] == "load_pnl_dt") {

   
    $sql = "select* from pnl_notes_data where l_code = '" . $_GET['txt_code'] . "'";

    $result = $db->RunQuery($sql);
    $mstr = "";
    $mstr .="<table>";
    $mstr .= "<tr>";
    $mstr .= "<th>Date</th>";
    $mstr .= "<th>Amount</th>";
    $mstr .= "<th></th>";
    $mstr .= "</tr>";

    while ($row = mysql_fetch_array($result)) {
        $mstr .= "<tr>";
        $mstr .= "<td>" . $row['sdate'] . "</td>";
        $mstr .= "<td>" . $row['l_amount'] . "</td>";
        $mstr .= "<td><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['l_code'] . " onClick=\"del_pnl_dt('" . $row['id'] . "');\"></td>";
        $mstr .= "</tr>";
    }
    $mstr .="</table>";
    echo $mstr;
}


if ($_GET['Command'] == "del_pnl_dt") {

    $sql = "delete from pnl_notes_data where id = '" . $_GET['txtid'] . "'";
    $result = $db->RunQuery($sql);

    $sql = "select* from pnl_notes_data where l_code = '" . $_GET['txt_code'] . "'";

    $result = $db->RunQuery($sql);
    $mstr = "";
    $mstr .="<table>";
    $mstr .= "<tr>";
    $mstr .= "<th>Date</th>";
    $mstr .= "<th>Amount</th>";
    $mstr .= "<th></th>";
    $mstr .= "</tr>";

    while ($row = mysql_fetch_array($result)) {
        $mstr .= "<tr>";
        $mstr .= "<td>" . $row['sdate'] . "</td>";
        $mstr .= "<td>" . $row['l_amount'] . "</td>";
        $mstr .= "<td><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['l_code'] . " onClick=\"del_pnl_dt('" . $row['id'] . "');\"></td>";
        $mstr .= "</tr>";
    }
    $mstr .="</table>";
    echo $mstr;
}


if ($_GET["Command"] == "save_mettrix_text") {

    //echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec
    $sheet_desc = str_replace("~", "&", $_GET["sheet_desc"]);

    $sql = "delete from acc_cel_cal where mrow=" . $_SESSION["i"] . " and mcol=" . $_SESSION["j"] . "";
    $result = $db->RunQuery($sql);

    $sql = "insert into acc_cel_cal(mrow, mcol, description, cell_type, mbold, munder) values ('" . $_SESSION["i"] . "', '" . $_SESSION["j"] . "', '" . $_GET["sheet_desc"] . "', 'text', '" . $_GET["mbold"] . "', '" . $_GET["munder"] . "')";

    $result = $db->RunQuery($sql);

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<sheet_desc><![CDATA[" . $_GET["sheet_desc"] . "]]></sheet_desc>";
    $ResponseXML .= "<i><![CDATA[" . $_SESSION["i"] . "]]></i>";
    $ResponseXML .= "<j><![CDATA[" . $_SESSION["j"] . "]]></j>";

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "save_mettrix_cell_r") {

    //echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec

    $sql = "delete from acc_cel_cal where mrow=" . $_SESSION["i"] . " and mcol=" . $_SESSION["j"] . "";
    $result = $db->RunQuery($sql);

    if (trim($_GET["row1"]) != "") {
        $row1 = $_GET["row1"];
    } else {
        $row1 = 0;
    }

    if (trim($_GET["col1"]) != "") {
        $col1 = $_GET["col1"];
    } else {
        $col1 = 0;
    }

    if (trim($_GET["row2"]) != "") {
        $row2 = $_GET["row2"];
    } else {
        $row2 = 0;
    }

    if (trim($_GET["col2"]) != "") {
        $col2 = $_GET["col2"];
    } else {
        $col2 = 0;
    }

    if (trim($_GET["row3"]) != "") {
        $row3 = $_GET["row3"];
    } else {
        $row3 = 0;
    }

    if (trim($_GET["col3"]) != "") {
        $col3 = $_GET["col3"];
    } else {
        $col3 = 0;
    }

    if (trim($_GET["row4"]) != "") {
        $row4 = $_GET["row4"];
    } else {
        $row4 = 0;
    }

    if (trim($_GET["col4"]) != "") {
        $col4 = $_GET["col4"];
    } else {
        $col4 = 0;
    }

    if ($_GET["opr"] == "~") {
        $opr = "+";
    } else {
        $opr = "-";
    }

    $sql = "insert into acc_cel_cal(mrow, mcol, mrow1, mcol1, mrow2, mcol2, mrow3, mcol3, mrow4, mcol4, opr, cell_type, mbold, munder) values (" . $_SESSION["i"] . ", " . $_SESSION["j"] . ", " . $row1 . ", " . $col1 . ", " . $row2 . ", " . $col2 . ", " . $row3 . ", " . $col3 . ", " . $row4 . ", " . $col4 . ", '" . $opr . "', 'opr', '" . $_GET["mbold"] . "', '" . $_GET["munder"] . "')";
    //echo $sql;
    $result = $db->RunQuery($sql);

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $opr_str = "";



    //if (($row1!=0) and ($col1!=0) and ($row2!=0) and ($col2!=0) and ($row3!=0) and ($col3!=0) and ($row4!=0) and ($col4!=0)){

    if ($opr == "+") {
        $opr_str = "SUM(" . $row1 . ", " . $col1 . " : " . $row2 . ", " . $col2 . ") + SUM(" . $row3 . ", " . $col3 . " : " . $row4 . ", " . $col4 . ")";
    } else if ($opr == "-") {
        $opr_str = "SUM(" . $row1 . ", " . $col1 . " : " . $row2 . ", " . $col2 . ") - SUM(" . $row3 . ", " . $col3 . " : " . $row4 . ", " . $col4 . ")";
    }

    //}


    $ResponseXML .= "<i><![CDATA[" . $_SESSION["i"] . "]]></i>";
    $ResponseXML .= "<j><![CDATA[" . $_SESSION["j"] . "]]></j>";
    $ResponseXML .= "<opr_str><![CDATA[" . $opr_str . "]]></opr_str>";


    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "save_mettrix_coll_acc") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    //$sql="delete from acc_cel_cal where mrow=".$_SESSION["i"]." and mcol=".$_SESSION["j"]."";
    //$result =$db->RunQuery($sql);


    $sql1 = "delete from acc_account_data where mrow=" . $_SESSION["i"] . " and mcol=" . $_SESSION["j"] . " and (acc_type= 'acc_front' or acc_type= 'acc_rear' or acc_type= 'text' or acc_type= 'opr')";
    $result1 = $db->RunQuery($sql1);



    if ($_GET["opr_acc"] == "~") {
        $opr = "+";
    } else {
        $opr = "-";
    }

    if (($_GET["txt_acc"] != "") and ( $_GET["val_acc"] != 0)) {
        $sql1 = "insert into acc_account_data(mrow, mcol, add_less, acc_code, acc_name, acc_type, acc_val) values (" . $_SESSION["i"] . ", " . $_SESSION["j"] . ", '" . $opr . "', '" . $row["c_code"] . "', '" . $_GET["txt_acc"] . "', 'acc_front', " . $_GET["val_acc"] . ")";
        echo $sql1;
        $result1 = $db->RunQuery($sql1);
    }

    if ($_GET["opr_acc_last"] == "~") {
        $opr = "+";
    } else {
        $opr = "-";
    }

    if (($_GET["txt_acc_last"] != "") and ( $_GET["val_acc_last"] != 0)) {
        $sql1 = "insert into acc_account_data(mrow, mcol, add_less, acc_code, acc_name, acc_type, acc_val) values (" . $_SESSION["i"] . ", " . $_SESSION["j"] . ", '" . $opr . "', '" . $row["c_code"] . "', '" . $_GET["txt_acc_last"] . "', 'acc_rear', " . $_GET["val_acc_last"] . ")";
        echo $sql1;
        $result1 = $db->RunQuery($sql1);
    }

    $sql1 = "update acc_cel_cal set set mbold='" . $_GET["mbold"] . "', munder='" . $_GET["munder"] . "' where mrow=" . $_SESSION["i"] . " and mcol=" . $_SESSION["j"];
    //echo $sql1;
    $result1 = $db->RunQuery($sql1);

    $acc_list = "";
    $sql = "select * from acc_cel_cal where mrow=" . $_SESSION["i"] . " and mcol=" . $_SESSION["j"] . " and cell_type='acc'";
    $result = $db->RunQuery($sql);
    while ($row = mysql_fetch_array($result)) {
        $acc_list .= $row["acc_code"] . " / ";
    }

    $ResponseXML .= "<acc_list><![CDATA[" . $acc_list . "]]></acc_list>";
    $ResponseXML .= "<i><![CDATA[" . $_SESSION["i"] . "]]></i>";
    $ResponseXML .= "<j><![CDATA[" . $_SESSION["j"] . "]]></j>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}



if ($_GET["Command"] == "del_item") {



    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql1 = "delete from acc_account_data where id='" . $_GET["c_code"] . "'";
    $result1 = $db->RunQuery($sql1);

    $ResponseXML = "<acc_table><![CDATA[";

    $table = "<table width=\"415\" border=\"1\">
      		<tr>
        		<th width=\"92\">Acc Code</th>
        		<th width=\"307\">Acc Name</th>
      		</tr>";

    $sql1 = "select * from acc_account_data where mrow='" . $_GET["mrow"] . "' and mcol='" . $_GET["mcol"] . "'";


    $result1 = $db->RunQuery($sql1);
    while ($row1 = mysql_fetch_array($result1)) {
        $table.="<tr><td>" . $row1["acc_code"] . "</td>";
        $table.="<td>" . $row1["acc_name"] . "</td>";
        $table.="<td><img width=\"20\" height=\"20\" onclick=\"del_item('" . $row1['id'] . "','" . $_SESSION["i"] . "','" . $_SESSION["j"] . "');\" name=\'" . $id . "'\" id=\'" . $id . "'\" src=\"images/delete_01.png\"></td></tr>";
    }

    $table.="</table>";

    $ResponseXML .= $table;
    $ResponseXML .= "]]></acc_table>";
    $ResponseXML .= "</salesdetails>";
    echo $table;
}




if ($_GET["Command"] == "loadnt") {
    //header('Content-Type: text/xml'); 
    /* echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n"; */

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<acc_table><![CDATA[";
    $ResponseXML .= "<table><tr><th>Code</th><th width='80'>Name</th><th>Order</th></tr>";
    $sql = "select * from acc_account_data where mrow='" . $_GET["row"] . "' and mcol ='4'";

    $i = 1;

    $result = $db->RunQuery($sql);

    while ($row = mysql_fetch_array($result)) {
        if ($row['atype'] == "D") {
            $sql = "select * from lcodes where paccno='" . $row['acc_code'] . "'";
            $resultr = $db->RunQuery($sql);
            if (mysql_num_rows($resultr) > 0) {
                while ($rstr = mysql_fetch_array($resultr)) {


                    $ResponseXML .= "<tr><td><input type='text' disabled id='test_desc" . $i . "' value='" . $rstr['c_code'] . "'></td>";
                    $ResponseXML .= "<td><input type='text' disabled value='" . $rstr['c_name'] . "'></td>";

                    $sql = "select * from pnlpos where l_code = '" . $rstr['c_code'] . "'";
                    $resultpos = $db->RunQuery($sql);
                    $rstpos = mysql_fetch_array($resultpos);


                    $ResponseXML .= "<td><input type='text' id='unit" . $i . "'  value='" . $rstpos['pos'] . "'></td></tr>";
                    $i = $i + 1;
                }
            } else {
                $sql = "select * from lcodes where c_code='" . $row['acc_code'] . "'";
                $resultr = $db->RunQuery($sql);
                if ($rstr = mysql_fetch_array($resultr)) {
                    $ResponseXML .= "<tr><td><input type='text' disabled id='test_desc" . $i . "' value='" . $rstr['c_code'] . "'></td>";
                    $ResponseXML .= "<td><input type='text' disabled value='" . $rstr['c_name'] . "'></td>";

                    $sql = "select * from pnlpos where l_code = '" . $rstr['c_code'] . "'";
                    $resultpos = $db->RunQuery($sql);
                    $rstpos = mysql_fetch_array($resultpos);


                    $ResponseXML .= "<td><input type='text' id='unit" . $i . "'  value='" . $rstpos['pos'] . "'></td></tr>";
                    $i = $i + 1;
                }
            }
        } else {
            $sql = "select * from lcodes where c_code='" . $row['acc_code'] . "'";
            $resultr = $db->RunQuery($sql);
            if ($rstr = mysql_fetch_array($resultr)) {
                $ResponseXML .= "<tr><td><input type='text' disabled id='test_desc" . $i . "' value='" . $rstr['c_code'] . "'></td>";
                $ResponseXML .= "<td><input type='text' disabled value='" . $rstr['c_name'] . "'></td>";

                $sql = "select * from pnlpos where l_code = '" . $rstr['c_code'] . "'";
                $resultpos = $db->RunQuery($sql);
                $rstpos = mysql_fetch_array($resultpos);


                $ResponseXML .= "<td><input type='text' id='unit" . $i . "'  value='" . $rstpos['pos'] . "'></td></tr>";
                $i = $i + 1;
            }
        }
    }

    $ResponseXML .= "</table>";
    $ResponseXML .= "]]></acc_table>";
    $ResponseXML .= "<count><![CDATA[" . $i . "]]></count>";



    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}


if ($_GET["Command"] == "save_note") {


    $j = 1;
    $i = $_GET['count'];
    while ($i >= $j) {
        $test_desc = "test_desc" . $j;


        $unit = "unit" . $j;

        $sql = "delete from pnlpos where l_code ='" . $_GET[$test_desc] . "'";
        $result = $db->RunQuery($sql);

        if ($_GET[$unit] == "") {
            $mdt = 99;
        } else {
            $mdt = $_GET[$unit];
        }
        $sql = "insert into pnlpos  (l_code,pos)  values ('" . $_GET[$test_desc] . "','" . $mdt . "')";
        $result = $db->RunQuery($sql);

        $j = $j + 1;
    }
}
?>