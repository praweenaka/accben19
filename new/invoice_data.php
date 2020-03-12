<?php

session_start();



////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////

require_once ("connection_sql.php");



////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////

header('Content-Type: text/xml');



date_default_timezone_set('Asia/Colombo');



/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////



if ($_GET["Command"] == "new_inv") {



    $invno = getno();



    $sql = "Select QTNNO from tmpinvpara_acc";

    $result = $conn->query($sql);

    $row = $result->fetch();



    $tono = $row['QTNNO'];



    $sql = "delete from tmp_po_data where tmp_no='" . $tono . "'";

    $result = $conn->query($sql);



    $sql = "update tmpinvpara_acc set QTNNO=QTNNO+1";

    $result = $conn->query($sql);





    $ResponseXML = "";

    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";

    $ResponseXML .= "<tmpno><![CDATA[" . $tono . "]]></tmpno>";

    $ResponseXML .= "<dt><![CDATA[" . date('Y-m-d') . "]]></dt>";



    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

function getno() {



    include './connection_sql.php';

    $sql = "select SPINV from invpara where COMCODE='" . $_SESSION['company'] . "'";

    $result = $conn->query($sql);

    $row = $result->fetch();

    $tmpinvno = "000000" . $row["SPINV"];

    $lenth = strlen($tmpinvno);

    return $invno = substr($tmpinvno, $lenth - 6);
}

if ($_GET["Command"] == "setitem") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql = "delete from tmp_cheque_pay where accno='" . $_GET['itemCode'] . "' and tmp_no='" . $_SESSION["UserName"] . "' ";

    $result = $conn->query($sql);

    if ($_GET["Command1"] == "add_tmp") {
        $amount = str_replace(",", "", $_GET["itemPrice"]);
        $sql = "insert into tmp_cheque_pay(entno, accno, accname, descript, amt, tmp_no) values ('" . trim($_GET["invno"]) . "', '" . $_GET["itemCode"] . "', '" . $_GET["itemDesc"] . "', '" . $_GET["qty"] . "', " . $amount . ", '" . $_SESSION["UserName"] . "')";
        $result = $conn->query($sql);
    }



    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">

					<tr>

						<td style=\"width: 90px;\">Acc Code</td>

						<td style=\"width: 300px;\">Acc Name</td>

						<td>Description</td>

						<td style=\"width: 60px;\">Amount</td>

						<td style=\"width: 100px;\">Remove</td>

						<td style=\"width: 10px;\"></td>

					</tr>";



    $i = 1;

    $mtot = 0;

    $sql = "Select * from tmp_cheque_pay where tmp_no='" . $_SESSION["UserName"] . "'";

    foreach ($conn->query($sql) as $row1) {

        $ResponseXML .= "<tr>                              

                            <td>" . $row1['accno'] . "</td>
                            <td>" . $row1['accname'] . "</td>
                            <td>" . $row1['descript'] . "</td>
                            <td>" . number_format($row1['amt'], 2, ".", ",") . "</td>
                            <td><a class=\"btn btn-danger btn-xs\" onClick=\"del_item('" . $row1['accno'] . "')\"> <span class='fa fa-remove'></span></a></td>

                            </tr>";

        $mtot = $mtot + $row1['amt'];
        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";
    $ResponseXML .= "<subtot><![CDATA[" . number_format($mtot, 2, ".", ",") . "]]></subtot>";

    $ResponseXML .= "</salesdetails>";



    echo $ResponseXML;
}



if ($_GET["Command"] == "save_item") {

    try {

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $recno = $_GET["txt_entno"];

        $sql = "delete from ledger where l_flag1 = 'DEB' and l_refno = '$recno'";
        $conn->query($sql);
        $sql = "delete from cashpaytrn where refno = '$recno'";
        $conn->query($sql);

        $sql = "select bdate, cancel from paymas where refno = '$recno'";
        $row = $conn->query($sql)->fetch();
        $trnDate = $row["bdate"];
        $cancel = $row["cancel"];
        $TXT_NARA=str_replace("~", "&", $_GET["TXT_NARA"]);
        
        $i = 0;
        $sql = "Select * from tmp_cheque_pay where tmp_no='" . $_SESSION["UserName"] . "'";
        foreach ($conn->query($sql) as $row) {
            $m_acode = $row["accno"];
            $m_nara = $row["descript"];
            $mAmount = $row["amt"];
            
            $sql = "Insert into ledger(l_refno, l_date, l_code, L_amount,l_flag, l_flag1, l_lmem, comcode, l_flag2, l_flag3, l_flag4, l_yearfl, user, ent_datetime) 
                    Values ('" . $recno . "', '" . $trnDate . "', '" . trim($m_acode) . "', " . $mAmount . ",
                    'CAP', 'DEB', '" . $TXT_NARA . "', '" . $_SESSION['company'] . "', '1', 'R', 'CHQ', 0, '" . $_SESSION['UserName'] . "', '" . date("Y-m-d H:i:s") . "')";
            $conn->query($sql);
            
            $sql="Insert into cashpaytrn(refno, bdate, code, amount, flag, nara,comcode, cancel, user, ent_datetime) 
                Values ('" . trim($recno) . "', '" . trnDate . "', '" . trim($m_acode) . "', " . $mAmount . ", 'DEB', '" . $m_nara . "',
                '" . $_SESSION['company'] . "', '$cancel', '".$_SESSION['UserName']."', '".date("Y-m-d H:i:s")."')";
            $conn->query($sql);
            $i++;
        }
        
        $sql = "update ledger set l_lmem = '$TXT_NARA' where l_flag1 = 'CRE' and l_refno = '$recno'";
        $conn->query($sql);
        $sql = "update paymas set naration = '$TXT_NARA' where refno = '$recno'";
        $conn->query($sql);
        
        if ($i > 0){
            $conn->commit();
            echo "Saved";
        }else{
            echo "Debit Entries Not Set!";
        }

    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
    $sql = "delete from tmp_cheque_pay where tmp_no='" . $_SESSION["UserName"] . "'";
    $conn->query($sql);
}









if ($_GET["Command"] == "pass_rec") {



    $ResponseXML = "";

    $ResponseXML .= "<salesdetails>";

    $sql = "Select * from paymas where refno='" . $_GET['refno'] . "'";

    $result = $conn->query($sql);



    if ($row = $result->fetch()) {

        $ResponseXML .= "<C_REFNO><![CDATA[" . $row["refno"] . "]]></C_REFNO>";
        
        $naration=str_replace("&nbsp;", " ", $row['naration']);
        $ResponseXML .= "<TXT_NARA><![CDATA[".$naration."]]></TXT_NARA>";
        
//        $ResponseXML .= "<C_DATE><![CDATA[" . $row["SDATE"] . "]]></C_DATE>";
//
//        $ResponseXML .= "<str_crecash><![CDATA[" . $row['TYPE'] . "]]></str_crecash>";
//
//        $ResponseXML .= "<C_CODE><![CDATA[" . $row["C_CODE"] . "]]></C_CODE>";
//
//        $ResponseXML .= "<name><![CDATA[" . $row["CUS_NAME"] . "]]></name>";
//
//        $ResponseXML .= "<txt_remarks><![CDATA[" . $row["REMARK"] . "]]></txt_remarks>";
//
//        $ResponseXML .= "<Attn><![CDATA[" . $row['C_ADD1'] . "]]></Attn>";
//
        $ResponseXML .= "<tmp_no><![CDATA[" . $row["refno"] . "]]></tmp_no>";
//
//
//
//        $ResponseXML .= "<currency><![CDATA[LKR]]></currency>";
//
//        $ResponseXML .= "<txt_rate><![CDATA[1]]></txt_rate>";
//
//        $ResponseXML .= "<department><![CDATA[" . $row["DEPARTMENT"] . "]]></department>";
//
//        $ResponseXML .= "<DANO><![CDATA[" . $row["dele_no"] . "]]></DANO>";
//
//
//
//        $ResponseXML .= "<salesrep><![CDATA[" . $row["SAL_EX"] . "]]></salesrep>";
//
//        $msg = "";
//
//        if ($row['CANCELL'] == "1") {
//            $msg = "Cancelled";
//        }
//
//        $ResponseXML .= "<msg><![CDATA[" . $msg . "]]></msg>";

        $sql = "delete from tmp_cheque_pay where tmp_no='" . $_SESSION["UserName"] . "'";
        $result = $conn->query($sql);

        $sql = "Select * from cashpaytrn where refno='" . $row["refno"] . "'";

        foreach ($conn->query($sql) as $row_rst) {

            $code = $row_rst["code"];
            $sql_rst1 = "Select * from lcodes where C_CODE='" . $row_rst["code"] . "'";
            $result = $conn->query($sql_rst1);
            if ($row_rst1 = $result->fetch()) {
                $c_name = $row_rst1["c_name"];
            }

            $nara = $row_rst["nara"];
            $amount = $row_rst["amount"];

            $sql1 = "insert into tmp_cheque_pay(entno, accno, accname, descript, amt, tmp_no) values ('" . trim($_GET["refno"]) . "', '" . $code . "', '" . $c_name . "', '" . $nara . "', " . $amount . ", '" . $_SESSION["UserName"] . "')";
            $result = $conn->query($sql1);
        }





        $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">

					<tr>

						<td style=\"width: 90px;\">Acc Code</td>

						<td style=\"width: 300px;\">Acc Name</td>

						<td>Description</td>

						<td style=\"width: 60px;\">Amount</td>

						<td style=\"width: 100px;\">Remove</td>

						<td style=\"width: 10px;\"></td>

					</tr>";



        $i = 1;

        $mtot = 0;

        $sql = "Select * from tmp_cheque_pay where tmp_no='" . $_SESSION["UserName"] . "'";

        foreach ($conn->query($sql) as $row1) {



            $ResponseXML .= "<tr>                              

                            <td>" . $row1['accno'] . "</td>
                            <td>" . $row1['accname'] . "</td>
                            <td>" . $row1['descript'] . "</td>
                            <td>" . number_format($row1['amt'], 2, ".", ",") . "</td>
                            <td><a class=\"btn btn-danger btn-xs\" onClick=\"del_item('" . $row1['accno'] . "')\"> <span class='fa fa-remove'></span></a></td>

                            </tr>";

            $mtot = $mtot + $row1['amt'];
            $i = $i + 1;
        }

        $ResponseXML .= "   </table>]]></sales_table>";

        $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";
        $ResponseXML .= "<nara><![CDATA[" . $row1['descript'] . "]]></nara>";
        $ResponseXML .= "<subtot><![CDATA[" . number_format($mtot, 2, ".", ",") . "]]></subtot>";
    }









    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}





if ($_GET["Command"] == "update_list") {

    $ResponseXML = "";

    $ResponseXML .= "<table class=\"table\">

	            <tr>

                        <th width=\"121\">Reference No</th>
                        <th width=\"121\">DA No</th>

                        <th width=\"121\">Date</th>

                        <th width=\"100\">Code</th> 

                        <th width=\"200\">Name</th> 

                        <th width=\"121\">Amount</th>  

                    </tr>";





    $sql = "select REF_NO,dele_no, SDATE,C_CODE,CUS_NAME,GRAND_TOT from s_salma where company = '" . $_SESSION["company"] . "' and trn_type = 'INV'";



    if ($_GET['refno'] != "") {
        $sql .= " and REF_NO like '%" . $_GET['refno'] . "%'";
    }

    if ($_GET['refno1'] != "") {
        $sql .= " and dele_no like '%" . $_GET['refno1'] . "%'";
    }

    if ($_GET['cusname'] != "") {

        $sql .= " and cus_NAME like '%" . $_GET['cusname'] . "%'";
    }

    $stname = $_GET['stname'];



    $sql .= " and company = '" . $_SESSION["company"] . "' ORDER BY id desc limit 50";


//    echo $sql;
    foreach ($conn->query($sql) as $row) {

        $cuscode = $row["REF_NO"];





        $ResponseXML .= "<tr>               

                              <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['REF_NO'] . "</a></td>
                              <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['dele_no'] . "</a></td>

                              <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['SDATE'] . "</a></td>

                              <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['C_CODE'] . "</a></td>

                                  <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['CUS_NAME'] . "</a></td>

                                      <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['GRAND_TOT'] . "</a></td>

                            </tr>";
    }

    $ResponseXML .= "</table>";

    echo $ResponseXML;
}







if ($_GET["Command"] == "del_inv") {



    $ResponseXML = "";

    $ResponseXML .= "<salesdetails>";

    try {

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->beginTransaction();



        $sql = "select REF_NO,CANCELL,TOTPAY,DEPARTMENT from s_salma where tmp_no ='" . $_GET['tmpno'] . "'";

        $result = $conn->query($sql);

        if ($row = $result->fetch()) {





            if ($row['CANCELL'] != "0") {

                echo "Already Enterd";

                exit();
            }

            if ($row['CANCELL'] != "0") {

                echo "Already Cancelled";

                exit();
            }



            if ($row['TOTPAY'] > 0) {

                echo "Already Paid";

                exit();
            }



            $invno = $row['REF_NO'];







            $sql = "update s_salma set CANCELL='1' where REF_NO = '" . $row['REF_NO'] . "'";

            $conn->exec($sql);



            $sql = "DELETE from ledger WHERE l_refno='" . $row['REF_NO'] . "'";

            $conn->exec($sql);



            $sql = "delete from s_trn where REFNO='" . $row['REF_NO'] . "'";

            $conn->exec($sql);

            //new
            $sqlInv = "select * from s_invo where REF_NO='" . $row['REF_NO'] . "' ";
            foreach ($conn->query($sqlInv) as $rowInv) {
                $sql2 = "update s_mas set QTYINHAND=QTYINHAND+" . $rowInv["QTY"] . " where STK_NO='" . $rowInv['STK_NO'] . "'";
                $conn->exec($sql);
                $sql2 = "update s_submas set QTYINHAND=QTYINHAND+" . $rowInv["QTY"] . " where STO_CODE='" . $row["DEPARTMENT"] . "' and STK_NO='" . $rowInv['STK_NO'] . "'";
                $conn->exec($sql);
            }

            $sql = "update s_invo set CANCELL='1' where ref_no = '" . $row['REF_NO'] . "'";

            $conn->exec($sql);



            echo "ok";

            $conn->commit();
        } else {

            echo "Entry Not Found";
        }
    } catch (Exception $e) {

        $conn->rollBack();

        echo $e;
    }
}
?>