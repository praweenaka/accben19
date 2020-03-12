<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Trial Balance</title>
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

        <style>
            body
            {
                font-size:14px;
            }

            a:link, a:visited {

                text-decoration: none;
                color:#000000;
            }

            a:hover {
                text-decoration: underline;
            }

        </style>
    </head>

    <body><center>

            <?php
            include('connection.php');

            if ($_GET["radio"] == "op_sumexpo") {

                $sql_rsl_code = "select c_code, pen from lcodes where c_group='D' order by c_code";
                $result_rsl_code = mysql_query($sql_rsl_code, $dbacc);
                while ($row_rsl_code = mysql_fetch_array($result_rsl_code)) {

                    $mamo = 0;

                    // if ($_GET["chk_lastyear"] == "on") {
                    $sql_rsledger = "select * from ledger  where l_code='" . $row_rsl_code["c_code"] . "' and  l_yearfl != '1' and  l_date >='" . $_GET["dtfrom"] . "' and l_date <='" . $_GET["dtto"] . "' order by l_date";

                    /*  } else {
                      //	$sql_rsledger="select * from ledger  where l_code='" . $row_rsl_code["c_code"] . "' and  l_yearfl != '1' and  l_date >='" . $_GET["dtfrom"] . "' and l_date <='" . $_GET["dtto"] . "' order by l_date";
                      $sql_rsledger="select * from view_ledger  where l_code='" . $row_rsl_code["c_code"] . "' and  l_yearfl != '2' and  l_yearfl != '1' and  l_date >='" . $_GET["dtfrom"] . "' and l_date <='" . $_GET["dtto"] . "' order by l_date";
                      } */

                    $result_rsledger = mysql_query($sql_rsledger, $dbacc);
                    while ($row_rsledger = mysql_fetch_array($result_rsledger)) {

                        if ($_GET["chk_lastyear"] == "on") {
                            if (($row_rsledger["l_flag"] == "OPB") and ($row_rsledger["l_yearfl"] != 2)) {
                                
                            } else {

                                if ($row_rsledger["l_flag"] != "OPB") {
                                    if ($row_rsledger["l_flag1"] == "DEB") {
                                        $mamo = number_format($mamo, 2, ".", "") + number_format($row_rsledger["l_amount"], 2, ".", "");
                                    } else {
                                        $mamo = number_format($mamo, 2, ".", "") - number_format($row_rsledger["l_amount"], 2, ".", "");
                                    }
                                }
                            }
                        } else {
                            if ($row_rsledger["l_yearfl"] != 2) {
                                if ($row_rsledger["l_flag"] != "OPB") {
                                    if ($row_rsledger["l_flag1"] == "DEB") {

                                        $mamo = number_format($mamo, 2, ".", "") + number_format($row_rsledger["l_amount"], 2, ".", "");
                                    } else {

                                        $mamo = number_format($mamo, 2, ".", "") - number_format($row_rsledger["l_amount"], 2, ".", "");
                                    }
                                }
                            }
                        }
                    }
                    $sql = "update lcodes set pen=" . $mamo . "  where c_code='" . $row_rsl_code["c_code"] . "'";
                    $result = mysql_query($sql, $dbacc);
                }

                $sql_rspara = "select * from accpara";
                $result_rspara = mysql_query($sql_rspara, $dbacc);
                $row_rspara = mysql_fetch_array($result_rspara);





                $txtdes = "TB Report From : " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "    To: " . date("Y-m-d", strtotime($_GET["dtto"]));

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
    <td height=\"21\" colspan=\"3\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"208\" height=\"21\" colspan=\"3\"><span class=\"heading\">" . $txtdes . "</span></td>
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



                $table.="<table width=\"904\" height=\"81\" border=\"1\" cellspacing=\"0\">
		
      	<tr>
        <th width=\"70\" height=\"23\">Ledger</th>
        <th width=\"400\">Account Description</th>
        <th width=\"100\">Opening Debit</th>
		<th width=\"100\">Opening Credit</th>
		<th width=\"100\">Debit</th>
        <th width=\"100\">Credit</th>
		<th width=\"100\">Closing Debit</th>
        <th width=\"100\">Closing Credit</th>
		
        </tr>";

                $deb = 0;
                $cre = 0;

                $bal = 0;
                $totbal = 0;
                $cl_deb = 0;
                $cl_cre = 0;

                $open_tot_deb = 0;
                $open_tot_cre = 0;



                if (trim($_GET["ledgno"]) != "") {
                    $ledgno = $_GET["ledgno"];
                    $sql_rsPrInv = "select *  from lcodes where c_group='D' and c_code like '$ledgno%' order by c_code";
                } else {
                    $sql_rsPrInv = "select *  from lcodes where c_group='D' order by c_code";
                }
                $result_rsPrInv = mysql_query($sql_rsPrInv, $dbacc);
                while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)) {

                    if ($row_rsPrInv["c_group"] == "D") {
                        $bF = 0;
                        $OpCrAmu = 0;
                        $OpDbAmu = 0;
                        $OpBalAm = 0;
                        $OpLnkAmt = 0;

                        //echo $_SESSION['User_Type'];
                        /* if ($_SESSION['User_Type'] == "1") {

                          $sql_rs="sELECT  l_amount, l_code, l_refno, l_flag1 from ledger where l_flag = 'OPB' and l_code = '".$row_rsPrInv["c_code"]."' and l_yearfl = '2' ";
                          echo $sql_rs."1</br>";
                          $result_rs=mysql_query($sql_rs, $dbacc);
                          while ($row_rs = mysql_fetch_array($result_rs)){
                          if ($row_rs["l_flag1"] == "CRE") {
                          $OpCrAmu = $OpCrAmu + $row_rs["l_amount"];
                          } else {
                          $OpDbAmu = $OpDbAmu + $row_rs["l_amount"];
                          }
                          }
                          } else { */

                        if ($_GET["chk_lastyear"] == "on") {
                            if ($_SESSION['dev'] == "1") {
                                $sql_rs = "sELECT  l_amount, l_code, l_refno, l_flag1 from ledger where l_flag = 'OPB' and l_code = '" . $row_rsPrInv["c_code"] . "' and l_yearfl = '2' ";
                            } else {
                                $sql_rs = "sELECT  l_amount, l_code, l_refno, l_flag1 from ledger where l_flag = 'OPB' and l_code = '" . $row_rsPrInv["c_code"] . "' and l_yearfl = '0' ";
                            }
                        } else {
                            $sql_rs = "sELECT  l_amount, l_code, l_refno, l_flag1 from ledger where l_flag = 'OPB' and l_code = '" . $row_rsPrInv["c_code"] . "' and l_yearfl = '0' ";
                        }
                        //echo $sql_rs."2</br>";
                        $result_rs = mysql_query($sql_rs, $dbacc);
                        while ($row_rs = mysql_fetch_array($result_rs)) {

                            if ($row_rs["l_flag1"] == "CRE") {
                                $OpCrAmu = $OpCrAmu + $row_rs["l_amount"];
                            } else {
                                $OpDbAmu = $OpDbAmu + $row_rs["l_amount"];
                            }
                        }
                        //}

                        $sql_opCR = "select sum(l_amount) as ctot from ledger where l_flag != 'OPB' and l_yearfl != '2' and  l_yearfl != '1'  AND l_flag1='CRE' and l_code = '" . $row_rsPrInv["c_code"] . "' and (l_date<'" . $_GET["dtfrom"] . "'  )";
//echo $sql_opCR."</br>";
                        $result_opCR = mysql_query($sql_opCR, $dbacc);
                        while ($row_opCR = mysql_fetch_array($result_opCR)) {
                            $OpCrAmu = $OpCrAmu + $row_opCR["ctot"];
                        }

                        $sql_opDb = "select sum(l_amount) as dtot from ledger where  l_flag != 'OPB' and l_yearfl != '2' and  l_yearfl != '1' AND l_flag1='DEB' and l_code = '" . $row_rsPrInv["c_code"] . "'  and (l_date<'" . $_GET["dtfrom"] . "' ) ";
//echo $sql_opDb."</br>";
                        $result_opDb = mysql_query($sql_opDb, $dbacc);
                        while ($row_opDb = mysql_fetch_array($result_opDb)) {
                            $OpDbAmu = $OpDbAmu + $row_opDb["dtot"];
                        }


                        $bF = $OpBalAm + $OpDbAmu - $OpCrAmu + $OpLnkAmt;

                        if ($bF >= 0) {
                            $bfFlag = "DEB";
                        } else {
                            $bfFlag = "CRE";
                        }

                        if (($bF != 0) or ($row_rsPrInv["pen"] != 0)) {
                            $url = "report_ledger_link.php?txtAccCode=" . $row_rsPrInv["c_code"] . "&txtAccName=" . $row_rsPrInv["c_name"] . "&repdatefrom=" . $_GET["dtfrom"] . "&repdateto=" . $_GET["dtto"];

                            $table.="<tr><td><a target=\"_blank\" href=\"" . $url . "\">" . $row_rsPrInv["c_code"] . "</a></td>
			<td><a target=\"_blank\" href=\"" . $url . "\">" . $row_rsPrInv["c_name"] . "</a></td>";


                            if ($bfFlag == "DEB") {
                                if ($bF == 0) {
                                    $table.="<td>&nbsp;</td>";
                                } else {
                                    $table.="<td align=right>" . number_format($bF.'aas', 2, ".", ",") . "</td>";
                                }
                                $table.="<td>&nbsp;</td>";
                                $open_tot_deb = $open_tot_deb + $bF;
                            } else {
                                $table.="<td>&nbsp;</td>";
                                $table.="<td align=right>" . number_format((-1 * $bF), 2, ".", ",") . "</td>";
                                $open_tot_cre = $open_tot_cre + $bF;
                            }
                            //echo $bF;
                            //echo $row_rsPrInv["pen"];

                            if ($row_rsPrInv["pen"] > 0) {

                                $table.="<td align=right>" . number_format($row_rsPrInv["pen"], 2, ".", ",") . "</td>";
                                $table.="<td>&nbsp;</td>";
                                $deb = $deb + $row_rsPrInv["pen"];
                            } else {
                                $table.="<td>&nbsp;</td>";
                                $pen = -1 * $row_rsPrInv["pen"];
                                $table.="<td align=right>" . number_format($pen, 2, ".", ",") . "</td>";
                                $cre = $cre + $row_rsPrInv["pen"];
                            }
                            $bal = $bal + $bF + $row_rsPrInv["pen"];

                            $cl_bal = $bF + $row_rsPrInv["pen"];

                            if ($cl_bal >= 0) {
                                $table.="<td align=right>" . number_format($cl_bal, 2, ".", ",") . "</td>";
                                $table.="<td>&nbsp;</td>";
                                $cl_deb = $cl_deb + $cl_bal;
                            } else {
                                $table.="<td>&nbsp;</td>";
                                $table.="<td align=right>" . number_format(-1 * $cl_bal.'as', 2, ".", ",") . "</td>";
                                $cl_cre = $cl_cre + $cl_bal;
                            }

                            /* if ($bal<0){
                              echo "<td align=right>(".number_format((-1*$bal), 2, ".", ",").")</td>";
                              } else {
                              echo "<td align=right>".number_format($bal, 2, ".", ",")."</td>";
                              } */
                            $table.="</tr>";
                        }
                    } else {
                        $table.="<tr><td><b>" . $row_rsPrInv["c_code"] . "</b></td>
			<td colspan=5><b>" . $row_rsPrInv["c_name"] . "</b></td>";
                    }
                }
                $cre_plus = -1 * $cre;
                $totbal = $totbal + $bal;

                $table.="<tr><td colspan=2>&nbsp;</td>
		<td align=right><b>" . number_format($open_tot_deb, 2, ".", ",") . "</b></td>
		<td align=right><b>" . number_format(-1 * $open_tot_cre, 2, ".", ",") . "</b></td>
		<td align=right><b>" . number_format($deb, 2, ".", ",") . "</b></td>
		<td align=right><b>" . number_format($cre_plus, 2, ".", ",") . "</b></td>
		<td align=right><b>" . number_format($cl_deb, 2, ".", ",") . "</b></td>
		<td align=right><b>" . number_format(-1 * $cl_cre, 2, ".", ",") . "</b></td></tr>";

                /* if ($totbal>=0){
                  echo "<td align=right><b>".number_format($totbal, 2, ".", ",")."</b></td></tr>";
                  } else {
                  echo "<td align=right><b>(".number_format(-1*$totbal, 2, ".", ",").")</b></td></tr>";
                  } */








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
                $file = "report/rpt_trial_bal.xls";

                $f = fopen($file, "w+");

                fwrite($f, $table);

                echo "<a href=\"report/rpt_trial_bal.xls\">Download Excel Report</a>";
            }


            if ($_GET["radio"] == "op_sumexpo_p") {

                $sql_rsl_code = "select c_code, pen from lcodes where c_group='D' order by c_code";
                $result_rsl_code = mysql_query($sql_rsl_code, $dbacc);
                while ($row_rsl_code = mysql_fetch_array($result_rsl_code)) {

                    $mamo = 0;

                    // if ($_GET["chk_lastyear"] == "on") {
                    $sql_rsledger = "select * from ledger  where l_code='" . $row_rsl_code["c_code"] . "' and  l_yearfl != '1' and  l_date >='" . $_GET["dtfrom"] . "' and l_date <='" . $_GET["dtto"] . "' order by l_date";
                    /*  } else {
                      //	$sql_rsledger="select * from ledger  where l_code='" . $row_rsl_code["c_code"] . "' and  l_yearfl != '1' and  l_date >='" . $_GET["dtfrom"] . "' and l_date <='" . $_GET["dtto"] . "' order by l_date";
                      $sql_rsledger="select * from view_ledger  where l_code='" . $row_rsl_code["c_code"] . "' and  l_yearfl != '2' and  l_yearfl != '1' and  l_date >='" . $_GET["dtfrom"] . "' and l_date <='" . $_GET["dtto"] . "' order by l_date";
                      } */

                    $result_rsledger = mysql_query($sql_rsledger, $dbacc);
                    while ($row_rsledger = mysql_fetch_array($result_rsledger)) {

                        if ($_GET["chk_lastyear"] == "on") {
                            if (($row_rsledger["l_flag"] == "OPB") and ($row_rsledger["l_yearfl"] != 2)) {
                                
                            } else {

                                if ($row_rsledger["l_flag"] != "OPB") {
                                    if ($row_rsledger["l_flag1"] == "DEB") {
                                        $mamo = $mamo + $row_rsledger["l_amount"];
                                    } else {
                                        $mamo = $mamo - $row_rsledger["l_amount"];
                                    }
                                }
                            }
                        } else {
                            if ($row_rsledger["l_yearfl"] != 2) {
                                if ($row_rsledger["l_flag"] != "OPB") {
                                    if ($row_rsledger["l_flag1"] == "DEB") {
                                        $mamo = $mamo + $row_rsledger["l_amount"];
                                    } else {
                                        $mamo = $mamo - $row_rsledger["l_amount"];
                                    }
                                }
                            }
                        }
                    }
                    $sql = "update lcodes set pen=" . $mamo . "  where c_code='" . $row_rsl_code["c_code"] . "'";
                    $result = mysql_query($sql, $dbacc);
                }

//$sql_rsPrInv1 = "select *  from lcodes where paccno='".$row_rsPrInv["c_code"]."' order by c_code";
                $sql_rsPrInv = "select *  from lcodes where c_group!='D' order by c_code desc";
                $result_rsPrInv = mysql_query($sql_rsPrInv, $dbacc);
                while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)) {

                    $sql_rsPrInv1 = "select sum(pen) as totpen  from lcodes where paccno='" . $row_rsPrInv["c_code"] . "' ";
                    $result_rsPrInv1 = mysql_query($sql_rsPrInv1, $dbacc);
                    $row_rsPrInv1 = mysql_fetch_array($result_rsPrInv1);

                    $sql = "update lcodes set pen=" . $row_rsPrInv1["totpen"] . "  where c_code='" . $row_rsPrInv["c_code"] . "'";
                    $result = mysql_query($sql, $dbacc);

                    $opbal = 0;

                    //$sql_rsPrInv3 = "select *  from lcodes where paccno='".$row_rsPrInv["c_code"]."' and c_group='D' order by c_code desc";
                    $sql_rsPrInv3 = "select *  from lcodes where c_code like '" . $row_rsPrInv["c_code"] . "%' and c_group='D' order by c_code desc";
                    $result_rsPrInv3 = mysql_query($sql_rsPrInv3, $dbacc);
                    while ($row_rsPrInv3 = mysql_fetch_array($result_rsPrInv3)) {

                        $sql_rsPrInv_deb = "select sum(l_amount) as totpen  from ledger where l_code='" . $row_rsPrInv3["c_code"] . "' and  l_yearfl != '1' and  l_date <'" . $_GET["dtfrom"] . "' and l_flag1='DEB' ";
                        //	echo $sql_rsPrInv_deb."</br>";
                        $result_rsPrInv_deb = mysql_query($sql_rsPrInv_deb, $dbacc);
                        $row_rsPrInv_deb = mysql_fetch_array($result_rsPrInv_deb);

                        $sql_rsPrInv_cre = "select sum(l_amount) as totpen  from ledger where l_code='" . $row_rsPrInv3["c_code"] . "' and  l_yearfl != '1' and  l_date <'" . $_GET["dtfrom"] . "' and l_flag1='CRE' ";
                        //	echo $sql_rsPrInv_cre."</br>";
                        $result_rsPrInv_cre = mysql_query($sql_rsPrInv_cre, $dbacc);
                        $row_rsPrInv_cre = mysql_fetch_array($result_rsPrInv_cre);

                        $sql_rsPrInv1 = "select sum(c_opbal) as totc_opbal  from lcodes where c_code='" . $row_rsPrInv3["c_code"] . "'";
                        //echo $sql_rsPrInv1."</br>";
                        $result_rsPrInv1 = mysql_query($sql_rsPrInv1, $dbacc);
                        $row_rsPrInv1 = mysql_fetch_array($result_rsPrInv1);

                        $opbal = $opbal + $row_rsPrInv1["totc_opbal"] + $row_rsPrInv_deb["totpen"] - $row_rsPrInv_cre["totpen"];
                    }
                    $sql = "update lcodes set c_opbal=" . $opbal . "  where c_code='" . $row_rsPrInv["c_code"] . "'";
                    //echo $sql."</br></br>";
                    $result = mysql_query($sql, $dbacc);
                }


////// Elder Account  //////////////////

                $sql_rsPrInv = "select *  from lcodes where c_group='E' order by c_code desc";
                $result_rsPrInv = mysql_query($sql_rsPrInv, $dbacc);
                while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)) {

                    $sql_rsPrInv1 = "select sum(pen) as totpen  from lcodes where paccno='" . $row_rsPrInv["c_code"] . "' ";
                    $result_rsPrInv1 = mysql_query($sql_rsPrInv1, $dbacc);
                    $row_rsPrInv1 = mysql_fetch_array($result_rsPrInv1);

                    $sql = "update lcodes set pen=" . $row_rsPrInv1["totpen"] . "  where c_code='" . $row_rsPrInv["c_code"] . "'";
                    $result = mysql_query($sql, $dbacc);

                    $sql_rsPrInv1 = "select sum(c_opbal) as totc_opbal  from lcodes where paccno='" . $row_rsPrInv["c_code"] . "' ";
                    $result_rsPrInv1 = mysql_query($sql_rsPrInv1, $dbacc);
                    $row_rsPrInv1 = mysql_fetch_array($result_rsPrInv1);

                    $sql = "update lcodes set c_opbal=" . $row_rsPrInv1["totc_opbal"] . "  where c_code='" . $row_rsPrInv["c_code"] . "'";
                    $result = mysql_query($sql, $dbacc);
                    /*
                      $opbal=0;

                      //$sql_rsPrInv3 = "select *  from lcodes where paccno='".$row_rsPrInv["c_code"]."' and c_group='D' order by c_code desc";
                      $sql_rsPrInv3 = "select *  from lcodes where paccno = '".$row_rsPrInv["c_code"]."' order by c_code desc";
                      $result_rsPrInv3=mysql_query($sql_rsPrInv3, $dbacc);
                      while ($row_rsPrInv3 = mysql_fetch_array($result_rsPrInv3)){

                      $sql_rsPrInv_deb = "select sum(l_amount) as totpen  from ledger where l_code='".$row_rsPrInv3["c_code"]."' and  l_yearfl != '1' and  l_date <'" . $_GET["dtfrom"] . "' and l_flag1='DEB' ";
                      //	echo $sql_rsPrInv_deb."</br>";
                      $result_rsPrInv_deb=mysql_query($sql_rsPrInv_deb, $dbacc);
                      $row_rsPrInv_deb = mysql_fetch_array($result_rsPrInv_deb);

                      $sql_rsPrInv_cre = "select sum(l_amount) as totpen  from ledger where l_code='".$row_rsPrInv3["c_code"]."' and  l_yearfl != '1' and  l_date <'" . $_GET["dtfrom"] . "' and l_flag1='CRE' ";
                      //	echo $sql_rsPrInv_cre."</br>";
                      $result_rsPrInv_cre=mysql_query($sql_rsPrInv_cre, $dbacc);
                      $row_rsPrInv_cre = mysql_fetch_array($result_rsPrInv_cre);

                      $sql_rsPrInv1 = "select sum(c_opbal) as totc_opbal  from lcodes where c_code='".$row_rsPrInv3["c_code"]."'";
                      //echo $sql_rsPrInv1."</br>";
                      $result_rsPrInv1=mysql_query($sql_rsPrInv1, $dbacc);
                      $row_rsPrInv1 = mysql_fetch_array($result_rsPrInv1);

                      $opbal=$opbal+$row_rsPrInv1["totc_opbal"]+$row_rsPrInv_deb["totpen"]-$row_rsPrInv_cre["totpen"];
                      }
                      $sql="update lcodes set c_opbal=".$opbal."  where c_code='" . $row_rsPrInv["c_code"] . "'";
                      //echo $sql."</br></br>";
                      $result=mysql_query($sql, $dbacc); */
                }

                $sql_rspara = "select * from accpara";
                $result_rspara = mysql_query($sql_rspara, $dbacc);
                $row_rspara = mysql_fetch_array($result_rspara);





                $txtdes = "TB Report From : " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "    To: " . date("Y-m-d", strtotime($_GET["dtto"]));

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
    <td height=\"21\" colspan=\"3\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"208\" height=\"21\" colspan=\"3\"><span class=\"heading\">" . $txtdes . "</span></td>
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



                $table.="<table width=\"904\" height=\"81\" border=\"1\" cellspacing=\"0\">
		
      	<tr>
        <th width=\"70\" height=\"23\">Ledger</th>
        <th width=\"400\">Account Description</th>
        <th width=\"100\">Opening Debit</th>
		<th width=\"100\">Opening Credit</th>
		<th width=\"100\">Debit</th>
        <th width=\"100\">Credit</th>
		<th width=\"100\">Closing Debit</th>
        <th width=\"100\">Closing Credit</th>
		
        </tr>";

                $deb = 0;
                $cre = 0;

                $bal = 0;
                $totbal = 0;
                $cl_deb = 0;
                $cl_cre = 0;

                $open_tot_deb = 0;
                $open_tot_cre = 0;



                if (trim($_GET["ledgno"]) != "") {
                    $ledgno = $_GET["ledgno"];
                    $sql_rsPrInv = "select *  from lcodes where c_code like '$ledgno%' order by c_code";
                } else {
                    $sql_rsPrInv = "select *  from lcodes order by c_code";
                }
                $result_rsPrInv = mysql_query($sql_rsPrInv, $dbacc);
                while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)) {

                    //if ($row_rsPrInv["c_group"]!="D"){	
                    $bF = 0;
                    $OpCrAmu = 0;
                    $OpDbAmu = 0;
                    $OpBalAm = 0;
                    $OpLnkAmt = 0;

                    //echo $_SESSION['User_Type'];
                    /* if ($_SESSION['User_Type'] == "1") {

                      $sql_rs="sELECT  l_amount, l_code, l_refno, l_flag1 from ledger where l_flag = 'OPB' and l_code = '".$row_rsPrInv["c_code"]."' and l_yearfl = '2' ";
                      echo $sql_rs."1</br>";
                      $result_rs=mysql_query($sql_rs, $dbacc);
                      while ($row_rs = mysql_fetch_array($result_rs)){
                      if ($row_rs["l_flag1"] == "CRE") {
                      $OpCrAmu = $OpCrAmu + $row_rs["l_amount"];
                      } else {
                      $OpDbAmu = $OpDbAmu + $row_rs["l_amount"];
                      }
                      }
                      } else { */

                    //	$sql_rsPrInv1 = "select *  from lcodes where paccno='".$row_rsPrInv["c_code"]."' order by c_code";
                    //	$result_rsPrInv1=mysql_query($sql_rsPrInv1, $dbacc); 
                    //  	while ($row_rsPrInv1 = mysql_fetch_array($result_rsPrInv1)){

                    if ($_GET["chk_lastyear"] == "on") {
                        if ($_SESSION['dev'] == "1") {
                            $sql_rs = "sELECT  l_amount, l_code, l_refno, l_flag1 from ledger where l_flag = 'OPB' and l_code = '" . $row_rsPrInv1["c_code"] . "' and l_yearfl = '2' ";
                        } else {
                            $sql_rs = "sELECT  l_amount, l_code, l_refno, l_flag1 from ledger where l_flag = 'OPB' and l_code = '" . $row_rsPrInv1["c_code"] . "' and l_yearfl = '0' ";
                        }
                    } else {
                        $sql_rs = "sELECT  l_amount, l_code, l_refno, l_flag1 from ledger where l_flag = 'OPB' and l_code = '" . $row_rsPrInv1["c_code"] . "' and l_yearfl = '0' ";
                    }
                    //echo $sql_rs."</br>";
                    $result_rs = mysql_query($sql_rs, $dbacc);
                    while ($row_rs = mysql_fetch_array($result_rs)) {

                        if ($row_rs["l_flag1"] == "CRE") {
                            $OpCrAmu = $OpCrAmu + $row_rs["l_amount"];
                        } else {
                            $OpDbAmu = $OpDbAmu + $row_rs["l_amount"];
                        }
                    }
                    //	}	//}
                    //	$sql_rsPrInv1 = "select *  from lcodes where paccno='".$row_rsPrInv["c_code"]."' order by c_code";
                    //	$result_rsPrInv1=mysql_query($sql_rsPrInv1, $dbacc); 
                    //  	while ($row_rsPrInv1 = mysql_fetch_array($result_rsPrInv1)){

                    $sql_opCR = "select sum(l_amount) as ctot from ledger where l_flag != 'OPB' and l_yearfl != '2' and  l_yearfl != '1'  AND l_flag1='CRE' and l_code = '" . $row_rsPrInv["c_code"] . "' and (l_date<'" . $_GET["dtfrom"] . "'  )";
//echo $sql_opCR."</br>";
                    $result_opCR = mysql_query($sql_opCR, $dbacc);
                    while ($row_opCR = mysql_fetch_array($result_opCR)) {
                        $OpCrAmu = $OpCrAmu + $row_opCR["ctot"];
                    }

                    $sql_opDb = "select sum(l_amount) as dtot from ledger where  l_flag != 'OPB' and l_yearfl != '2' and  l_yearfl != '1' AND l_flag1='DEB' and l_code = '" . $row_rsPrInv["c_code"] . "'  and (l_date<'" . $_GET["dtfrom"] . "' ) ";
//echo $sql_opDb."</br>";
                    $result_opDb = mysql_query($sql_opDb, $dbacc);
                    while ($row_opDb = mysql_fetch_array($result_opDb)) {
                        $OpDbAmu = $OpDbAmu + $row_opDb["dtot"];
                    }

                    //	}

                    $bF = $OpBalAm + $OpDbAmu - $OpCrAmu + $OpLnkAmt;

                    if ($bF >= 0) {
                        $bfFlag = "DEB";
                    } else {
                        $bfFlag = "CRE";
                    }

                    if ($row_rsPrInv["c_group"] == "D") {
                        $url = "report_ledger_link.php?txtAccCode=" . $row_rsPrInv["c_code"] . "&txtAccName=" . $row_rsPrInv["c_name"] . "&repdatefrom=" . $_GET["dtfrom"] . "&repdateto=" . $_GET["dtto"];
                    } else {
                        $url = "report_ledger_parent.php?txtAccCode=" . $row_rsPrInv["c_code"] . "&txtAccName=" . $row_rsPrInv["c_name"] . "&repdatefrom=" . $_GET["dtfrom"] . "&repdateto=" . $_GET["dtto"];
                    }

                    if (($row_rsPrInv["pen"] != 0) or ($row_rsPrInv["c_opbal"] != 0)) {

                        if ($row_rsPrInv["c_group"] != "D") {
                            $table.="<tr><td><a target=\"_blank\" href=\"" . $url . "\"><b>" . $row_rsPrInv["c_code"] . "</b></a></td>
			<td><a target=\"_blank\" href=\"" . $url . "\"><b>" . $row_rsPrInv["c_name"] . "</b></a></td>";
                        } else {
                            $table.="<tr><td><a target=\"_blank\" href=\"" . $url . "\">" . $row_rsPrInv["c_code"] . "</a></td>
			<td><a target=\"_blank\" href=\"" . $url . "\">" . $row_rsPrInv["c_name"] . "</a></td>";
                        }

                        /* if ($bfFlag=="DEB"){
                          if ($bF==0){
                          $table.="<td>&nbsp;</td>";
                          } else {
                          $table.="<td align=right>".number_format($bF, 2, ".", ",")."</td>";
                          }
                          $table.="<td>&nbsp;</td>";
                          $open_tot_deb=$open_tot_deb+$bF;
                          } else {
                          $table.="<td>&nbsp;</td>";
                          $table.="<td align=right>".number_format((-1*$bF), 2, ".", ",")."</td>";
                          $open_tot_cre=$open_tot_cre+$bF;
                          } */


                        if ($row_rsPrInv["c_group"] != "D") {
                            if ($row_rsPrInv["c_opbal"] > 0) {
                                $table.="<td align=right><b>" . number_format($row_rsPrInv["c_opbal"], 2, ".", ",") . "</b></td>";
                                $table.="<td>&nbsp;</td>";
                                $open_tot_deb = $open_tot_deb + $row_rsPrInv["c_opbal"];
                            } else if ($row_rsPrInv["c_opbal"] == 0) {
                                $table.="<td>&nbsp;</td>";
                                $table.="<td>&nbsp;</td>";
                                //$open_tot_deb=$open_tot_deb+$bF;
                            } else if ($row_rsPrInv["c_opbal"] < 0) {
                                $table.="<td>&nbsp;</td>";
                                $table.="<td align=right><b>" . number_format(($row_rsPrInv["c_opbal"] * -1), 2, ".", ",") . "</b></td>";

                                $open_tot_cre = $open_tot_cre + $row_rsPrInv["c_opbal"];
                            } else {
                                $table.="<td>&nbsp;</td>";
                                $table.="<td>&nbsp;</td>";
                            }
                        } else {

                            if ($row_rsPrInv["c_opbal"] > 0) {
                                $table.="<td align=right>" . number_format($row_rsPrInv["c_opbal"], 2, ".", ",") . "</td>";
                                $table.="<td>&nbsp;</td>";
                                $open_tot_deb = $open_tot_deb + $row_rsPrInv["c_opbal"];
                            } else if ($row_rsPrInv["c_opbal"] == 0) {
                                $table.="<td>&nbsp;</td>";
                                $table.="<td>&nbsp;</td>";
                                //$open_tot_deb=$open_tot_deb+$bF;
                            } else if ($row_rsPrInv["c_opbal"] < 0) {
                                $table.="<td>&nbsp;</td>";
                                $table.="<td align=right>" . number_format(($row_rsPrInv["c_opbal"] * -1), 2, ".", ",") . "</td>";

                                $open_tot_cre = $open_tot_cre + $row_rsPrInv["c_opbal"];
                            } else {
                                $table.="<td>&nbsp;</td>";
                                $table.="<td>&nbsp;</td>";
                            }
                        }

                        //echo $bF;
                        //echo $row_rsPrInv["pen"];

                        if ($row_rsPrInv["c_group"] != "D") {
                            if ($row_rsPrInv["pen"] > 0) {

                                $table.="<td align=right><b>" . number_format($row_rsPrInv["pen"], 2, ".", ",") . "</b></td>";
                                $table.="<td>&nbsp;</td>";

                                if ($row_rsPrInv["c_group"] == "D") {
                                    $deb = $deb + $row_rsPrInv["pen"];
                                }
                            } else {
                                $table.="<td>&nbsp;</td>";
                                $pen = -1 * $row_rsPrInv["pen"];
                                $table.="<td align=right><b>" . number_format($pen, 2, ".", ",") . "</b></td>";

                                if ($row_rsPrInv["c_group"] == "D") {
                                    $cre = $cre + $row_rsPrInv["pen"];
                                }
                            }
                        } else {

                            if ($row_rsPrInv["pen"] > 0) {

                                $table.="<td align=right>" . number_format($row_rsPrInv["pen"], 2, ".", ",") . "</td>";
                                $table.="<td>&nbsp;</td>";

                                if ($row_rsPrInv["c_group"] == "D") {
                                    $deb = $deb + $row_rsPrInv["pen"];
                                }
                            } else {
                                $table.="<td>&nbsp;</td>";
                                $pen = -1 * $row_rsPrInv["pen"];
                                $table.="<td align=right>" . number_format($pen, 2, ".", ",") . "</td>";

                                if ($row_rsPrInv["c_group"] == "D") {
                                    $cre = $cre + $row_rsPrInv["pen"];
                                }
                            }
                        }

                        $bal = $bal + $row_rsPrInv["c_opbal"] + $row_rsPrInv["pen"];

                        $cl_bal = $row_rsPrInv["c_opbal"] + $row_rsPrInv["pen"];

                        if ($row_rsPrInv["c_group"] != "D") {
                            if ($cl_bal >= 0) {
                                $table.="<td align=right><b>" . number_format($cl_bal, 2, ".", ",") . "</b></td>";
                                $table.="<td>&nbsp;</td>";
                                $cl_deb = $cl_deb + $cl_bal;
                            } else {
                                $table.="<td>&nbsp;</td>";
                                $table.="<td align=right><b>" . number_format(-1 * $cl_bal, 2, ".", ",") . "</b></td>";
                                $cl_cre = $cl_cre + $cl_bal;
                            }
                        } else {
                            if ($cl_bal >= 0) {
                                $table.="<td align=right>" . number_format($cl_bal, 2, ".", ",") . "</td>";
                                $table.="<td>&nbsp;</td>";
                                $cl_deb = $cl_deb + $cl_bal;
                            } else {
                                $table.="<td>&nbsp;</td>";
                                $table.="<td align=right>" . number_format(-1 * $cl_bal, 2, ".", ",") . "</td>";
                                $cl_cre = $cl_cre + $cl_bal;
                            }
                        }

                        /* if ($bal<0){
                          echo "<td align=right>(".number_format((-1*$bal), 2, ".", ",").")</td>";
                          } else {
                          echo "<td align=right>".number_format($bal, 2, ".", ",")."</td>";
                          } */
                        $table.="</tr>";
                    }

                    /* } else {
                      $table.="<tr><td><b>".$row_rsPrInv["c_code"]."</b></td>
                      <td colspan=5><b>".$row_rsPrInv["c_name"]."</b></td>";

                      } */
                }
                $cre_plus = -1 * $cre;
                $totbal = $totbal + $bal;

                $table.="<tr><td colspan=2>&nbsp;</td>
		<td align=right><b>" . number_format($open_tot_deb, 2, ".", ",") . "</b></td>
		<td align=right><b>" . number_format(-1 * $open_tot_cre, 2, ".", ",") . "</b></td>
		<td align=right><b>" . number_format($deb, 2, ".", ",") . "</b></td>
		<td align=right><b>" . number_format($cre_plus, 2, ".", ",") . "</b></td>
		<td align=right><b>" . number_format($cl_deb, 2, ".", ",") . "</b></td>
		<td align=right><b>" . number_format(-1 * $cl_cre, 2, ".", ",") . "</b></td></tr>";

                /* if ($totbal>=0){
                  echo "<td align=right><b>".number_format($totbal, 2, ".", ",")."</b></td></tr>";
                  } else {
                  echo "<td align=right><b>(".number_format(-1*$totbal, 2, ".", ",").")</b></td></tr>";
                  } */








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
                $file = "report/rpt_trial_bal_p.xls";

                $f = fopen($file, "w+");

                fwrite($f, $table);

                echo "<a href=\"report/rpt_trial_bal_p.xls\">Download Excel Report</a>";
            }


            if ($_GET["radio"] == "op_Details") {

                include('connection.php');

                $table.="<table width=\"904\" height=\"81\" border=\"1\" cellspacing=\"0\">
		
      	<tr>
        <th width=\"70\" height=\"23\">Date</th>
        <th width=\"80\">Ref No</th>
        <th width=\"80\">Code</th>
		<th width=\"200\">Ledger Name</th>
		<th width=\"50\">Debit/Credit</th>
        <th width=\"100\">Amount</th>
		
        </tr>";


                if ($_GET["chk_lastyear"] == "on") {
                    $strsql = "select * from view_ledger  where  l_yearfl != '1' and  l_date >='" . $_GET["dtfrom"] . "' and l_date <='" . $_GET["dtto"] . "' order by l_date, l_refno ";
                } else {
                    $strsql = "select * from view_ledger  where  l_yearfl != '2' and  l_yearfl != '1' and  l_date >='" . $_GET["dtfrom"] . "' and l_date <='" . $_GET["dtto"] . "' order by l_date, l_refno ";
                }
                //echo $strsql;

                $deb = 0;
                $cre = 0;

                $result_strsql = mysql_query($strsql, $dbacc);
                while ($row_strsql = mysql_fetch_array($result_strsql)) {

                    if ($row_strsql["l_refno"] != $l_refno) {
                        $table.="
		
      				<tr>
        <td width=\"70\" height=\"23\" colspan=6>&nbsp;</td>
       
	    </tr>";
                    }

                    $c_group = "";
                    $strsql_lcode = "select * from lcodes  where  c_code = '" . $row_strsql["l_code"] . "'";
                    $result_lcode = mysql_query($strsql_lcode, $dbacc);
                    if ($row_lcode = mysql_fetch_array($result_lcode)) {
                        $c_group = $row_lcode["c_group"];
                    }


                    if ($_GET["chk_lastyear"] == "on") {
                        $strsql_cre = "select sum(l_amount) as cretot from view_ledger  where  l_yearfl != '1' and  l_date >='" . $_GET["dtfrom"] . "' and l_date <='" . $_GET["dtto"] . "' and l_flag1='CRE' and l_date='" . $row_strsql["l_date"] . "' and l_refno='" . $row_strsql["l_refno"] . "' order by l_date, l_refno ";
                    } else {
                        $strsql_cre = "select sum(l_amount) as cretot from view_ledger  where  l_yearfl != '2' and  l_yearfl != '1' and  l_date >='" . $_GET["dtfrom"] . "' and l_date <='" . $_GET["dtto"] . "'  and l_flag1='CRE' and l_date='" . $row_strsql["l_date"] . "' and l_refno='" . $row_strsql["l_refno"] . "' order by l_date, l_refno ";
                    }
                    $result_strsql_cre = mysql_query($strsql_cre, $dbacc);
                    $row_strsql_cre = mysql_fetch_array($result_strsql_cre);

                    if ($_GET["chk_lastyear"] == "on") {
                        $strsql_deb = "select sum(l_amount) as debtot from view_ledger  where  l_yearfl != '1' and  l_date >='" . $_GET["dtfrom"] . "' and l_date <='" . $_GET["dtto"] . "' and l_flag1='DEB' and l_date='" . $row_strsql["l_date"] . "' and l_refno='" . $row_strsql["l_refno"] . "' order by l_date, l_refno ";
                    } else {
                        $strsql_deb = "select sum(l_amount) as debtot from view_ledger  where  l_yearfl != '2' and  l_yearfl != '1' and  l_date >='" . $_GET["dtfrom"] . "' and l_date <='" . $_GET["dtto"] . "'  and l_flag1='DEB' and l_date='" . $row_strsql["l_date"] . "' and l_refno='" . $row_strsql["l_refno"] . "' order by l_date, l_refno ";
                    }
                    $result_strsql_deb = mysql_query($strsql_deb, $dbacc);
                    $row_strsql_deb = mysql_fetch_array($result_strsql_deb);

                    if ($row_strsql_cre["cretot"] != $row_strsql_deb["debtot"]) {
                        $table.="
		
      	<tr>
        <td width=\"70\" height=\"23\" bgcolor=\"#00FF00\">" . $row_strsql["l_date"] . "</td>
        <td width=\"400\" bgcolor=\"#00FF00\">" . $row_strsql["l_refno"] . "</td>
        <td width=\"100\" bgcolor=\"#00FF00\">" . $row_strsql["l_code"] . "</td>
		<td width=\"100\" bgcolor=\"#00FF00\">" . $row_strsql["name"] . "</td>
		<td width=\"100\" bgcolor=\"#00FF00\">" . $row_strsql["l_flag1"] . "</td>
        <td width=\"100\" bgcolor=\"#00FF00\">" . $row_strsql["l_amount"] . "</td>
	    </tr>";
                    } else if ($row_strsql["l_code"] == "") {
                        $table.="
		
      	<tr>
        <td width=\"70\" height=\"23\" bgcolor=\"#FFFF00\">" . $row_strsql["l_date"] . "</td>
        <td width=\"400\" bgcolor=\"#FFFF00\">" . $row_strsql["l_refno"] . "</td>
        <td width=\"100\" bgcolor=\"#FFFF00\">" . $row_strsql["l_code"] . "</td>
		<td width=\"100\" bgcolor=\"#FFFF00\">" . $row_strsql["name"] . "</td>
		<td width=\"100\" bgcolor=\"#FFFF00\">" . $row_strsql["l_flag1"] . "</td>
        <td width=\"100\" bgcolor=\"#FFFF00\">" . $row_strsql["l_amount"] . "</td>
	    </tr>";
                    } else if ($c_group != "D") {
                        $table.="
		
      	<tr>
        <td width=\"70\" height=\"23\" bgcolor=\"#FF0000\">" . $row_strsql["l_date"] . "</td>
        <td width=\"400\" bgcolor=\"#FF0000\">" . $row_strsql["l_refno"] . "</td>
        <td width=\"100\" bgcolor=\"#FF0000\">" . $row_strsql["l_code"] . "</td>
		<td width=\"100\" bgcolor=\"#FF0000\">" . $row_strsql["name"] . "</td>
		<td width=\"100\" bgcolor=\"#FF0000\">" . $row_strsql["l_flag1"] . "</td>
        <td width=\"100\" bgcolor=\"#FF0000\">" . $row_strsql["l_amount"] . "</td>
	    </tr>";
                    } else {
                        $table.="
		
      	<tr>
        <td width=\"70\" height=\"23\">" . $row_strsql["l_date"] . "</td>
        <td width=\"400\">" . $row_strsql["l_refno"] . "</td>
        <td width=\"100\">" . $row_strsql["l_code"] . "</td>
		<td width=\"100\">" . $row_strsql["name"] . "</td>
		<td width=\"100\">" . $row_strsql["l_flag1"] . "</td>
        <td width=\"100\">" . $row_strsql["l_amount"] . "</td>
	    </tr>";
                    }

                    if ($row_strsql["l_flag1"] == "DEB") {
                        $deb = $deb + $row_strsql["l_amount"];
                    }

                    if ($row_strsql["l_flag1"] == "CRE") {
                        $cre = $cre + $row_strsql["l_amount"];
                    }

                    $l_refno = $row_strsql["l_refno"];
                }

                $table.="
		
      				<tr>
        <td width=\"70\" height=\"23\" colspan=5><b>Debit Total - " . number_format($deb, 2, ".", ",") . "</b></td>
       
	    </tr>";

                $table.="
		
      				<tr>
        <td width=\"70\" height=\"23\" colspan=5><b>Credit Total - " . number_format($cre, 2, ".", ",") . "</b></td>
       
	    </tr>";
                echo $table;

                $file = "report/rpt_detail.xls";

                $f = fopen($file, "w+");

                fwrite($f, $table);

                echo "<a href=\"report/rpt_detail.xls\">Download Excel Report</a>";
            }
            ?>
