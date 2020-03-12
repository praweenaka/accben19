<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	include('connection.php');
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		 date_default_timezone_set('Asia/Colombo'); 
		
if($_GET["Command"]=="get_bank")
{
	$sql="select * from bankmas where bcode='".$_GET["bankcode"]."'";
	$result=mysql_query($sql, $dbinv);
	if ($row = mysql_fetch_array($result)){
		echo $row["bname"];
	}
}


if($_GET["Command"]=="setamt")
{
	$sql="update tmp_cash_pay set amt=".$_GET["amt"]." where   accno='".$_GET["accno"]."' and tmp_no= '".$_SESSION['tmp_no_cashpayacc']."'";
		//echo $sql;
		$result=mysql_query($sql, $dbacc); 
		
		$sql="select sum(amt) as totamt from tmp_cash_pay where  entno='".$_GET["txt_entno"]."' and tmp_no= '".$_SESSION['tmp_no_cashpayacc']."'";
		//echo $sql;
		$result=mysql_query($sql, $dbacc); 
		$row = mysql_fetch_array($result);
		echo $row["totamt"];
}

if($_GET["Command"]=="addchq_cash_rec")
{
		
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec
		
		$sql="delete from tmp_cash_pay where accno='".$_GET["accno"]."' and tmp_no='".$_SESSION["tmp_no_cashpayacc"]."'";
		$result=mysql_query($sql, $dbacc);
		
		$sql="insert into tmp_cash_pay(entno, accno, accname, descript, amt, tmp_no) values ('".$_GET["txt_entno"]."', '".$_GET["accno"]."', '".$_GET["acc_name"]."', '".$_GET["descript"]."', ".$_GET["amt"].", '".$_SESSION["tmp_no_cashpayacc"]."')";
		$result=mysql_query($sql, $dbacc);
			
			$totamt=0;
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"100\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"200\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"300\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
				$sql="select * from tmp_cash_pay where tmp_no='".$_SESSION["tmp_no_cashpayacc"]."' ";
				$result=mysql_query($sql, $dbacc);
				while ($row = mysql_fetch_array($result)){
					$accno="accno_acc".$i;
					$accname="accname_acc".$i;
					$descript="descript_acc".$i;
					$amt="amt_acc".$i;
					
					$ResponseXML .= "<tr>
					<td><input type=\"text\" name=\"".$accno."\" id=\"".$accno."\" onblur=\"set_acc('".$row["accno"]."', '".$i."');\" value=\"".$row["accno"]."\" /></td>
					<td><input type=\"text\" name=\"".$accname."\" id=\"".$accname."\" value=\"".$row["accname"]."\" /></td>
					<td><input type=\"text\" name=\"".$descript."\" id=\"".$descript."\" value=\"".$row["descript"]."\" />".$row["descript"]."</td>
					<td align=right><input type=\"text\" name=\"".$amt."\" id=\"".$amt."\" onblur=\"setamt_opr('".$i."');\" value=\"".number_format($row["amt"], 2, ".", "")."\" /></td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['accno']."  name=".$row['accno']." onClick=\"del_item('".$row['accno']."');\"></td></tr>";
					
					
					$i=$i+1;
					$totamt=$totamt+$row["amt"];
				}
						
				$ResponseXML .= "   </table>]]></chq_table>";
				$ResponseXML .= "<totamt><![CDATA[".number_format($totamt, 2, ".", "")."]]></totamt>";		
				
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;			
}



if($_GET["Command"]=="del_item")
		{
		
			
			$sql="delete from tmp_cash_pay where accno='".$_GET["accno"]."' and tmp_no='".$_SESSION["tmp_no_cashpayacc"]."'";
		$result=mysql_query($sql, $dbacc);
		
	
			
			$totamt=0;
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
				$i=1;
				$sql="select * from tmp_cash_pay where tmp_no='".$_SESSION["tmp_no_cashpayacc"]."' ";
				$result=mysql_query($sql, $dbacc);
				while ($row = mysql_fetch_array($result)){
					$accno="accno".$i;
					$accname="accname".$i;
					$descript="descript".$i;
					$amt="amt".$i;
					
					$ResponseXML .= "<tr>
					<td><input type=\"text\" name=\"".$accno."\" id=\"".$accno."\" onblur=\"set_acc('".$row["accno"]."', '".$i."');\" value=\"".$row["accno"]."\" /></td>
					<td><input type=\"text\" name=\"".$accname."\" id=\"".$accname."\" value=\"".$row["accname"]."\" /></td>
					<td><input type=\"text\" name=\"".$descript."\" id=\"".$descript."\" value=\"".$row["descript"]."\" />".$row["descript"]."</td>
					<td align=right><input type=\"text\" name=\"".$amt."\" id=\"".$amt."\" onblur=\"setamt_opr('".$i."');\" value=\"".number_format($row["amt"], 2, ".", "")."\" /></td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['accno']."  name=".$row['accno']." onClick=\"del_item('".$row['accno']."');\"></td></tr>";
					
					$i=$i+1;
					$totamt=$totamt+$row["amt"];
				}
						
				$ResponseXML .= "   </table>]]></chq_table>";
				$ResponseXML .= "<totamt><![CDATA[".number_format($totamt, 2, ".", "")."]]></totamt>";		
				
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;		
				
			
	}
	

if($_GET["Command"]=="utilization")
{	
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	$i=1;
	$a_chq_no=array();
	$a_chq_date=array();
	$a_chq_amt=array();
	$a_chq_bank=array();
	
	$chq_pay="";
	$invno="";
	$delidate="";
	$available_inv_amt=0;
	$available_chq_amt=0;
	
	$sql="delete from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'"; 
	$result =$db->RunQuery($sql);
	
	$sql="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'"; 
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		
		if (($row["chqdate"] < date("Y-m-d")) or ($row["chqdate"] == date("Y-m-d"))) {
			
			$date = date('Y-m-d',strtotime(date("Y-m-d").' +1 days'));
			
			$a_chq_date[$i] = $date;
		} else {
			$a_chq_date[$i]=$row["chqdate"];
		}
		$a_chq_no[$i]=$row["chqno"];
		$a_chq_amt[$i]=$row["chqamt"];
		$a_chq_bank[$i]=$row["chqbank"];
		$i=$i+1;
	}	
	
	$mcou=$i;
		
	
	$invset=0;
	


	$i = 1;
	$K = 1;
	$invpos = 1;
 
while ($mcou>=$i){
   
 	if ($invset == 0) {
 		$j = 1;
 	} else {
 		$j = $invpos;
 	}
    $chqbal = $a_chq_amt[$i];
    $chqval = $a_chq_amt[$i];
 
 	while (($j < $_GET["mcount"]) and ($chqbal > 0)){
 
 		$chq_pay="chq_pay".$j;
		$chq_balance="chq_balance".$j;
		$invno="invno".$j;
		$delidate="delidate".$j;
		$invval="invval".$j;
		
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
				$days = floor($diff / (60*60*24));
			
				$col2=str_replace(",", "", $_GET[$invval]);
				
   				$sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, invval, c1, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$invset.", ".$days.", ".$col2.", 0, '".$_SESSION["tmp_no_cashrec"]."')"; 
			//echo $sql1." 1 /";
				$result =$db->RunQuery($sql1);
               
            } else {
                if ($invset > 0) { $invset = $invset - $chqbal; }
               
				$date1 = $_GET[$delidate];
				$date2 = $a_chq_date[$i];
				$diff = abs(strtotime($date2) - strtotime($date1));
				$days = floor($diff / (60*60*24));
				
				$col2=str_replace(",", "", $_GET[$invval]);
				
				$sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, invval, c1, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$chqbal.", ".$days.", ".$col2.", 0, '".$_SESSION["tmp_no_cashrec"]."')"; 
			//echo $sql1." 2 /";
				$result =$db->RunQuery($sql1);
            
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

while ($_GET["mcount"]>$ii){

	$cash_pay="cash_pay".$ii;
	$invno="invno".$ii;
	$delidate="delidate".$ii;
	$invval="invval".$ii;
	
  if ($_GET[$cash_pay] != "") {
     
	
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
				
				
		$col2=str_replace(",", "", $_GET[$invval]);		 	
	$sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, invval, c1, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', 'Cash', '".$chqdate."', '".$a_chq_bank[$i]."', ".$_GET[$cash_pay].", ".$days.", ".$col2.", 0, '".$_SESSION["tmp_no_cashrec"]."')"; 
			//echo $sql1." 3 /";
	$result =$db->RunQuery($sql1);
     $K = $K + 1;
  }
$ii = $ii + 1;
}

		$invno_0=array();
		$invdate_1=array();
		$chqno_2=array();
		$chqdate_3=array();
		$settled_4=array();
		$days_5=array();
	
	
		$r=1;	
		$sql="select * from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'"; 
		//echo $sql;
		$result =$db->RunQuery($sql);	
		while ($row = mysql_fetch_array($result)){
			$id[$r]=$row["id"];	
			$invno_0[$r]=$row["invno"];	
			$invdate_1[$r]=$row["invdate"];	
			$chqno_2[$r]=$row["chqno"];	
			$chqdate_3[$r]=$row["chqdate"];	
			$settled_4[$r]=$row["settled"];	
			$days_5[$r]=$row["days"];	
			$c1_6[$r]=$row["c1"];
			$r=$r+1;
		}
		

$S = 1;
while ($_GET["mcount"]>$S){
$H = 10;
 while ($H != 0){
 
   $invno="invno".$S;
   $cash_pay="cash_pay".$S;
   $inv_balance="inv_balance".$S;
   
  if ($_GET[$invno] == $invno_0[$H]) {
    if ($invno_0[$H+1] == $invno_0[$H]) {
        if (trim($chqno_2[$H]) != "Cash") {
            $c1_6[$H] = $c1_6[$H+1] + $settled_4[$H+1]  - $_GET[$cash_pay];
        } else {
            $c1_6[$H] = $c1_6[$H+1] + $settled_4[$H+1];
        }
		
		$sql11="update tmp_utilization set c1=".$c1_6[$H]." where id=".$id[$H]; 
		$result1 =$db->RunQuery($sql11);
	
    } else {
       if (trim($chqno_2[$H]) != "Cash") {
        $c1_6[$H] = $_GET[$inv_balance] - $_GET[$cash_pay];
       } else {
        $c1_6[$H] = $_GET[$inv_balance];
       }
	   $sql11="update tmp_utilization set c1=".$c1_6[$H]." where id=".$id[$H]; 
	   $result1 =$db->RunQuery($sql11);
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
	}*/
	
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
	}*/


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
				
				$sql="select * from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
				$result =$db->RunQuery($sql);
				while ($row = mysql_fetch_array($result)){
					$ResponseXML .= "<tr>
					<td>".$row["invno"]."</td>
					<td>".$row["invdate"]."</td>
					<td>".$row["chqno"]."</td>
					<td>".$row["chqdate"]."</td>
					<td align=right>".number_format($row["settled"], 2, ".", ",")."</td>
					<td>".$row["days"]."</td>
					</tr>";
					
				}
						
				$ResponseXML .= "   </table>]]></uti_table>";
							
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;		
	
	
}



		if($_GET["Command"]=="new_rec")
		{
			
			include('connection.php');
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
			//rst.Open "Select * from dep_mas", DNACC.CNACC
//Me.txt_entno = CURRENT_COMPANY & "\" & Right(CURRENT_year, 2) & "\L\" & Trim(Right("0000" & rst!PAYCASH + 1, 4))


			
				$sql="Select * from dep_mas";
				$result=mysql_query($sql, $dbacc);
				$row = mysql_fetch_array($result);
			
  				$tmprecno="000000".$row["paycash"];
				$lenth=strlen($tmprecno);
				$recno=$_SESSION['company']."/".date("y")."/L/".substr($tmprecno, $lenth-7);
				$_SESSION["recno"]=$recno;
				
				$sql="Select * from tmpdep_mas";
				$result=mysql_query($sql, $dbacc);
				$row = mysql_fetch_array($result);
				$tmprecno="000000".$row["paycash"];
				$_SESSION["tmp_no_cashpayacc"]=$_SESSION['company']."/".date("y")."/L/".trim("ACC/THT/ ").substr($tmprecno, $lenth-7);
				
				$sql="update tmpdep_mas paycash=paycash+1";
				$result=mysql_query($sql, $dbacc);
				
				$sql="delete from tmp_cash_pay ";
				$result=mysql_query($sql, $dbacc);
			
			$ResponseXML .= "<recno><![CDATA[".$recno."]]></recno>";	
			
			
				
			$ResponseXML .= "</salesdetails>";

			$_SESSION["txt_stat"]="new";
			echo $ResponseXML;
			
		}
		
		
if($_GET["Command"]=="save_crec")
{
	include('connection.php');
	
	//$ResponseXML = "";
	//$ResponseXML .= "<salesdetails>";
	
	$sql="select * from  dep_mas";
	$result=mysql_query($sql, $dbacc);
	$row = mysql_fetch_array($result);
	if (($row["datefrom"]<=$_GET["Calendar1"]) and ($_GET["Calendar1"]<=$row["dateto"])){
	} else {
		exit("Out of Current Accounting Year");
	}
	
	mysql_query("START TRANSACTION", $dbacc);
	
	if ($_SESSION["txt_stat"] == "new") {
		
		$sql="Select * from dep_mas";
		$result=mysql_query($sql, $dbacc);
		$row = mysql_fetch_array($result);
			
  		$tmprecno="000000".$row["paycash"];
		$lenth=strlen($tmprecno);
		$recno=$_SESSION['company']."/".date("y")."/L/".trim("ACC/THT/ ").substr($tmprecno, $lenth-7);
		$_SESSION["recno"]=$recno;
			
	}		
			
	$macccode = $_GET["cmbBarer"];
				
	$sql="Delete   from paymas where refno = '" . trim($_GET["txt_entno"]) . "'";
	$result=mysql_query($sql, $dbacc);
	
	$sql="Delete   from cashpaytrn where refno = '" . trim($_GET["txt_entno"]) . "'";
	$result=mysql_query($sql, $dbacc);
     
	$sql_rst="Select * from ledger where l_refno = '" . trim($_GET["txt_entno"]) . "'";
	$result_rst=mysql_query($sql_rst, $dbacc);      
    while ($row_rst = mysql_fetch_array($result_rst)){
    	$m_amount = $row_rst["l_amount"];
        $m_account = $row_rst["l_code"];
        $m_flag1 = $row_rst["l_flag1"]; 
        
		$sql="Delete   from ledger where l_refno = '" . trim($_GET["txt_entno"]) . "'";
		$result=mysql_query($sql, $dbacc);         
    }            
       
   
    //..............................................................................
    $m_ok = "";
	$sql="Update dep_mas set paycash=paycash+1 where code= '" . $_SESSION['company'] . "'";
	//echo $sql;
	$result=mysql_query($sql, $dbacc);         
    
    if ($_GET["txt_entno"] == "") { $m_ok = "Jouirnal No Not Entered"; }
    if (($_GET["TXT_DEBTOT"] == "0") or ($_GET["TXT_DEBTOT"] == "")) { $m_ok = "ledger Entry Is Incomplete"; }

    
    
    if ($m_ok != "") { $ResponseXML = $m_ok;	 } 
    if ($m_ok == "") {
       //Dim mHead As String, mBarer As String, mAmount As Currency, mType As String, mNara As String
       if (trim($_GET["TXT_HEADING"]) != "") { $mHead = trim($_GET["TXT_HEADING"]); }
       if ($_GET["cmbBarer"] != "") { $mBarer = trim($_GET["cmbBarer"]); }
       
       if ($_GET["TXT_NARA"] != "") { $mNara = trim($_GET["TXT_NARA"]); }
       if (is_null($_GET["TXT_HEADING"])==false) { $mHead = trim($_GET["TXT_HEADING"]); }
       if (($_GET["TXT_DEBTOT"]) > 0) { $mAmount = $_GET["TXT_DEBTOT"]; }
       
	   $sql="Insert into paymas(refno, bdate, heading, barer, naration, amount, type, rights, comcode, cancel) Values ('" . trim($_GET["txt_entno"]) . "', '" . $_GET["Calendar1"] . "', '" . $mHead . "', '" . $mBarer . "', '" . $mNara . "', " . $mAmount . ", 'C', '" . $mUserWrite . "', '" . $_SESSION['company'] . "', '0')";
	   $result=mysql_query($sql, $dbacc);       
	
              
       if ($_GET["TXT_DEBTOT"] > 0) { $mAmount = $_GET["TXT_DEBTOT"]; }
       if (is_null(trim($_GET["TXT_HEADING"]))==false) { $mHead = trim($_GET["TXT_HEADING"]); }
       if (is_null(trim($_GET["TXT_NARA"]))==false) { $mNara = trim($_GET["TXT_NARA"]); }
       
	   $sql="Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, L_head, l_lmem, rights, comcode, l_flag2, l_yearfl, l_year) Values ('" . trim($_GET["txt_entno"]) . "', '" . $_GET["Calendar1"] . "', '" . $macccode . "', " . $mAmount . ", 'CAP', 'CRE', '" . $mHead . "', '" . $mNara . "', '" . $mUserWrite . "', '" . $_SESSION['company'] . "', '0', 0, ".date("Y").")";
	   $result=mysql_query($sql, $dbacc);      
	   
       $sql="select * from  tmp_cash_pay where tmp_no='".$_SESSION["tmp_no_cashpayacc"]."'";
	 
	   $result=mysql_query($sql, $dbacc);     
       while ($row = mysql_fetch_array($result)){
                 
            $m_acode = trim($row["accno"]);
            $m_ades = $row["accname"];
            $m_nara = $row["descript"];
            $m_amount = $row["amt"];
          
            if (($m_acode != "") and ($m_amount != 0)) {
             if (is_null(trim($m_nara))==false) { $mNara = trim($m_nara); }
			 
			 $sql1="Insert into cashpaytrn(refno, bdate, code, amount, flag, nara, rights, comcode, cancel) Values ('" . trim($_GET["txt_entno"]) . "', '" . $_GET["Calendar1"] . "', '" . trim($m_acode) . "', " . $m_amount . ", 'CRE', '" . $m_nara . "', '" . $mUserWrite . "', '" . $_SESSION['company'] . "','0')";
	   		 $result1=mysql_query($sql1, $dbacc);      
             
             
             if ($_GET["TXT_DEBTOT"] > 0) { $mAmount = $m_amount; }
             if (is_null(trim($_GET["TXT_HEADING"]))==false) { $mHead = trim($_GET["TXT_HEADING"]); }
             if (is_null(trim($m_nara))==false) { $mNara = trim($m_nara); }
             
			 $sql1="Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_head, l_lmem, rights, comcode, l_flag2, l_yearfl, l_year) Values ('" . trim($_GET["txt_entno"]) . "', '" . $_GET["Calendar1"] . "', '" . trim($m_acode) . "', " . $mAmount . ", 'CAP', 'DEB', '" . $mHead . "', '" . trim($m_nara) . "', '" . $mUserWrite . "', '" . $_SESSION['company'] . "', '0', 0, ".date("Y").")";
	   		 $result1=mysql_query($sql1, $dbacc);   
			 
            }
             
       }
       
       mysql_query("COMMIT", $dbacc);
      

      $m_pen = $_GET["txt_entno"];

  		$ResponseXML="Records are saved";

    }
    echo $ResponseXML;
	
			

}



if ($_GET["Command"]=="search_rec"){
	
	include_once("connection.php");
	
	$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"221\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ref No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Date</font></td>
							   <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cheque No</font></td>
							    <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Name</font></td>
								 <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Amount</font></td>
							   
   							</tr>";
                           $letters = $_GET['recno'];
						   $sql="select refno, bdate, cheno, name, amount  from paymas where type = 'C' and cancel!='1' and refno like  '$letters%' order by bdate limit 50";
						   
						   $result=mysql_query($sql, $dbacc);
						/*	if ($_GET["mfield"]=="recno"){
						   		$letters = $_GET['recno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
								//echo $a;
								$sql="select CA_REFNO, CA_DATE, CA_AMOUNT, cus_ref  from s_crec where DEPARTMENT != 'S' and CANCELL='0' and FLAG = 'REC-A' and CA_REFNO like  '$letters%'  ORDER BY CA_REFNO limit 50";
								$result=mysql_query($sql, $dbinv);
								
							} else if ($_GET["mstatus"]=="recdate"){
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
							}
							*/
													
						
							while($row = mysql_fetch_array($result)){
								$REF_NO = $row['CA_REFNO'];
								$stname = $_GET["mstatus"];
							$ResponseXML .= "<tr>               
                              <td onclick=\"recno('".$row['refno']."');\">".$row['refno']."</a></td>
                              <td onclick=\"recno('".$row['refno']."');\">".date("Y-m-d", strtotime($row["bdate"]))."</a></td>
							  <td onclick=\"recno('".$row['refno']."');\">".$row["cheno"]."</a></td>
							  <td onclick=\"recno('".$row['refno']."');\">".$row["name"]."</a></td>
                              <td onclick=\"recno('".$row['refno']."');\">".$row['amount']."</a></td></tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}


if ($_GET["Command"]=="search_bank"){
	
	include_once("connection.php");
	
	$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Bank Code</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Banl Name</font></td>
							  
                             
   							</tr>";
                           
						   
						   if ($_GET["mstatus"]=="cash_rec"){
						    if ($_GET["mfield"]=="bcode"){
						   		$letters = $_GET['bcode'];
						   		$sql = "SELECT * from bankmas where  bcode like  '$letters%'";
								$result=mysql_query($sql, $dbinv);
							 } else if ($_GET["mfield"]=="bank"){
							 	$letters = $_GET['bank'];
						   		$sql = "SELECT * from bankmas where  bname like  '$letters%'";
								$result=mysql_query($sql, $dbinv);
							 }	
						   } 
						   
						  						
						
							while($row = mysql_fetch_array($result)){
								
							$ResponseXML .= "<tr>
                           	    <td onclick=\"selbank('".$row["bcode"]."', '".$stname."');\">".$row["bcode"]."</a></td>
                              <td onclick=\"selbank('".$row["bcode"]."', '".$stname."');\">".$row["bname"]."</a></td>
				
							                           	
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}

if ($_GET["Command"]=="pass_selbank"){
	//header('Content-Type: text/xml'); 
	/*echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";*/

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	$sql="select * from bankmas where bcode='".$_GET["bcode"]."'";
	$result=mysql_query($sql, $dbinv);
	
	if ($row = mysql_fetch_array($result)){
		$ResponseXML .= "<bname><![CDATA[".$row["bname"]."]]></bname>";
	}
		
	
				$ResponseXML .= "</salesdetails>";

				echo $ResponseXML;
}
	

if ($_GET["Command"]=="pass_recno"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	
	
	//Call setGrid
	$sql_rst="Select * from paymas where refno ='" .$_GET["recno"]. "'";
	$result_rst=mysql_query($sql_rst, $dbacc);
	if($row_rst = mysql_fetch_array($result_rst)){	
		$ResponseXML .= "<txt_entno><![CDATA[".$_GET["recno"]."]]></txt_entno>";
		$ResponseXML .= "<Calendar1><![CDATA[".date("Y-m-d", strtotime($row_rst["bdate"]))."]]></Calendar1>";
		$ResponseXML .= "<TXT_HEADING><![CDATA[".$row_rst["heading"]."]]></TXT_HEADING>";
		$ResponseXML .= "<TXT_NARA><![CDATA[".$row_rst["naration"]."]]></TXT_NARA>";
		$ResponseXML .= "<txt_bea><![CDATA[".$row_rst["barer"]."]]></txt_bea>";
		  
		  $sql_rstcode = "Select * from lcodes where c_code='" . trim($row_rst["barer"]) . "'";
          $result_rstcode=mysql_query($sql_rstcode, $dbacc);
		  if($row_rstcode = mysql_fetch_array($result_rstcode)){	
		  	$ResponseXML .= "<cmbBarer><![CDATA[".$row_rstcode["c_name"]."]]></cmbBarer>";
          }
		   
		$ResponseXML .= "<lab_can><![CDATA[".$row_rst["cancel"]."]]></lab_can>";
		$_SESSION["tmp_no_cashpayacc"]=$row_rst["tmp_no"];
	}

        
      $TXT_DEBTOT=0;
      
	  	$sql="delete from tmp_cash_pay where tmp_no = '".$_SESSION["tmp_no_cashpayacc"]."'";
				//echo $sql;
				$result=mysql_query($sql, $dbacc);
		
        $sql_rst = "Select * from cashpaytrn where refno = '" . $_GET["recno"] . "'";
        $result_rst=mysql_query($sql_rst, $dbacc);
		while($row_rst = mysql_fetch_array($result_rst)){	
       		
			if (trim($row_rst["refno"])==$_GET["recno"]){

              $sql_rst1 = "Select * from lcodes where c_code = '" . trim($row_rst["code"]) . "'";
              $result_rst1=mysql_query($sql_rst1, $dbacc);
			  if($row_rst1 = mysql_fetch_array($result_rst1)){	
             	$m_acname = $row_rst1["c_name"];
              } else {
                 $m_acname = "";
              }
              
              if (is_null($row_rst["code"])==false) { $code = $row_rst["code"]; }
              
			  $nara = $row_rst["nara"];
              $amount = $row_rst["amount"];
              $TXT_DEBTOT = $TXT_DEBTOT + $row_rst["amount"];
           
             
				 
				 
              	$sql="insert into tmp_cash_pay(entno, accno, accname, descript, amt, tmp_no) values ('".$_GET["recno"]."', '".$code."', '".$m_acname."', '".$nara."', ".$amount.", '".$_SESSION["tmp_no_cashpayacc"]."')";
				//echo $sql;
				$result=mysql_query($sql, $dbacc);
           }
           
        }
		
		
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
				$i=1;
				
				$sql="select * from tmp_cash_pay where tmp_no='".$_SESSION["tmp_no_cashpayacc"]."' ";
				$result=mysql_query($sql, $dbacc);
				while ($row = mysql_fetch_array($result)){
					
					$accno="accno_acc".$i;
					$accname="accname_acc".$i;
					$descript="descript_acc".$i;
					$amt="amt_acc".$i;
					
					$ResponseXML .= "<tr>
					<td><input type=\"text\" name=\"".$accno."\" id=\"".$accno."\" onblur=\"set_acc('".$row["accno"]."', '".$i."');\" value=\"".$row["accno"]."\" /></td>
					<td><input type=\"text\" name=\"".$accname."\" id=\"".$accname."\" value=\"".$row["accname"]."\" /></td>
					<td><input type=\"text\" name=\"".$descript."\" id=\"".$descript."\" value=\"".$row["descript"]."\" />".$row["descript"]."</td>
					<td align=right><input type=\"text\" name=\"".$amt."\" id=\"".$amt."\" onblur=\"setamt_opr('".$i."');\" value=\"".number_format($row["amt"], 2, ".", "")."\" /></td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['accno']."  name=".$row['accno']." onClick=\"del_item('".$row['accno']."');\"></td></tr>";
					
					$totamt=$totamt+$row["amt"];
					
					$i=$i+1;
				}
						
				$ResponseXML .= "   </table>]]></chq_table>";
				$ResponseXML .= "<TXT_DEBTOT><![CDATA[".number_format($totamt, 2, ".", "")."]]></TXT_DEBTOT>";		
				
					
     
 //  If Val(TXT_DEBTOT) > 0 Then Call amoword_cal
 
   		$sql_rs = "Select * from  ledger where l_refno='" . $_GET["recno"].  "'  and l_flag1='CRE'";
        $result_rs=mysql_query($sql_rs, $dbacc);
		if($row_rs = mysql_fetch_array($result_rs)){		
			
			$sql_rs2 = "Select * from lcodes where c_code='" . $row_rs["l_code"] . "'";
        	$result_rs2=mysql_query($sql_rs2, $dbacc);
			if($row_rs2 = mysql_fetch_array($result_rs2)){	
			
			} else {
				exit("Your " . $row_rs["l_code"] . " Changed");
			}
		
  		}	

				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;		
   
	
		
}

if ($_GET["Command"]=="set_acc"){
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	
	$sql_rst="Select * from lcodes where c_code='" . trim($_GET["accno"]) . "'";
	$result_rst=mysql_query($sql_rst, $dbacc);
    if($row_rst = mysql_fetch_array($result_rst)){	
		
		$sql1="update tmp_cash_pay set accno='".trim($row_rst["c_code"])."', accname='".trim($row_rst["c_name"])."', descript='".trim($_GET["TXT_NARA"])."' where entno='".trim($_GET["txt_entno"])."' and accno='".$_GET["old_accno"]."'";
		$result1=mysql_query($sql1, $dbacc);
			
		$ResponseXML .= "<c_code><![CDATA[".$row_rst["c_code"]."]]></c_code>";
		$ResponseXML .= "<c_name><![CDATA[".$row_rst["c_name"]."]]></c_name>";
		$ResponseXML .= "<TXT_NARA><![CDATA[".trim($_GET["TXT_NARA"])."]]></TXT_NARA>";
		$ResponseXML .= "<i><![CDATA[".$_GET["i"]."]]></i>";
	}	
	$ResponseXML .= "</salesdetails>";
	echo $ResponseXML;
}


if ($_GET["Command"]=="delete_rec"){
	$ResponseXML = "";
	
	if ($_GET["Calendar1"]==date("Y-m-d")){
		
		 mysql_query("START TRANSACTION", $dbacc);
         
		 $sql="Update cashpaytrn set cancel='1' where refno='" . trim($_GET["txt_entno"]) . "'";
		 $result=mysql_query($sql, $dbacc);
		 
		 $sql="Update paymas set cancel='1' where refno = '" . trim($_GET["txt_entno"]) . "'";
		 $result=mysql_query($sql, $dbacc);
		 
		 $sql="Delete  from ledger where l_refno = '" . trim($_GET["txt_entno"]) . "'";
		 $result=mysql_query($sql, $dbacc);
		 
      
        mysql_query("START TRANSACTION", $dbacc);     
        
			
			
			$ResponseXML = " Canceled";
		
	} else {
		$ResponseXML = "Sorry Cant Cancel.... please check reciept date";
	}

	echo $ResponseXML;

}
?>