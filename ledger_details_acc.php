
<?php 
/*if($_SESSION["login"]!="True")
{
	header('Location:./index.php');
}*/




/*if($_SESSION["login"]!="True")
{
	header('Location:./index.php');
}*/

	

						 
	require_once("config.inc.php");
	require_once("DBConnector.php");
						
	$sql = "delete FROM TMP_EDU_FILTER";
	$db = new DBConnector();
	$result =$db->RunQuery($sql);
						
	$sql = "delete FROM	TMP_QUALI_FILTER";
	$db = new DBConnector();
	$result =$db->RunQuery($sql);
	
	date_default_timezone_set('Asia/Colombo'); 
?>	

						 
	


<script language="JavaScript" src="js/pur_ord.js"></script>
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
var win=null;
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);}
// -->
</script>

<script type="text/javascript">
function openWin()
{
myWindow=window.open('serach_inv.php','','width=200,height=100');
myWindow.focus();

}
</script>

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"dte_shedule",
			dateFormat:"%Y-%m-%d"
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
function load_calader(tar){
		new JsDatePick({
			useMode:2,
			target:tar,
			dateFormat:"%Y-%m-%d"
			
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
  <div class="text_forheader">Enter Ledger Accounts Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="13%"><input type="text"  class="label_purchase" value="Account Code" disabled/></td>
    <td width="13%"><input type="text" name="txtAccCode" id="txtAccCode" value="" class="text_purchase" onKeyPress="keyset('txtDESCRIPTION', event);" onblur="itemno_ind(); "   />
      <a href="search_ledger_acc.php?stname=ledger_sel" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchinv2" id="searchinv2" value="..." class="btn_purchase1" >
      </a></td>
    <td width="6%">
    <input type="hidden" name="cmbLetter" id="cmbLetter" value="" class="text_purchase" onKeyPress="keyset('txtDESCRIPTION', event);" onblur="itemno_ind(); "   />
   </td>
    <td colspan="5"><input type="radio" name="acc_type" id="acc_type1" value="radio" checked="checked" />
      Elder<input type="radio" name="acc_type" id="acc_type2" value="radio"  />
      Parent <input type="radio" name="acc_type" id="acc_type3" value="radio" />
      Detail</td>
    <td width="2%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
    <td width="4%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Account Name" disabled/></td>
    <td colspan="3"><input id="txtAccName" name="txtAccName" type="text" onkeypress="keyset('txtGEN_NO',event);" class="text_purchase3" /></td>
    <td colspan="2">&nbsp;</td>
    <td width="13%"><input type="text"  class="label_purchase" value="Date From" disabled="disabled"/></td>
    <td width="15%"><input type="text" class="text_purchase3"  id="repdatefrom" name="repdatefrom" onfocus="load_calader('repdatefrom');" value="<?php echo date("Y-m-d"); ?>"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address" disabled="disabled"/></td>
    <td colspan="3"><input id="txtAdd1" name="txtAdd1" type="text" onkeypress="keyset('txtGEN_NO',event);" class="text_purchase3" /></td>
    <td colspan="2">&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Date To" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3"  id="repdateto" name="repdateto" onfocus="load_calader('repdateto');" value="<?php echo date("Y-m-d"); ?>"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><input id="txtAdd2" name="txtAdd2" type="text" onkeypress="keyset('txtGEN_NO',event);" class="text_purchase3" /></td>
    <td colspan="2"></td>
    <td>
      <input type="button" name="searchinv3" id="searchinv3" value="Print" class="btn_purchase1" onclick="show_ledger();" />    </td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td colspan="6"><fieldset>
        	<legend><strong>Account Type</strong></legend>
            
    
    
    <table border="0">
      <tr>
        <th width="139" scope="col"><input type="radio" name="radio" id="op_manu" value="op_manu" checked="checked" />
    Manufacturing</th>
        <th width="183" scope="col"><input type="radio" name="radio" id="optPLAcc" value="optPLAcc" />
    PNL Account</th>
        <th width="272" scope="col"><input type="radio" name="radio" id="optBal" value="optBal" />
    Balance Sheet Account</th>
      </tr>
    </table>
    </fieldset></td>
    <td colspan="2">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td colspan="3"><fieldset>
       	
           <input type="checkbox" name="Check1" id="Check1" /> Cash Book Account
    <input type="checkbox" name="Check2" id="Check2" />
    Bank Account
    </fieldset> </td>
    <td><input type="text" name="txtchqno" id="txtchqno" class="label_purchase" value="Cheque No" disabled="disabled"/></td>
    <td width="13%"><input type="text" class="text_purchase3"  id="chqno" name="chqno" /></td>
    <td width="5%"><input type="button" name="searchinv4" id="searchinv4" value="update" class="btn_purchase1" onclick="update_chq();" /></td>
    <td colspan="5"> </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="13%">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="11"><table width="954" border="0">
      <tr>
        <th width="16%" scope="col"><input type="text"  class="label_purchase" value="Opening Balance" disabled="disabled"/></th>
        <th width="17%" scope="col"><input type="text" class="text_purchase3"  id="txtOpenBal" name="txtOpenBal" onkeypress="keyset('txtMARGIN',event);" value="0"/></th>
        <th width="22%" scope="col"><input type="text"  class="label_purchase" value="Parent Account" disabled="disabled"/></th>
        <th width="16%" scope="col"><a href="search_ledger_acc.php?stname=ledger" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
          <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" />
        </a></th>
        <th width="16%" scope="col"><input type="text" class="text_purchase3"  id="txtLinkNo" name="txtLinkNo" onkeypress="keyset('txtSELLING',event);"/></th>
        <th width="13%" scope="col">&nbsp;</th>
      </tr>
      <tr>
        <th width="16%" scope="col"><input type="text"  class="label_purchase" value="Opening Date" disabled="disabled"/></th>
        <th scope="col"><input type="text" class="text_purchase3"  id="dtpOpenDate" name="dtpOpenDate" value="2015-04-01" onkeypress="keyset('txtSIZE',event);"  onfocus="load_calader('dtpOpenDate');"/></th>
        <th width="22%" scope="col">&nbsp;</th>
        <th scope="col"><input type="text" class="text_purchase3"  id="txtcode" name="txtcode" onkeypress="keyset('txtRE_O_LEVEL',event);"/></th>
        <th width="16%" scope="col">
        <?php
        if ($_SESSION['dev']=="1"){
        	echo "<input type=\"text\" class=\"text_purchase3\"  id=\"txtOpenBal1\" name=\"txtOpenBal1\" onkeypress=\"keyset('txtRE_O_qty',event);\"/>";
		} else {
			echo "<input type=\"hidden\" class=\"text_purchase3\"  id=\"txtOpenBal1\" name=\"txtOpenBal1\" onkeypress=\"keyset('txtRE_O_qty',event);\"/>";
		}	
		?>
			</th>
        <th scope="col">&nbsp;</th>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="11"><fieldset>
        	<legend><strong>Budget</strong></legend>
            
            <table width="1124" border="0">
              <tr>
                <td width="594" rowspan="2"><table border="0">
                  <tr>
                    <th width="144" scope="col"><input type="text"  class="label_purchase" value="January" disabled="disabled"/></th>
                    <th width="144" scope="col"><input type="text" class="text_purchase3"  id="jan" name="jan" value="0" onkeypress="keyset('txtSIZE',event);"/></th>
                    <th width="144" scope="col"><input type="text"  class="label_purchase" value="July" disabled="disabled"/></th>
                    <th width="144" scope="col"><input type="text" class="text_purchase3"  id="jul" name="jul" value="0" onkeypress="keyset('txtSIZE',event);"/></th>
                  </tr>
                  <tr>
                    <td><input type="text"  class="label_purchase" value="February" disabled="disabled"/></td>
                    <td><input type="text" class="text_purchase3"  id="feb" name="feb" value="0" onkeypress="keyset('txtSIZE',event);"/></td>
                    <td><input type="text"  class="label_purchase" value="Augest" disabled="disabled"/></td>
                    <td><input type="text" class="text_purchase3"  id="aug" name="aug" value="0" onkeypress="keyset('txtSIZE',event);"/></td>
                  </tr>
                  <tr>
                    <td><input type="text"  class="label_purchase" value="March" disabled="disabled"/></td>
                    <td><input type="text" class="text_purchase3"  id="mar" name="mar" value="0" onkeypress="keyset('txtSIZE',event);"/></td>
                    <td><input type="text"  class="label_purchase" value="September" disabled="disabled"/></td>
                    <td><input type="text" class="text_purchase3"  id="sep" name="sep" value="0" onkeypress="keyset('txtSIZE',event);"/></td>
                  </tr>
                  <tr>
                    <td><input type="text"  class="label_purchase" value="April" disabled="disabled"/></td>
                    <td><input type="text" class="text_purchase3"  id="apr" name="apr" value="0" onkeypress="keyset('txtSIZE',event);"/></td>
                    <td><input type="text"  class="label_purchase" value="October" disabled="disabled"/></td>
                    <td><input type="text" class="text_purchase3"  id="oct" name="oct" value="0" onkeypress="keyset('txtSIZE',event);"/></td>
                  </tr>
                  <tr>
                    <td><input type="text"  class="label_purchase" value="May" disabled="disabled"/></td>
                    <td><input type="text" class="text_purchase3"  id="may" name="may" value="0" onkeypress="keyset('txtSIZE',event);"/></td>
                    <td><input type="text"  class="label_purchase" value="November" disabled="disabled"/></td>
                    <td><input type="text" class="text_purchase3"  id="nov" name="nov" value="0" onkeypress="keyset('txtSIZE',event);"/></td>
                  </tr>
                  <tr>
                    <td><input type="text"  class="label_purchase" value="June" disabled="disabled"/></td>
                    <td><input type="text" class="text_purchase3"  id="jun" name="jun" value="0" onkeypress="keyset('txtSIZE',event);"/></td>
                    <td><input type="text"  class="label_purchase" value="December" disabled="disabled"/></td>
                    <td><input type="text" class="text_purchase3"  id="dec" name="dec" value="0" onkeypress="keyset('txtSIZE',event);"/></td>
                  </tr>
                                </table></td>
                <td><input type="text"  class="label_purchase" value="Comments" disabled="disabled"/></td>
              </tr>
              <tr>
                <td width="514"><textarea name="textcomments" id="textcomments" cols="60" rows="8"></textarea></td>
              </tr>
            </table>
    </fieldset></td>
    </tr>
  

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>

  
 
  <fieldset>               
            
 
</form>        

   
            
          