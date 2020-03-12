
<style type="text/css">
#display_selected a {
	color:#000;
}

#display_notSelected a{
	color:#fff;
}
</style>
<script src="js/user.js"></script>
<?php
require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
?>
<div id="menus_wrapper">
				
				
				
				
				
				<div id="main_menu">
					<ul>
						<li><a href="home.php"><span><span>Home</span></span></a></li>
                        <?php
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Maintenance' and doc_view=1";
						$result =$db->RunQuery($sql);	
						
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"masterfiles_acc.php\" class=\"selected\" ><span><span>Maintenance</span></span></a></li>";
						}
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Task' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
                        	echo "<li><a href=\"datacapture_acc.php\"><span><span>Task</span></span></a></li>";
						}	
						 
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Reports' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"reports.php\"><span><span>Reports</span></span></a></li>";
						}	
						
						$sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Final Account' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"final_report.php\"><span><span>Final Reports</span></span></a></li>";
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
                    	$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Ledger Accounts' and grp='Maintenance' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"ledger_acc.php\" target=\"_blank\" class=\"sm1\" >Ledger Accounts</a></li>";
						}	
						
                       ?>
                       
					</ul>
				</div>
			</div>