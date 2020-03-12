<?php
session_start();
?>
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

$sql = "select * from pnl_notes_data_bs where sdate <='" . $_GET['dtto'] . "'   order by sdate desc";

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




        $table = "";
        $mrow = "";
        $start = 0;

        $sql = "select max(mrow) maxrow from acc_cel_cal_bs";
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


                $sql = "select * from acc_cel_cal_bs where  mrow=" . $r . " and mcol=" . $c . " order by mrow, mcol";
                $result = mysql_query($sql, $dbacc);
                if ($row = mysql_fetch_array($result)) {

                    if ($row["cell_type"] == "text") {
                        $cell = $row["description"];
                    }

                    if ($row["cell_type"] == "acc") {
						
						
                        $pen = 0;

                        $sql1 = "select * from acc_account_data_bs where mrow=" . $row["mrow"] . " and mcol=" . $row["mcol"] . " and acc_type='acc_front'";
                        $result1 = mysql_query($sql1, $dbacc);
                        if ($row1 = mysql_fetch_array($result1)) {
                            $pen = $pen + $row1["acc_val"];
                        }


                        $sql1 = "select * from acc_account_data_bs where mrow=" . $row["mrow"] . " and mcol=" . $row["mcol"];
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

                        $sql1 = "select * from acc_account_data_bs where mrow=" . $row["mrow"] . " and mcol=" . $row["mcol"] . " and acc_type='acc_rear'";
                        $result1 = mysql_query($sql1, $dbacc);
                        if ($row1 = mysql_fetch_array($result1)) {
                            if ($row1["add_less"] == "+") {
                                $pen = $pen + ($row1["acc_val"]);
                            } else if ($row1["add_less"] == "-") {
                                $pen = $pen - ($row1["acc_val"]);
                            }
                        }
                        $pen = abs($pen);
                        $cell = $pen;
                    }

                    if ($row["cell_type"] == "opr") {

					if ($r =="20") {
							
						  $sql = "select * from final_acc1 where mrow='29'";
						$result1 = mysql_query($sql, $dbacc);
						if ($row1 = mysql_fetch_array($result1)) {
            
			$sql = "update final_acc2 set c4 = '" . $row1['c4'] . "' where mrow ='19'";
            $result_final = mysql_query($sql, $dbacc);
			
			
            $sql = "update final_acc2 set c5 = '" . $row1['c5'] . "' where mrow ='19'";
            $result_final = mysql_query($sql, $dbacc);
            $sql = "update final_acc2 set c6 = '" . $row1['c6'] . "' where mrow ='19'";
            $result_final = mysql_query($sql, $dbacc);
            $sql = "update final_acc2 set c7 = '" . $row1['c7'] . "' where mrow ='19'";
            $result_final = mysql_query($sql, $dbacc);
			
						}
						}
					
                        $cell = 0;

                        $mrow1 = $row["mrow1"];
                        $mcol1 = "c" . $row["mcol1"];
                        $i = $mrow1;

                        $mrow2 = $row["mrow2"];
                        $mcol2 = "c" . $row["mcol2"];

                        //We suggest $mcol1 and $mcol2 are same
                        $cell_1 = 0;
                        while ($i <= $mrow2) {

                            $sql1 = "select * from final_acc2 where mrow=" . $i;
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

                            $sql1 = "select * from final_acc2 where mrow=" . $i;
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
                    $sql_final = "update final_acc2 set c" . $c . "='" . $cell . "' where mrow=" . $r;
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


        $table.="<center><b>Statement of Financial Position</b><br><br>";
        $table.="<i>For the Period From " . date("d-M-Y", strtotime($_GET["dtfrom"])) . " To " . date("d-M-Y", strtotime($_GET["dtto"])) . "</i><br><br>";
        $mstr = date("Y", strtotime($_GET["dtfrom"])) . "/" . date("Y", strtotime($_GET["dtto"])) . "<br>" . "&nbsp;&nbsp;Rs.<br>";




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
            $mon = 0;
        }


        $table.="</tr>";
        $sql = "select * from final_acc2";
        $result = mysql_query($sql, $dbacc);
        while ($row = mysql_fetch_array($result)) {



            $table.="<tr>";

            $c = 1;
            while ($c <= (4 + $mon)) {

                $col = "c" . $c;


                $sql1 = "select * from acc_cel_cal_bs where mrow='" . $row["mrow"] . "' and mcol=" . $c;
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

                $mwidth = "100px";

                if ($c == "1") {
                    $mwidth = "200px";
                }

                if ($c == "2") {
                    $mwidth = "5px";
                }
                if ($c == "3") {
                    $mwidth = "5px";
                }

                if ((($row[$col] == "") or ( is_null($row[$col]) == true)) and $c <= 3) {
                    if (($row["c3"] == "") and ( $c == 1)) {
                        $mwidth = "600px";
                        $table.="<td align=left colspan='3' width='" . $mwidth . "'>&nbsp;</td>";
                    } else {
                        if (($row["c3"] != "") and ( $c == 1)) {
                            $table.="<td align=left width='" . $mwidth . "'>&nbsp;</td>";
                        }
                        if (($row["c3"] != "") and ( $c != 1)) {
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
                            if (($row["c3"] == "") and ( $c == 1)) {
                                $mwidth = "600px";
                                $table.="<td align=left colspan='3' width='" . $mwidth . "'>" . $mbold_st . $munder_st . $row[$col] . $mbold_en . "</td>";
                            } else {
                                if (($row["c3"] != "") and ( $c == 1)) {
                                    $table.="<td align=left width='" . $mwidth . "'>" . $mbold_st . $munder_st . $row[$col] . $mbold_en . "</td>";
                                }
                                if (($row["c3"] != "") and ( $c != 1)) {
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
            if ($_GET['type'] != 'date') {


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
