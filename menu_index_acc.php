
<script src="js/user.js"></script>
<?php
require_once("config.inc.php");
require_once("DBConnector.php");
$db = new DBConnector();
?>
<div id="menus_wrapper">





    <div id="main_menu">
        <ul>
            <li><a href="home.php" class="selected"><span><span>Home</span></span></a></li>
            <?php
            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Maintenance' and doc_view=1";
            $result = $db->RunQuery($sql);

            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"masterfiles_acc.php\"  ><span><span>Maintenance</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Task' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"datacapture_acc.php\"><span><span>Task</span></span></a></li>";
            }
            

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Reports' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"reports.php\"><span><span>Reports</span></span></a></li>";
            }
            
             $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Final Account' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"final_report.php\"><span><span>Final Reports</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Administration' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"administration.php\"><span><span>Administration</span></span></a></li>";
            }
            ?>	
            <li class="last" onclick="logout();"><a href="#"><span><span>Logout</span></span></a></li>
        </ul>
    </div>



    <div id="sec_menu">
        <ul>
            <li></li>
            <li></li>
            <li><a href="#" class="sm3">&nbsp;</a></li>





        </ul>
    </div>
</div>