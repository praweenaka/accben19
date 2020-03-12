
<?php 
session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	$sql="select * from tmp order by c_code";
	$result =$db->RunQuery($sql);
	while($row= mysql_fetch_array($result)){
		$sql1="update lcodes set c_opbal1='".$row["c_opbal1"]."' where  c_code='".$row["c_code"]."'";
		$result1 =$db->RunQuery($sql1);
	}
