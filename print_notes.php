<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Final Account - Notes</title>
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
        include ('./connectioni.php');




        $sql_rsledger = "select l_code,name,sum(l_amount) as l_amount,l_flag1,month(l_date) as mon,year(l_date) as yer,paccno from view_ledger  where l_yearfl != '1' and l_yearfl != '2' and l_date <='" . $_POST["dtto"] . "' and c_group = 'D' group by l_code,l_flag1,month(l_date),year(l_date),name,paccno";


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


        $sql = "delete from tmp_tb where (atype = 'E')";
        mysqli_query($dbacc, $sql);


        $sql = "select l_code from tmp_tb group by l_code";
        $result1 = mysqli_query($dbacc, $sql);
        while ($rst1 = mysqli_fetch_array($result1)) {
            $sql = "select * from lcodes where c_code = '" . $rst1['l_code'] . "'";
            $resultr = mysqli_query($dbacc, $sql);
            while ($rstr = mysqli_fetch_array($resultr)) {

                $sql = "select * from acc_account_data where (acc_code = '" . $rstr['c_code'] . "' or acc_code ='" . $rstr['paccno'] . "') and mrow='" . $_POST["row"] . "' and mcol ='4'";
                $resultm = mysqli_query($dbacc, $sql);
                if (!$rstm = mysqli_fetch_array($resultm)) {

                    $sql = "delete from tmp_tb where l_code = '" . $rst1['l_code'] . "'";
                    mysqli_query($dbacc, $sql);
                } else {
//             
                    if ($rstm['atype'] == "D") {
                        $sql = "delete from tmp_tb where l_code='" . $rst1['l_code'] . "' and atype = 'P'";
                        $resultm = mysqli_query($dbacc, $sql);
                    } else {
                        $sql = "delete from tmp_tb where l_code='" . $rst1['l_code'] . "' and atype = 'D'";
                        $resultm = mysqli_query($dbacc, $sql);
                    }
                }
            }
        }




        $table = "<center><b>Accounting Notes</b><br>";
        $table .= "<i>From " . date("d-M-Y", strtotime($_POST["dtfrom"])) . " To " . date("d-M-Y", strtotime($_POST["dtto"])) . "</i><hr>";

        $table .= "<table border=0 >";
        echo $table;





        $sql = "select * from pnl_notes_data where sdate <='" . $_POST['dtto'] . "'and mrow = '" . $_POST["row"] . "' order by sdate desc";

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

        $sql = "select * from acc_cel_cal where mrow='" . $_POST["row"] . "' and mcol ='3'";
        $result = mysqli_query($dbacc, $sql);
        $rst = mysqli_fetch_array($result);
        echo "<tr><th>&nbsp;</th><th width ='50'>&nbsp;</th><th colspan=4 align='left'><u>Schedule - " . $rst['description'] . "</u></th></tr>";


        $sql = "select * from acc_cel_cal where mrow='" . $_POST["row"] . "' and mcol ='2'";
        $result = mysqli_query($dbacc, $sql);
        $rst = mysqli_fetch_array($result);
        echo "<tr><th>&nbsp;</th><th width ='50'>&nbsp;</th><th colspan=4 align='left'><u>" . $rst['description'] . "</u></th></tr>";


        if ($_POST['type'] != 'date') {
            if (isset($_POST['Check2'])) {
                $mon = date("Y", strtotime($_POST['dtfrom'])) . "-" . (date("m", strtotime($_POST['dtfrom'])) - 1) . "-01";

                $sql = "update tmp_tb set l_mon = '" . (date("m", strtotime($_POST['dtfrom'])) - 1) . "',l_year='" . date("Y", strtotime($_POST['dtfrom'])) . "',l_date = '" . $mon . "' where l_date <'" . $_POST['dtfrom'] . "'";

                $resultm = mysqli_query($dbacc, $sql);
            }
        }




        if ($_POST['type'] == 'date') {
            $sql = "update tmp_tb set l_mon = '" . date("m", strtotime($_POST['dtto'])) . "' ";
            $resultm = mysqli_query($dbacc, $sql);
            $sql = "update tmp_tb set l_year = '" . date("Y", strtotime($_POST['dtto'])) . "' ";
            $resultm = mysqli_query($dbacc, $sql);
        }




        /*
          $sql = "select l_code from tmp_tb group by l_code";
          $result1 = mysqli_query($dbacc, $sql);
          while ($rst1 = mysqli_fetch_array($result1)) {
          $sql = "select * from lcodes where c_code = '" . $rst1['l_code'] . "'";
          $resultr = mysqli_query($dbacc, $sql);
          while ($rstr = mysqli_fetch_array($resultr)) {
          $sql = "select * from acc_account_data where (acc_code = '" . $rstr['c_code'] . "' or acc_code ='" . $rstr['paccno'] . "') and mrow='" . $_POST["row"] . "' and mcol ='4'";
          $resultm = mysqli_query($dbacc, $sql);
          if (!$rstm = mysqli_fetch_array($resultm)) {
          $sql = "delete from tmp_tb where l_code = '" . $rst1['l_code'] . "'";
          mysqli_query($dbacc, $sql);
          } else {

          }
          }
          }


          $sql = "select * from acc_account_data where mrow='" . $_POST["row"] . "' and mcol ='4'";
          $result1 = mysqli_query($dbacc, $sql);
          while ($rst1 = mysqli_fetch_array($result1)) {
          if ($rst1['actype']== "D") {

          $sql = "delete from tmp_tb where atype !='D' and paccno='" . $rst1['acc_code'] . "'";
          $resultm = mysqli_query($dbacc, $sql);

          }
          }




         */











//        $sql = "select * from acc_account_data where mrow='" . $_POST["row"] . "' and mcol ='4'";
//        while ($rst1 = mysqli_fetch_array($result1)) {
//
//            $sql = "select * from lcodes where c_code = '" . $rst1['l_code'] . "'";
//            $resultr = mysqli_query($dbacc, $sql);
//            if ($rstr = mysqli_fetch_array($resultr)) {
//
//                if ($rstr['c_group'] == "E") {
//                    $sql = "delete from tmp_tb where (atype = 'E' or atype='D')";
//                    mysqli_query($dbacc, $sql);
//                }
//                
//                if ($rstr['c_group'] == "P") {
//                    $sql = "delete from tmp_tb where (atype = 'E' or atype='P')";
//                    mysqli_query($dbacc, $sql);
//                }                              
//            }
//        }
//
//        
//        $sql = "select paccno from tmp_tb    group by paccno";
//        $result1 = mysqli_query($dbacc, $sql);
//        while ($rst1 = mysqli_fetch_array($result1)) {
//            $sql = "delete from tmp_tb where l_code = '" . $rst1['paccno'] . "'";
//            mysqli_query($dbacc, $sql);
//        }

        $i = 1;

        echo "<tr><th></th><th width=50></th><th width=500></th>";
        if ($_POST['type'] != 'date') {

            $sql = "select l_mon,l_year from tmp_tb  ";
            if (!isset($_POST['Check2'])) {
                $sql .= " where l_mon >='" . date("m", strtotime($_POST['dtfrom'])) . "' and l_year >='" . date("Y", strtotime($_POST['dtfrom'])) . "'";
            }
            $sql .= "  group by l_mon,l_year  order by l_year,l_mon";

            $resultm = mysqli_query($dbacc, $sql);
            while ($rstm = mysqli_fetch_array($resultm)) {

                if (!isset($_POST['Check2'])) {
                    $mon = $rstm["l_year"] . "-" . $rstm["l_mon"] . "-01";
                    $mstr = date("M", strtotime($mon)) . " " . date("Y", strtotime($mon));
                } else {
                    if ($i != 1) {
                        $mon = $rstm["l_year"] . "-" . $rstm["l_mon"] . "-01";
                        $mstr = date("M", strtotime($mon)) . " " . date("Y", strtotime($mon));
                    } else {
                        $mstr = "OP Balance";
                    }
                    $i = $i + 1;
                }


                echo "<th width=100>" . $mstr . "</th>";
            }
            echo "<th width=100>Total</th>";
        } else {
            echo "<th width=100>Amount</th>";
        }

        echo "</tr>";

        echo "<tr><td></td>";

        $sql = "select * from pnlpos where mrow = '" . $_POST["row"] . "' order by pos ";
        $result1 = mysqli_query($dbacc, $sql);
        $numrows = mysqli_num_rows($result1) + 1;
        $i = 1;

        if ($numrows == 1) {
            $sql = "select l_code,l_name from view_pnlnotes group by  l_code,l_name  order by pos,l_code";
            $result1 = mysqli_query($dbacc, $sql);
            $numrows = mysqli_num_rows($result1) + 1;
        }

        $sql = "select * from pnlpos where mrow = '" . $_POST["row"] . "'   and noteP <> ''  order by pos ";
        $result1 = mysqli_query($dbacc, $sql);
        $numrows1 = mysqli_num_rows($result1) + 1;
        if ($numrows1 > 1) {
		 
            while ($i < ($numrows + $numrows1)) {

                $sql = "select * from pnlpos where mrow = '" . $_POST["row"] . "' and pos = '" . $i . "' and noteP <> ''  order by pos ";

                $result1 = mysqli_query($dbacc, $sql);
                $irest = 0;
                if ($row1 = mysqli_fetch_array($result1)) {

                    $mstr1 = $row1['noteP'];
                    $mcode = $row1['l_code'];
                    $msign = $row1['action'];
                }

                if ($msign != "") {
					
                    echo "<tr><th></th>";
                    echo "<td></td><th></th>";

                    $sql = "select l_mon,l_year from tmp_tb ";
                    if (!isset($_POST['Check2'])) {
                        $sql .= " where l_mon >='" . date("m", strtotime($_POST['dtfrom'])) . "' and l_year >='" . date("Y", strtotime($_POST['dtfrom'])) . "'";
                    }
                    $sql .= "  group by l_mon,l_year  order by l_year,l_mon";
					
                    $resultm = mysqli_query($dbacc, $sql);
                    while ($rstm = mysqli_fetch_array($resultm)) {
                        $mamo = 0;
                        $sql = "select  sum(l_amount) as l_amo from tmp_tb  where   l_mon = '" . $rstm['l_mon'] . "' and l_year='" . $rstm['l_year'] . "'   and atype<> 'E'";

                        $resultm1 = mysqli_query($dbacc, $sql);
                        if ($rstm1 = mysqli_fetch_array($resultm1)) {
                            $mamo = $rstm1['l_amo'];
                        }

                        $ldate = $rstm['l_year'] . "-" . $rstm['l_mon'] . "-01";
                        $ldate = date("Y-m-t", strtotime($ldate));
                        $sql = "select  (l_amount*subtot) as  l_amount from view_pnlnotes  where   atype = 'E'  and l_code <> '" . $mcode . "'   and l_mon = '" . $rstm['l_mon'] . "' and l_year='" . $rstm['l_year'] . "'  order by l_date";
						
                        $resultm1 = mysqli_query($dbacc, $sql);
                        if ($rstm1 = mysqli_fetch_array($resultm1)) {
                            $mamo = $mamo + $rstm1['l_amount'];
                        }

                        echo "<th style='border-top-style :solid;border-top-width: 1px;'  align='right'>" . number_format($mamo, 2, ".", ",") . "</td>";
                    }
                    if ($_POST['type'] != 'date') {



                        $mamo = 0;
                        $sql = "select  sum(l_amount*subtot) as l_amo from view_pnlnotes where atype<> 'E'  ";
                        $resultm1 = mysqli_query($dbacc, $sql);
                        if ($rstm1 = mysqli_fetch_array($resultm1)) {
                            $mamo = $mamo + $rstm1['l_amo'];
                        }



                        $sql = "select  (l_amount*subtot) as  l_amount from view_pnlnotes  where   atype = 'E'  and l_code <> '" . $mcode . "' order by l_date  ";
                        $resultm1 = mysqli_query($dbacc, $sql);
                        if ($rstm1 = mysqli_fetch_array($resultm1)) {
                            $mamo = $mamo + $rstm1['l_amount'];
                        }
                        echo "<th  style='border-top-style :solid;border-top-width: 1px;'  align='right'>" . number_format($mamo, 2, ".", ",") . "</td>";
                    }
                    echo "</tr>";
                }


                $sql = "select l_code,l_name from view_pnlnotes where pos = '" . $i . "'  group by  l_code,l_name  order by pos,l_code";
                $resultr = mysqli_query($dbacc, $sql);

                while ($rstr = mysqli_fetch_array($resultr)) {
					 
                    $sql = "select sum(l_amount) as l_amo  from tmp_tb where l_code='" . $rstr['l_code'] . "'";

                    $resultr1 = mysqli_query($dbacc, $sql);
                    while ($rstr1 = mysqli_fetch_array($resultr1)) {
                        if ($rstr1['l_amo'] != 0) {
                            echo "<tr><td></td>";


                            echo "<td>" . $mstr1 . "</td><td>" . $rstr['l_name'] . "</td>";
                            $mstr1 = "";

                            $sql = "select l_mon,l_year from tmp_tb";
                            if (!isset($_POST['Check2'])) {
                                $sql .= " where l_mon >='" . date("m", strtotime($_POST['dtfrom'])) . "' and l_year >='" . date("Y", strtotime($_POST['dtfrom'])) . "'";
                            }
                            $sql .= "  group by l_mon,l_year  order by l_year,l_mon";
                            $resultm = mysqli_query($dbacc, $sql);
                            while ($rstm = mysqli_fetch_array($resultm)) {
                                $sql = "select  sum(l_amount) as l_amo from tmp_tb  where l_code='" . $rstr['l_code'] . "' and l_mon = '" . $rstm['l_mon'] . "' and l_year='" . $rstm['l_year'] . "' and atype <> 'E'";
                                $resultm1 = mysqli_query($dbacc, $sql);
                                if ($rstm1 = mysqli_fetch_array($resultm1)) {
                                    $mamo = $rstm1['l_amo'];
                                }

                                if ($mamo == 0) {
                                    $ldate = $rstm['l_year'] . "-" . $rstm['l_mon'] . "-01";
                                    $ldate = date("Y-m-t", strtotime($ldate));
                                    $sql = "select  l_amount  from tmp_tb  where l_code='" . $rstr['l_code'] . "' and l_mon = '" . $rstm['l_mon'] . "' and l_year='" . $rstm['l_year'] . "'   and atype = 'E'";
                                    if ($rstr['l_code'] == "T1") {
                                        $sql .= "  order by l_date ";
                                    } else {
                                        $sql .= "  order by l_date desc";
                                    }

                                    $resultm1 = mysqli_query($dbacc, $sql);
                                    if ($rstm1 = mysqli_fetch_array($resultm1)) {
                                        $mamo = $rstm1['l_amount'];
                                    }
                                }

                                echo "<td align='right'>" . number_format($mamo, 2, ".", ",") . "</td>";
                            }
                            if ($_POST['type'] != 'date') {



                                $mamo = 0;
                                $sql = "select  sum(l_amount) as l_amo from tmp_tb  where l_code='" . $rstr['l_code'] . "'  and atype <> 'E'";

                                $resultm1 = mysqli_query($dbacc, $sql);
                                if ($rstm1 = mysqli_fetch_array($resultm1)) {
                                    $mamo = $rstm1['l_amo'];
                                }
                                if ($mamo == 0) {
                                    $sql = "select  l_amount from tmp_tb  where l_code='" . $rstr['l_code'] . "'  and atype = 'E'";
                                    if ($rstr['l_code'] == "T1") {
                                        $sql .= "  order by l_date ";
                                    } else {
                                        $sql .= "  order by l_date desc";
                                    }

                                    $resultm1 = mysqli_query($dbacc, $sql);
                                    if ($rstm1 = mysqli_fetch_array($resultm1)) {
                                        $mamo = $rstm1['l_amount'];
                                    }
                                }
                                echo "<td align='right'>" . number_format($mamo, 2, ".", ",") . "</td>";
                            }
                            echo "</tr>";
                        }
                    }
                }

                if ($msign != "") {
                    $msign = "";
                    echo "<tr><th></th>";
                    echo "<td></td><th></th>";

                    $sql = "select l_mon,l_year from tmp_tb  ";
                    if (!isset($_POST['Check2'])) {
                        $sql .= " where l_mon >='" . date("m", strtotime($_POST['dtfrom'])) . "' and l_year >='" . date("Y", strtotime($_POST['dtfrom'])) . "'";
                    }

                    $sql .= "  group by l_mon,l_year  order by l_year,l_mon";
                    $resultm = mysqli_query($dbacc, $sql);
                    while ($rstm = mysqli_fetch_array($resultm)) {

                        $sql = "select  sum(l_amount*subtot) as l_amo from view_pnlnotes  where   l_mon = '" . $rstm['l_mon'] . "' and l_year='" . $rstm['l_year'] . "' and atype<> 'E'";
                        $resultm1 = mysqli_query($dbacc, $sql);
                        $mamo = 0;
                        if ($rstm1 = mysqli_fetch_array($resultm1)) {
                            $mamo = $rstm1['l_amo'];
                        }

                        $ldate = $rstm['l_year'] . "-" . $rstm['l_mon'] . "-01";
                        $ldate = date("Y-m-t", strtotime($ldate));
                        $sql = "select  (l_amount*subtot) as  l_amount from view_pnlnotes  where  l_mon = '" . $rstm['l_mon'] . "' and l_year='" . $rstm['l_year'] . "'   and atype = 'E'  and l_code = '" . $mcode . "'";
                        if ($mcode == "T1") {
                            $sql .= "  order by l_date ";
                        } else {
                            $sql .= "  order by l_date desc";
                        }
                        $resultm1 = mysqli_query($dbacc, $sql);
                        if ($rstm1 = mysqli_fetch_array($resultm1)) {
                            $mamo = $mamo + $rstm1['l_amount'];
                        }

                        $sql = "select  (l_amount*subtot) as  l_amount from view_pnlnotes  where  l_mon = '" . $rstm['l_mon'] . "' and l_year='" . $rstm['l_year'] . "'   and atype = 'E'  and l_code <> '" . $mcode . "'";
                        if ($mcode == "T1") {
                            $sql .= "  order by l_date ";
                        } else {
                            $sql .= "  order by l_date desc";
                        }
                        $resultm1 = mysqli_query($dbacc, $sql);
                        if ($rstm1 = mysqli_fetch_array($resultm1)) {
                            $mamo = $mamo + $rstm1['l_amount'];
                        }
                        echo "<th style='border-top-style :solid;border-top-width: 1px;border-bottom-style :double;'  align='right'>" . number_format($mamo, 2, ".", ",") . "</td>";
                    }

                    if ($_POST['type'] != 'date') {
                        $mamo = 0;
                        $sql = "select  sum(l_amount*subtot) as l_amo from view_pnlnotes where atype<> 'E'  ";
                        $resultm1 = mysqli_query($dbacc, $sql);
                        if ($rstm1 = mysqli_fetch_array($resultm1)) {
                            $mamo = $mamo + $rstm1['l_amo'];
                        }

                        $sql = "select  (l_amount*subtot) as  l_amount from view_pnlnotes  where  atype = 'E'  and l_code <> '" . $mcode . "'";
                        if ($mcode != "T1") {
                            $sql .= "  order by l_date ";
                        } else {
                            $sql .= "  order by l_date desc";
                        }
                        $resultm1 = mysqli_query($dbacc, $sql);
                        if ($rstm1 = mysqli_fetch_array($resultm1)) {
                            $mamo = $mamo + $rstm1['l_amount'];
                        }

                        $sql = "select  (l_amount*subtot) as  l_amount from view_pnlnotes  where   atype = 'E'  and l_code = '" . $mcode . "'";
                        if ($mcode == "T1") {
                            $sql .= "  order by l_date ";
                        } else {
                            $sql .= "  order by l_date desc";
                        }
                        $resultm1 = mysqli_query($dbacc, $sql);
                        if ($rstm1 = mysqli_fetch_array($resultm1)) {
                            $mamo = $mamo + $rstm1['l_amount'];
                        }

                        echo "<th  style='border-top-style :solid;border-top-width: 1px;border-bottom-style :double;'  align='right'>" . number_format($mamo, 2, ".", ",") . "</td>";
                    }
                    echo "</tr>";
                }
                $i = $i + 1;
            }
        } else {

            $sql = "select l_code,l_name from view_pnlnotes   group by  l_code,l_name  order by pos,l_code";
            $resultr = mysqli_query($dbacc, $sql);
            while ($rstr = mysqli_fetch_array($resultr)) {

                $sql = "select sum(l_amount) as l_amo  from tmp_tb where l_code='" . $rstr['l_code'] . "'";
				 
                $resultr1 = mysqli_query($dbacc, $sql);
                while ($rstr1 = mysqli_fetch_array($resultr1)) {
                    if ($rstr1['l_amo'] != 0) {
                        echo "<tr><td></td>";
                        echo "<td></td><td>" . $rstr['l_name'] . "</td>";
                        $sql = "select l_mon,l_year from tmp_tb  ";
                        if (!isset($_POST['Check2'])) {
                            $sql .= " where l_mon >='" . date("m", strtotime($_POST['dtfrom'])) . "' and l_year >='" . date("Y", strtotime($_POST['dtfrom'])) . "'";
                        }
                        $sql .= "  group by l_mon,l_year  order by l_year,l_mon";
                        $resultm = mysqli_query($dbacc, $sql);
                        while ($rstm = mysqli_fetch_array($resultm)) {
                            $sql = "select  sum(l_amount) as l_amo from tmp_tb  where l_code='" . $rstr['l_code'] . "' and l_mon = '" . $rstm['l_mon'] . "' and l_year='" . $rstm['l_year'] . "'";
                            $resultm1 = mysqli_query($dbacc, $sql);
                            if ($rstm1 = mysqli_fetch_array($resultm1)) {
                                echo "<td align='right'>" . number_format($rstm1['l_amo'], 2, ".", ",") . "</td>";
                            } else {
                                echo "<td align='right'>" . number_format(0, 2, ".", ",") . "</td>";
                            }
                        }
                        if ($_POST['type'] != 'date') {
                            $sql = "select  sum(l_amount) as l_amo from tmp_tb  where l_code='" . $rstr['l_code'] . "'";
                            $resultm1 = mysqli_query($dbacc, $sql);
                            if ($rstm1 = mysqli_fetch_array($resultm1)) {
                                echo "<td align='right'>" . number_format($rstm1['l_amo'], 2, ".", ",") . "</td>";
                            } else {
                                echo "<td align='right'>" . number_format(0, 2, ".", ",") . "</td>";
                            }
                        }
                        echo "</tr>";
                    }
                }
            }
            echo "<tr><th></th>";
            echo "<td></td><th></th>";

            echo "<tr><th></th>";
            echo "<td></td><th>Total</th>";

            $sql = "select l_mon,l_year from tmp_tb  ";
            if (!isset($_POST['Check2'])) {
                $sql .= " where l_mon >='" . date("m", strtotime($_POST['dtfrom'])) . "' and l_year >='" . date("Y", strtotime($_POST['dtfrom'])) . "'";
            }

            $sql .= "  group by l_mon,l_year  order by l_year,l_mon";
            $resultm = mysqli_query($dbacc, $sql);
            while ($rstm = mysqli_fetch_array($resultm)) {

                $sql = "select  sum(l_amount) as l_amo from tmp_tb  where   l_mon = '" . $rstm['l_mon'] . "' and l_year='" . $rstm['l_year'] . "' and atype<> 'E'";
                $resultm1 = mysqli_query($dbacc, $sql);
                if ($rstm1 = mysqli_fetch_array($resultm1)) {
                    echo "<th align='right'>" . number_format($rstm1['l_amo'], 2, ".", ",") . "</td>";
                } else {
                    echo "<th align='right'>" . number_format(0, 2, ".", ",") . "</td>";
                }
            }
            if ($_POST['type'] != 'date') {
                $sql = "select  sum(l_amount) as l_amo from tmp_tb where atype<> 'E'";
                $resultm1 = mysqli_query($dbacc, $sql);
                if ($rstm1 = mysqli_fetch_array($resultm1)) {
                    echo "<th align='right'>" . number_format($rstm1['l_amo'], 2, ".", ",") . "</td>";
                } else {
                    echo "<th align='right'>" . number_format(0, 2, ".", ",") . "</td>";
                }
            }
            echo "</tr>";
        }
        ?>
    </body>
