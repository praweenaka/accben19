<?php session_start();
	
	
	$UserName=$_GET["UserName"];
	$Password=$_GET["Password"];
	$Command=$_GET["Command"];
	
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
if($Command=="CheckUsers")

	{	
	
	
	//$connection = mysql_connect("localhost","root", "");
	//$db = "login";
	//mysql_select_db($db, $connection) or die( "Could not open $db database");

	
					//$UserName = mysql_real_escape_string($UserName);
				//	$Password = mysql_real_escape_string($Password);
					
					
					
				
					
					
					
					$sql="SELECT * FROM user_mast WHERE user_name =  '".$UserName."' AND user_pass =  '".md5($Password)."' ";
					
					$result =$db->RunQuery($sql);
									
					if($row = mysql_fetch_array($result))
					  {
						
						$sessionId = session_id(  );
						$_SESSION['sessionId']=session_id(  );
						session_regenerate_id();
						$ip=$_SERVER['REMOTE_ADDR'];
						$_SESSION['UserName']=$UserName;
						$_SESSION['User_Type']=$row['user_level'];
						$_SESSION['dev']=$row['dev'];
						//$_SESSION['company']="EF";
						//$_SESSION['company']="TH";
						$_SESSION['company']="BE";
						
						//if (($_SERVER['REMOTE_ADDR']=="113.59.211.14") or ($_SERVER['REMOTE_ADDR']=="112.135.99.115") or ($_SERVER['REMOTE_ADDR']=="124.43.128.214")){
							echo "ok";
					//	} else {
					//		echo "Invalied Connection";
					//	}	
						
						$time_now=mktime(date('h')+5,date('i')+30,date('s'));
						$time=date('h:i:s',$time_now);
						$today = date('Y-m-d');
						
						$sql1="Insert into loging(Name,User_Type,Date,Logon_Time,Sessioan_Id,ip) values ('".$UserName."','".$row['User_Type']."','".$today."','".$time."','".$_SESSION['sessionId']."','".$ip."')";
						$result1 =$db->RunQuery($sql1);
												
						
						
						}	
					
					
					
					
	}

			
			
			

else if($Command=="logout")
	{
		
		
	//$connection = mysql_connect("localhost","weldb", "uY4xjyHNur7JYNGj");
	//$db = "welfare1";
	//mysql_select_db($db, $connection) or die( "Could not open $db database");
		
		
		
		//$_SESSION['int_User_ID']=$int_User_ID;
		echo $_SESSION['sessionId'];
		
		$time_now=mktime(date('h')+5,date('i')+30,date('s'));
		$time=date('h:i:s',$time_now);
		$today = date('Y-m-d');
		
		
		$sql="UPDATE loging
			  SET Logout_Time='".$time."'
			  WHERE Sessioan_Id='".$_SESSION['sessionId']."'";
			  
			 
			  $result =$db->RunQuery($sql);
			
			
			  $sqlDelete="Delete FROM active_users
			  where Sessioan_Id='".$_SESSION['sessionId']."'";
			  $resultDelete =$db->RunQuery($sqlDelete);
			  
			 
			
		session_unset();
		session_destroy();
			
} else if($Command=="lock_acc"){

	$sql="update lock_table set lock_date='".$_GET["Calendar1"]."'";
	$result =$db->RunQuery($sql);
	
	echo "Locked";

} else if($Command=="updated"){

	$sql="update dep_mas set   dateto='" . $_GET["DTTO"] . "', datefrom='" . $_GET["DTfrom"] . "', reccabook =" . $_GET["txtRECCABOOK"] . ", paycash=" . $_GET["txtcashpay"] . ", paycheq=" . $_GET["txtchqPay"] . ",bankdep=" . $_GET["txtdep"] . ", ledger=" . $_GET["txtJe"] . ", bankent=" . $_GET["txtBt"];
	
	$result =$db->RunQuery($sql);
	
	echo "Updated";

}








?>