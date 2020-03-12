
<style type="text/css">
#display_selected a {
	color:#000;
}

#display_notSelected a{
	color:#fff;
}




</style>
<?php
require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
?>
<script src="js/user.js"></script>
<div id="menus_wrapper">
				
				
				
				
				
				<div id="main_menu">
					<ul>
										<li><a href="home.php"><span><span>Home</span></span></a></li>
                        <?php
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Maintenance' and doc_view=1";
						$result =$db->RunQuery($sql);	
						
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"masterfiles_acc.php\"  ><span><span>Maintenance</span></span></a></li>";
						}
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Task' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
                        	echo "<li><a href=\"datacapture_acc.php\"><span><span>Task</span></span></a></li>";
						}	
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Final Account' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"#\"><span><span>Final Account</span></span></a></li>";
						}	
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Reports' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"reports.php\" class=\"selected\"><span><span>Reports</span></span></a></li>";
						}	
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Administration' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"administration.php\"><span><span>Administration</span></span></a></li>";
						}
						
						?>	
                        <li class="last" onclick="logout();"><a href="#"><span><span>Logout</span></span></a></li>
					</ul>
				</div>
				
				
				
				<div id="sec_menu">
					<ul>
                    	<?php
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Cheque Report' and grp='Reports' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"rep_chq_acc.php\" target=\"_blank\" class=\"sm1\" >Cheque Report</a></li>";
							echo "<li><a href=\"rep_reciepts.php\" target=\"_blank\" class=\"sm1\" >Deposit Report</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='VAT Schedule' and grp='Reports' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){	
							echo "<li><a href=\"rep_vat_acc.php\" target=\"_blank\" class=\"sm2\" >VAT Schedule</a></li>";
						}	
                        
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Journal Report' and grp='Reports' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){	
							echo "<li><a href=\"rep_jou_acc.php\" target=\"_blank\" class=\"sm2\" >Journal Report</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Cheque Details' and grp='Reports' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){	
							echo "<li><a href=\"gin.php\" target=\"_blank\" class=\"sm2\" >Cheque Details</a></li>";
						}	
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Detail Trial Balance' and grp='Reports' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"rep_trialbal_acc.php\" target=\"_blank\" class=\"sm4\">Detail Trial Balance</a></li>";
						}	
						
						
						
						
                       ?>
					<!--	<li>
							<span class="drop"><span><span><a href="#" class="sm8">More</a></span></span></span>
							<ul>
                            	<?php
								
							//	$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Direct Deposit' and grp='Task' and doc_view=1";
							///	$result =$db->RunQuery($sql);	
							//	if ($row = mysql_fetch_array($result)){	
                        	//		echo "<li><a href=\"advance_payment.php\" target=\"_blank\" class=\"sm7\">Direct Deposit</a></li>";
							//	}	
						
								
								
								?>	
							</ul>
						</li>-->
					</ul>
				</div>
			</div>