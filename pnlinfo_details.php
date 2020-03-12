<?php
require_once("config.inc.php");
require_once("DBConnector.php");


$db = new DBConnector();
?>	


 
<link rel="stylesheet" href="css/table.css" type="text/css"/>	
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>

<script type="text/javascript" language="javascript" src="js/get_cat_description.js"></script>
<script type="text/javascript" language="javascript" src="js/datepickr.js"></script>

<script language="javascript" src="cal2.js">
    /*
     Xin's Popup calendar script-  Xin Yang (http://www.yxscripts.com/)
     Script featured on/available at http://www.dynamicdrive.com/
     This notice must stay intact for use
     */
</script>
<script language="javascript" src="cal_conf2.js"></script>
<script language="javascript" type="text/javascript">
<!--
    /****************************************************
     Author: Eric King
     Url: http://redrival.com/eak/index.shtml
     This script is free to use as long as this info is left in
     Featured on Dynamic Drive script library (http://www.dynamicdrive.com)
     ****************************************************/
    var win = null;
    function NewWindow(mypage, myname, w, h, scroll, pos) {
        if (pos == "random") {
            LeftPosition = (screen.width) ? Math.floor(Math.random() * (screen.width - w)) : 100;
            TopPosition = (screen.height) ? Math.floor(Math.random() * ((screen.height - h) - 75)) : 100;
        }
        if (pos == "center") {
            LeftPosition = (screen.width) ? (screen.width - w) / 2 : 100;
            TopPosition = (screen.height) ? (screen.height - h) / 2 : 100;
        } else if ((pos != "center" && pos != "random") || pos == null) {
            LeftPosition = 0;
            TopPosition = 20
        }
        settings = 'width=' + w + ',height=' + h + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=' + scroll + ',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
        win = window.open(mypage, myname, settings);
    }
// -->
</script>

<script type="text/javascript">
    function openWin()
    {
        myWindow = window.open('serach_inv.php', '', 'width=200,height=100');
        myWindow.focus();

    }
</script>

<script type="text/javascript">
    window.onload = function () {
        new JsDatePick({
            useMode: 2,
            target: "dte_shedule",
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


<!-- Dynamic List area -->

<script type="text/javascript" src="ajax-dynamic-list.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="ajax.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="js/pnlinfo.js"></script>






<style type="text/css">
    /* Big box with list of options */
    #ajax_listOfOptions{
        position:absolute;	/* Never change this one */
        width:175px;	/* Width of box */
        height:250px;	/* Height of box */
        overflow:auto;	/* Scrolling features */
        border:1px solid #317082;	/* Dark green border */
        background-color:#FFF;	/* White background color */
        text-align:left;
        font-size:0.9em;
        z-index:100;
    }
    #ajax_listOfOptions div{	/* General rule for both .optionDiv and .optionDivSelected */
        margin:1px;		
        padding:1px;
        cursor:pointer;
        font-size:0.9em;
    }
    #ajax_listOfOptions .optionDiv{	/* Div for each item in list */

    }
    #ajax_listOfOptions .optionDivSelected{ /* Selected item in the list */
        background-color:#317082;
        color:#FFF;
    }
    #ajax_listOfOptions_iframe{
        background-color:#F00;
        position:absolute;
        z-index:5;
    }

    form{
        display:inline;
    }

    #article {font: 12pt Verdana, geneva, arial, sans-serif;  background: white; color: black; padding: 10pt 15pt 0 5pt}
    .style1 {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-weight: bold;
    }
</style>   

<script type="text/javascript">
    function load_calader(tar) {
        new JsDatePick({
            useMode: 2,
            target: tar,
            dateFormat: "%Y-%m-%d"

        });

    }

</script>
<!-- End of Dynamic list area -->
</label>

<style type="text/css">
    <!--
    .style1 {font-weight: bold}
    -->
</style>
<fieldset>
    <legend>
        <div class="text_forheader"></div>
    </legend>             

    <form name="form1" method="POST" action="print_notes.php" target="_blank" id="form1">            
        <input type='hidden'  id='count' name='count' value='' />

        <table  border="0"  class=\"form-matrix-table\">

            <tr>
                <td><input type="text" class="label_purchase" value="Date" disabled="disabled"/></td>
                <td><input type="text" class="text_purchase3"  id="dtfrom" name="dtfrom" onfocus="load_calader('dtfrom');" value="<?php echo date("Y-m-d"); ?>"/></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td><input type="text" class="label_purchase"  value="Note" disabled="disabled"/></td>
                <td colspan='4'>
                    <select id="row" onclick="loadnt();" name="row">
                        <?php
                        $sql = "select * from lcodes where code1 <> ''";
                        $result = $db->RunQuery($sql);
                        while ($row = mysql_fetch_array($result)) {
                            echo "<option value='" . $row['c_code'] . "'>" . $row['c_name'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td><input type="text" class="label_purchase"  value="Value" disabled="disabled"/></td>
                <td colspan='4'>
                    <input type="text" class="text_purchase3"  id="txt_bal" name="txt_bal"/>
                </td>
            </tr>
            
            <tr>
                <td></td>
                <td colspan='4'>
                    <div id='loadnt' class='CSSTableGenerator loadnt'>

                    </div>
                </td>
            </tr>
                         
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

        </table>



        <fieldset>               


    </form>        


