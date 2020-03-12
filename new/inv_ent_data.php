<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connection_sql.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////

if ($_GET["Command"] == "new_inv") {

    $sql = "select GIN from invpara";
    $result = $conn->query( $sql);
    $row = $result->fetch();
    $tmpinvno="000000".$row["GIN"];
	$lenth=strlen($tmpinvno);
	$invno=trim("GIN/").substr($tmpinvno, $lenth-8);

    $sql = "Select QTNNO from tmpinvpara";
    $result = $conn->query( $sql);
    $row = $result->fetch();

    $tono = $row['QTNNO'];

    $sql = "delete from tmp_gin_data_multi where tmp_no='" . $tono . "'";
    $result = $conn->query( $sql);

    $sql = "update tmpinvpara set QTNNO=QTNNO+1";
    $result = $conn->query( $sql);


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
    $ResponseXML .= "<tmpno><![CDATA[" . $tono . "]]></tmpno>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "add_tmp") {

  
    if ($_GET["tmpno"] == "") {
        exit("Error");
    }


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql = "delete from tmp_gin_data_multi where dep_from ='" . $_GET['from_dep'] . "' and str_code='" . $_GET['itemCode'] . "' and tmp_no='" . $_GET['tmpno'] . "' ";
    $result = $conn->query( $sql);

    $qty = str_replace(",", "", $_GET["qty"]);

   
   
	$sql = "Insert into tmp_gin_data_multi (dep_from,str_invno, str_code, str_description, cur_qty, tmp_no, user_id)values 
			('".$_GET['from_dep']."','".$_GET['invno']."', '".$_GET['itemCode']."', '".$_GET['itemDesc']."', ".$qty.", '".$_GET["tmpno"] ."', '".$_SESSION["CURRENT_USER"]."') ";								
    $result = $conn->query($sql);
    if (!$result) {
        echo $sql . "<br>";
        echo mysqli_error($GLOBALS['dbinv']);
    }

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
					<tr>
						<td style=\"width: 90px;\">From Dep</td>
						<td style=\"width: 40px;\">Item</td>
						<td style=\"width: 220px;\">Description</td>
						<td style=\"width: 50px;\">Qty</td>
						<td style=\"width: 10px;\"></td>
					</tr>";

    $i = 1;
    $sql = "Select * from view_tmp_gin where tmp_no='" . $_GET['tmpno'] . "'";
    $result = $conn->query($sql);
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>                              
                         <td>" . $row['dep_from'] . " "  .  $row['DESCRIPTION']  . "</td>
                         <td>" . $row['str_code'] . "</td>
                         <td>" . $row['str_description'] . "</td>
                         <td>" . number_format($row['cur_qty'], 0, ".", ",") . "</td>
                         <td><a class=\"btn btn-danger btn-sm\" onClick=\"del_item('" . $row['id'] . "')\"> <span class='fa fa-remove'></span></a></td>
                         </tr>";
        $i = $i + 1;
		
    }

    $ResponseXML .= "</table>]]></sales_table>";
    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>"; 
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "del_item") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql = "delete from tmp_gin_data_multi where id='" . $_GET['code'] . "' and tmp_no='" . $_GET['tmpno'] . "'";
    $result = $conn->query($sql);

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
					<tr>
						<td style=\"width: 90px;\">From Dep</td>
						<td style=\"width: 40px;\">Item</td>
						<td style=\"width: 220px;\">Description</td>
						<td style=\"width: 50px;\">Qty</td>
						<td style=\"width: 10px;\"></td>
					</tr>";

    $i = 1;
    $sql = "Select * from view_tmp_gin where tmp_no='" . $_GET['tmpno'] . "'";
    $result = $conn->query( $sql);
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>                              
                         <td>" . $row['dep_from'] . " "  .  $row['DESCRIPTION']  . "</td>
                         <td>" . $row['str_code'] . "</td>
                         <td>" . $row['str_description'] . "</td>
                         <td>" . number_format($row['cur_qty'], 0, ".", ",") . "</td>
                         <td><a class=\"btn btn-danger btn-sm\" onClick=\"del_item('" . $row['id'] . "')\"> <span class='fa fa-remove'></span></a></td>
                         </tr>";
        $i = $i + 1;
		
    }

    $ResponseXML .= "</table>]]></sales_table>";

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";

 
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "save_item") {


    if ($_GET["invno"] == "") {
        exit("Error");
    }
	
	$sql = "select * from ledger where l_refno = '"  . $_GET["invno"]  . "' and l_flag1 = 'DEB'";
	$result = $conn->query($sql);
	if (!$row = $result->fetch()) {
		 exit("Error1");
	} else {
		$mflag = $row['l_flag'];
		$chno = $row['chno'];
		$comcode = $row['comcode'];
		
		if (trim($row['l_flag2']=="1")) {
			exit("Error2");			
		}		
	}
	
	$sql = "delete from ledger where l_refno = '" . $_GET["invno"]  .  "'";
	$result = $conn->query($sql);
	
	
	try {
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();
		
		
			$i = 1;
             
            $count = $_GET['tb_deb'];
			
            while ($_GET["tb_deb"] > $i) {
                
				$l_code_d = "l_code_d" . $i;
                $l_amount_d = "l_amount_d" . $i;
				
				if (isset($_GET[$l_code_d])) {
				
				$sql = "insert into ledger (l_refno,l_code,l_amount,l_date,l_lmem,l_flag,l_flag1,l_flag2,l_flag3,comcode,chno) values 
				('" . $_GET['invno'] . "','" . $_GET[$l_code_d] . "','" . $_GET[$l_amount_d] . "','" . $_GET['sdate'] . "','" . $_GET['l_lmem'] . "','" . $mflag . "','DEB','0','R','" . $comcode . "','" . $chno . "') ";
				$result = $conn->query($sql);
				
				
			}
				$i=$i+1;
				
			}
				
			
			$i = 1;
             
            $count = $_GET['tb_cre'];
            while ($_GET["tb_cre"] > $i) {
                
				$l_code_c = "l_code_c" . $i;
                $l_amount_c = "l_amount_c" . $i;
				
				if (isset($_GET[$l_code_c])) {
				
				$sql = "insert into ledger (l_refno,l_code,l_amount,l_date,l_lmem,l_flag,l_flag1,l_flag2,l_flag3,comcode,chno) values 
				('" . $_GET['invno'] . "','" . $_GET[$l_code_c] . "','" . $_GET[$l_amount_c] . "','" . $_GET['sdate'] . "','" . $_GET['l_lmem'] . "','" . $mflag . "','CRE','0','R','" . $comcode . "','" . $chno . "') ";
				$result = $conn->query($sql);
				
				}
				$i= $i+1;
			}	
	  
        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}


if ($_GET["Command"] == "del_inv") {

	exit();
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sql = "select REF_NO,cancel from s_ginmas where tmp_no ='" . $_GET['tmpno'] . "'";
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {
            if ($row['cancel'] != "0") {
                echo "Not Found";
                exit();
            } else {

			
				$sql = "select REF_NO , dep_to from s_ginmas where tmp_no ='" . $_GET['tmpno'] . "'";
				foreach ($conn->query($sql) as $row1) {
				
				$sql = "select * from s_trn where REFNO='" . $row1["REF_NO"] . "' and LEDINDI='GINR'";
    
				 
				foreach ($conn->query($sql) as $row) {	
					$sql1 = "update s_submas set QTYINHAND=QTYINHAND-" . $row["QTY"] . " where STK_NO='" . $row["STK_NO"] . "' and STO_CODE='" . $row["DEPARTMENT"] . "'";        
					$result1 = $conn->query($sql1);
				}
				
				
				$sql = "select * from s_trn where REFNO='" . $row1["REF_NO"] . "' and LEDINDI='GINI'";
     
				foreach ($conn->query($sql) as $row) {	
					$sql1 = "update s_submas set QTYINHAND=QTYINHAND+" . $row["QTY"] . " where STK_NO='" . $row["STK_NO"] . "' and STO_CODE='" . $row["DEPARTMENT"] . "'";         
					$result1 = $conn->query($sql1);
				}
				
				$sql1 = "delete from s_trn where REFNO='" . $row1["REF_NO"] . "'"; 	
				$result1 = $conn->query($sql1);	
				
				}
				
				$sql1 = "delete from s_ginmas where ref_no ='" . $row1["REF_NO"] . "'";
				$result1 = $conn->query($sql1);
				
				
				echo "ok";
				
                $conn->commit();
            }
        } else {
            echo "Entry Not Found";
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}






if($_GET["Command"]=="gin")
		{
		
			//$department=$_GET["department"];
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
			 
			
			$sql="select * from ledger  where l_refno='".$_GET['invno']."'  and l_flag1 = 'DEB'";
			
			$tb = "<table class=\"table\">";	
			$tb .= "<tr><td>Code</td><td>Amount</td></tr>";
			$i =1;	
			foreach ($conn->query($sql) as $row) {
				 
				$l_refno = $row['l_refno'];
				$l_date = $row['l_date'];
				$l_lmem = $row['l_lmem'];
				
				$l_code_d = "l_code_d" . $i;
				$l_amount_d = "l_amount_d" . $i;
				
				$tb .=  "<tr>";
				$tb .=  "<td><input type = 'text' id ='" . $l_code_d . "' value='" . $row['l_code'] . "'></td>";
				$tb .=  "<td><input type = 'text' id ='" . $l_amount_d . "' value='" . $row['l_amount'] . "'></td>";				 
				$tb .=  "</tr>";
				$i =$i+1;								
			}
			$tb .= "</table>";
			
			$ResponseXML .= "<tb_deb><![CDATA[" . $tb . "]]></tb_deb>";
			$ResponseXML .= "<count_d><![CDATA[" . $i . "]]></count_d>";

			$sql="select * from ledger  where l_refno='".$_GET['invno']."'  and l_flag1 = 'CRE'";
			
			$tb1 .= "<table class=\"table\">";	
			$tb1 .= "<tr><td>Code</td><td>Amount</td></tr>";
			$i =1;	
			foreach ($conn->query($sql) as $row) {
				 
				$l_refno = $row['l_refno'];
				$l_date = $row['l_date'];
				$l_lmem = $row['l_lmem'];
				
				$l_code_c = "l_code_c" . $i;
				$l_amount_c = "l_amount_c" . $i;
				
				$tb1 .=  "<tr>";
				$tb1 .=  "<td><input type = 'text' id ='" . $l_code_c . "' value='" . $row['l_code'] . "'></td>";
				$tb1 .=  "<td><input type = 'text' id ='" . $l_amount_c . "' value='" . $row['l_amount'] . "'></td>";				 
				$tb1 .=  "</tr>";
				$i =$i+1;								
			}
			$tb1 .= "</table>";
			
			$ResponseXML .= "<l_refno><![CDATA[" . $l_refno . "]]></l_refno>";
			$ResponseXML .= "<l_date><![CDATA[" . $l_date . "]]></l_date>";
			$ResponseXML .= "<l_lmem><![CDATA[" . $l_lmem . "]]></l_lmem>";
			
			$ResponseXML .= "<tb_cre><![CDATA[" . $tb1 . "]]></tb_cre>";
			$ResponseXML .= "<count_c><![CDATA[" . $i . "]]></count_c>";

			$ResponseXML .= " </salesdetails>";
			echo $ResponseXML;
			
				
			}
			
			
			
 
			
		
	

?>