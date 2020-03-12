<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Print Voucher</title>

        <style>
            body
            {
                font-size:21px;
            }

            p {
                font-size:21px;
            }

        </style>

    </head>

    <body>
        <?php
        include('connection.php');

        $txt_bea = str_replace("~", "&", $_GET['txt_bea']);

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
            if ($ii == 9) {
                $txtacc9 = number_format($row_rsPrInv["l_amount"], 2, ".", ",");
            }


            $ii = $ii + 1;
        }

        $sql_rst2 = "Select * from bankmaster where bm_code='" . trim($_GET["com_cas"]) . "'";
        //echo $sql_rst2;
        $result_rst2 = mysql_query($sql_rst2, $dbacc);
        if ($row_rst2 = mysql_fetch_array($result_rst2)) {
            $txtbankshname = $row_rst2["bm_bank"];
        }

        $txtpay = $txt_bea;
        $txtcheno = $_GET["txt_cheno"];
//$txtbankshname= $_GET["com_cas"];


        $sql_rsPrInv1 = "select * from ledger where l_refno='" . $_GET["txt_entno"] . "' and l_flag1='DEB'";
        $result_rsPrInv1 = mysql_query($sql_rsPrInv1, $dbacc);
        $row_rsPrInv1 = mysql_fetch_array($result_rsPrInv1);

        $sql_chq = "select * from paymas where refno='" . $_GET["txt_entno"] . "'";
        //echo $sql_chq;
        $result_chq = mysql_query($sql_chq, $dbacc);
        $row_chq = mysql_fetch_array($result_chq);
        ?>

        <table width="1184" border="0">

            <tr>
                <td width="227" height="221">&nbsp;</td>
                <td width="117">&nbsp;</td>
                <td width="188">&nbsp;</td>
            </tr>



            <tr>
                <td colspan="2"><?php echo date("Y-m-d", strtotime($row_chq["chq_date"])); ?></td>
                <td><?php echo $row_rsPrInv1["l_refno"]; ?></td>
                <td colspan="2">&nbsp;</td>
                <td width="328">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5"><?php echo $txtpay; ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td height="71" colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td height="80" colspan="5" rowspan="11" align="left" valign="top"><p><?php echo $row_rsPrInv1["l_lmem"]; ?></p></td>
                <td height="80" align="right"><?php echo $txtacc1; ?></td>
            </tr>
            <tr>
                <td align="right"><?php echo $txtacc2; ?></td>
            </tr>
            <tr>
                <td align="right"><?php echo $txtacc3; ?></td>
            </tr>
            <tr>
                <td align="right"><?php echo $txtacc4; ?></td>
            </tr>
            <tr>
                <td align="right"><?php echo $txtacc5; ?></td>
            </tr>
            <tr>
                <td align="right"><?php echo $txtacc6; ?></td>
            </tr>
            <tr>
                <td align="right"><?php echo $txtacc7; ?></td>
            </tr>
            <tr>
                <td align="right"><?php echo $txtacc8; ?></td>
            </tr>

            <tr>
                <?php
                $tot = str_replace(",", "", $txtacc1) + str_replace(",", "", $txtacc2) + str_replace(",", "", $txtacc3) + str_replace(",", "", $txtacc4) + str_replace(",", "", $txtacc5) + str_replace(",", "", $txtacc6) + str_replace(",", "", $txtacc7) + str_replace(",", "", $txtacc8) + str_replace(",", "", $txtacc9);
                ?>
                <td height="237" align="right" valign="bottom"><b><?php echo number_format($tot, 2, ".", ","); ?></b></td>
            </tr>
            <tr>
                <td height="70" align="right" valign="bottom"><?php echo $txtcheno; ?></td>
            </tr>
            <tr>
                <td height="24" align="right"><?php echo $row_rsPrInv1["l_refno"]; ?></td>
            </tr>
            <tr>
                <td colspan="2"><?php echo date("Y-m-d", strtotime($row_rsPrInv1["l_date"])); ?></td>
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td align="right"><?php echo $txtbankshname; ?></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </body>
</html>
