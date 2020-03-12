<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Final Account</title>
        <style>
            table
            {
                border-collapse:collapse;
            }
            table, td, th
            {

                font-family:Arial, Helvetica, sans-serif;
                padding:5px;
            }
            th
            {
                font-weight:bold;
                font-size:14px;

            }
            td
            {
                font-size:13px;

            }
        </style>



    </head>

    <body>

        <?php
        include('./connectioni.php');

        $sql_rsledger = "select l_code,name,sum(l_amount) as l_amount,l_flag1,month(l_date) as mon,year(l_date) as yer,paccno from view_ledger  where l_yearfl != '1' and l_yearfl != '2' and l_date <='" . $_GET["dtto"] . "' and c_group = 'D' group by l_code,l_flag1,month(l_date),year(l_date),name,paccno";


        $result_rsledger = mysqli_query($dbacc, $sql_rsledger);
        while ($row_rsledger = mysqli_fetch_array($result_rsledger)) {
            $mamo = 0;
            if ($row_rsledger["l_flag1"] == "DEB") {
                $mamo = $mamo + $row_rsledger["l_amount"];
            } else {
                $mamo = $mamo - $row_rsledger["l_amount"];
            }
            $mon = $row_rsledger["yer"] . "-" . $row_rsledger["mon"] . "-01";
            $sql[] = "('" . $mon . "','" . $row_rsledger['l_code'] . "','" . $row_rsledger['name'] . "', '" . $mamo . "','" . $row_rsledger['l_flag1'] . "','D','" . $row_rsledger['mon'] . "','" . $row_rsledger['yer'] . "','" . $row_rsledger['paccno'] . "')";
        }

        $sql_RSMONSALES = "delete from tmp_tb";
        $result_RSMONSALES = mysqli_query($dbacc, $sql_RSMONSALES);
        $sql_RSMONSALES = "insert into tmp_tb (l_date,l_code,l_name,l_amount,l_flag1,atype,l_mon,l_year,paccno) values " . implode(',', $sql);
        $result_RSMONSALES = mysqli_query($dbacc, $sql_RSMONSALES);
        if (!$result_RSMONSALES) {
            print_r(mysql_error($dbacc));
        }




        $sql_tmp = "select sum(l_amount) as l_amount,l_flag1,c_name,paccno,paccno1,l_mon,l_year from view_tmptb group by paccno,paccno1,c_name,l_flag1,l_mon,l_year";
        $result_rsledger = mysqli_query($dbacc, $sql_tmp);
        while ($row_rsledger = mysqli_fetch_array($result_rsledger)) {
            if ($row_rsledger['paccno'] != "") {
                $mon = $row_rsledger["l_year"] . "-" . $row_rsledger["l_mon"] . "-01";
                $sql1[] = "('" . $mon . "','" . $row_rsledger['paccno'] . "','" . $row_rsledger['c_name'] . "', '" . $row_rsledger['l_amount'] . "','" . $row_rsledger['l_flag1'] . "','P','" . $row_rsledger['l_mon'] . "','" . $row_rsledger['l_year'] . "','" . $row_rsledger['paccno1'] . "')";
            }
        }
        $sql_RSMONSALES = "insert into tmp_tb (l_date,l_code,l_name,l_amount,l_flag1,atype,l_mon,l_year,paccno) values " . implode(',', $sql1);
        $result_RSMONSALES = mysqli_query($dbacc, $sql_RSMONSALES);
        if (!$result_RSMONSALES) {
            print_r(mysql_error($dbacc));
        }




        $sql_tmp = "select sum(l_amount) as l_amount,l_flag1,c_name,paccno,paccno1,l_mon,l_year from view_tmptb where atype = 'P' group by paccno,c_name,paccno1,l_flag1,l_mon,l_year";
        $result_rsledger = mysqli_query($dbacc, $sql_tmp);
        while ($row_rsledger = mysqli_fetch_array($result_rsledger)) {
            if ($row_rsledger['paccno'] != "") {
                $mon = $row_rsledger["l_year"] . "-" . $row_rsledger["l_mon"] . "-01";
                $sql2[] = "('" . $mon . "','" . $row_rsledger['paccno'] . "','" . $row_rsledger['c_name'] . "', '" . $row_rsledger['l_amount'] . "','" . $row_rsledger['l_flag1'] . "','E','" . $row_rsledger['l_mon'] . "','" . $row_rsledger['l_year'] . "','" . $row_rsledger['paccno1'] . "')";
            }
        }
		
        $sql_RSMONSALES = "insert into tmp_tb (l_date,l_code,l_name,l_amount,l_flag1,atype,l_mon,l_year,paccno) values " . implode(',', $sql2);
        $result_RSMONSALES = mysqli_query($dbacc, $sql_RSMONSALES);
        if (!$result_RSMONSALES) {
            print_r(mysql_error($dbacc));
        }





        $sql = "select * from pnl_notes_data where sdate <='" . $_GET['dtto'] . "'   order by sdate desc";
        $result1 = mysqli_query($dbacc, $sql);
        while ($rst1 = mysqli_fetch_array($result1)) {
            $mon = date("m", strtotime($rst1['sdate']));
            $yer = date("Y", strtotime($rst1['sdate']));
            $mstr = 'Stock As at ' . $rst1['sdate'];
            $sql = "insert into tmp_tb (l_date,l_code,l_name,l_amount,l_flag1,atype,l_mon,l_year,paccno) values 
			('" . $rst1['sdate'] . "','" . $rst1['l_code'] . "','" . $rst1['l_name'] . "', '" . $rst1['l_amount'] . "','DEB','E','" . $mon . "','" . $yer . "','')";
            $resultr = mysqli_query($dbacc, $sql);
            if (!$resultr) {
                echo mysqli_error($dbacc);
            }
        }

        include('./connection.php');

        //  exit();
//        $sql_rsl_code = "select c_code, pen from lcodes where c_group='D' order by c_code";
//        $result_rsl_code = mysql_query($sql_rsl_code, $dbacc);
//        while ($row_rsl_code = mysql_fetch_array($result_rsl_code)) {
//
//            $mamo = 0;
//
//            $sql_rsledger = "select sum(l_amount) as l_amount,l_flag,l_flag1 from ledger  where l_code='" . $row_rsl_code["c_code"] . "' and  l_yearfl != '1' and l_yearfl != '2' and  l_date >='" . $_GET["dtfrom"] . "' and l_date <='" . $_GET["dtto"] . "' group by l_flag,l_flag1 order by l_date";
//
//
//            $result_rsledger = mysql_query($sql_rsledger, $dbacc);
//            while ($row_rsledger = mysql_fetch_array($result_rsledger)) {
//                if ($row_rsledger["l_flag"] != "OPB") {
//                    if ($row_rsledger["l_flag1"] == "DEB") {
//                        $mamo = $mamo + $row_rsledger["l_amount"];
//                    } else {
//                        $mamo = $mamo - $row_rsledger["l_amount"];
//                    }
//                }
//            }
//
//            if ($mamo < 0) {
//                $mbal = -1 * $mamo;
//            } else {
//                $mbal = $mamo;
//            }
//
//            $sql = "update lcodes set pen=" . $mbal . "  where c_code='" . $row_rsl_code["c_code"] . "'";
//            $result = mysql_query($sql, $dbacc);
//        }
////$sql_rsPrInv1 = "select *  from lcodes where paccno='".$row_rsPrInv["c_code"]."' order by c_code";
//        $sql_rsPrInv = "select *  from lcodes where c_group!='D' order by c_code desc";
//        $result_rsPrInv = mysql_query($sql_rsPrInv, $dbacc);
//        while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)) {
//
//            $sql_rsPrInv1 = "select sum(pen) as totpen  from lcodes where paccno='" . $row_rsPrInv["c_code"] . "' ";
//            $result_rsPrInv1 = mysql_query($sql_rsPrInv1, $dbacc);
//            $row_rsPrInv1 = mysql_fetch_array($result_rsPrInv1);
//
//            if ($row_rsPrInv1["totpen"] < 0) {
//                $mbal = -1 * $row_rsPrInv1["totpen"];
//            } else {
//                $mbal = $row_rsPrInv1["totpen"];
//            }
//
//            $sql = "update lcodes set pen=" . $mbal . "  where c_code='" . $row_rsPrInv["c_code"] . "'";
//            $result = mysql_query($sql, $dbacc);
//
//            $opbal = 0;
//
//            //$sql_rsPrInv3 = "select *  from lcodes where paccno='".$row_rsPrInv["c_code"]."' and c_group='D' order by c_code desc";
//            $sql_rsPrInv3 = "select *  from lcodes where c_code like '" . $row_rsPrInv["c_code"] . "%' and c_group='D' order by c_code desc";
//            $result_rsPrInv3 = mysql_query($sql_rsPrInv3, $dbacc);
//            while ($row_rsPrInv3 = mysql_fetch_array($result_rsPrInv3)) {
//
//                $sql_rsPrInv_deb = "select sum(l_amount) as totpen  from ledger where l_code='" . $row_rsPrInv3["c_code"] . "' and  l_yearfl != '1' and  l_date <'" . $_GET["dtfrom"] . "' and l_flag1='DEB' ";
//                //	echo $sql_rsPrInv_deb."</br>";
//                $result_rsPrInv_deb = mysql_query($sql_rsPrInv_deb, $dbacc);
//                $row_rsPrInv_deb = mysql_fetch_array($result_rsPrInv_deb);
//
//                $sql_rsPrInv_cre = "select sum(l_amount) as totpen  from ledger where l_code='" . $row_rsPrInv3["c_code"] . "' and  l_yearfl != '1' and  l_date <'" . $_GET["dtfrom"] . "' and l_flag1='CRE' ";
//                //	echo $sql_rsPrInv_cre."</br>";
//                $result_rsPrInv_cre = mysql_query($sql_rsPrInv_cre, $dbacc);
//                $row_rsPrInv_cre = mysql_fetch_array($result_rsPrInv_cre);
//
//                $sql_rsPrInv1 = "select sum(c_opbal) as totc_opbal  from lcodes where c_code='" . $row_rsPrInv3["c_code"] . "'";
//                //echo $sql_rsPrInv1."</br>";
//                $result_rsPrInv1 = mysql_query($sql_rsPrInv1, $dbacc);
//                $row_rsPrInv1 = mysql_fetch_array($result_rsPrInv1);
//
//                $opbal = $opbal + $row_rsPrInv1["totc_opbal"] + $row_rsPrInv_deb["totpen"] - $row_rsPrInv_cre["totpen"];
//            }
//            $sql = "update lcodes set c_opbal=" . $opbal . "  where c_code='" . $row_rsPrInv["c_code"] . "'";
//            //echo $sql."</br></br>";
//            $result = mysql_query($sql, $dbacc);
//        }
////// Elder Account  //////////////////
//        $sql_rsPrInv = "select *  from lcodes where c_group='E' order by c_code desc";
//        $result_rsPrInv = mysql_query($sql_rsPrInv, $dbacc);
//        while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)) {
//
//            $sql_rsPrInv1 = "select sum(pen) as totpen  from lcodes where paccno='" . $row_rsPrInv["c_code"] . "' ";
//            $result_rsPrInv1 = mysql_query($sql_rsPrInv1, $dbacc);
//            $row_rsPrInv1 = mysql_fetch_array($result_rsPrInv1);
//
//
//            if ($row_rsPrInv1["totpen"] < 0) {
//                $mbal = -1 * $row_rsPrInv1["totpen"];
//            } else {
//                $mbal = $row_rsPrInv1["totpen"];
//            }
//
//            $sql = "update lcodes set pen=" . $mbal . "  where c_code='" . $row_rsPrInv["c_code"] . "'";
//            $result = mysql_query($sql, $dbacc);
//
//            $sql_rsPrInv1 = "select sum(c_opbal) as totc_opbal  from lcodes where paccno='" . $row_rsPrInv["c_code"] . "' ";
//            $result_rsPrInv1 = mysql_query($sql_rsPrInv1, $dbacc);
//            $row_rsPrInv1 = mysql_fetch_array($result_rsPrInv1);
//
//            $sql = "update lcodes set c_opbal=" . $row_rsPrInv1["totc_opbal"] . "  where c_code='" . $row_rsPrInv["c_code"] . "'";
//            $result = mysql_query($sql, $dbacc);
//        }
        //////////////////////////////////////////////////////////

        $table = "";
        $mrow = "";
        $start = 0;

        $sql = "select max(mrow) maxrow from acc_cel_cal";
        $result = mysql_query($sql, $dbacc);
        $row = mysql_fetch_array($result);

        $max_row = $row["maxrow"];



        $datetime1 = date_create($_GET['dtfrom']);
        $datetime2 = date_create($_GET['dtto']);
        $interval = date_diff($datetime1, $datetime2);
        $mon = $interval->m + 12 * $interval->y;
        $mon = $mon + 1;

        $r = 1;

        while ($r <= $max_row) {

            $c = 1;
            $month = $_GET['dtfrom'];
            while ($c <= (4 + $mon)) {


                $sql = "select * from acc_cel_cal where  mrow=" . $r . " and mcol=" . $c . " order by mrow, mcol";
                $result = mysql_query($sql, $dbacc);
                if ($row = mysql_fetch_array($result)) {

                    if ($row["cell_type"] == "text") {
                        $cell = $row["description"];
                    }

                    if ($row["cell_type"] == "acc") {

                        $pen = 0;

                        $sql1 = "select * from acc_account_data where mrow=" . $row["mrow"] . " and mcol=" . $row["mcol"] . " and acc_type='acc_front'";
                        $result1 = mysql_query($sql1, $dbacc);
                        if ($row1 = mysql_fetch_array($result1)) {
                            $pen = $pen + $row1["acc_val"];
                        }


                        $sql1 = "select * from acc_account_data where mrow=" . $row["mrow"] . " and mcol=" . $row["mcol"];
                        $result1 = mysql_query($sql1, $dbacc);
                        while ($row1 = mysql_fetch_array($result1)) {

                            if ($_GET['type'] != 'date') {
                                $sql2 = "select sum(l_amount) as l_amount  from tmp_tb where l_code='" . $row1["acc_code"] . "' and l_mon = '" . date("n", strtotime($month)) . "' and l_year='" . date("Y", strtotime($month)) . "'";
                            } else {
                                $sql2 = "select sum(l_amount) as l_amount  from tmp_tb where l_code='" . $row1["acc_code"] . "' ";
                            }

                            $result2 = mysql_query($sql2, $dbacc);
                            $row2 = mysql_fetch_array($result2);
                            if ($row1["add_less"] == "+") {
                                $pen = $pen + ($row2["l_amount"]);
                            } else if ($row1["add_less"] == "-") {
                                $pen = $pen - ($row2["l_amount"]);
                            }
                        }

                        $pen = abs($pen);

                        $sql1 = "select * from acc_account_data where mrow=" . $row["mrow"] . " and mcol=" . $row["mcol"] . " and acc_type='acc_rear'";
                        $result1 = mysql_query($sql1, $dbacc);
                        if ($row1 = mysql_fetch_array($result1)) {
                            if ($row1["add_less"] == "+") {
                                $pen = $pen + abs($row1["acc_val"]);
                            } else if ($row1["add_less"] == "-") {
                                $pen = $pen - abs($row1["acc_val"]);
                            }
                        }

                        $cell = $pen;
                    }

                    if ($row["cell_type"] == "opr") {

                        $cell = 0;

                        $mrow1 = $row["mrow1"];
                        $mcol1 = "c" . $row["mcol1"];
                        $i = $mrow1;

                        $mrow2 = $row["mrow2"];
                        $mcol2 = "c" . $row["mcol2"];

                        //We suggest $mcol1 and $mcol2 are same
                        $cell_1 = 0;
                        while ($i <= $mrow2) {

                            $sql1 = "select * from final_acc1 where mrow=" . $i;
                            $result1 = mysql_query($sql1, $dbacc);
                            if ($row1 = mysql_fetch_array($result1)) {
                                if (is_numeric($row1[$mcol2]) == true) {

                                    $cell_1 = $cell_1 + $row1[$mcol2];
                                }
                            }
                            $i = $i + 1;
                        }


                        $mrow3 = $row["mrow3"];

                        $mcol3 = "c" . $row["mcol3"];
                        $i = $mrow3;

                        $mrow4 = $row["mrow4"];
                        $mcol4 = "c" . $row["mcol4"];

                        //We suggest $mcol1 and $mcol2 are same
                        $cell_2 = 0;
                        while ($i <= $mrow4) {

                            $sql1 = "select * from final_acc1 where mrow=" . $i;
                            $result1 = mysql_query($sql1, $dbacc);
                            if ($row1 = mysql_fetch_array($result1)) {
                                if (is_numeric($row1[$mcol4]) == true) {

                                    $cell_2 = $cell_2 + $row1[$mcol4];
                                }
                            }
                            $i = $i + 1;
                        }

                        if ($row["opr"] == "+") {
                            $cell = $cell_1 + $cell_2;
                        } else {
                            $cell = $cell_1 - $cell_2;
                        }
                    }


                    //echo $cell;
					if (is_numeric($cell)) {
						$cell = round($cell);
					}
                    $sql_final = "update final_acc1 set c" . $c . "='" . $cell . "' where mrow=" . $r;
                    //echo $sql_final;
                    $result_final = mysql_query($sql_final, $dbacc);
                }

                if ($c > 3) {
                    $month = date('Y-m-d', strtotime('+1 month', strtotime($month)));
                }

                $c = $c + 1;
            }
            //$table.="</td>";
            $r = $r + 1;
        }






        $r = 1;
        $table.="<center><b>";
        if ($_SESSION['company'] == "EF") {
            $table.="E-Friendly";
        }

        if ($_SESSION['company'] == "BE") {
            $table.="Benedicsons (Pvt) Ltd";
        }

        if ($_SESSION['company'] == "TH") {
            $table.="Tyre House Trading (Pvt) Ltd";
        }
        $table.="</b><br><br>";


        $table.="<center><b>Statment of Income</b><br><br>";
        $table.="<i>For the Period From " . date("d-M-Y", strtotime($_GET["dtfrom"])) . " To " . date("d-M-Y", strtotime($_GET["dtto"])) . "</i><br><br>";
        $mstr = date("Y", strtotime($_GET["dtfrom"])) . "/" . date("Y", strtotime($_GET["dtto"])) . "<br>" . "&nbsp;&nbsp;Rs.<br>";

        if (date("Y", strtotime($_GET["dtfrom"]))  ==  date("Y", strtotime($_GET["dtto"]))) {
            $mstr = date("Y", strtotime($_GET["dtfrom"])) ;
        }


        // $table.="<center><table width='700px' border=0 ><tr><td width='5px'>&nbsp;</td><td  width='260px'>&nbsp;</td><td  width='200px' align=center>Notes</td><td width='5px'>&nbsp;</td><td width='5px'>&nbsp;</td><td width='5px'>&nbsp;</td><td align=center  width='100px'>&nbsp;&nbsp;" . $mstr . "</td></tr></table>";
        $table.="<hr><br><center><table border=0 >";
        $table.="<tr><td align=left colspan='3'>&nbsp;</td>";
        $i = 1;
        $month = $_GET['dtfrom'];
        if ($_GET['type'] != 'date') {
            while ($i <= $mon) {
                $mstr = date("M", strtotime($month)) . " " . date("Y", strtotime($month));
                $table.= "<th>" . $mstr . "</th>";
                $i = $i + 1;
                $month = date('Y-m-d', strtotime('+1 month', strtotime($month)));
            }
              $table.= "<th></th>";
              $table.= "<th>Total</th>";
        } else {
            $table.= "<th>" . $mstr . "</th>";
           
        }
        if ($_GET['type'] == 'date') {
            $mon=0;
        }
        
        
        $table.="</tr>";
        $sql = "select * from final_acc1";
        $result = mysql_query($sql, $dbacc);
        while ($row = mysql_fetch_array($result)) {



            $table.="<tr>";

            $c = 1;
            while ($c <= (4 + $mon)) {

                $col = "c" . $c;


                $sql1 = "select * from acc_cel_cal where mrow='" . $row["mrow"] . "' and mcol=" . $c;
                $result1 = mysql_query($sql1, $dbacc);
                $row1 = mysql_fetch_array($result1);
                if ($row1["mbold"] == "1") {
                    $mbold_st = "<b>";
                    $mbold_en = "</b>";
                } else {
                    $mbold_st = "";
                    $mbold_en = "";
                }

                if ($row1["munder"] == "1") {
                    $munder_st = "<u>";
                    $munder_en = "</u>";
                } else {
                    $munder_st = "";
                    $munder_en = "";
                }

                $mborder = "";
                if ($row1["mborder"] == "top") {
                    $mborder = "border-top-style :solid;border-top-width: 1px;";
                }
                if ($row1["mborder"] == "double") {
                    $mborder = "border-top-style :solid;border-top-width: 1px;border-bottom-style :double;";
                }

                $mwidth = "80px";

                if ($c == "2") {
                    $mwidth = "200px";
                }

                if ($c == "1") {
                    $mwidth = "5px";
                }


                if ((($row[$col] == "") or ( is_null($row[$col]) == true)) and $c <= 3) {
                    if (($row["c2"] == "") and ( $c == 1)) {
                        $mwidth = "600px";
                        $table.="<td align=left colspan='3' width='" . $mwidth . "'>&nbsp;</td>";
                    } else {
                        if (($row["c2"] != "") and ( $c == 1)) {
                            $table.="<td align=left width='" . $mwidth . "'>&nbsp;</td>";
                        }
                        if (($row["c2"] != "") and ( $c != 1)) {
                            $table.="<td align=left width='" . $mwidth . "'>&nbsp;</td>";
                        }
                    }
                } else {
                    if (is_numeric($row[$col])) {
                        $mbord1 = $mborder;
                        if ($row[$col] < 0) {
                            $table.="<td align=right  style ='" . $mborder . "' width='" . $mwidth . "'>" . $mbold_st . $munder_st . "(" . number_format(abs($row[$col]), 2, ".", ",") . ")" . $munder_en . $mbold_en . "</td>";
                        } else {
                            $table.="<td align=right  style ='" . $mborder . "' width='" . $mwidth . "'>" . $mbold_st . $munder_st . number_format(abs($row[$col]), 2, ".", ",") . $munder_en . $mbold_en . "</td>";
                        }
                    } else {

                        if ($c < 3) {
                            if (($row["c2"] == "") and ( $c == 1)) {
                                $mwidth = "600px";
                                $table.="<td align=left colspan='3' width='" . $mwidth . "'>" . $mbold_st . $munder_st . $row[$col] . $mbold_en . "</td>";
                            } else {
                                if (($row["c2"] != "") and ( $c == 1)) {
                                    $table.="<td align=left width='" . $mwidth . "'>" . $mbold_st . $munder_st . $row[$col] . $mbold_en . "</td>";
                                }
                                if (($row["c2"] != "") and ( $c != 1)) {
                                    $table.="<td align=left width='" . $mwidth . "'>" . $mbold_st . $munder_st . $row[$col] . $mbold_en . "</td>";
                                }
                            }
                        } else {
                            $table.="<td align=left width='" . $mwidth . "'>" . $mbold_st . $munder_st . $row[$col] . $mbold_en . "</td>";
                        }
                    }
                }
                $c = $c + 1;
            }
            if ($_GET['type']!= 'date') {
         
        
            $m = 4;
            $mtot = '';
            while ($m <= (4 + $mon)) {
                $colm = "c" . $m;
                if (($row[$colm] == "") or ( is_null($row[$colm]) == true)) {
                    
                } else {
                    $mtot = $mtot + $row[$colm];
                }

                $m = $m + 1;
            }
            if ($mtot != "") {
                if ($mtot < 0) {
                    $table.="<td align=right  style ='" . $mbord1 . "' width='" . $mwidth . "'>" . $mbold_st . $munder_st . "(" . number_format((-1 * $mtot), 2, ".", ",") . ")" . $munder_en . $mbold_en . "</td>";
                } else {
                    $table.="<td align=right  style ='" . $mbord1 . "' width='" . $mwidth . "'>" . $mbold_st . $munder_st . number_format($mtot, 2, ".", ",") . $munder_en . $mbold_en . "</td>";
                }
            } else {
                $table.="<td align=left width='" . $mwidth . "'>&nbsp;</td>";
            }
            }
            $table.="</tr>";
        }

        echo $table;

        $file = "final_acc.xls";

        $f = fopen($file, "w+");

        fwrite($f, $table);
        ?>
        </table>

        <?php echo "<a href=\"final_acc.xls\">---</a>"; ?>
    </body>
</html>
