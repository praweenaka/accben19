<?php 
session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		 date_default_timezone_set('Asia/Colombo'); 
	
	/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
	
		
				
	///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////
		
		
				
		if($_GET["Command"]=="new_crn")
		{
			
			
		/*	$sql="Select CAS_INV_NO_m from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
			
			$sql="Select CRN from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CRN"];
			$lenth=strlen($tmpinvno);
			$crn=trim("CRN/ ").substr($tmpinvno, $lenth-7);
			$_SESSION["crn"]=$crn;
			
		//	$sql1="delete from tmp_ord_data where str_invno='".$invno."'";
		//	$result1 =$db->RunQuery($sql1);
			
			echo $crn;	
			
		}
		
		
		if($_GET["Command"]=="add_address")
		{
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;
			
			
	/*		$sql="Select * from tmp_army_no where edu= '".$_GET['edu']."'";
			$result =$db->RunQuery($sql);
			if($row = mysql_fetch_array($result)){
				$ResponseXML .= "exist";
				
				
				
			}	else {*/
			
		//	$ResponseXML .= "";
			//$ResponseXML .= "<ArmyDetails>";
			
		/*	$sql1="Select * from mas_educational_qualifications where str_Educational_Qualification= '".$_GET['edu']."'";
			$result1 =$db->RunQuery($sql1);
			$row1 = mysql_fetch_array($result1);
			$ResponseXML .=  $row1["int_Educational_Qulifications"];*/
			
			$sqlt="Select * from customer_mast where id ='".$_GET['customerid']."'";
			
			$resultt =$db->RunQuery($sqlt);
			if ($rowt = mysql_fetch_array($resultt)){
				echo $rowt["str_address"];
			}
			
			
				
			
	}

	
	if($_GET["Command"]=="setord")
	{
		
		include_once("connection.php");
		
		$len=strlen($_GET["salesord1"]);
		$need=substr($_GET["salesord1"],$len-7, $len);
		$salesord1=trim("ORD/ ").$_GET["salesrep"].trim(" / ").$need;
		
		
		$_SESSION["custno"]=$_GET['custno'];
		$_SESSION["brand"]=$_GET["brand"];
	
	$sql = mysql_query("DROP VIEW view_s_salma") or die(mysql_error());
					$sql = mysql_query("CREATE VIEW view_s_salma
AS
SELECT     s_salma.*, brand_mas.class AS class
FROM         brand_mas RIGHT OUTER JOIN
                      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysql_error());
					  
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				$cuscode=$_GET["custno"];	
				
					
					$ResponseXML .= "<salesord><![CDATA[".$salesord1."]]></salesord>";
				
					
				$cuscode=$_GET["custno"];	
				$sql = mysql_query("Select * from vendor where CODE='".$cuscode."'") or die(mysql_error());
				if($row = mysql_fetch_array($sql)){
					
					$OldRefno = "";
					$NewRefNo = "";
					$sql1 = mysql_query("SELECT  * From REF_HISTORY WHERE NewRefNo = '".$_GET["salesrep"]."'") or die(mysql_error());
					if($row1 = mysql_fetch_array($sql1)){
						$OldRefno = trim($row1["OldRefno"]);
    					$NewRefNo = trim($row1["NewRefNo"]);	
					}
					
					$OutpDAMT = 0;
					$OutREtAmt = 0;
					$OutInvAmt = 0;
					

		
					$sql1 = mysql_query("select * from brand_mas where barnd_name='".trim($_GET["brand"])."'") or die(mysql_error());
					
					if($row1 = mysql_fetch_array($sql1)){
						if (is_null($row1["class"])==false){ $InvClass = trim($row1["class"]); }
					}
					
		//////// Total Invoice Amount ///////////////////////////////////////////////////////////////	/						
				if ($NewRefNo==$_GET["salesrep"]){
					$sqlview = mysql_query("select sum(grand_tot-totpay) as totout from view_s_salma where ACCNAME <> 'NON STOCK' and grand_tot>totpay and cancell='0' and c_code='".trim($cuscode)."' and (sal_ex='".$OldRefno."' or sal_ex='".trim($_GET["salesrep"])."' and class='".$InvClass."'") or die(mysql_error());
				} else {
					$sqlview = mysql_query("select sum(grand_tot-totpay) as totout from view_s_salma where ACCNAME <> 'NON STOCK' and grand_tot>totpay and cancell='0' and c_code='".trim($cuscode)."' and sal_ex='".trim($_GET["salesrep"])."' and class='".$InvClass."'") or die(mysql_error());
				}
				
					$rowview = mysql_fetch_array($sqlview);
						if (is_null($rowview["totout"])==false) { $OutInvAmt = $rowview["totout"]; }


////////// PD Cheques ////////////////////////////////////////////////////////////////////////////
				if ($NewRefNo==$_GET["salesrep"]){
				
					$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("Y-m-d")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and (sal_ex='".$OldRefno."' or sal_ex='".trim($_GET["salesrep"])."'") or die(mysql_error());
				} else {	
					
					$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("Y-m-d")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($_GET["salesrep"])."'") or die(mysql_error());
				}
				while($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
				
					$sqlstr = mysql_query("select * from s_sttr where ST_REFNO='".trim($rowinvcheq["refno"])."' and ST_CHNO ='".trim($rowinvcheq["cheque_no"])."'") or die(mysql_error());
						
						while($rowstr = mysql_fetch_array($sqlstr)){
							echo "select class from view_s_salma where Accname <> 'NON STOCK' and REF_NO='".trim($rowstr["ST_INVONO"])."' ";
						  	$sqltmp = mysql_query("select class from view_s_salma where Accname <> 'NON STOCK' and REF_NO='".trim($rowstr["ST_INVONO"])."' ") or die(mysql_error());
                    		if($rowstmp = mysql_fetch_array($sqltmp)){
								//echo $rowstmp["class"];
                    			if (trim($rowstmp["class"] == $InvClass)) {
                   			 		$OutpDAMT = $OutpDAMT + $rowstr["ST_PAID"];
								}
               			     }
                		}
     				}	
	 
////////////  Return Settlement PD Cheques////////////////////////////////////////////////////////	 
	 	 $pend_ret_set = 0;
		 $sqlview = mysql_query("SELECT sum(che_amount) as  che_amount FROM S_INVCHeQ WHERE CHE_DATE >'".date("Y-m-d")."' AND CUS_CODE='".trim($cuscode)."' and trn_type='RET'") or die(mysql_error());
          $rowsview = mysql_fetch_array($sqlview);
			if( is_null($rowsview["che_amount"])==false){ $pend_ret_set = $rowsview["che_amount"]; }
							

//////////// Reurn Cheques////////////////////////////////////// //   /////////////////////////////////
	 	if ($NewRefNo==$_GET["salesrep"]){
		
     		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-paid) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and (S_REF='".$_GET["salesrep"]."' or S_REF='" & $OldRefno & "') ") or die(mysql_error());
		
		} else {
	 
	 		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-paid) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='".$_GET["salesrep"]."' ") or die(mysql_error());
			
		}	
		$rowscheq = mysql_fetch_array($sqlcheq);
		if (is_null($rowscheq["tot"])==false){ 
			$OutREtAmt=$rowscheq["tot"];
		} else {
			$OutREtAmt=0;
		}
 
   
		$ResponseXML .= "<sales_table><![CDATA[ <table  bgcolor=\"#0000FF\" border=1  cellspacing=0>
						<tr><td>Outstanding Invoice Amount</td><td>".number_format($OutInvAmt, 2, ".", ",")."</td></tr>
						 <td>Return Cheque Amount</td><td>".number_format($OutREtAmt, 2, ".", ",")."</td></tr>
						 <td>Pending Cheque Amount</td><td>".number_format($OutpDAMT, 2, ".", ",")."</td></tr>
						 <td>PSD Cheque Settlments</td><td>".number_format($pend_ret_set, 2, ".", ",")."</td></tr>
						 <td>Total</td><td>".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."</td></tr>
						 </table></table>]]></sales_table>";
						 
        
        $sqlbrtrn = mysql_query("select * from br_trn where Rep='".trim($_GET["salesrep"])."' and brand='".$InvClass."' and cus_code='".trim($cuscode)."' ") or die(mysql_error());
       if( $rowsbrtrn = mysql_fetch_array($sqlbrtrn)){
	   	if (is_null($rowsbrtrn["credit_lim"])==false){
			$crLmt = $rowsbrtrn["credit_lim"];
		} else {
			$crLmt =0;
		}
		
		if (is_null($rowsbrtrn["tmpLmt"])==false){
			$tmpLmt = $rowsbrtrn["tmpLmt"];
		} else {
			$tmpLmt =0;
		}
		
		if (is_null($rowsbrtrn["CAT"])==false){ $cuscat=$rowsbrtrn["CAT"]; }
		if ($cuscat="A") { $m=2.5; }
		if ($cuscat="B") { $m=2.5; }
		if ($cuscat="C") { $m=1; }
			
		$txt_crelimi="0";
		$txt_crebal="0";
		
		$txt_crelimi=number_format($crLmt, 2, ".", ",");
		
		$txt_crebal = number_format($crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set, 2, ".", ",");
			
		
		$ResponseXML .= "<txt_crelimi><![CDATA[".$txt_crelimi."]]></txt_crelimi>";
        $ResponseXML .= "<txt_crebal><![CDATA[".$txt_crebal."]]></txt_crebal>";
	   } else {
	   	$ResponseXML .= "<txt_crelimi><![CDATA[0.00]]></txt_crelimi>";
        $ResponseXML .= "<txt_crebal><![CDATA[0.00]]></txt_crebal>";
	   }
		
		$creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;
		


				
				
		 			$sql = mysql_query("select dis from brand_mas where barnd_name = '".trim($_GET["brand"])."'") or die(mysql_error());
					if ($row = mysql_fetch_array($sql)){	
						$ResponseXML .= "<dis><![CDATA[".$row["dis"]."]]></dis>";
					}
			
				}
			
	
				$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
				
				
	
	
	}
	
	if($_GET["Command"]=="add_tmp")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql="delete from tmp_ord_data where str_code='".$_GET['itemcode']."' and str_invno='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			$rate=str_replace(",", "", $_GET["rate"]);
			$qty=str_replace(",", "", $_GET["qty"]);
			$discount=str_replace(",", "", $_GET["discount"]);
			$subtotal=str_replace(",", "", $_GET["subtotal"]);
			
			$sql="Insert into tmp_ord_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand)values 
			('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', ".$rate.", ".$qty.", ".$_GET["discountper"].", ".$discount.", ".$subtotal.", '".$_GET["brand"]."') ";
			$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							  <td></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_ord_data where str_invno='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>
                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".number_format($row['cur_rate'], 2, ".", ",")."</a></td>
							 <td bgcolor=\"#222222\" >".number_format($row['cur_qty'], 2, ".", ",")."</a></td>
							 <td bgcolor=\"#222222\" >".number_format($_GET["discountper"], 2, ".", ",")."</a></td>
							 <td bgcolor=\"#222222\" >".number_format($row['cur_subtot'], 2, ".", ",")."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
						
						include_once("connection.php");
							 
							 $sqlqty = mysql_query("select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysql_error());
					if($rowqty = mysql_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td bgcolor=\"#222222\" >".$qty."</a></td>
						
                            </tr>";
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ord_data where str_invno='".$_GET['invno']."'";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);	
				$ResponseXML .= "<subtot><![CDATA[".number_format($row['tot_sub'], 2, ".", ",")."]]></subtot>";
				$ResponseXML .= "<tot_dis><![CDATA[".number_format($row['tot_dis'], 2, ".", ",")."]]></tot_dis>";
				
				$vatrate=0.12;
				
				if ($_GET["vatmethod"]=="vat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="svat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="evat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="non"){
					//$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
					$ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";
					
					$invtot=number_format($row['tot_sub'], 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
				}
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	


	
if($_GET["Command"]=="delete_crn")
{
	$sql="select * from c_bal where REFNO= '".trim($_GET["crnno"])."' ";
	$result =$db->RunQuery($sql);					
	if($row = mysql_fetch_array($result)){
		if ($row["SDATE"]==date("Y-m-d")){
			$sql1="delete from c_bal where REFNO='".$_GET["crnno"]."'";
			$result1 =$db->RunQuery($sql1);	
			
			$sql1="update cred set CANCELL='1' where C_REFNO='".$_GET["crnno"]."'";
			$result1 =$db->RunQuery($sql1);	
			
			$sql1="update s_salma set RET_AMO=RET_AMO-".$_GET["amount"]." where REF_NO='".$_GET["invno"]."'";
			$result1 =$db->RunQuery($sql1);	
			
			$sql1="delete from s_led  where REF_NO = '".$_GET["crnno"]."'";
			$result1 =$db->RunQuery($sql1);	
			
			$sql1="update vendor set CUR_BAL=CUR_BAL+ ".$_GET["amount"]."  where CODE='".$_GET["cus_code"]."'";
			$result1 =$db->RunQuery($sql1);	
			
			$sql1="update br_trn set credit=credit+ ".$_GET["amount"]."  where cus_code='".$_GET["cus_code"]."' and Rep='".$_GET["salesrep"]."'";
			$result1 =$db->RunQuery($sql1);	
			
			$ResponseXML .= "<msg_cancel><![CDATA[Cancelled]]></msg_cancel>";
		}	else {
			$ResponseXML .= "<msg_cancel><![CDATA[Cant Cancel]]></msg_cancel>";
		}
		
		
		
	}
	
  
}
	
		
	if($_GET["Command"]=="del_item")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
	
			$sql="delete from tmp_ord_data where str_code='".$_GET['code']."' and str_invno='".$_GET['invno']."' ";
			//echo $sql;
			$result =$db->RunQuery($sql);
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_ord_data where str_invno='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>
                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_rate']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_qty']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_discount']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_subtot']."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
							 
							 	include_once("connection.php");
							 
							 $sqlqty = mysql_query("select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysql_error());
					if($rowqty = mysql_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td bgcolor=\"#222222\" >".$qty."</a></td>
                            </tr>";
				}			
							
                $ResponseXML .= "   </table>]]></sales_table></salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	

	if($_GET["Command"]=="pass_crnno")
	{
		$ResponseXML .= "";
		$ResponseXML .= "<salesdetails>";
		$sql="Select * from cred where C_REFNO='".$_GET['crnno']."'";
		$result =$db->RunQuery($sql);	
		if ($row = mysql_fetch_array($result)){
			$ResponseXML .= "<C_REFNO><![CDATA[".$row["C_REFNO"]."]]></C_REFNO>";
			$ResponseXML .= "<C_DATE><![CDATA[".$row["C_DATE"]."]]></C_DATE>";
			$ResponseXML .= "<C_CODE><![CDATA[".$row["C_CODE"]."]]></C_CODE>";
			$sql1="Select * from vendor where CODE='".$row["C_CODE"]."'";
			$result1 =$db->RunQuery($sql1);	
			if ($row1 = mysql_fetch_array($result1)){
				$ResponseXML .= "<name><![CDATA[".$row1["NAME"]."]]></name>";
			}
			$ResponseXML .= "<C_INVNO><![CDATA[".$row["C_INVNO"]."]]></C_INVNO>";
			
			$sql1="Select * from s_salma where REF_NO='".$row["C_INVNO"]."'";
			$result1 =$db->RunQuery($sql1);	
			if ($row1 = mysql_fetch_array($result1)){
					$ResponseXML .= "<invdate><![CDATA[".$row1['SDATE']."]]></invdate>";
					$ResponseXML .= "<inv_amt><![CDATA[".$row1['GRAND_TOT']."]]></inv_amt>";
					$ResponseXML .= "<TOTPAY><![CDATA[".$row1['TOTPAY']."]]></TOTPAY>";
					$bal=$row1['GRAND_TOT']-$row1['TOTPAY'];
					$ResponseXML .= "<balance><![CDATA[".$bal."]]></balance>";
			} else {
					$ResponseXML .= "<invdate><![CDATA[]]></invdate>";
					$ResponseXML .= "<inv_amt><![CDATA[]]></inv_amt>";
					$ResponseXML .= "<TOTPAY><![CDATA[]]></TOTPAY>";
					$ResponseXML .= "<balance><![CDATA[]]></balance>";
			}
			$ResponseXML .= "<C_REMARK><![CDATA[".$row["C_REMARK"]."]]></C_REMARK>";
			$ResponseXML .= "<C_SALEX><![CDATA[".$row["C_SALEX"]."]]></C_SALEX>";
			$ResponseXML .= "<Brand><![CDATA[".$row["Brand"]."]]></Brand>";
			$ResponseXML .= "<C_PAYMENT><![CDATA[".$row["C_PAYMENT"]."]]></C_PAYMENT>";
		}
		
		$sql="Select * from c_bal where REFNO='".$_GET['crnno']."'";
		$result =$db->RunQuery($sql);	
		if ($row = mysql_fetch_array($result)){
			$ResponseXML .= "<DEP><![CDATA[".$row["DEP"]."]]></DEP>";
		} else {
			$ResponseXML .= "<DEP><![CDATA[]]></DEP>";
		}
		
		$ResponseXML .= "</salesdetails>";
		echo $ResponseXML;
	}
	
	if($_GET["Command"]=="save_crn")
		{
	/*		$_SESSION["CURRENT_DOC"] = 1;      //document ID
			$_SESSION["VIEW_DOC"] = false ;     //view current document
			$_SESSION["FEED_DOC"] = true;       //save  current document
			$_GET["MOD_DOC"] = false  ;         //delete   current document
			$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
			$_GET["PRICE_EDIT"] = false ;       //edit selling price
			$_GET["CHECK_USER"] = false ;       //check user permission again   */

			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			$sql="Select C_REFNO from cred where C_REFNO='".$_GET['customercode']."'";
			$result =$db->RunQuery($sql);	
			if ($row = mysql_fetch_array($result)){
				$ResponseXML .= "<msg_exist><![CDATA[Credit Note NO Already Exists]]></msg_exist>";
			} else {
				$ResponseXML .= "<msg_exist><![CDATA[0]]></msg_exist>";
			}
			
			$mcash=0;
			if ($_GET["chkcash_disc"]=="on"){
				$mcash=1;
			}
			$mvatrate=12;
			$sql="Insert into c_bal (REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, vatrate, RNO, flag1, DEV, CANCELL, old, active, totpay) values 
			('".$_GET["crnno"]."', '".$_GET["crndate"]."', 'CNT', '".$_GET["cus_code"]."', '".$_GET["amount"]."', '".$_GET["amount"]."', '".$_GET["brand"]."', '".$_GET["department"]."', '".$_GET["salesrep"]."', '".$mvatrate."', '".$_GET["txtrno"]."', '".$mcash."', '".$_SESSION['dev']."', '0', '0', 1, 0) ";
			$result =$db->RunQuery($sql);	
			
			$sql="Insert into cred (C_REFNO, C_DATE, C_INVNO, C_CODE, C_PAYMENT, C_REMARK, C_SALEX, Brand, DEV, DEPARTMENT, cus_ref) values 
			('".$_GET["crnno"]."', '".$_GET["crndate"]."', '".$_GET["invno"]."', '".$_GET["cus_code"]."', '".$_GET["amount"]."', '".$_GET["remarks"]."', '".$_GET["salesrep"]."', '".$_GET["brand"]."', '".$_SESSION['dev']."', 'O', '0') ";
			$result =$db->RunQuery($sql);	
			
			$sql="update s_salma set RET_AMO=RET_AMO+".$_GET["amount"]." where REF_NO='".$_GET["invno"]."'";
			$result =$db->RunQuery($sql);		
	
			$sql="Insert into s_led (REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT, DEV) values 
			('".$_GET["crnno"]."', '".$_GET["crndate"]."', '".$_GET["cus_code"]."', '".$_GET["amount"]."', 'CRN', '".$_GET["department"]."', '".$_SESSION['dev']."') ";
			$result =$db->RunQuery($sql);	

			$sql="update vendor set CUR_BAL = CUR_BAL - ".$_GET["amount"]." where CODE='".$_GET["cus_code"]."'";
			$result =$db->RunQuery($sql);	
			
			$sql="update br_trn set credit = credit - ".$_GET["amount"]." where cus_code='".$_GET["cus_code"]."' and Rep='".$_GET["salesrep"]."'";
			$result =$db->RunQuery($sql);		


			$sql="update invpara set CRN = CRN + 1";
			$result =$db->RunQuery($sql);	
			
			$ResponseXML .= "<msg_saved><![CDATA[Saved]]></msg_saved>";
			
			$ResponseXML .= "</salesdetails>";
			echo $ResponseXML;
					
			
	}
	

	
if($_GET["Command"]=="tmp_crelimit")
{	
	echo "abc";
	$crLmt = 0;
	$cat = "";
	
	$rep=trim(substr($_GET["Com_rep1"], 0, 5));
	
	$sql = "select * from br_trn where rep='".$rep."' and cus_code='".trim($_GET["txt_cuscode"])."' and brand='".trim($_GET["cmbbrand1"])."'";
	echo $sql;
	$result =$db->RunQuery($sql);
    if ($row = mysql_fetch_array($result)) {
		$crLmt = $row["credit_lim"];
   		If (is_null($row["cat"])==false) {
      		$cat = trim($row["cat"]);
   		} else {
      		$crLmt = 0;
		}	
   	}
/*	
$_SESSION["CURRENT_DOC"] = 66     //document ID
//$_SESSION["VIEW_DOC"] = true      //  view current document
 $_SESSION["FEED_DOC"] = true      //  save  current document
//$_SESSION["MOD_DOC"] = true       //   delete   current document
//$_SESSION["PRINT_DOC"] = true     // get additional print   of  current document
//$_SESSION["PRICE_EDIT"]= true     // edit selling price
$_SESSION["CHECK_USER"] = true    // check user permission again
$crLmt = $crLmt;
setlocale(LC_MONETARY, "en_US");
$CrTmpLmt = number_format($_GET["txt_tmeplimit"], 2, ".", ",");

$REFNO = trim($_GET["txt_cuscode"]) ;

$AUTH_USER="tmpuser";

$sql = "insert into tmpCrLmt (sdate, stime, username, tmpLmt, class, rep, cuscode, crLmt, cat) values 
        ('".date("Y-m-d")."','".date("H:i:s", time())."' ,'".$AUTH_USER."',".$CrTmpLmt." ,'".trim($_GET["cmbbrand1"])."','".$rep."','".trim($_GET["txt_cuscode"])."',".$crLmt.",'".$cat"' )";
$result =$db->RunQuery($sql);

$sql = "select * from  br_trn where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."'";
$result =$db->RunQuery($sql);
if ($row = mysql_fetch_array($result)) {
   $sqlbrtrn= "insert into br_trn (cus_code, rep, credit_lim, brand, tmplmt) values ('".trim($_GET["txt_cuscode"])."','".$rep."','0','".trim($_GET["cmbbrand1"])."',".$CrTmpLmt." )";
   $resultbrtrn =$db->RunQuery($sqlbrtrn);
   
} else {
  
  	$sqlbrtrn= "update br_trn set tmplmt= ".$CrTmpLmt."  where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."' ";
 	$resultbrtrn =$db->RunQuery($sqlbrtrn);
	
//	$sqlbrtrn= "update vendor set temp_limit= ".$CrTmpLmt."  where code='".trim($_GET["txt_cuscode"])."' "
}

	If ($_GET["Check1"] == 1) {
   		$sqlblack= "update vendor set blacklist= '1'  where code='".trim($_GET["txt_cuscode"])."' ";
		$resultblack =$db->RunQuery($sqlblack);
	} else {	
    	$sqlblack= "update vendor set blacklist= '0'  where code='".trim($_GET["txt_cuscode"])."' ";
		$resultblack =$db->RunQuery($sqlblack);
	}

echo "Tempory limit updated";*/

}
	
?>