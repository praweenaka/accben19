<?php
require_once("config.inc.php");
require_once("DBConnector.php");

$sql = "delete FROM TMP_EDU_FILTER";
$db = new DBConnector();
$result = $db->RunQuery($sql);

$sql = "delete FROM	TMP_QUALI_FILTER";
$db = new DBConnector();
$result = $db->RunQuery($sql);
?>	






<link rel="stylesheet" href="css/table.css" type="text/css"/>	
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>

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
        }
        else if ((pos != "center" && pos != "random") || pos == null) {
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
    function load_calader(tar) {
        new JsDatePick({
            useMode: 2,
            target: tar,
            dateFormat: "%Y-%m-%d"

        });

    }

</script>
   <table  border="0"  class=\"form-matrix-table\">
<tr>
                <td><input type="text" class="label_purchase" value="Date From" disabled="disabled"/></td>
                <td><input type="text" class="text_purchase3"  id="dtfrom" name="dtfrom" onfocus="load_calader('dtfrom');" value="<?php echo date("Y-m-d"); ?>"/></td>


                <td><input type="text" class="label_purchase" value="Date To" disabled="disabled"/></td>
                <td><input type="text" class="text_purchase3"  id="dtto" name="dtto" onfocus="load_calader('dtto');" value="<?php echo date("Y-m-d"); ?>"/></td>
                <td></td>
            </tr>

            <tr>
                <td><input type="text" class="label_purchase" value="Type" disabled="disabled"/>    </td>
                <td> <select id='type' name='type'>
                        <option value='date'>Date</option>
                        <option value='monthly'>Monthly</option>
                    </select>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr> </table>
<fieldset>
    <legend>

    </legend>             

    <form name="form1" id="form1">            
        <table width="100%" border="1" cellpadding="0" cellspacing="0"  class="CSSTableGenerator">
            <tr>
                <td width="2%"><span class="style1">
                        <input type="text"  class="label_purchase" value="No" disabled="disabled" align="middle"/>
                    </span></td>
                <td width="20%"><span class="style1">
                        <input type="text"  class="label_purchase" value="1" disabled="disabled" align="middle"/>
                    </span></td>
                <td width="20%"><span class="style1">
                        <input type="text"  class="label_purchase" value="2" disabled="disabled" align="middle"/>
                    </span></td>
                <td width="23%"><span class="style1">
                        <input type="text"  class="label_purchase" value="3" disabled="disabled" align="middle"/>
                    </span></td>
                <td width="20%"><span class="style1">
                        <input type="text"  class="label_purchase" value="4" disabled="disabled" align="middle"/>
                    </span></td>
                <td width="20%"><span class="style1">
                        <input type="text"  class="label_purchase" value="5" disabled="disabled" align="middle" />
                    </span></td>

            </tr>
            <?php
            include('connection.php');

            $i = 1;
            while ($i < 50) {
                echo "<tr><td>" . $i . "</td>";
                $j = 1;
                while ($j < 6) {

                    $cell_content = "";

                    $sql = "select * from acc_cel_cal where mrow=" . $i . " and mcol=" . $j . " and cell_type='text'";
                    $result = mysql_query($sql, $dbacc);
                    if ($row = mysql_fetch_array($result)) {
                        $cell_content = $row["description"];
                    }

                    $sql = "select * from acc_cel_cal where mrow=" . $i . " and mcol=" . $j . " and cell_type='acc'";
                    $result = mysql_query($sql, $dbacc);
                    if ($row = mysql_fetch_array($result)) {
                        $sql1 = "select * from acc_account_data where mrow=" . $i . " and mcol=" . $j . " ";
                        $result1 = mysql_query($sql1, $dbacc);
                        while ($row1 = mysql_fetch_array($result1)) {
                            $cell_content .= $row1["acc_code"] . " / ";
                        }
                    }

                    $sql = "select * from acc_cel_cal where mrow=" . $i . " and mcol=" . $j . " and cell_type='opr'";
                    $result = mysql_query($sql, $dbacc);
                    if ($row = mysql_fetch_array($result)) {
                        if (trim($row["opr"]) == "+") {

                            $cell_content = "SUM(" . $row["mrow1"] . ", " . $row["mcol1"] . " : " . $row["mrow2"] . ", " . $row["mcol2"] . ") + SUM(" . $row["mrow3"] . ", " . $row["mcol3"] . " : " . $row["mrow4"] . ", " . $row["mcol4"] . ")";
                        } else {
                            $cell_content = "SUM(" . $row["mrow1"] . ", " . $row["mcol1"] . " : " . $row["mrow2"] . ", " . $row["mcol2"] . ") - SUM(" . $row["mrow3"] . ", " . $row["mcol3"] . " : " . $row["mrow4"] . ", " . $row["mcol4"] . ")";
                        }
                    }

                    if ($cell_content == "") {
                        $cell_content = "&nbsp;";
                    }

                    echo "<td width=\"20%\" ><div id=\"td_" . $i . "_" . $j . "\"  onclick=\"view_frame($i, $j);\">" . $cell_content . "</div>";
                    //<input type=\"text\"  class=\"text_purchase3\" name=\"c".$i."_".$j."\"/>
                    echo "</td>";



                    $j = $j + 1;
                }
                echo "</tr>";
                $i = $i + 1;
            }


            /* 	while ($i<50){


              echo " <tr>";

              $j=1;
              while ($j<6){
              echo "<td><a onClick=\"NewWindow('search_ledger_acc_final.php','mywin','800','700','yes','center');return false\" onFocus=\"this.blur()\"><input type=\"button\" name=\"searchacc_".$i."_".$j."\" id=\"searchacc_".$i."_".$j."\" value=\"Acc\" class=\"btn_purchase\" /></a><input type=\"text\" name=\"cell_".$i."_".$j."\" id=\"cell_".$i."_".$j."\" value=\"\" class=\"text_purchase2\" /><input type=\"button\" name=\"searchcal_".$i."_".$j."\" id=\"searchcal_".$i."_".$j."\" value=\"Cal\" class=\"btn_purchase\" /></td>";
              $j=$j+1;
              }

              echo "</tr>";
              $i=$i+1;
              } */
            ?>  
        </table>


        <br/>   
        <div id="set_acc_frame" style="left:35px; top:170px; position:absolute; background-color:#999; padding:10px; width: 600px; height: 800px; visibility:visible;overflow:scroll;"> 
            <p><a onClick="NewWindow('search_ledger_acc_final.php', 'mywin', '800', '700', 'yes', 'center');
            return false" onFocus="this.blur()"></a>
                <input type="radio" name="radio" id="descr" value="radio" checked="checked" onclick="dis_val();" />
                Text <br />
                <input type="radio" name="radio" id="coll_acc" value="radio" onclick="dis_val();"/>
                Collection Of Accounts Values<br />
                <input type="radio" name="radio" id="calc_cell_r" value="radio" onclick="dis_val();"/>
                Calculation Of Cell
            </p>
            <p><a onclick="NewWindow('search_ledger_acc_final.php', 'mywin', '800', '700', 'yes', 'center');
            return false" onfocus="this.blur()"></a>
                <input type="text" name="sheet_desc" id="sheet_desc" size="50" />
            </p>
            <p><a onclick="NewWindow('search_ledger_acc_final.php?stname=final_acc', 'mywin', '800', '700', 'yes', 'center');
            return false" onfocus="this.blur()">
                    <input type="button" name="searchacc" id="searchacc" value="Sel Acc" class="btn_purchase" />
                </a>
                <input type="button" name="viewacc" id="viewacc"  value="View Acc" class="btn_purchase" onclick="save_mettrix();"/>


            <div id="calc_cell">
                <table width="221" border="0">
                    <tr>
                        <td width="37">Row1</td>
                        <td width="30"><input type="text" name="row1" id="row1" size="5" /></td>
                        <td width="30">Col1</td>
                        <td width="30"><input type="text" name="col1" id="col1" size="5" /></td>
                        <td width="15">&nbsp;</td>
                        <td width="19">&nbsp;</td>
                        <td width="30">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Row2</td>
                        <td><input type="text" name="row2" id="row2" size="5" /></td>
                        <td>Col2</td>
                        <td><input type="text" name="col2" id="col2" size="5" /></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4"><hr></td>
                        <td><div id="lblopr2">+/-</div></td>
                        <td><input type="text" name="opr" id="opr" size="5" /></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><div id="lblrow3">Row3</div></td>
                        <td><input type="text" name="row3" id="row3" size="5" /></td>
                        <td><div id="lblcol3">Col3</div></td>
                        <td><input type="text" name="col3" id="col3" size="5" /></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><div id="lblrow">Row4</div></td>
                        <td><input type="text" name="row4" id="row4" size="5" /></td>
                        <td><div id="lblrow4">Col4</div></td>
                        <td><input type="text" name="col4" id="col4" size="5" /></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
                <a onclick="NewWindow('search_ledger_acc_final.php', 'mywin', '800', '700', 'yes', 'center');
        return false" onfocus="this.blur()"></a><a onclick="NewWindow('search_ledger_acc_final.php', 'mywin', '800', '700', 'yes', 'center');
                return false" onfocus="this.blur()"></a>    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            </p>
            Description <input type="text" name="txt_acc" id="txt_acc" size="30" value="" /> Value <input type="text" name="val_acc" id="val_acc" size="20" value="" /><br>
            Add/Less <input type="text" name="opr_acc" id="opr_acc" size="5" value="+" />
            <div id="acc_table">
                <table width="415" border="1">
                    <tr>
                        <th width="92">Acc Code</th>
                        <th width="307">Acc Name</th>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>


            </div>
            <br>
            Add/Less <input type="text" name="opr_acc_last" id="opr_acc_last" size="5" value="+" /><br>
            Description <input type="text" name="txt_acc_last" id="txt_acc_last" size="30" value="" /> Value <input type="text" name="val_acc_last" id="val_acc_last" size="20" value="" />
            <br>
            <p>
                <input type="button" name="cmdsave" id="cmdsave" value="Save" class="btn_purchase" onclick="save_mettrix();" />
                <input type="button" name="cmdhide" id="cmdhide" value="Hide" class="btn_purchase" onclick="hide_frame();" />
                <input type="button" name="cmdhide" id="cmdpintn" value="Print Note" class="btn_purchase" onclick="print_notes();" />
            </p>
        </div>


        <fieldset>               


    </form>        

</fieldset>    

<table width="765" border="0" cellpadding="0">
    <tr>
        <th height="189" colspan="5" align="left" nowrap="nowrap">
    <div align="left">
        <script>
            hide_frame();
        </script>                                   
