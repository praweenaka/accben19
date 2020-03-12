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


if($_GET["Command"]=="chkvat")
{
	$sql="Select vatno from bankentmas where code = '" . $_GET["txtacccode"] . "' order by vatno desc";
	$result=mysql_query($sql, $dbacc);
	if ($row = mysql_fetch_array($result)){
		echo trim($row["vatno"]);
	}
	
	
}



if($_GET["Command"]=="addchq_cash_rec")
{
		
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec
		
		//$sql="delete from tmp_bank_trans where tmp_no='".$_SESSION["tmp_no_banktrans"]."' and accno='".$_GET["accno"]."'";
		//$result=mysql_query($sql, $dbacc);
		

		$descript=str_replace("~", "&", $_GET["descript"]);
	 	$descript=str_replace("&nbsp;", " ", $descript);	 
		
		$sql="insert into tmp_bank_trans(entno, accno, accname, descript, amt, tmp_no) values ('".$_GET["txt_entno"]."', '".$_GET["accno"]."', '".$_GET["acc_name"]."', '".$descript."', '".$_GET["amt"]."', '".$_SESSION["tmp_no_banktrans"]."')";
		$result=mysql_query($sql, $dbacc);
			
			$totchq=0;
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"100\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"200\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"300\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
				$i=1;
				$sql="select * from tmp_bank_trans where tmp_no='".$_SESSION["tmp_no_banktrans"]."' ";
				$result=mysql_query($sql, $dbacc);
				while ($row = mysql_fetch_array($result)){
					$accno="accno_acc".$i;
					$accname="accname_acc".$i;
					$descript="descript_acc".$i;
					$amt="amt_acc".$i;
					
					$ResponseXML .= "<tr>
					<td><input type=\"text\" name=\"".$accno."\" id=\"".$accno."\" onblur=\"set_acc('".$row["accno"]."', '".$i."');\" value=\"".$row["accno"]."\" /></td>
					<td><input type=\"text\" name=\"".$accname."\" id=\"".$accname."\" value=\"".$row["accname"]."\" /></td>";
					$descript_txt=str_replace("~", "&", $row["descript"]);
					$ResponseXML .= "<td><input type=\"text\" name=\"".$descript."\" id=\"".$descript."\" value=\"".$row["descript"]."\" />".$descript_txt."</td>
					<td align=right><input type=\"text\" name=\"".$amt."\" id=\"".$amt."\" onblur=\"setamt_opr('".$i."');\" value=\"".number_format($row["amt"], 2, ".", "")."\" /></td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['accno']."  name=".$row['accno']." onClick=\"del_item('".$row['accno']."');\"></td></tr>";
					
					
					$totchq=$totchq+$row["amt"];
					$i=$i+1;
				}
						
				$ResponseXML .= "   </table>]]></chq_table>";
				$ResponseXML .= "<chqtot><![CDATA[". number_format($totchq, 2, ".", "") ."]]></chqtot>";	
			
				
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;			
}



if($_GET["Command"]=="del_item")
		{
		
			
			$sql="delete from tmp_bank_trans where tmp_no='".$_SESSION["tmp_no_banktrans"]."' and accno='".$_GET["accno"]."'";
		$result=mysql_query($sql, $dbacc);
		
		
			
			$totchq=0;
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
				$i=1;
				$sql="select * from tmp_bank_trans where tmp_no='".$_SESSION["tmp_no_banktrans"]."' ";
				$result=mysql_query($sql, $dbacc);
				while ($row = mysql_fetch_array($result)){
					$accno="accno_acc".$i;
					$accname="accname_acc".$i;
					$descript="descript_acc".$i;
					$amt="amt_acc".$i;
					
					$ResponseXML .= "<tr>
					<td><input type=\"text\" name=\"".$accno."\" id=\"".$accno."\" onblur=\"set_acc('".$row["accno"]."', '".$i."');\" value=\"".$row["accno"]."\" /></td>
					<td><input type=\"text\" name=\"".$accname."\" id=\"".$accname."\" value=\"".$row["accname"]."\" /></td>";
					$descript_txt=str_replace("~", "&", $row["descript"]);
					$ResponseXML .= "<td><input type=\"text\" name=\"".$descript."\" id=\"".$descript."\" value=\"".$row["descript"]."\" />".$descript_txt."</td>
					<td align=right><input type=\"text\" name=\"".$amt."\" id=\"".$amt."\" onblur=\"setamt_opr('".$i."');\" value=\"".number_format($row["amt"], 2, ".", "")."\" /></td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['accno']."  name=".$row['accno']." onClick=\"del_item('".$row['accno']."');\"></td></tr>";
					
					$i=$i+1;
					$totchq=$totchq+$row["amt"];
				}
						
				$ResponseXML .= "   </table>]]></chq_table>";
				$ResponseXML .= "<chqtot><![CDATA[".$totchq."]]></chqtot>";	
			
				
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
			
		
		
				$sql="select bankent from dep_mas";
				$result=mysql_query($sql, $dbacc);
				$row = mysql_fetch_array($result);
			
  				$tmprecno="000000".$row["bankent"];
				$lenth=strlen($tmprecno);
				$recno= $_SESSION['company'] . "/" . date("y") . "/P/" . substr($tmprecno, $lenth-7);
				$_SESSION["recno"]=$recno;
				
				$sql="select bankent from tmpdep_mas";
				$result=mysql_query($sql, $dbacc);
				$row = mysql_fetch_array($result);
				$_SESSION["tmp_no_banktrans"]=$_SESSION['company'] . "/" . date("y") . "/P/" . substr($tmprecno, $lenth-7);
				
				$sql="update tmpdep_mas set bankent=bankent+1";
				$result=mysql_query($sql, $dbacc);
				
				$sql="delete from  tmp_bank_trans where tmp_no='".$_SESSION["tmp_no_banktrans"]."'";
				$result=mysql_query($sql, $dbacc);
				
				
			$_SESSION["txt_stat"]= "new";
			
		

			echo $recno;
			
		}
		
		

if($_GET["Command"]=="edit_rec")
{
	
	$_SESSION["txt_stat"]="edit";
}		
		
if($_GET["Command"]=="save_crec")
{
	include('connection.php');
	
	$sql="select * from  dep_mas";
	$result=mysql_query($sql, $dbacc);
	$row = mysql_fetch_array($result);
	if (($row["datefrom"]<=$_GET["dtpDate"]) and ($_GET["dtpDate"]<=$row["dateto"])){
	} else {
		exit("Out of Current Accounting Year");
	}
	
	
	$sql="Select * from lock_table";
	$result=mysql_query($sql, $dbacc);
	$row = mysql_fetch_array($result);
	if ($row["lock_date"]>=$_GET["dtpDate"]){
		exit("Can't EDIT. This Transaction id Locked!!!");
	}
	
	
	/*$sql="Select * from lock_bank_rec where bank_code='".$_GET["txtacccode"]."'";
	$result=mysql_query($sql, $dbacc);
	$row = mysql_fetch_array($result);
	if ($row["lock_date_to"]>=$_GET["dtpDate"]){
		exit("Can't Add NEW Transaction. Reconciliation is Completed!!!");
	}*/
			
		 	if ($_SESSION["txt_stat"] == "new") {
	 			$sql="select bankent from dep_mas";
				$result=mysql_query($sql, $dbacc);
				$row = mysql_fetch_array($result);
			
  				$tmprecno="000000".$row["bankent"];
				$lenth=strlen($tmprecno);
				$txt_entno= $_SESSION['company'] . "/" . date("y") . "/P/" . substr($tmprecno, $lenth-7);
				
				$sql_rec="select * from ledger where l_refno='" . trim($txt_entno) . "'";
				$result_rec=mysql_query($sql_rec, $dbacc);
	    		if($row_rec = mysql_fetch_array($result_rec)){
					exit("Entry No is Already Exist !!!");
				}
			
			}	else {
				$txt_entno=$_GET["txt_entno"];
			}
	
	
	$sql1="Select * from lock_bank_rec where bank_code='".$_GET["txtacccode"]."'";
	//echo $sql1;
	$result1=mysql_query($sql1, $dbacc);
	$row1 = mysql_fetch_array($result1);
	//echo $row1["lock_date_to"]."/";
	//echo $_GET["dtpDate"];
	if (strtotime($row1["lock_date_to"])>=strtotime($_GET["dtpDate"])){
			
		$sql_p="Select * from ledger where l_refno='".$_GET["txt_entno"]."'";
		//echo $sql_p;
		$result_p=mysql_query($sql_p, $dbacc);
		if ($row_p = mysql_fetch_array($result_p)){
		
			if (strtotime($row_p["l_date"])>strtotime($row1["lock_date_to"])){
				exit("Can't EDIT Date. Reconciliation is Completed!!!");
			}
		}
		
	} else {
		$sql_p="Select * from ledger where l_refno='".$_GET["txt_entno"]."'";
		//echo $sql_p;
		$result_p=mysql_query($sql_p, $dbacc);
		if ($row_p = mysql_fetch_array($result_p)){
			if (strtotime($row_p["l_date"])<=strtotime($row1["lock_date_to"])){
				exit("Can't EDIT Date. Reconciliation is Completed!!!");
			}
		}
	}
	
				
   $mCode = $_GET["txtacccode"];
   $mName = $_GET["com_bank"];
   
   
   $mName = "";
   
  	
		$l_month="";
		$recdate="";
		
		$sql_rec="select * from ledger where l_refno='" . trim($txt_entno) . "'";
		$result_rec=mysql_query($sql_rec, $dbacc);
	    while($row_rec = mysql_fetch_array($result_rec)){
			
	   		if (($l_month=="") and (is_null($row_rec["l_month"])==false) and ($row_rec["l_month"]!="0")){
				$l_month=$row_rec["l_month"];
				$recdate=$row_rec["recdate"];
				
			}	
	    }
		
  
    $m_ok = "";
    
      
    $sql_rsBANKMASTER = "Select * from bankmaster where bm_code = '" . $mCode . "'";
	$result_rsBANKMASTER=mysql_query($sql_rsBANKMASTER, $dbacc);
	if ($row_rsBANKMASTER = mysql_fetch_array($result_rsBANKMASTER)){
		$bnkName = trim($row_rsBANKMASTER["bm_bank"]);
	} else {
		 $m_ok = "Invalid Bank Please Select the Bank";
	}
    
    
    if (($txt_entno) == "") { $m_ok = "Reference No Not Entered"; }
    if ($_GET["TXT_DEBTOT"] == 0) { $m_ok = "Entry Is Incomplete"; }
    
    if ($m_ok != "") { exit($m_ok); }
    
	
	 $sql_rspaymas="Select sum(l_amount) as tot_l_amount from ledger where l_refno='" . trim($txt_entno) . "' and lock1='1' and l_code='".$_GET["txtacccode"]."'";
	//echo $sql_rspaymas;
	$result_rspaymas=mysql_query($sql_rspaymas, $dbacc);
	$row_rspaymas = mysql_fetch_array($result_rspaymas);
	if ($row_rspaymas["tot_l_amount"]>0){
	   if ($_GET["TXT_DEBTOT"] != $row_rspaymas["tot_l_amount"]) {
          exit ("Sorry You Have Changed The Cheque Value");
       }
      
	} 
	
	$sql_rspaymas="Select * from ledger where l_refno='" . trim($txt_entno) . "' and lock1='1' and l_code='".$_GET["txtacccode"]."'";
	//echo $sql_rspaymas;
	$result_rspaymas=mysql_query($sql_rspaymas, $dbacc);
	if($row_rspaymas = mysql_fetch_array($result_rspaymas)){
	   if ($_GET["dtpDate"] != $row_rspaymas["l_date"])  {
          exit ("Sorry You Have Changed The Date");
       }
      
	} 
	
	
	mysql_query("START TRANSACTION", $dbacc);
   
   $sql_rsbankentmas="Select * from bankentmas where refno = '" . trim($_GET["txt_entno"]) . "'";
   $result_rsbankentmas=mysql_query($sql_rsbankentmas, $dbacc);
   if ($row_rsbankentmas = mysql_fetch_array($result_rsbankentmas)){
   } else {
   		$sql="update dep_mas set bankent=bankent+1 where code='" . $_SESSION['company'] . "'";
   		$result=mysql_query($sql, $dbacc);
   }
  
   $sql="Delete   from bankentmas where refno = '" . trim($txt_entno) . "'";
   $result=mysql_query($sql, $dbacc);
   
   $sql="Delete   from bankenttrn where refno = '" . trim($txt_entno) . "'";
   $result=mysql_query($sql, $dbacc);
		
    
	$sql_rst = "Select * from ledger where l_refno = '" . trim($txt_entno) . "'";
	$result_rst=mysql_query($sql_rst, $dbacc);
	while ($row_rst = mysql_fetch_array($result_rst)){
   
        if (trim($row_rst["l_refno"]) == trim($txt_entno)) {
            $mAmount = $row_rst["l_amount"];
           
            $mFlag1 = $row_rst["l_flag1"];
            
			$sql = "Delete  from  ledger where l_refno = '" . trim($txt_entno) . "'";
			$result=mysql_query($sql, $dbacc);
        }
        
    }
	
	
	
	 $TXT_DETAIL=str_replace("~", "&", $_GET["TXT_HEADING"]);
	 $TXT_DETAIL=str_replace("&nbsp;", " ", $TXT_DETAIL);	 
	
	
    if (trim($_GET["TXT_HEADING"]) != "") { $mHead = trim($TXT_DETAIL); }
    
	
	
   
    if ($_GET["TXT_DEBTOT"] > 0) { $mAmount = $_GET["TXT_DEBTOT"]; }
       
	   	$sql_tmp = "Select * from tmp_bank_trans where tmp_no = '" . $_SESSION["tmp_no_banktrans"] . "'";
		$result_tmp=mysql_query($sql_tmp, $dbacc);
		if ($row_tmp = mysql_fetch_array($result_tmp)){
	
       		$dCode =$row_tmp["accno"];
			
		}	
                 
       if ($_GET["Option1"] == "true") {
          $mFlag1 = "DEB";
       } else {
          $mFlag1 = "CRE";
       }
	   
	   	$sql_tmp = "Insert into bankentmas(refno, bdate, heading, code, name, amount, type, comcode, invno, vatno, inv_date, bea1, tmp_no, cancel) Values ('" . trim($txt_entno) . "', '" . $_GET["dtpDate"] . "', '" . $TXT_DETAIL . "', '" . trim($mCode) . "', '" . trim($_GET["com_bank"]) . "', '" . $mAmount . "', '" . $mFlag1 . "', '" . $_SESSION['company'] . "', '" . $_GET["txtINVNO"] . "', '" . trim($_GET["txtVATNO"]) . "', '" . $_GET["DTinv_date"] . "', '" . $_GET["txtbea1"] . "', '".$_SESSION["tmp_no_banktrans"]."', '0')";
		
		$result_tmp=mysql_query($sql_tmp, $dbacc);
		if ($result_tmp==false){ exit("Transaction NOT Saved !!!"); }
	
       
       if (is_null(trim($_GET["TXT_HEADING"]))==false) { $mHead = trim($TXT_DETAIL); }
       
       if ($_GET["Option1"]=="true") {
	   
	   		// $l_lmem= $TXT_DETAIL . " De. " . $dCode . " - Ch/No. " . $_GET["txtchno"];
			 $l_lmem= $TXT_DETAIL ;
			 
			 
	   		$sql_tmp = "Insert into ledger (l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_head, l_lmem, rights, comcode, chno, l_flag3, l_month, recdate, user, ent_datetime) Values  ('" . trim($txt_entno) . "', '" . $_GET["dtpDate"] . "', '" . trim($mCode) . "', " . $mAmount . ", 'RTN', '" . $mFlag1 . "', '" . $TXT_DETAIL . "', '" .$l_lmem. "', '" . $mUserWrite . "', '" . $_SESSION['company'] . "', '" . trim($_GET["txtchno"]) . "', 'R', '".$l_month."', '".$recdate."', '".$_SESSION['UserName']."', '".date("Y-m-d H:i:s")."')";
			//echo "1".$sql_tmp;
			$result_tmp=mysql_query($sql_tmp, $dbacc);
			if ($result_tmp==false){ exit("Transaction NOT Saved !!!"); }
           
        } else {
			
			 $l_lmem= $TXT_DETAIL ;
			 
			$sql_tmp = "Insert into ledger (l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_head, l_lmem, rights, comcode, chno, l_flag3, l_month, recdate, user, ent_datetime) Values  ('" . trim($txt_entno) . "', '" . $_GET["dtpDate"] . "', '" . trim($mCode) . "', " . $mAmount . ", 'BEN', '" . $mFlag1 . "', '" . $TXT_DETAIL . "', '" . $l_lmem . "', '" . $mUserWrite . "', '" . $_SESSION['company'] . "', '" . trim($_GET["txtchno"]) . "', 'R', '".$l_month."', '".$recdate."', '".$_SESSION['UserName']."', '".date("Y-m-d H:i:s")."')";
			//echo "2".$sql_tmp;
			$result_tmp=mysql_query($sql_tmp, $dbacc);
			if ($result_tmp==false){ exit("Transaction NOT Saved !!!"); }
			
       }
       
       $sql_tmp = "Select * from tmp_bank_trans where tmp_no = '" . $_SESSION["tmp_no_banktrans"]. "'";
	  
	   $result_tmp=mysql_query($sql_tmp, $dbacc);
	   while ($row_tmp = mysql_fetch_array($result_tmp)){
       
          $mCode = $row_tmp["accno"];
          $mName = $row_tmp["accname"];
         // $mNara = $row_tmp["descript"];
          $mAmount = $row_tmp["amt"];
          
		  $mNara=str_replace("~", "&", $row_tmp["descript"]);
	 	  $mNara=str_replace("&nbsp;", " ", $mNara);	 
		  $mNara=str_replace("'", "''", $mNara);	
				
          if (($mCode != "") and ($mAmount != 0)) {
		  
		  	$sql_tmp1 = "Insert into bankenttrn(refno, bdate, code, amount, nara, comcode) Values ('" . trim($txt_entno) . "', '" . $_GET["dtpDate"] . "', '" . trim($mCode) . "', " . $mAmount . ", '" . trim($mNara) . "', '" . $_SESSION['company'] . "')";
			$result_tmp1=mysql_query($sql_tmp1, $dbacc);
			
			if ($result_tmp1==false){ exit("Transaction NOT Saved !!!"); }
            
               
          
            if ($_GET["Option1"] == "true") {
               $mFlag1 = "CRE";
            } else {
               $mFlag1 = "DEB";
            }
            if (is_null(trim($_GET["TXT_HEADING"]))=="false") { $mNara = trim($TXT_DETAIL); }
            if (is_null(trim($_GET["TXT_HEADING"]))=="false") { $mHead = trim($TXT_DETAIL); }
            if ($_GET["Option1"]=="true") {
				
				$sql_tmp1 = "Insert into ledger (l_refno, l_date, l_code, l_flag, l_amount, l_flag1, l_flag2, l_flag3, l_lmem,  l_bank, rights, comcode, chno, l_month, recdate) Values ('" . trim($txt_entno) . "', '" . $_GET["dtpDate"] . "', '" . trim($mCode) . "', 'RTN', " . $mAmount . ", '" . $mFlag1 . "', '0', 'R', '" . trim($mNara) . "', '" . trim($_GET["txtBankCode"]) . "', '" . $mUserWrite . "', '" . $_SESSION['company'] . "', '" . trim($_GET["txtchno"]) . "', '".$l_month."', '".$recdate."')";
				//echo "3".$sql_tmp1;
				$result_tmp1=mysql_query($sql_tmp1, $dbacc);
				if ($result_tmp1==false){ exit("Transaction NOT Saved !!!"); }
				
              
            } else {
				
				$sql_tmp1 = "Insert into ledger (l_refno, l_date, l_code, l_flag, l_amount, l_flag1, l_flag2, l_flag3, l_lmem,  l_bank, rights, comcode, chno, l_month, recdate) Values ('" . trim($txt_entno) . "', '" . $_GET["dtpDate"] . "', '" . trim($mCode) . "', 'BEN', " . $mAmount . ", '" . $mFlag1 . "', '0', 'R', '" . trim($mNara) . "',  '" . trim($_GET["txtBankCode"]) . "', '" . $mUserWrite . "', '" . $_SESSION['company'] . "','" . trim($_GET["txtchno"]) . "', '".$l_month."', '".$recdate."')";
				//echo "4".$sql_tmp1;
				$result_tmp1=mysql_query($sql_tmp1, $dbacc);
				if ($result_tmp1==false){ exit("Transaction NOT Saved !!!"); }
				
              
            }
            
          }
          
      }
      


  	mysql_query("COMMIT", $dbacc);
            
			$_SESSION["txt_stat"]= "";
	$m_ok="Saved";
	
	echo $m_ok;

	
//Call CRPRINT
//Call cmdNew_Click
}



if ($_GET["Command"]=="search_rec"){
	
	include_once("connection.php");
	
	$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ref No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Date</font></td>
							   <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Amount</font></td>
							   
                             
   							</tr>";
                           
						   $letters = $_GET['recno'];
						   $sql="select *  from bankentmas where cancel!='1' and refno like  '$letters%'  ORDER BY bdate desc limit 50";
						   $result=mysql_query($sql, $dbacc);
						   
						/*	if ($_GET["mfield"]=="recno"){
						   		
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
	$sql_rscrec="Select * from bankentmas where refno = '" .$_GET["recno"]. "'";
	$result_rscrec=mysql_query($sql_rscrec, $dbacc);
	if($row_rscrec = mysql_fetch_array($result_rscrec)){
		
		$_SESSION["tmp_no_banktrans"]=$row_rscrec["tmp_no"];
		
		$ResponseXML .= "<refno><![CDATA[".$row_rscrec["refno"]."]]></refno>";
		$ResponseXML .= "<bdate><![CDATA[".date("Y-m-d", strtotime($row_rscrec["bdate"]))."]]></bdate>";
		$ResponseXML .= "<heading><![CDATA[".$row_rscrec["heading"]."]]></heading>";
		$ResponseXML .= "<code><![CDATA[".$row_rscrec["code"]."]]></code>";
		$ResponseXML .= "<name><![CDATA[".$row_rscrec["name"]."]]></name>";
		$ResponseXML .= "<invno><![CDATA[".$row_rscrec["invno"]."]]></invno>";
		$ResponseXML .= "<vatno><![CDATA[".$row_rscrec["vatno"]."]]></vatno>";
		if ($row_rscrec["inv_date"]=="0000-00-00 00:00:00"){
			$ResponseXML .= "<inv_date><![CDATA[]]></inv_date>";
		} else {
			$ResponseXML .= "<inv_date><![CDATA[".$row_rscrec["inv_date"]."]]></inv_date>";
		}	
		$ResponseXML .= "<bea1><![CDATA[".$row_rscrec["bea1"]."]]></bea1>";
		
		if ($row_rscrec["cancel"]=='1'){
			$ResponseXML .= "<cancel><![CDATA[Cancel]]></cancel>";
		} else {
			$ResponseXML .= "<cancel><![CDATA[]]></cancel>";
		}
		
	}
	
	
	$sql1="delete from tmp_bank_trans where  tmp_no = '".$_SESSION["tmp_no_banktrans"]."'";
	$result1=mysql_query($sql1, $dbacc);
		
	$sql="Select * from bankenttrn where refno = '" .$_GET["recno"]. "' ";
	$result=mysql_query($sql, $dbacc);
	while ($row = mysql_fetch_array($result)){
		
		
		$sql_lcode="Select * from lcodes where c_code = '" . $row["code"]. "' ";
		$result_lcode=mysql_query($sql_lcode, $dbacc);
		$row_lcode = mysql_fetch_array($result_lcode);
	
		
		$mNara=str_replace("~", "&", $row["nara"]);
	 	$mNara=str_replace("&nbsp;", " ", $mNara);	
		$mNara=str_replace("'", "''", $mNara); 
				
		$sql1="insert into tmp_bank_trans(entno, accno, accname, descript, amt, tmp_no) values ('".$_GET["recno"]."', '".$row["code"]."', '".$row_lcode["c_name"]."', '".$mNara."', '".$row["amount"]."', '".$_SESSION["tmp_no_banktrans"]."')";
		//echo $sql1;
		$result1=mysql_query($sql1, $dbacc);
	
	}
			
			$totchq=0;
			
			$i=1;
			
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"100\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"200\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"300\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				$i=1;
				$sql="select * from tmp_bank_trans where tmp_no='".$_SESSION["tmp_no_banktrans"]."' ";
				$result=mysql_query($sql, $dbacc);
				while ($row = mysql_fetch_array($result)){
					
					
					
					$accno="accno_acc".$i;
					$accname="accname_acc".$i;
					$descript="descript_acc".$i;
					$amt="amt_acc".$i;
					
					$ResponseXML .= "<tr>
					<td><input type=\"text\" name=\"".$accno."\" id=\"".$accno."\" onblur=\"set_acc('".$row["accno"]."', '".$i."');\" value=\"".$row["accno"]."\" /></td>
					<td><input type=\"text\" name=\"".$accname."\" id=\"".$accname."\" value=\"".$row["accname"]."\" /></td>";
					$descript_txt=str_replace("~", "&", $row["descript"]);
					$ResponseXML .= "<td><input type=\"text\" name=\"".$descript."\" id=\"".$descript."\" value=\"".$row["descript"]."\" />".$descript_txt."</td>
					<td align=right><input type=\"text\" name=\"".$amt."\" id=\"".$amt."\" onblur=\"setamt_opr('".$i."');\" value=\"".number_format($row["amt"], 2, ".", "")."\" /></td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['accno']."  name=".$row['accno']." onClick=\"del_item('".$row['accno']."');\"></td></tr>";
					
					$i=$i+1;
					$totchq=$totchq+$row["amt"];
				}
						
				$ResponseXML .= "   </table>]]></chq_table>";
				$ResponseXML .= "<chqtot><![CDATA[".$totchq."]]></chqtot>";	
			
	
	

	
		$ResponseXML .= "</salesdetails>";

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
		
		$sql1="update tmp_bank_trans set accno='".trim($row_rst["c_code"])."', accname='".trim($row_rst["c_name"])."', descript='".trim($_GET["TXT_NARA"])."' where entno='".trim($_GET["txt_entno"])."' and accno='".$_GET["old_accno"]."'";
		$result1=mysql_query($sql1, $dbacc);
			
		$ResponseXML .= "<c_code><![CDATA[".$row_rst["c_code"]."]]></c_code>";
		$ResponseXML .= "<c_name><![CDATA[".$row_rst["c_name"]."]]></c_name>";
		$ResponseXML .= "<TXT_NARA><![CDATA[".trim($_GET["TXT_NARA"])."]]></TXT_NARA>";
		$ResponseXML .= "<i><![CDATA[".$_GET["i"]."]]></i>";
	}	
	$ResponseXML .= "</salesdetails>";
	echo $ResponseXML;
}


if($_GET["Command"]=="setamt")
{
	$amt=str_replace(",", "", $_GET["amt"]);
	$sql="update tmp_bank_trans set amt=".$amt." where  entno='".$_GET["txt_entno"]."' and accno='".$_GET["accno"]."' and tmp_no= '".$_SESSION["tmp_no_banktrans"]."'";
	//echo $sql;	
		$result=mysql_query($sql, $dbacc); 
		
		$sql="select sum(amt) as totsum from tmp_bank_trans where  entno='".$_GET["txt_entno"]."' and tmp_no= '".$_SESSION["tmp_no_banktrans"]."'";
	//	echo $sql;
		
		$result=mysql_query($sql, $dbacc);
		$row = mysql_fetch_array($result);
		echo $row["totsum"];
}

if ($_GET["Command"]=="delete_rec"){
	$ResponseXML = "";
	
	//if ($_GET["invdate"]==date("Y-m-d")){
		
	
	
	$sql="Select * from lock_table";
	$result=mysql_query($sql, $dbacc);
	$row = mysql_fetch_array($result);
	if ($row["lock_date"]>=$_GET["dtpDate"]){
		exit("Can't EDIT. This Transaction id Locked!!!");
	}
	
	
	$sql="Select * from lock_bank_rec where bank_code='".$_GET["txtacccode"]."'";
	$result=mysql_query($sql, $dbacc);
	$row = mysql_fetch_array($result);
	if ($row["lock_date_to"]>=$_GET["dtpDate"]){
		exit("Can't Add NEW Transaction. Reconciliation is Completed!!!");
	}
	
		
		 mysql_query("START TRANSACTION", $dbacc);
         
		 $sql="Update bankentmas set cancel='1' where refno = '" . trim($_GET["txt_entno"]) . "'";
		 $result=mysql_query($sql, $dbacc);
		 
		 $sql="Delete  from ledger where l_refno = '" . trim($_GET["txt_entno"]) . "'";
		 $result=mysql_query($sql, $dbacc);
		 
		
	
		 mysql_query("COMMIT", $dbacc);
        
         //echo "Reciept Canceled";
         //Call cmdNew_Click
			
			
			$ResponseXML = "Entry Canceled";
		
//	} else {
//		$ResponseXML = "Sorry Cant Cancel.... please check reciept date";
//	}

	echo $ResponseXML;

}
?>