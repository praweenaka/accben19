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
	
			
		if($_GET["Command"]=="new_inv")
		{
			
			$_SESSION["print"]=0;
			
		/*	$sql="Select CAS_INV_NO_m from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
			
			$sql="Select CCRNNO from invpara";
			
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CCRNNO"];
			$lenth=strlen($tmpinvno);
			$invno=trim("CCRN/ ").substr($tmpinvno, $lenth-7);
			$_SESSION["invno"]=$invno;
			
			$sql="delete from tmp_credit_note_form where str_invno='".$invno."'";
			$result =$db->RunQuery($sql);
			
			//echo $invno;
			header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
			$ResponseXML = "<salesdetails>";		
			$ResponseXML .= "<invno><![CDATA[".$invno."]]></invno>";	
			$ResponseXML .= "<msg><![CDATA[CREDIT NOTE FOR CASH DISCOUNTS AMOUNTS]]></msg>";	
			$ResponseXML .= "</salesdetails>";		

		echo $ResponseXML;	
			
		}

if ($_GET["Command"]=="pass_crn_form_cash"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	
    $ResponseXML = "<salesdetails>";		
	
	$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Deli. Date</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Inv. Amount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Settle Amou.</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Settle Date</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Days</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cash Disc %</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Dis Amount</font></td>
                             
                            </tr>";		
			
	$i = $_GET["mcou"]+1;
    $tot = 0;
    if (($_GET["invno"] != "") and ($_GET["invno"] != "Invoice No")) {
        $mqty = 0;
        $sql_rscrn= " Select * from s_crnfrmtrn where Inv_no = '" . trim($_GET["invno"]) . "' AND Flag = 'CCRN' ";
		$result_rscrn =$db->RunQuery($sql_rscrn);
		if ($row_rscrn = mysql_fetch_array($result_rscrn)){
       
               
                //cmdSave.Enabled = False
               
				
				
			$Inv_date="Inv_date".$i;
			$inv_no="inv_no".$i;
			$Amount="Amount".$i;
			$settle="settle".$i;
			$settledate="settledate".$i;
			$days="days".$i;
			$cash_dis="cash_dis".$i;
			$cash_amt="cash_amt".$i;
						
						
					
					
				
			$ResponseXML .= "<tr>
                        
							 <td ><input type=\"text\" size=\"10\" name=".$Inv_date."  disabled id=".$Inv_date." value='".$row_rscrn['Inv_date']."' class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"30\" name=".$inv_no."  disabled id=".$inv_no." value='".$_GET["invno"]."' class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$Amount."  disabled id=".$Amount." value=".$row_rscrn['Amount']." class=\"txtbox\"/></td>
							 <td  ><input type=\"text\" size=\"10\" name=".$settle."  disabled id=".$settle." value=".$row_rscrn['Settle_amo']." class=\"txtbox\"/></td>
							 <td  ><input type=\"text\" size=\"10\" name=".$settledate."  disabled id=".$settledate." value=".$row_rscrn['Mon']." class=\"txtbox\"/></td>
							 <td  ><input type=\"text\" size=\"10\" name=".$days."  disabled id=".$days." value=".$row_rscrn["Qty"]." class=\"txtbox\"/></td>
							
							 <td  ><input type=\"text\" size=\"10\" name=".$cash_dis." id=".$cash_dis."  class=\"txtbox\" value=".$row_rscrn["Incen_per"]." \"/></td>
							 <td  ><input type=\"text\" size=\"10\" name=".$Incen_val." id=".$Incen_val." value=".$row_rscrn['Incen_val']." class=\"txtbox\"/></td>
							 
							 
							
							 
                            </tr>";
							
			$i=$i+1;
							
			
			 	
			$ResponseXML .= "   </table>]]></sales_table>";
			$ResponseXML .= "<mcou><![CDATA[".$i."]]></mcou>";	
			$ResponseXML .= "<msg><![CDATA[Sorry this Invoice Incentive Already Paid]]></msg>";	

        } else {
        
        
        
        	$sql_rssalma= "Select * from view_s_sttr_copy where ST_INVONO = '" . trim($_GET["invno"]) . "' AND ST_FLAG = 'CHK' ";
        	$result_rssalma =$db->RunQuery($sql_rssalma);
			if ($row_rssalma1 = mysql_fetch_array($result_rssalma)){
			
            	while ($row_rssalma = mysql_fetch_array($result_rssalma)){
						
					$Inv_date="Inv_date".$i;
					$inv_no="inv_no".$i;
					$Amount="Amount".$i;
					$settle="settle".$i;
					$settledate="settledate".$i;
					$days="days".$i;
					$cash_dis="cash_dis".$i;
					$cash_amt="cash_amt".$i;
						
						
                	if (is_null($row_rssalma["deli_date"])==false) {
                    	
						$mdate=$row_rssalma['deli_date'];
						
               	 	} else {
						$mdate=$row_rssalma['SDATE'];
						
                    	
                	}
					
					$ResponseXML .= "<tr>
                        
							 <td ><input type=\"text\" size=\"10\" name=".$Inv_date."  disabled id=".$Inv_date." value='".$mdate."' class=\"txtbox\"/></td>";
							 
					$ResponseXML .= "<td ><input type=\"text\" size=\"30\" name=".$inv_no."  disabled id=".$inv_no." value='".$_GET["ST_INVONO"]."' class=\"txtbox\"/></td>
					
					<td ><input type=\"text\" size=\"10\" name=".$Amount."  disabled id=".$Amount." value=".$row_rssalma['GRAND_TOT']." class=\"txtbox\"/></td>
							 <td  ><input type=\"text\" size=\"10\" name=".$settle."  disabled id=".$settle." value=".$row_rssalma['ST_PAID']." class=\"txtbox\"/></td>
							 <td  ><input type=\"text\" size=\"10\" name=".$settledate."  disabled id=".$settledate." value=".$row_rssalma['st_chdate']." class=\"txtbox\"/></td>";
							 
					$apdays = $row_sttr["del_days"];
					$diff = abs(strtotime($mdate) - strtotime($row_rssalma["ST_CHDATE"]));
					$mdays = floor($diff / (60*60*24));
					
					$ResponseXML .= "	 <td  ><input type=\"text\" size=\"10\" name=".$days."  disabled id=".$days." value=".$mdays." class=\"txtbox\"/></td>
							
							 <td  ><input type=\"text\" size=\"10\" name=".$cash_dis." id=".$cash_dis."  class=\"txtbox\" value=\"\" \"/></td>
							 <td  ><input type=\"text\" size=\"10\" name=".$Incen_val." id=".$Incen_val." value=\"\" class=\"txtbox\"/></td>
							 
							 
							
							 
                            </tr>";
               
                	$i = $i + 1;

            	}
            $ResponseXML .= "   </table>]]></sales_table>";
			$ResponseXML .= "<mcou><![CDATA[".$i."]]></mcou>";	
			$ResponseXML .= "<msg><![CDATA[]]></msg>";	
        	} else {
            	//if ($check == "New") {
                //	$msg = MsgBox("No cash/cheque settlement records found in this invoice. Do you wish to continue?", vbYesNo)
           		//Else
                //	msg = vbYes
            	//End If
            	//If msg = vbYes Then
                
                $sql_rsstr= "Select * from view_s_sttr_copy where ST_INVONO = '" . trim($_GET["invno"]) . "' ";
				$result_rsstr =$db->RunQuery($sql_rsstr);
				if ($row_rsstr1 = mysql_fetch_array($result_rsstr)){
                	
					while ($row_rsstr = mysql_fetch_array($result_rsstr)){
                    
                        if (is_null($row_rsstr["deli_date"])==false) {
                            $mdate = $row_rsstr["deli_date"];
                        } else {
                            $mdate = $row_rsstr["SDATE"];
                        }
						
						$ResponseXML .= "<tr>
                        
							 <td ><input type=\"text\" size=\"10\" name=".$Inv_date."  disabled id=".$Inv_date." value='".$mdate."' class=\"txtbox\"/></td>";
							 
						$ResponseXML .= "<td ><input type=\"text\" size=\"30\" name=".$inv_no."  disabled id=".$inv_no." value='".$_GET["ST_INVONO"]."' class=\"txtbox\"/></td>
					
					<td ><input type=\"text\" size=\"10\" name=".$Amount."  disabled id=".$Amount." value=".$row_rssalma['GRAND_TOT']." class=\"txtbox\"/></td>
							 <td  ><input type=\"text\" size=\"10\" name=".$settle."  disabled id=".$settle." value=".$row_rssalma['ST_PAID']." class=\"txtbox\"/></td>
							 <td  ><input type=\"text\" size=\"10\" name=".$settledate."  disabled id=".$settledate." value=".$row_rssalma['ST_DATE']." class=\"txtbox\"/></td>";
							 
						$apdays = $row_sttr["del_days"];
						$diff = abs(strtotime($mdate) - strtotime($row_rssalma["ST_DATE"]));
						$mdays = floor($diff / (60*60*24));
					
						$ResponseXML .= "	 <td  ><input type=\"text\" size=\"10\" name=".$days."  disabled id=".$days." value=".$mdays." class=\"txtbox\"/></td>
							
							 <td  ><input type=\"text\" size=\"10\" name=".$cash_dis." id=".$cash_dis."  class=\"txtbox\" value=\"\" \"/></td>
							 <td  ><input type=\"text\" size=\"10\" name=".$Incen_val." id=".$Incen_val." value=\"\" class=\"txtbox\"/></td>
							 
							 
							
							 
                            </tr>";
							
                       
                        $i = $i + 1;
                        
                    }
					
					$ResponseXML .= "   </table>]]></sales_table>";
					$ResponseXML .= "<mcou><![CDATA[".$i."]]></mcou>";	
					$ResponseXML .= "<msg><![CDATA[]]></msg>";	
					
                } else {
					$ResponseXML .= "   </table>]]></sales_table>";
					$ResponseXML .= "<mcou><![CDATA[".$i."]]></mcou>";	
					$ResponseXML .= "<msg><![CDATA[No any records found in this invoice]]></msg>";	
                    
                    
                }
            }   
           //} else {
                //MSFlexGrid1.TextMatrix(MSFlexGrid1.Row, 1) = ""
            //}
        }
        $check = "";
    }
	
	
			
			
			
		$ResponseXML .= "</salesdetails>";		

		echo $ResponseXML;	
			
	
}
	
	
if ($_GET["Command"]=="pass_crn_form"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$ResponseXML = "<salesdetails>";		
	
	$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Amount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Incentive (%)</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Incentive Val</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Brand</font></td>
                             
                            </tr>";		
			
	$i = $_GET["mcou"]+1;
    $tot = 0;
   // Do While MSFlexGrid1.TextMatrix(i, 1) <> ""
        $mqty = 0;
        $sql_rscrn= " Select * from s_crnfrmtrn where Inv_no = '" .$_GET["invno"]. "' and Flag = 'ACRN'";
        $result_rscrn =$db->RunQuery($sql_rscrn);
		if ($row_rscrn = mysql_fetch_array($result_rscrn)){
			
			//$sql_tmpinst= " insert into tmp_credit_note_form (crn_form_no, Inv_date, inv_no, Amount, disc, Qty, Incen_per, Incen_val, Brands) values ('".$_GET["txtrefno"]."', '".$row_rscrn['Inv_date']."', '".$_GET["invno"]."', ".$row_rscrn['Amount'].", ".$row_rscrn['disc'].", ".$row_rscrn['Qty'].", ".$row_rscrn['Incen_per'].", ".$row_rscrn['Incen_val'].", '".$row_rscrn['Brand']."' )";
        	//$result_tmpinst =$db->RunQuery($sql_tmpinst);
			
			
							
        	
			
						$Inv_date="Inv_date".$i;
						$inv_no="inv_no".$i;
						$Amount="Amount".$i;
						$disc="disc".$i;
						$Qty="Qty".$i;
						$Incen_per="Incen_per".$i;
						$Incen_val="Incen_val".$i;
						$Brands="Brands".$i;
						
					
					
				
			 	$ResponseXML .= "<tr>
                        
							 <td ><input type=\"text\" size=\"10\" name=".$Inv_date."  disabled id=".$Inv_date." value='".$row_rscrn['Inv_date']."' class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"30\" name=".$inv_no."  disabled id=".$inv_no." value='".$_GET["invno"]."' class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$Amount."  disabled id=".$Amount." value=".$row_rscrn['Amount']." class=\"txtbox\"/></td>
							 <td  ><input type=\"text\" size=\"10\" name=".$disc."  disabled id=".$row." value=".$row_rscrn['disc']." class=\"txtbox\"/></td>
							 <td  ><input type=\"text\" size=\"10\" name=".$Qty."  disabled id=".$Qty." value=".$row_rscrn["Qty"]." class=\"txtbox\"/></td>
							
							 <td  ><input type=\"text\" size=\"10\" name=".$Incen_per." id=".$Incen_per."  class=\"txtbox\" value=".$row_rscrn["row_rscrn"]." \"/></td>
							 <td  ><input type=\"text\" size=\"10\" name=".$Incen_val." id=".$Incen_val." value=".$row_rscrn['row_rscrn']." class=\"txtbox\"/></td>
							 <td  ><input type=\"text\" size=\"10\" name=".$Brands." id=".$Brands." value=".$row_rscrn['Brands']." class=\"txtbox\"/></td>
							 
							
							 
                            </tr>";
							
							$i=$i+1;
							
			
			 	
			$ResponseXML .= "   </table>]]></sales_table>";
			$ResponseXML .= "<mcou><![CDATA[".$i."]]></mcou>";	
			$ResponseXML .= "<msg><![CDATA[Sorry this Invoice Incentive Already Paid]]></msg>";	
			   
        } else {
        
       
        	$sql_RSINVO= "Select * from s_invo  where REF_NO =  '" .$_GET["invno"]. "'";
			$result_RSINVO =$db->RunQuery($sql_RSINVO);
        	$sql_rssalma= "Select * from s_salma where REF_NO = '" .$_GET["invno"]. "'";
			$result_rssalma =$db->RunQuery($sql_rssalma);
        	if ($row_rssalma = mysql_fetch_array($result_rssalma)){
				
						$Inv_date="Inv_date".$i;
						$inv_no="inv_no".$i;
						$Amount="Amount".$i;
						$disc="disc".$i;
						$Qty="Qty".$i;
						$Incen_per="Incen_per".$i;
						$Incen_val="Incen_val".$i;
						$Brands="Brands".$i;
						
				$ResponseXML .= "<tr>
                        
							 <td ><input type=\"text\" size=\"10\" name=".$Inv_date."  disabled id=".$Inv_date." value='".$row_rssalma['SDATE']."' class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"30\" name=".$inv_no."  disabled id=".$inv_no." value='".$_GET["invno"]."' class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$Amount."  disabled id=".$Amount." value=".$row_rssalma['GRAND_TOT']." class=\"txtbox\"/></td>
							 
							 <td ><input type=\"text\" size=\"10\" name=".$disc."  disabled id=".$disc." value=".$row_rssalma['DIS']." class=\"txtbox\"/></td>";
							 
				
           
            	$sql_rsqty= " select * from view_salma_sinvo where REF_NO = '" . trim($row_rssalma["REF_NO"]) . "'";
				$result_rsqty =$db->RunQuery($sql_rsqty);
                while ($row_rsqty = mysql_fetch_array($result_rsqty)){
                    $mqty = $mqty + $row_rsqty["QTY"];
                    
                }
				$ResponseXML .= "<td ><input type=\"text\" size=\"10\" name=".$Qty."  disabled id=".$Qty." value=".$mqty." class=\"txtbox\"/></td>";
				
				$ResponseXML .= "<td ><input type=\"text\" size=\"10\" name=".$Incen_per."  onBlur=\"cal_incentive('".$i."')\" id=".$Incen_per." value=\"\" class=\"txtbox\"/></td>";
				$ResponseXML .= "<td ><input type=\"text\" size=\"10\" name=".$Incen_val."  disabled id=".$Incen_val." value=\"\" class=\"txtbox\"/></td>";
            	            	
            	/*if MSFlexGrid1.Col = 4 And MSFlexGrid1.TextMatrix(i, 4) <> "" Then
                	devdes = (100 - (RSINVO!dis_per))
                	MSFlexGrid1.TextMatrix(i, 5) = Format((rssalma!GRAND_TOT / (100 - (RSINVO!dis_per))) * MSFlexGrid1.TextMatrix(i, 4), "######.00")
            	End If
            	If MSFlexGrid1.TextMatrix(i, 5) <> "" Then tot = tot + MSFlexGrid1.TextMatrix(i, 5)*/
            	$ResponseXML .= "<td ><input type=\"text\" size=\"10\" name=".$Brands."  disabled id=".$Brands." value=".$row_rssalma['Brand']." class=\"txtbox\"/></td></tr>";
				
				$i=$i+1;
        	}
						
							
			$ResponseXML .= "   </table>]]></sales_table>";
			$ResponseXML .= "<mcou><![CDATA[".$i."]]></mcou>";	
			$ResponseXML .= "<msg><![CDATA[]]></msg>";						
			
		}	 	
			
        
    //Loop
    //txttot = Format(tot, "######.00")		
			
			
			
			
			
			
			
			
			
		$ResponseXML .= "</salesdetails>";		

		echo $ResponseXML;	
			
	
}

	
	
	if($_GET["Command"]=="add_tmp")
		{
		
			$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql="delete from tmp_purord_data where str_code='".$_GET['itemcode']."' and str_invno='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			
			$qty=str_replace(",", "", $_GET["qty"]);
			
			
			$sql="Insert into tmp_purord_data (str_invno, str_code, str_description, partno, qty)values 
			('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', '".$_GET["partno"]."', ".$qty.") ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                             
                            </tr>";
							
			
			$sql="Select * from tmp_purord_data where str_invno='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['partno']."</a></td>
							 <td bgcolor=\"#222222\" >".number_format($row['qty'], 2, ".", ",")."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td></tr>";
							 
                           
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	
	
	if($_GET["Command"]=="arn")
		{
		
			//$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql="select * from s_ordmas where REFNO='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			if($row = mysql_fetch_array($result)){
				$ResponseXML .= "<REFNO><![CDATA[".$row['REFNO']."]]></REFNO>";
				$ResponseXML .= "<SDATE><![CDATA[".$row['SDATE']."]]></SDATE>";
				$ResponseXML .= "<SUP_CODE><![CDATA[".$row['SUP_CODE']."]]></SUP_CODE>";
				$ResponseXML .= "<SUP_NAME><![CDATA[".$row['SUP_NAME']."]]></SUP_NAME>";
				$ResponseXML .= "<REMARK><![CDATA[".$row['REMARK']."]]></REMARK>";
				$ResponseXML .= "<DEP_CODE><![CDATA[".$row['DEP_CODE']."]]></DEP_CODE>";
				$ResponseXML .= "<DEP_NAME><![CDATA[".$row['DEP_NAME']."]]></DEP_NAME>";
				$ResponseXML .= "<REP_CODE><![CDATA[".$row['REP_CODE']."]]></REP_CODE>";
				$ResponseXML .= "<REP_NAME><![CDATA[".$row['REP_NAME']."]]></REP_NAME>";
				$ResponseXML .= "<S_date><![CDATA[".$row['S_date']."]]></S_date>";
				$ResponseXML .= "<LC_No><![CDATA[".$row['LC_No']."]]></LC_No>";
				$ResponseXML .= "<Brand><![CDATA[".$row['Brand']."]]></Brand>";
				$ResponseXML .= "<COUNTRY><![CDATA[".$row["COUNTRY"]."]]></COUNTRY>";
			}	
			
		//	$sql="delete from tmp_purord_data where str_invno='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
		//	$result =$db->RunQuery($sql);
			
		//	$sql="select * from s_ordtrn where REFNO='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
		//	$result =$db->RunQuery($sql);
		//	while($row = mysql_fetch_array($result)){
		//		$sql1="Insert into tmp_purord_data (str_invno, str_code, str_description, partno, qty)values 
		//		('".$row['REFNO']."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', '".$row["partno"]."', ".$row["ORD_QTY"].") ";
			//$ResponseXML .= $sql;
		//		$result1 =$db->RunQuery($sql1);	
		//	}
							
			
			
	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"200\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"800\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Order Qty</font></td>
                              <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">FOB</font></td>
                              <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cost</font></td>
							   <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Selling</font></td>
							    <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Margin</font></td>
								 <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							
                            </tr>";
				
			$mcou=0;	
			$sql="Select count(*) as mcou from s_ordtrn where REFNO='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			$row = mysql_fetch_array($result);
			$mcou=$row["mcou"]+1;
							
			$i=1;
			$sql="Select * from s_ordtrn where REFNO='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){	
			
				$itemcode="itemcode".$i;
				$itemname="itemname".$i;
				$ord_qty="ord_qty".$i;
				$fob="fob".$i;
				$qty="qty".$i;
				$cost="cost".$i;
				$selling="selling".$i;
				$margin="margin".$i;
				$subtotal="subtotal".$i;
							
             	$ResponseXML .= "<tr>                              
                             <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemcode." id=".$itemcode."   value=".$row['STK_NO']." class=\"txtbox\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemname." id=".$itemname."  value='".$row['DESCRIPT']."' class=\"txtbox\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$ord_qty." id=".$ord_qty."  value=".$row['ORD_QTY']." class=\"txtbox\"/></td>
							
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$fob." id=".$fob."  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$qty." id=".$qty."  class=\"txtbox\" onBlur=\"cal_subtot('".$i."', '".$mcou."');\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$cost." id=".$cost."  class=\"txtbox\" onBlur=\"cal_subtot('".$i."', '".$mcou."');\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$selling." id=".$selling."  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$margin." id=".$margin."  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$subtotal." id=".$subtotal."  class=\"txtbox\"/></td>
							</tr>";
							$i=$i+1; 
                           
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				$ResponseXML .= "<count><![CDATA[".$i."]]></count>";
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	
	
	if($_GET["Command"]=="setord")
	{
		
		include_once("connection.php");
		
		$len=strlen($_GET["salesord1"]);
		$need=substr($_GET["salesord1"],$len-7, $len);
		$salesord1=trim("ORD/ ").$_GET["salesrep"].trim(" / ").$need;
		
		
		$_SESSION["custno"]=$_GET['custno'];
		$_SESSION["brand"]=$_GET["brand"];
		$_SESSION["department"]=$_GET["department"];
		
		
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				$cuscode=$_GET["custno"];	
				$salesrep=$_GET["salesrep"];
				$brand=$_GET["brand"];
					
			//		$ResponseXML .= "<salesord><![CDATA[".$salesord1."]]></salesord>";
				
					
	    //Call SETLIMIT ====================================================================
		
		
		
	/*	$sql = mysql_query("DROP VIEW view_s_salma") or die(mysql_error());
					$sql = mysql_query("CREATE VIEW view_s_salma
AS
SELECT     s_salma.*, brand_mas.class AS class
FROM         brand_mas RIGHT OUTER JOIN
                      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysql_error());*/

	$OutpDAMT = 0;
	$OutREtAmt = 0;
	$OutInvAmt = 0;
	$InvClass="";
	
	$sqlclass = mysql_query("select class from brand_mas where barnd_name='".trim($brand)."'") or die(mysql_error());
	if ($rowclass = mysql_fetch_array($sqlclass)){
		if (is_null($rowclass["class"])==false){
			$InvClass=$rowclass["class"];
		}
	}
	
	$sqloutinv = mysql_query("select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($salesrep)."' and class='".$InvClass."'") or die(mysql_error());
	if ($rowoutinv = mysql_fetch_array($sqloutinv)){
		if (is_null($rowoutinv["totout"])==false){
			$OutInvAmt=$rowoutinv["totout"];
		}
	}

$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("d-m-Y")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($salesrep)."'") or die(mysql_error());
	while($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
		
		$sqlsttr = mysql_query("select * from s_sttr where ST_REFNO='".trim($rowinvcheq["refno"])."' and ST_CHNO ='".trim($rowinvcheq["cheque_no"]) ."'") or die(mysql_error());
		while($rowsttr = mysql_fetch_array($sqlsttr)){
			$sqlview_s_salma = mysql_query("select class from view_s_salma where REF_NO='".trim($rowsttr["ST_INVONO"])."'") or die(mysql_error());
			if($rowview_s_salma = mysql_fetch_array($sqlview_s_salma)){
				
				if (trim($rowview_s_salma["class"]) == $InvClass){
                    $OutpDAMT = $OutpDAMT + $rowsttr["ST_PAID"];
                }
			}
		}
	}


        
        $pend_ret_set = 0;
		
		$sqlinvcheq = mysql_query("SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'".date("d-m-Y")."' AND cus_code='".trim($cuscode)."' and trn_type='RET'") or die(mysql_error());
		if($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
			if (is_null($rowinvcheq["che_amount"])==false){
				$pend_ret_set=$rowinvcheq["che_amount"];
			}
		}
		
		
		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='".trim($salesrep)."'") or die(mysql_error());
		if($rowcheq = mysql_fetch_array($sqlcheq)){
			if (is_null($rowcheq["tot"])==false){
				$OutREtAmt=$rowcheq["tot"];
			} else {
				$OutREtAmt=0;
			}
		}
		
            
 
$ResponseXML .= "<sales_table_acc><![CDATA[ <table  bgcolor=\"#0000FF\" border=1  cellspacing=0>
						<tr><td>Outstanding Invoice Amount</td><td>".number_format($OutInvAmt, 2, ".", ",")."</td></tr>
						 <td>Return Cheque Amount</td><td>".number_format($OutREtAmt, 2, ".", ",")."</td></tr>
						 <td>Pending Cheque Amount</td><td>".number_format($OutpDAMT, 2, ".", ",")."</td></tr>
						 <td>PSD Cheque Settlments</td><td>".number_format($pend_ret_set, 2, ".", ",")."</td></tr>
						 <td>Total</td><td>".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."</td></tr>
						 </table></table>]]></sales_table_acc>";
        

      $sqlbr_trn = mysql_query("select * from br_trn where Rep='".trim($salesrep)."' and brand='".trim($InvClass)."' and cus_code='" .trim($cuscode)."'") or die(mysql_error());  
	if($rowbr_trn = mysql_fetch_array($sqlbr_trn)){
		if(is_null($rowbr_trn["credit_lim"]) == false){
			$crLmt=$rowbr_trn["credit_lim"];
		} else {	
			$crLmt=0;		
		}
	
		
		if(is_null($rowbr_trn["tmpLmt"]) == false){
			$tmpLmt=$rowbr_trn["tmpLmt"];
		} else {	
			$tmpLmt=0;		
		}
		
		if (is_null($rowbr_trn["CAT"])==false) {
			$cuscat = trim($rowbr_trn["cat"]);
            if ($cuscat = "A"){ $m = 2.5; }
            if ($cuscat = "B"){ $m = 2.5; }
            if ($cuscat = "C"){ $m = 1; }
            $txt_crelimi = "0";
            $txt_crebal = "0";
            $txt_crelimi = number_format($crLmt, 2, ".", ",");
			$crebal=$crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            $txt_crebal = number_format($crebal, "2", ".", ",");
          } else {
            $txt_crelimi = "0";
            $txt_crebal = "0";
          }
         $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;

	   			
			
			 
    }    
			$ResponseXML .= "<txt_crelimi><![CDATA[".$txt_crelimi."]]></txt_crelimi>";
			$ResponseXML .= "<txt_crebal><![CDATA[".$txt_crebal."]]></txt_crebal>";
          
         	 $ResponseXML .= "<creditbalance><![CDATA[".$creditbalance."]]></creditbalance>";


		$ResponseXML .= "</salesdetails>";	
		echo $ResponseXML;
				
				
	
	
	}

		
	if($_GET["Command"]=="del_item")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
	
			$sql="delete from tmp_purord_data where str_code='".$_GET['code']."' and str_invno='".$_GET['invno']."' ";
			
			$result =$db->RunQuery($sql);
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_purord_data where str_invno='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>
                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['partno']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['qty']."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td></tr>";
							 
						
				}			
				
				$ResponseXML .= "   </table>]]></sales_table>";
							
                $ResponseXML .= " </salesdetails>";
				
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	

	
if($_GET["Command"]=="save_item")
{

	$vatrate=0.12;
	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";
			
  if (($_GET["txt_cuscode"] != "") and ($_GET["mcou"] > 0)){
    $mrefno = trim($_GET["txtrefno"]);
	
    $sql_rscrnfrm= "Select * from s_crnfrmtrn where Refno = '" . $mrefno . "'";
	$result_rscrnfrm =$db->RunQuery($sql_rscrnfrm);
		
    $sql_rscrn= "Select * From s_crnfrm where Refno = '" . $mrefno . "'";
	$result_rscrn =$db->RunQuery($sql_rscrn);
    if($row_rscrnfrm = mysql_fetch_array($result_rscrnfrm)){	
		$row_rscrn = mysql_fetch_array($result_rscrn);	
        if ($row_rscrn["Lock1"] == "1") {
            exit ("Sorry this Credit note is locked");
            
        }
		$sql1= "Delete from S_crnfrmtrn where Refno = '" . $mrefno . "'";
		$result1 =$db->RunQuery($sql1);
		
		$sql1= "Delete from S_crnfrm where REfno = '" . $mrefno . "'";
		$result1 =$db->RunQuery($sql1);
       
        
        $i = 1;
        $mamount = 0;
        while ($_GET["mcou"]>$i){
			
			$Inv_date="Inv_date".$i;
			$inv_no="inv_no".$i;
			$Amount="Amount".$i;
			$settle="settle".$i;
			$settledate="settledate".$i;
			$days="days".$i;
			$cash_dis="cash_dis".$i;
			$cash_amt="cash_amt".$i;
			
			
          
			$sql1= "Insert into s_crnfrmtrn (Sdate, Refno, Code, Name, Sal_ex, Mon, Inv_no, Inv_date, Amount, Qty, Incen_per, Incen_val, Settle_amo, Flag) values('" . $_GET["DTPicker1"] . "', '" . $mrefno . "','" . trim($_GET["txt_cuscode"]) . "', '" . trim($_GET["txt_cusname"]) . "', '" . $_GET["Com_rep"] . "', '" . $_GET[$settledate] . "','" . trim($_GET[$inv_no]) . "', '" . $_GET[$Inv_date] . "', '" . $_GET[$Amount] . "', '" . $_GET[$days] . "', '" . $_GET[$cash_dis] . "', '" . $_GET[$cash_amt] . "','" . $_GET[$settle] . "','CCRN')";
			$result1 =$db->RunQuery($sql1);
		
          
            $mamount = $mamount + $_GET[$cash_amt];
            $i = $i + 1;
        }
        
		
        
       
		
		$sql1= "insert into s_crnfrm (Refno, Sdate, Code, Mon, Amount, Remark, Sal_ex, Flag) Values('" . $mrefno . "','" . $_GET["DTPicker1"] . "', '" . trim($_GET["txt_cuscode"]) . "', '" . $_GET["MonthView1"] . "', '" . $mamount . "','" . trim($_GET["txtremark"]) . "','" . $_GET["Com_rep"] . "','CCRN')";
		$result1 =$db->RunQuery($sql1);
			
       
	    $sql1= "Update invpara set CCRNNO = CCRNNO+1";
		$result1 =$db->RunQuery($sql1);
        
    	echo "Saved";
		  
    } else {
        $i = 1;
        $mamount = 0;
        while ($_GET["mcou"]>$i){
			
			$Inv_date="Inv_date".$i;
			$inv_no="inv_no".$i;
			$Amount="Amount".$i;
			$settle="settle".$i;
			$settledate="settledate".$i;
			$days="days".$i;
			$cash_dis="cash_dis".$i;
			$cash_amt="cash_amt".$i;
			
			$sql1= "Insert into s_crnfrmtrn (Sdate, Refno, Code, Name, Sal_ex, Mon, Inv_no, Inv_date, Amount, Qty, Incen_per, Incen_val, Settle_amo, Flag) values('" . $_GET["DTPicker1"] . "', '" . $mrefno . "','" . trim($_GET["txt_cuscode"]) . "', '" . trim($_GET["txt_cusname"]) . "', '" . $_GET["Com_rep"] . "', '" . $_GET[$settledate] . "','" . trim($_GET[$inv_no]) . "', '" . $_GET[$Inv_date] . "', '" . $_GET[$Amount] . "', '" . $_GET[$days] . "', '" . $_GET[$cash_dis] . "', '" . $_GET[$cash_amt] . "','" . $_GET[$settle] . "','CCRN')";
			
			
			$result1 =$db->RunQuery($sql1);
           
            $mamount = $mamount + $_GET[$cash_amt];
            $i = $i + 1;
        }
        
		$sql1= "insert into s_crnfrm (Refno,sdate,code,mon,Amount,Remark,sal_ex,flag) Values('" . $mrefno . "','" . $_GET["DTPicker1"] . "', '" . trim($_GET["txt_cuscode"]) . "','" . $_GET["MonthView1"] . "', '" . $mamount . "','" . trim($_GET["txtremark"]) . "','" . $_GET["Com_rep"] . "','CCRN')";
		$result1 =$db->RunQuery($sql1);
		
       
        
		$sql1= "Update invpara set CCRNNO = CCRNNO+1";
		$result1 =$db->RunQuery($sql1);
        echo "Saved";
    }
  }
		
}
	

	if($_GET["Command"]=="pass_arnno")
	{
		$ResponseXML .= "";
		$ResponseXML .= "<salesdetails>";
		$sql="Select * from s_purmas where REFNO='".$_GET['arnno']."'";
		$result =$db->RunQuery($sql);	
		if ($row = mysql_fetch_array($result)){
			$ResponseXML .= "<REFNO><![CDATA[".$row["REFNO"]."]]></REFNO>";
			$ResponseXML .= "<SDATE><![CDATA[".$row["SDATE"]."]]></SDATE>";
			$ResponseXML .= "<ORDNO><![CDATA[".$row["ORDNO"]."]]></ORDNO>";
			$ResponseXML .= "<LCNO><![CDATA[".$row["LCNO"]."]]></LCNO>";
			$ResponseXML .= "<COUNTRY><![CDATA[".$row["COUNTRY"]."]]></COUNTRY>";
			$ResponseXML .= "<SUP_CODE><![CDATA[".$row["SUP_CODE"]."]]></SUP_CODE>";
			$ResponseXML .= "<SUP_NAME><![CDATA[".$row["SUP_NAME"]."]]></SUP_NAME>";
			$ResponseXML .= "<REMARK><![CDATA[".$row["REMARK"]."]]></REMARK>";
			$ResponseXML .= "<DEPARTMENT><![CDATA[".$row["DEPARTMENT"]."]]></DEPARTMENT>";
			$ResponseXML .= "<AMOUNT><![CDATA[".$row["AMOUNT"]."]]></AMOUNT>";
			$ResponseXML .= "<PUR_DATE><![CDATA[".$row["PUR_DATE"]."]]></PUR_DATE>";
			$ResponseXML .= "<brand><![CDATA[".$row["brand"]."]]></brand>";
			$ResponseXML .= "<TYPE><![CDATA[".$row["TYPE"]."]]></TYPE>";
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"200\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"800\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Unit</font></td>
                              <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Pre. Ret. Qty</font></td>
							  <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Price</font></td>
							   <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ret Qty</font></td>
							    <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Value</font></td>
							
                            </tr>";
				
			$mcou=0;	
			$sql="Select count(*) as mcou from s_purtrn where REFNO='".$_GET['arnno']."'";
			$result =$db->RunQuery($sql);	
			$row = mysql_fetch_array($result);
			$mcou=$row["mcou"]+1;
							
			$i=1;
			$tot=0;
			$sql="Select * from s_purtrn where REFNO='".$_GET['arnno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){	
			
				$itemcode="itemcode".$i;
				$itemname="itemname".$i;
				$unit="unit".$i;
				$qty="qty".$i;
				$preretqty="preretqty".$i;
				$price="price".$i;
				$retqty="retqty".$i;
				$value="value".$i;
			
					
				if (($row['ret_qty']=="") or ($row['ret_qty']==0) or is_null($row['ret_qty'])){
					$val_ret_qty=0;
				}	else {
					$val_ret_qty=$row['ret_qty'];
				}
						
             	$ResponseXML .= "<tr>                              
                             <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemcode." id=".$itemcode."   value='".$row['STK_NO']."' class=\"txtbox\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemname." id=".$itemname."  value='".$row['DESCRIPT']."' class=\"txtbox\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$unit." id=".$unit."  value='' class=\"txtbox\"/></td>
							
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$qty." id=".$qty." value='".$row['REC_QTY']."'  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$preretqty." id=".$preretqty." value='".$val_ret_qty."'  class=\"txtbox\" /></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$price." id=".$price." value='".$row['SELLING']."'  class=\"txtbox\" /></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$retqty." id=".$retqty." value=''  class=\"txtbox\" onBlur=\"cal_subtot('".$i."', '".$mcou."');\" /></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$value." id=".$value." value=''  class=\"txtbox\"/></td>
							
							</tr>";
							$tot=$tot+($row['COST']*$row['REC_QTY']);
							$i=$i+1; 
                           
				}			
							
                $ResponseXML .= "</table>]]></sales_table>";
				$ResponseXML .= "<tot><![CDATA[".$tot."]]></tot>";
				$ResponseXML .= "<count><![CDATA[".$i."]]></count>";
		}
		
		
		
		$ResponseXML .= "</salesdetails>";
		echo $ResponseXML;
	}
	
if($_GET["Command"]=="cancel_inv")
{
	if (($_GET["txt_cuscode"] != "") and ($_GET["mcou"] > 0)) {
    	$mrefno = trim($_GET["txtrefno"]);
    	$sql_rscrnfrm= "Select * from s_crnfrmtrn where Refno = '" . $mrefno . "'";
		$result_rscrnfrm =$db->RunQuery($sql_rscrnfrm);	
		
    	$sql_rscrn= " Select * from s_crnfrm where Refno = '" . $mrefno . "'";
		$result_rscrn =$db->RunQuery($sql_rscrn);	
    	if($row_rscrnfrm = mysql_fetch_array($result_rscrnfrm)){	
			
			$row_rscrn = mysql_fetch_array($result_rscrn);
			
        	if ($row_rscrn["Lock1"] == "1") {
            	exit ("Sorry this credit note cannot Cancel");
            	
        	}
			$sql1= "Update s_crnfrm set Cancell = '1' where Refno = '" . $mrefno . "'";
			$result1 =$db->RunQuery($sql1);	
			
			$sql1= "Delete from s_crnfrmtrn where Refno = '" . $mrefno . "'";
			$result1 =$db->RunQuery($sql1);	
        	
        	echo "Cancelled";
        	
    	}
	}

}	
	
if ($_GET["Command"]=="check_print")
{
	
	echo $_SESSION["print"];
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