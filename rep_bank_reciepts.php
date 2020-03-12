<?php
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60);
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Bank Deposit Report</title>

        <style>
            table
            {
                border-collapse:collapse;
            }
            table, td, th
            {
                border:1px solid black;
                font-family:Arial, Helvetica, sans-serif;
                padding:5px;
            }
            th
            {
                font-weight:bold;
                font-size:12px;

            }
            td
            {
                font-size:11px;

            }
        </style>

    </head>

    <body> <center> 


            <?php
            require_once("./connection.php");

            $sql_head = "select * from dep_mas";
            $result_head = mysql_query($sql_head,$dbacc);
            $row_head = mysql_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . trim($row_head["description"]) . "</span></center><br>";
            echo "<center><span class=\"style2\">Bank Deposit Report - Detail</span></center><br>";
            
            $from = $_GET["dtfrom"];
            $to = $_GET["dtto"];

            
			$sql = "select * from lcodes where c_code = '" . $_GET["cmbbank"] . "'";
			$result = mysql_query($sql,$dbacc);
             ($row = mysql_fetch_array($result));
			
			echo "<center>" . $row['c_name']  . " - Period $from to $to </center><br>";

            echo "<table  border=1>";
            echo "<thead><tr><th>Ref No</th><th>Cheque No</th>";
				//echo "<th width=60>Cash</th>";
				echo "<th width=60>Cash TT</th>";	
				echo "<th width=60>PD</th>";
				echo "<th width=60>PD Rtn</th>";
				echo "<th width=60>R/Deposit</th><th width=80>Direct Dep.</th></tr></thead><tbody>";
			
            $sql = "SELECT * from ledger where l_flag1 = 'deb' and l_date between '$from' and '$to'";
            
            if($_GET["cmbbank"] != "All"){
                $sql .= " and l_code = '".$_GET["cmbbank"]."'";
            }
            $result = mysql_query($sql,$dbacc);
            while ($row = mysql_fetch_array($result)) {
                $cash = 0;
				$ctt =0;
				$pd =0;
				$pd_rtn =0;
				$rdep = 0;
				$mddep =0;
                echo "<tr><td>" . $row["l_refno"] . "</td>";
				echo "<td>" . $row["chno"] . "</td>";
				
				
				 
				$sql = "select * from s_crec where CA_REFNO='" . $row["l_refno"] . "'";
                $resultInner = mysql_query($sql,$dbinv);
                
				if ($rowInner = mysql_fetch_array($resultInner)) {
					
				if ($rowInner['pay_type'] == "Cash TT") {
				$ctt = $row["l_amount"];
				}
				if ($rowInner['pay_type'] == "Cash") {
				$cash = $row["l_amount"];
				}
				if ($rowInner['pay_type'] == "R/Deposit") {
				$rdep = $row["l_amount"];
				}
				
				} else {
					
				$sql = "select * from s_invcheq where ret_refno='" . $row["l_refno"] . "'";
                $resultInner = mysql_query($sql,$dbinv);
                
				if ($rowInner = mysql_fetch_array($resultInner)) {
					if ($rowInner['trn_type'] == "REC") {
					$pd = $row["l_amount"];
					}
					if ($rowInner['trn_type'] == "RET") {
					$pd_rtn = $row["l_amount"];
					}
				}  
				
				}
				
				//echo "<td align=right>" . number_format($cash, 2, ".", ",") . "</td>";
				echo "<td align=right>" . number_format($ctt, 2, ".", ",") . "</td>";	
				echo "<td align=right>" . number_format($pd, 2, ".", ",") . "</td>";
				echo "<td align=right>" . number_format($pd_rtn, 2, ".", ",") . "</td>";
				echo "<td align=right>" . number_format($rdep, 2, ".", ",") . "</td>";				
				if ($cash+$ctt+$pd+$pd_rtn+$rdep ==0) {
					echo "<td align=right>" . number_format($row["l_amount"], 2, ".", ",") . "</td>";
					$mdir = $mdir + $row["l_amount"];
				} else {
					echo "<td align=right>" . number_format(0, 2, ".", ",") . "</td>";			
				}
				
				$mcash = $mcash + $cash;
				$mctt = $mctt + $ctt;
				$mpd = $mpd + $pd;
				$mpd_rtn = $mpd_rtn + $pd_rtn;
				$mrdep = $mrdep + $rdep;
				
				
				echo "</tr>";
                
                 $mtot =   $mtot + $row["l_amount"];
            }
			echo "</tbody>";
			echo "<tr>";
			echo "<td colspan='2'></td>";
			//echo "<th align=right>" . number_format($mcash, 2, ".", ",") . "</th>";
			echo "<th align=right>" . number_format($mctt, 2, ".", ",") . "</th>";	
			echo "<th align=right>" . number_format($mpd, 2, ".", ",") . "</th>";
			echo "<th align=right>" . number_format($mpd_rtn, 2, ".", ",") . "</th>";
			echo "<th align=right>" . number_format($mrdep, 2, ".", ",") . "</th>";	
			echo "<th align=right>" . number_format($mdir, 2, ".", ",") . "</th></tr>";	
			
			echo "<tr>";
			echo "<th colspan='6'>Total</th>";
			echo "<th align=right>" . number_format($mctt+$mpd+$mpd_rtn+$mrdep+$mdir, 2, ".", ",") . "</th></tr>";	
			
			
            echo "</table>";
            ?>


    </body>
</html>
