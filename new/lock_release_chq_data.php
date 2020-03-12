<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("../new/connection_inv.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');


if ($_GET["Command"] == "update_inv") {

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sql11 = "Select * from ins_payment where chno='" . $_GET['Cheque_No'] . "' ";
        $result11 = $conn->query($sql11);
        if ($row11 = $result11->fetch()) {
            $sql = "update ins_payment set chno='0' where chno='" . $row11['chno'] . "' ";
            $result = $conn->query($sql);


            $sqlbrand = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $row11['chno'] . "', '" . $_SESSION["CURRENT_USER"] . "', 'InsentiveChequeActive', 'Active', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $result11 = $conn->query($sqlbrand);
            echo "Saved";
        } else {
            echo "Invalid Cheque No...!!";
        }

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}



if ($_GET["Command"] == "update_invcom") {

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sql1 = "Select * from s_commadva where chno='" . $_GET['Cheque_No_comm'] . "' ";
        $result1 = $conn->query($sql1);
        if ($row1 = $result1->fetch()) {
            $sql = "update s_commadva set chno='0' where chno='" . $row1['chno'] . "' ";
            $result = $conn->query($sql);


            $sqlbrand = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $row1['chno'] . "', '" . $_SESSION["CURRENT_USER"] . "', 'ComissionChequeActive', 'Active', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $result11 = $conn->query($sqlbrand);
            echo "Saved";
        } else {
            echo "Invalid Cheque No...!!";
        }


        $conn->commit();
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
