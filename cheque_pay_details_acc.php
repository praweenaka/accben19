
<?php 
/*if($_SESSION["login"]!="True")
{
	header('Location:./index.php');
}*/




/*if($_SESSION["login"]!="True")
{
	header('Location:./index.php');
}*/

	

						 
	include_once("connection.php");
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
function load_calader(tar){
		new JsDatePick({
			useMode:2,
			target:tar,
			dateFormat:"%Y-%m-%d"
			
		});
		
	}

</script>

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"DTinv_date",
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

</label>
          
<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {color: #FF0000; font-size: 36px; }
.style3 {
	font-size: 16px;
	font-weight: bold;
	color: #FF0000;
}
-->
</style>
<fieldset>
                                                	<legend>
  <div class="text_forheader">Enter Cheque Pay Details</div>
                                               	 </legend>
                                               	 <form name="form1" id="form1" target="_blank" method="get" action="disp_chq.php">            
  <table width="1200" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="12%"><input type="hidden" name="hiddencount" id="hiddencount" /></td>
    <td width="18%">&nbsp;</td>
    <td colspan="2"><input type="hidden" name="chkprint" id="chkprint" value="0" /></td>
    <td width="5%"><input type="hidden" name="edit" id="edit" value="0" /></td>
    <td width="12%"><input type="hidden" name="new1" id="new1" value="0" /></td>
    <td width="10%">&nbsp;</td>
    <td width="12%"><input type="hidden"  class="label_purchase" value="Voucher No" disabled="disabled"/><input type="hidden"  class="text_purchase3" name="TXT_HEADING" id="TXT_HEADING"/><input type="hidden"  class="label_purchase" value="Invoice No" disabled="disabled"/><input type="hidden" class="text_purchase3" name="txtINVNO" id="txtINVNO"/><input type="hidden"  class="label_purchase" value="Invoice Date" disabled="disabled"/><input type="hidden"  class="text_purchase3" size="10" id="DTinv_date" name="DTinv_date" onkeypress="keyset('bank',event);" onfocus="load_calader('DTinv_date');"/></td>
    <td width="12%"><div class="style2" id="labcan"> </div></td>
    <td width="3%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Entry No" disabled="disabled"/></td>
    <td> <a href="serach_rec_acc.php?stname=cash_rec" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
      <input type="text" disabled="disabled" name="txt_entno" id="txt_entno" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  />
    </a></td>
    <td width="4%"><a href="serach_chq_pay_acc.php?stname=chq_pay" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" />
    </a></td>
    <td width="10%"><input type="text"  class="label_purchase" value="A/C Payee Only" disabled="disabled"/></td>
    <td><input type="checkbox" name="Check1" id="Check1" /></td>
    <td><input type="text"  class="label_purchase" value="Entry Date" disabled="disabled"/></td>
    <td><input type="text" size="20" name="Calendar1" id="Calendar1" value="<?php echo date("Y-m-d"); ?>" class="text_purchase3" onfocus="load_calader('Calendar1');"/></td>
    <td><input type="text"  class="label_purchase" value="Cheque Date" disabled="disabled"/></td>
    <td><input type="text" size="20" name="chqdate" id="chqdate" value="<?php echo date("Y-m-d"); ?>" class="text_purchase3" onfocus="load_calader('chqdate');"/></td>
    <td></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Barer" disabled="disabled"/></td>
    <td colspan="5">
      <input type="text" class="text_purchase3" name="txt_bea" id="txt_bea"/>         </td>
    <td><a href="search_checus_acc.php?stname=cheque_pay" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv2" id="searchinv2" value="..." class="btn_purchase1" />
      </a> <a href="search_checus_acc_edit.php?stname=cheque_pay_edit" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv3" id="searchinv3" value="Edit Barer List" class="btn_purchase2" />
    </a></td>
    <td><input type="text"  class="label_purchase" value="VAT No" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="txtVATNO" id="txtVATNO" onblur="chk_vat();"/>
      
      <input type="button" name="searchinv4" id="searchinv4" value="Update VAT" class="btn_purchase2" onclick="update_vat();" />
     </td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="6">&nbsp;</td>
    <td colspan="2"><div class="style3" id="vatno"></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Barer 1" disabled="disabled"/></td>
    <td colspan="5"><script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"DTinv_date",
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
      <input type="text" class="text_purchase3" name="txt_bea1" id="txt_bea1"/></td>
    <td><a href="search_checus_acc.php?stname=cheque_pay1" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv6" id="searchinv6" value="..." class="btn_purchase1" />
    </a></td>
    <td><input type="text"  class="label_purchase" value="VAT No 1" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="txtVATNO1" id="txtVATNO1" onblur="chk_vat1();"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Barer 2" disabled="disabled"/></td>
    <td colspan="5"><input type="text" class="text_purchase3" name="txt_bea2" id="txt_bea2"/></td>
    <td><a href="search_checus_acc.php?stname=cheque_pay2" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv7" id="searchinv7" value="..." class="btn_purchase1" />
    </a></td>
    <td><input type="text"  class="label_purchase" value="VAT No 2" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="txtVATNO2" id="txtVATNO2" onblur="chk_vat2();"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Barer 3" disabled="disabled"/></td>
    <td colspan="5"><input type="text" class="text_purchase3" name="txt_bea3" id="txt_bea3"/></td>
    <td><a href="search_checus_acc.php?stname=cheque_pay3" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv8" id="searchinv8" value="..." class="btn_purchase1" />
    </a></td>
    <td><input type="text"  class="label_purchase" value="VAT No 3" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="txtVATNO3" id="txtVATNO3" onblur="chk_vat3();"/></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"></td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Naration" disabled="disabled"/></td>
    <td colspan="8">
      
      <textarea name="TXT_NARA" id="TXT_NARA" cols="100" rows="5"></textarea>    </td>
    <td></td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="VAT Barer" disabled="disabled"/></td>
    <td colspan="8"><div id="vat_barer">
      <input type="text"  class="text_purchase3" size="10" id="txtvatbea" name="txtvatbea" />
      <?php 
	/*	<select name="txtvatbea" id="txtvatbea"  class="text_purchase3" onchange="set_vatno();">
			include('connection.php');
			
			$sql="select bea1 from paymas group by bea1";
			$result=mysql_query($sql, $dbacc);
			while($row = mysql_fetch_array($result)){	
				echo "<option value=\"".$row["bea1"]."\">".$row["bea1"]."</option>	";
			}
			</select>*/
      ?>
      </div>   </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Commission Advance/Balance" disabled="disabled"/>     </td>
    <td><div id="commi">
      <select name="Combo1" id="Combo1"  onchange="set_nara_comm();" class="text_purchase3">
      	<option value=""></option>
        <?php 

			if ($_SESSION["dev"]=="0"){
				$sql="select * from s_commadva where chno='0' and dev='0'";
			} else if ($_SESSION["dev"]=="1"){
				$sql="select * from s_commadva where chno='0' and dev='1'";
			}	
			$result=mysql_query($sql, $dbinv);
			while($row = mysql_fetch_array($result)){	
				echo "<option value=\"".trim($row["refno"])."\">".$row["refno"]."</option>	";
			}
			
      ?>
      </select></div> </td>
    <td colspan="2"><input type="text"  class="label_purchase" value="Incentive" disabled="disabled"/></td>
    <td colspan="2"><div id="incent">
      <select name="Combo2" id="Combo2" onchange="set_nara();"  class="text_purchase3">
      <option value=""></option>
        <?php 
		
			$sql="Select * from ins_payment where chno = '0' order by id desc";
			$result=mysql_query($sql, $dbinv);
			while($row = mysql_fetch_array($result)){	
				$incen = trim($row["id"]) . " " . trim($row["cusCode"]) . " " . trim($row["I_month"]) . " " . trim($row["I_year"]);
				//$incen=$row["id"]." ".$row["cuscode"]." ".$row["i_month"]." ".$row["i_year"];
				echo "<option value=\"".$row["id"]."\">".$incen."</option>	";
			}
			
      ?>
      </select>  </div></td>
    <td colspan="2"></td>
    <td colspan="2">       </td>
    </tr>
	<tr>
	<td><input type="text"  class="label_purchase" value="Slab Incen." disabled="disabled"/>     </td>
    <td><div id="commi">
      <select name="Combo3" id="Combo3"  onchange="set_nara_inc();" class="text_purchase3">
      	<option value=""></option>
        <?php 
			
			$sql="select code,name  from inc_auto_credit_note where myear_mon like '2016%' and active = '1' group by code,name";			 
			$result=mysql_query($sql, $dbinv);
			while($row = mysql_fetch_array($result)){	
				echo "<option value=\"".trim($row["code"])."\">". $row['code'] . " " . $row["name"]."</option>	";
			}
			
      ?>
      </select></div> </td>
	</tr>
	
  </table>
<br>
  <fieldset>               
            
   	<legend><div class="text_forheader"></div></legend>
  <table width="1000" border="0">
      <tr>
        <td><span class="style1">
          <input type="text"  class="label_purchase" value="Amount in word" disabled="disabled"/>
        </span></td>
        <td colspan="3"><font color="#FFFFFF">
          <input type="text"  class="text_purchase3" size="10" id="txt_amoinword" name="txt_amoinword" onkeypress="keyset('bank',event);" />
        </font></td>
      </tr>
      <tr>
        <td width="18%"><span class="style1">
          <input type="text"  class="label_purchase" value="Bank" disabled="disabled"/>
        </span></td>
        <td  width="30%">
       
          <select name="com_cas" id="com_cas"  class="text_purchase3" onchange="set_chno();">
          	<option value=""></option>
            <?php 
		
			$sql="select * from lcodes where cat='B'";
			//echo $sql;
			$result=mysql_query($sql, $dbacc);
			while($row = mysql_fetch_array($result)){	
				echo "<option value=\"".$row["c_code"]."\">".$row["c_code"]." ".$row["c_name"]."</option>	";
			}
      ?>
          </select>
        </td>
        <td  width="26%"><span class="style1">
        <input type="text"  class="label_purchase" value="Cheque No" disabled="disabled"/>
        </span></td>
        <td  width="26%"><font color="#FFFFFF">
          <input type="text"  class="text_purchase3" size="10" id="txt_cheno" name="txt_cheno" onkeypress="keyset('bank',event);" />
        </font></td>
      </tr>
  </table>
       

</fieldset>    

  <br/>   
<fieldset>               
            
   	<legend><div class="text_forheader">Debit</div></legend>
    <label>
    <input type="hidden" name="Text3" id="Text3" />
    </label>
  <table width="89%" border="0">
  <tr>
        <td width="17%"><span class="style1">
        <input type="text"  class="label_purchase" value="Account No" disabled="disabled"/>
        </span></td>
        <td  width="17%"><span class="style1">
        <input type="text"  class="label_purchase" value="Account Name" disabled="disabled"/>
        </span></td>
        <td  width="32%"><span class="style1">
        <input type="text"  class="label_purchase" value="Description" disabled="disabled"/>
        </span></td>
        <td  width="6%">&nbsp;</td>
        <td  width="19%"><span class="style1">
        <input type="text"  class="label_purchase" value="Amount" disabled="disabled"/>
        </span></td>
    </tr>
      <tr>
        <td><font color="#FFFFFF">
          <div id="test"><font color="#FFFFFF">
            <input type="text"  class="text_purchase3" name="accno" id="accno" size="10" onkeypress="keyset('amt',event);"  onblur="ledgno_ind('cheque_pay');"    />
          </font></div>
        </font></td>
        <td><font color="#FFFFFF">
        <input type="text"  class="text_purchase3" size="10" id="acc_name" name="acc_name" disabled="disabled" onkeypress="keyset('bank',event);" />
        
        <script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"chqdate",
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
          </font></td>
        <td><font color="#FFFFFF">
          <input type="text" size="15" name="descript" id="descript" value="" class="text_purchase3" />
        
        </font></td>
        <td><font color="#FFFFFF"><a href="search_ledger_acc.php?stname=cheque_pay" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
          <input type="button" name="additem_tmp2" id="additem_tmp2" value="..." class="btn_purchase1" />
        </a></font></td>
        <td><font color="#FFFFFF">
          <input type="text" size="15" name="amt" id="amt" value="" class="text_purchase3" onkeypress="keyset('additem_tmp',event);"/>
        </font></td>
        
      
        <td width="5%"><input type="button" name="additem_tmp" id="additem_tmp" value="Add" onclick="addchq_cash_rec();" class="btn_purchase1" /></td>
    </tr>
      <tr>
        <td colspan="5"><div class="CSSTableGenerator" id="chq_table" >
          <table width="80%">
              <tr>
                <td width="10%"   background="images/headingbg.gif" ><font color="#FFFFFF">Account No</font></td>
                <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Account Name</font></td>
                <td width="20%"  background="images/headingbg.gif"><font color="#FFFFFF">Description</font></td>
              
                <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Amount</font></td>
              </tr>
            </table>
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="2%">&nbsp;</td>
        <td width="2%">&nbsp;</td>
      </tr>
    </table>
       

</fieldset>    



<br />

<table width="921" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Pay Total" disabled="disabled"/></td>
    <td><input type="text" size="20" name="TXT_DEBTOT" id="TXT_DEBTOT" value=""  class="text_purchase3"/></td>
  </tr>
  <tr>
    <td width="144">&nbsp;</td>
    <td width="127">&nbsp;</td>
      
      
      
    <td width="58">&nbsp;</td>
    <td width="58">&nbsp;</td>
    <td width="209">&nbsp;</td>
    <td width="144">&nbsp;</td>
    <td width="151">&nbsp;</td>
  </tr>
</table>


<fieldset>               
            
<legend>
</legend>
</form>        
<?php 
mysql_close($dbacc);
mysql_close($dbinv);
?>
</fieldset>    
            
<table width="765" border="0" cellpadding="0">
<tr>
                	<th height="189" colspan="5" align="left" nowrap="nowrap">
              			<div align="left">