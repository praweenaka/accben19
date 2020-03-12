<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
$servername = 'localhost';
$username = 'root';
$password = '';
$port = 10060;
$dbname = 'swijesooriya_accben18';   //current year db


$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);


$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$dbname = 'swijesooriya_accben17';  //previous year db


$conn2 = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);


$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  try {


$conn->beginTransaction();


$sql = "select * from lcodes where Cat='B' "; //select all the banks
echo $sql;
foreach ($conn2->query($sql) as $row) {




//change date to current year 3/31/  'curreny year to delete all previous data if re - importing more than onces. (Chk if auto postings are there before deleteing - Cash TT)

$sql_d =  "delete from ledger where l_flag <>'OPB' and l_code = '" . trim($row['c_code']) . "' and l_date <='2018-03-31'";
echo $sql_d;
$conn->query($sql_d);


$sql_old = "select * from  LEDGER where l_code = '" . trim($row['c_code']) . "' AND (L_FLAG2 = '0') and l_amount >0 and l_flag <> 'OPB'";  

foreach ($conn2->query($sql_old) as $row_o) {


	$sql_insert = "insert into ledger (l_refno,l_code,l_date,L_LMEM,L_HEAD,l_amount,L_FLAG,L_Flag1,l_flag2,L_FLAG3,L_FLAG4,L_BCODE,L_TRTYPE,L_YEARFL,L_post,L_Bank
	,l_month,Rights,ComCode,chno,recDate,Status,AcYear,l_year,tmpREcDate,PdType) values (
	'" . $row_o['l_refno'] . "','" . $row_o['l_code'] . "','" . $row_o['l_date'] . "','" . $row_o['l_lmem'] . "','" . $row_o['l_head'] . "','" . $row_o['l_amount'] . "',
	'" . $row_o['l_flag'] . "','" . $row_o['l_flag1'] . "','" . $row_o['l_flag2'] . "','" . $row_o['l_flag3'] . "','" . $row_o['l_flag4'] . "','" . $row_o['l_bcode'] . "',
	'" . $row_o['l_trtype'] . "','1','" . $row_o['l_post'] . "','" . $row_o['l_bank'] . "','" . $row_o['l_month'] . "','" . $row_o['rights'] . "',
	'" . $row_o['comcode'] . "','" . $row_o['chno'] . "','" . $row_o['recdate'] . "','" . $row_o['status'] . "','" . $row_o['acyear'] . "',
	'" . $row_o['l_year'] . "','" . $row_o['tmprecdate'] . "','" . $row_o['pdtype'] . "')";
 
 $conn->query($sql_insert);
   
}

}
  $conn->commit();
    echo "Saved";
  } catch (Exception $e) {
    $conn->rollBack();
    echo $e;
  }
