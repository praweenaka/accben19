
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
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>

<script type="text/javascript" language="javascript" src="js/get_cat_description.js"></script>
<script type="text/javascript" language="javascript" src="js/datepickr.js"></script>

<script src="js/user.js"></script>
<script type="text/javascript">
    function load_calader(tar) {
        new JsDatePick({
            useMode: 2,
            target: tar,
            dateFormat: "%Y-%m-%d"

        });

    }

</script>
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
                echo "<li><a href=\"administration.php\" class=\"selected\"><span><span>Administration</span></span></a></li>";
            }
            ?>	
            <li class="last" onclick="logout();"><a href="#"><span><span>Logout</span></span></a></li>
        </ul>
    </div>



    <div id="sec_menu">
        <ul>
            <?php
            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Create User' and grp='Administration' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"create_user.php\" target=\"_blank\" class=\"sm1\" >Create User</a></li>";
            }

            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Change Password' and grp='Administration' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"change_pass.php\" target=\"_blank\" class=\"sm1\" >Change Password</a></li>";
            }

            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Manage Permission' and grp='Administration' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"assign_privilages.php\" target=\"_blank\" class=\"sm1\" >Manage Permission</a></li>";
            }
            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Lock Cheque Activate' and grp='Administration' and doc_view=1";
//            echo $sql;
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"new/home.php?url=lock_release_chq\" target=\"_blank\" class=\"sm7\">Lock Cheque Activate</a></li>";
            }
            ?> 

        </ul>
    </div>
    <br />
    <?php
    $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Lock Amount' and grp='Administration' and doc_view=1";
    $result = $db->RunQuery($sql);
    if ($row = mysql_fetch_array($result)) {

        $sql_lock = "select  * from lock_table";
        $result_lock = $db->RunQuery($sql_lock);
        $row_lock = mysql_fetch_array($result_lock);


        $sql_dep = "select  * from dep_mas";
        $result_dep = $db->RunQuery($sql_dep);
        $row_dep = mysql_fetch_array($result_dep);

        $txtcashpay = $row_dep["paycash"];
        $txtchqPay = $row_dep["paycheq"];
        $txtdep = $row_dep["bankdep"];
        $txtJe = $row_dep["ledger"];
        $txtBt = $row_dep["bankent"];
        $txtRECCABOOK = $row_dep["recedirect"];
        if (is_null($row_dep["datefrom"]) == false) {
            $DTfrom = $row_dep["datefrom"];
        }
        if (is_null($row_dep["dateto"]) == false) {
            $DTTO = $row_dep["dateto"];
        }

        echo "<table width=\"470\" border=\"0\">
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
                    <td width=\"189\"><input type=\"text\"  class=\"label_purchase\" value=\"Lock Below \" disabled=\"disabled\"/></td>
      <td width=\"226\"><input type=\"text\" size=\"20\" name=\"Calendar1\" id=\"Calendar1\" value=\"" . date("Y-m-d", strtotime($row_lock["lock_date"])) . "\" class=\"text_purchase3\" onfocus=\"load_calader('Calendar1');\"/></td>
      <td width=\"41\"><input type=\"button\" name=\"button\" id=\"button\" value=\"Lock\" onclick=\"lock_acc();\"/></td>
    </tr>
	
	 <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
                    <td width=\"189\"><input type=\"text\"  class=\"label_purchase\" value=\"Cash Payment\" disabled=\"disabled\"/></td>
      <td width=\"226\"><input type=\"text\" size=\"20\" name=\"txtcashpay\" id=\"txtcashpay\" value=\"" . $txtcashpay . "\" class=\"text_purchase3\"/></td>
      <td width=\"41\"></td>
    </tr>
	
	 <tr>
                    <td width=\"189\"><input type=\"text\"  class=\"label_purchase\" value=\"Cheq.Payment\" disabled=\"disabled\"/></td>
      <td width=\"226\"><input type=\"text\" size=\"20\" name=\"txtchqPay\" id=\"txtchqPay\" value=\"" . $txtchqPay . "\" class=\"text_purchase3\" /></td>
      <td width=\"41\"></td>
    </tr>
	
	 <tr>
                    <td width=\"189\"><input type=\"text\"  class=\"label_purchase\" value=\"Deposits\" disabled=\"disabled\"/></td>
      <td width=\"226\"><input type=\"text\" size=\"20\" name=\"txtdep\" id=\"txtdep\" value=\"" . $txtdep . "\" class=\"text_purchase3\" /></td>
      <td width=\"41\"></td>
    </tr>
	
	 <tr>
                    <td width=\"189\"><input type=\"text\"  class=\"label_purchase\" value=\"J/Entries\" disabled=\"disabled\"/></td>
      <td width=\"226\"><input type=\"text\" size=\"20\" name=\"txtJe\" id=\"txtJe\" value=\"" . $txtJe . "\" class=\"text_purchase3\" /></td>
      <td width=\"41\"></td>
    </tr>
	
	 <tr>
                    <td width=\"189\"><input type=\"text\"  class=\"label_purchase\" value=\"Bank Transaction\" disabled=\"disabled\"/></td>
      <td width=\"226\"><input type=\"text\" size=\"20\" name=\"txtBt\" id=\"txtBt\" value=\"" . $txtBt . "\" class=\"text_purchase3\" /></td>
      <td width=\"41\"></td>
    </tr>
	
	 <tr>
                    <td width=\"189\"><input type=\"text\"  class=\"label_purchase\" value=\"Receipt Book\" disabled=\"disabled\"/></td>
      <td width=\"226\"><input type=\"text\" size=\"20\" name=\"txtRECCABOOK\" id=\"txtRECCABOOK\" value=\"" . $txtRECCABOOK . "\" class=\"text_purchase3\" /></td>
      <td width=\"41\"></td>
    </tr>
	
	 <tr>
                    <td width=\"189\"><input type=\"text\"  class=\"label_purchase\" value=\"Transaction Date From\" disabled=\"disabled\"/></td>
      <td width=\"226\"><input type=\"text\" size=\"20\" name=\"DTfrom\" id=\"DTfrom\" value=\"" . date("Y-m-d", strtotime($DTfrom)) . "\" class=\"text_purchase3\" onfocus=\"load_calader('DTfrom');\"/></td>
      <td width=\"41\"></td>
    </tr>
	
	 <tr>
                    <td width=\"189\"><input type=\"text\"  class=\"label_purchase\" value=\"Transaction Date To\" disabled=\"disabled\"/></td>
      <td width=\"226\"><input type=\"text\" size=\"20\" name=\"DTTO\" id=\"DTTO\" value=\"" . date("Y-m-d", strtotime($DTTO)) . "\" class=\"text_purchase3\" onfocus=\"load_calader('DTTO');\"/></td>
      <td width=\"41\"><input type=\"button\" name=\"button1\" id=\"button1\" value=\"Update\" onclick=\"updated();\"/></td>
    </tr>
                </table>";
    }
    ?>			
    <script type="text/javascript">
        window.onload = function() {
            new JsDatePick({
                useMode: 2,
                target: "DTinv_date",
                dateFormat: "%Y-%m-%d"
                        /*selectedDate:{				This is an example of what the full configuration offers.
                         day:5,						For full documentation about these settings please see the full version of the code.
                         month:9,
                         year:2006
                         },
                         yearsRange:[1978,2020],
                         limitToToday:false,
                         cellColorScheme:"beige",
                         dateFormat:"%m-%d-%Y",
                         imgPath:"img/",
                         weekStartDay:1*/
            });
        };
    </script>
    <br />
</div>

