
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
                echo "<li><a href=\"reports.php\" ><span><span>Reports</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Final Account' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"final_report.php\" class=\"selected\"><span><span>Final Reports</span></span></a></li>";
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
            <?php
           

            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='PNL Setup' and grp='Task' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"final_account.php\" target=\"_blank\" class=\"sm7\">PNL Setup</a></li>";
				echo "<li><a href=\"pnlinfo.php\" target=\"_blank\" class=\"sm7\">PNL Manual Setup</a></li>";
            }
            
            
             $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Cheque Report' and grp='Reports' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"notes.php\" target=\"_blank\" class=\"sm1\" >Notes P</a></li>";
            }
            
            
             $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Cheque Report' and grp='Reports' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"final_account_bs.php\" target=\"_blank\" class=\"sm1\" >Balance Sheet</a></li>";
            }
            
             $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Cheque Report' and grp='Reports' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"notes_bs.php\" target=\"_blank\" class=\"sm1\" >Notes B</a></li>";
            }
            ?>



        </ul>
    </div>
</div>