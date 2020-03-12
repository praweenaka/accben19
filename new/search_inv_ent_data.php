<?php


session_start();


include_once("connectioni.php");


if ($_GET["Command"]=="search_inv"){
	
	$ResponseXML = "";
 
	
	
		$ResponseXML .= "<table width=\"735\" class=\"table table-bordered\">
                            <tr>
                              <td width=\"121\">Reference No</td>
                              <td width=\"176\">Description</td>
							  <td width=\"176\">Date</td>                   
   							</tr>";
                           
							if ($_GET["mstatus"]=="invno") {
						   		$letters = $_GET['invno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
								//echo $a;
								$sql = mysqli_query($GLOBALS['dbinv'],"SELECT l_refno,l_date,l_lmem  from ledger where (l_flag='REC' or l_flag='RTC')  and l_refno like  '%$letters%'  group by l_refno,l_date,l_lmem  order by l_DATE desc limit 20") or die(mysqli_error());
							} else if ($_GET["mstatus"]=="from"){
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysqli_query($GLOBALS['dbinv'],"SELECT l_refno,l_date,l_lmem  from ledger where (l_flag='REC' or l_flag='RTC')   and l_lmem like  '%$letters%'  group by l_refno,l_date,l_lmem  order by l_DATE desc limit 20") or die(mysqli_error());
							} else if ($_GET["mstatus"]=="to"){
								$letters = $_GET['invdate'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysqli_query($GLOBALS['dbinv'],"SELECT l_refno,l_date,l_lmem  from ledger where (l_flag='REC' or l_flag='RTC') and DEP_T_NAME like  '$letters%'  group by l_refno,l_date,l_lmem  order by l_DATE desc limit 20") or die(mysqli_error());
							} else {
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysqli_query($GLOBALS['dbinv'],"SELECT l_refno,l_date,l_lmem  from ledger where (l_flag='REC' or l_flag='RTC')   group by l_refno,l_date,l_lmem  order by l_DATE desc limit 20") or die(mysqli_error());
							}
							
													
						
							while($row = mysqli_fetch_array($sql)){
							
							$ResponseXML .= "<tr>               
                              <td onclick=\"gin('".$row['l_refno']."');\">".$row['l_refno']."</a></td>
                              <td onclick=\"gin('".$row['l_refno']."');\">".$row['l_lmem']."</a></td>
                              <td onclick=\"gin('".$row['l_refno']."');\">".$row['l_date']."</a></td>
					 
                            </tr>";
							
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}	
	
	
 
 
if ($_GET["Command"]=="pass_ginno"){


	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			$sql=mysqli_query($GLOBALS['dbinv'],"Select * from s_ginmas where REF_NO='".$_GET['gin']."'")or die(mysqli_error());
			if($row = mysqli_fetch_array($sql)){		
			
				$ResponseXML .= "<SDATE><![CDATA[".$row['SDATE']."]]></SDATE>";
				$ResponseXML .= "<REF_NO><![CDATA[".$row['REF_NO']."]]></REF_NO>";
				$ResponseXML .= "<DEP_FROM><![CDATA[".$row['DEP_FROM']."]]></DEP_FROM>";
				$ResponseXML .= "<DEP_TO><![CDATA[".$row['DEP_TO']."]]></DEP_TO>";
				
			//	$sql1="insert into s_trn(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT) values ('".$row2["str_code"]."', '".$_GET["invdate"]."', '".$cur_qty."', 'GINI', '".$_GET["invno"]."', '".$_GET["from_dep"]."')";
				//	$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
				
				
				
								
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                            </tr>";
							
			
				$sql1=mysqli_query($GLOBALS['dbinv'],"Select * from s_trn where REFNO='".$_GET['gin']."' and LEDINDI='GINI'")or die(mysqli_error());
				while($row1 = mysqli_fetch_array($sql1)){
		
             	$ResponseXML .= "<tr>                              
                             <td bgcolor=\"#222222\" >".$row1['STK_NO']."</a></td>";
							 
				$sqldesc=mysqli_query($GLOBALS['dbinv'],"Select * from s_mas where STK_NO='".$row1['STK_NO']."'")or die(mysqli_error());
				$rowdesc = mysqli_fetch_array($sqldesc);
			
					$ResponseXML .= " <td bgcolor=\"#222222\" >".$rowdesc['DESCRIPT']."</a></td>
							 <td bgcolor=\"#222222\" >".$rowdesc['PART_NO']."</a></td>
							 <td bgcolor=\"#222222\" >".number_format($row1['QTY'], 0, ".", ",")."</a></td>
							
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
							 
							 include_once("connectioni.php");
					//	echo "select QTYINHAND from s_submas where STK_NO='".$row1['STK_NO']."' AND STO_CODE='".$_GET["from_dep"]."'";
							 $sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$row1['STK_NO']."' AND STO_CODE='".$row['DEP_FROM']."'") or die(mysqli_error());
					if($rowqty = mysqli_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td bgcolor=\"#222222\" >".number_format($qty, 0, ".", ",")."</a></td>
							 
                            </tr>";
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				
				$ResponseXML .= " </salesdetails>";
				
			}	
				
				
				echo $ResponseXML;
}	




if ($_GET["Command"]=="pass_itno"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
			if ($_GET["brand"] != ""){	
			//echo "Select * from s_mas where STK_NO='".$_GET['itno']."' and BRAND_NAME='".$_GET["brand"]."'";
				$sql = mysqli_query($GLOBALS['dbinv'],"Select * from s_mas where STK_NO='".$_GET['itno']."' and BRAND_NAME='".$_GET["brand"]."'") or die(mysqli_error());
				} else {
				$sql = mysqli_query($GLOBALS['dbinv'],"Select * from s_mas where STK_NO='".$_GET['itno']."'") or die(mysqli_error());
				}
				if($row = mysqli_fetch_array($sql)){
				
					
					$ResponseXML .= "<str_code><![CDATA[".$row['STK_NO']."]]></str_code>";
					$ResponseXML .= "<str_description><![CDATA[".$row['DESCRIPT']."]]></str_description>";
					$ResponseXML .= "<str_partno><![CDATA[".$row['PART_NO']."]]></str_partno>";
					//$ResponseXML .= "<str_selpri><![CDATA[".$row['SELLING']."]]></str_selpri>";
					
					
				/*	if ($_GET["vatmethod"]=="non"){
     					if (is_null($row["SELLING"])==false){
							$selpri = number_format($row["SELLING"]);
   						} 
						
					}else {
						$mvatrate=12;
						
      					if (is_null($row["SELLING"])==false){
							$selpri = number_format($row["SELLING"] / (1 + ($mvatrate / 100)), 2, ".", ",");
   						} 
					}*/
					
					
				//	$ResponseXML .= "<str_selpri><![CDATA[".$selpri."]]></str_selpri>";
					
					$department=trim(substr($_GET["department"], 0, 2));
					
					//echo "select QTYINHAND from s_submas where STK_NO='".$_GET['itno']."' AND STO_CODE='".$department."'";
					$sql = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$_GET['itno']."' AND STO_CODE='".$department."'") or die(mysqli_error());
					if($row = mysqli_fetch_array($sql)){
						if (is_null($row["QTYINHAND"])==false){
							$ResponseXML .= "<qtyinhand><![CDATA[".$row["QTYINHAND"]."]]></qtyinhand>";
						}  else {
							$ResponseXML .= "<qtyinhand><![CDATA[0]]></qtyinhand>";
						}
					}  else {
							$ResponseXML .= "<qtyinhand><![CDATA[0]]></qtyinhand>";
						}
				
					//================discount
				/*	$d1=0;
					if (is_numeric($_GET["discount1"])==true){
						$d1=$_GET["discount1"];
					} else {
						$d1=0;
					}
					
					$d2=0;
					if (is_numeric($_GET["discount2"])==true){
						$d2=$_GET["discount2"];
					} else {
						$d2=0;
					}
					
					$d3=0;
					if (is_numeric($_GET["discount3"])==true){
						$d3=$_GET["discount3"];
					} else {
						$d3=0;
					}
   										
   					$d = 100 - (100 - $d2) * (100 - $d1) / 100;
  				 	$ResponseXML .= "<dis><![CDATA[".$d."]]></dis>";*/
				}				
			
				 
			
	
				$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
				
			
	
}	


?>
