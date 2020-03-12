
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
-->
</style>
<fieldset>
                                                	<legend>
  <div class="text_forheader">Cheque Setup Details</div>
                                               	 </legend>
                                               	 <form name="form1" id="form1" target="_blank" action="disp_chq.php">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%">&nbsp;</td>
    <td width="10%"><input type="hidden" name="hiddencount" id="hiddencount" /></td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Bank" disabled="disabled"/>
    </span></td>
    <td colspan="7"><select name="com_bank" id="com_bank"  class="text_purchase3" onchange="load_bank();" >
      <option value=""></option>
      <?php 
		
			$sql="select * from lcodes where cat='B'";
			echo $sql;
			$result=mysql_query($sql, $dbacc);
			while($row = mysql_fetch_array($result)){	
				echo "<option value=\"".$row["c_code"]."\">".$row["c_code"]." ".$row["c_name"]."</option>	";
			}
      ?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Left" disabled="disabled"/>
    </span></td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Top" disabled="disabled"/>
    </span></td>
    <td colspan="2"><span class="style1">
      <input type="text"  class="label_purchase" value="Font Name" disabled="disabled"/>
    </span></td>
    <td colspan="2"><span class="style1">
      <input type="text"  class="label_purchase" value="Font Size" disabled="disabled"/>
    </span></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>1</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Year 1" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="left1" name="left1" onkeypress="keyset('bank',event);" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="top1" name="top1" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2"><select name="font_name1" id="font_name1"  class="text_purchase3" onchange="lastmonthcal();" >
      <option value='Arial Narrow'>Arial Narrow</option>
     <option value='Courier New'>Courier New</option>
     <option value='Times New Roman'>Times New Roman</option>
     <option value='Tahoma'>Tahoma</option>
     <option value='Bodoni MT'>Bodoni MT</option>
    </select></td>
    <td colspan="2"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="fontsize1" name="fontsize1" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>2</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Year 2" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="left2" name="left2" onkeypress="keyset('bank',event);" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="top2" name="top2" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2"><select name="font_name2" id="font_name2"  class="text_purchase3" onchange="lastmonthcal();" >
      <option value='Arial Narrow'>Arial Narrow</option>
      <option value='Courier New'>Courier New</option>
      <option value='Times New Roman'>Times New Roman</option>
      <option value='Tahoma'>Tahoma</option>
      <option value='Bodoni MT'>Bodoni MT</option>
    </select></td>
    <td colspan="2"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="fontsize2" name="fontsize2" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>3</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Month 1" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="left3" name="left3" onkeypress="keyset('bank',event);" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="top3" name="top3" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2"><select name="font_name3" id="font_name3"  class="text_purchase3" onchange="lastmonthcal();" >
      <option value='Arial Narrow'>Arial Narrow</option>
      <option value='Courier New'>Courier New</option>
      <option value='Times New Roman'>Times New Roman</option>
      <option value='Tahoma'>Tahoma</option>
      <option value='Bodoni MT'>Bodoni MT</option>
    </select></td>
    <td colspan="2"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="fontsize3" name="fontsize3" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>4</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Month 2" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="left4" name="left4" onkeypress="keyset('bank',event);" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="top4" name="top4" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2"><select name="font_name4" id="font_name4"  class="text_purchase3" onchange="lastmonthcal();" >
      <option value='Arial Narrow'>Arial Narrow</option>
      <option value='Courier New'>Courier New</option>
      <option value='Times New Roman'>Times New Roman</option>
      <option value='Tahoma'>Tahoma</option>
      <option value='Bodoni MT'>Bodoni MT</option>
    </select></td>
    <td colspan="2"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="fontsize4" name="fontsize4" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>5</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Day 1" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="left5" name="left5" onkeypress="keyset('bank',event);" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="top5" name="top5" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2"><select name="font_name5" id="font_name5"  class="text_purchase3" onchange="lastmonthcal();" >
      <option value='Arial Narrow'>Arial Narrow</option>
      <option value='Courier New'>Courier New</option>
      <option value='Times New Roman'>Times New Roman</option>
      <option value='Tahoma'>Tahoma</option>
      <option value='Bodoni MT'>Bodoni MT</option>
    </select></td>
    <td colspan="2"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="fontsize5" name="fontsize5" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>6</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Day 2" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="left6" name="left6" onkeypress="keyset('bank',event);" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="top6" name="top6" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2"><select name="font_name6" id="font_name6"  class="text_purchase3" onchange="lastmonthcal();" >
      <option value='Arial Narrow'>Arial Narrow</option>
      <option value='Courier New'>Courier New</option>
      <option value='Times New Roman'>Times New Roman</option>
      <option value='Tahoma'>Tahoma</option>
      <option value='Bodoni MT'>Bodoni MT</option>
    </select></td>
    <td colspan="2"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="fontsize6" name="fontsize6" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>7</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="A/C Payee Only 1" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="left7" name="left7" onkeypress="keyset('bank',event);" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="top7" name="top7" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2"><select name="font_name7" id="font_name7"  class="text_purchase3" onchange="lastmonthcal();" >
      <option value='Arial Narrow'>Arial Narrow</option>
      <option value='Courier New'>Courier New</option>
      <option value='Times New Roman'>Times New Roman</option>
      <option value='Tahoma'>Tahoma</option>
      <option value='Bodoni MT'>Bodoni MT</option>
    </select></td>
    <td colspan="2"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="fontsize7" name="fontsize7" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>8</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="A/C Payee Only 2" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="left8" name="left8" onkeypress="keyset('bank',event);" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="top8" name="top8" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2"><select name="font_name8" id="font_name8"  class="text_purchase3" onchange="lastmonthcal();" >
      <option value='Arial Narrow'>Arial Narrow</option>
      <option value='Courier New'>Courier New</option>
      <option value='Times New Roman'>Times New Roman</option>
      <option value='Tahoma'>Tahoma</option>
      <option value='Bodoni MT'>Bodoni MT</option>
    </select></td>
    <td colspan="2"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="fontsize8" name="fontsize8" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>9</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Account Payee" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="left9" name="left9" onkeypress="keyset('bank',event);" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="top9" name="top9" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2"><select name="font_name9" id="font_name9"  class="text_purchase3" onchange="lastmonthcal();" >
      <option value='Arial Narrow'>Arial Narrow</option>
      <option value='Courier New'>Courier New</option>
      <option value='Times New Roman'>Times New Roman</option>
      <option value='Tahoma'>Tahoma</option>
      <option value='Bodoni MT'>Bodoni MT</option>
    </select></td>
    <td colspan="2"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="fontsize9" name="fontsize9" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>10</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Amount in word 1" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="left10" name="left10" onkeypress="keyset('bank',event);" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="top10" name="top10" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2"><select name="font_name10" id="font_name10"  class="text_purchase3" onchange="lastmonthcal();" >
      <option value='Arial Narrow'>Arial Narrow</option>
      <option value='Courier New'>Courier New</option>
      <option value='Times New Roman'>Times New Roman</option>
      <option value='Tahoma'>Tahoma</option>
      <option value='Bodoni MT'>Bodoni MT</option>
    </select></td>
    <td colspan="2"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="fontsize10" name="fontsize10" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>11</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Amount in word 2" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="left11" name="left11" onkeypress="keyset('bank',event);" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="top11" name="top11" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2"><select name="font_name11" id="font_name11"  class="text_purchase3" onchange="lastmonthcal();" >
      <option value='Arial Narrow'>Arial Narrow</option>
      <option value='Courier New'>Courier New</option>
      <option value='Times New Roman'>Times New Roman</option>
      <option value='Tahoma'>Tahoma</option>
      <option value='Bodoni MT'>Bodoni MT</option>
    </select></td>
    <td colspan="2"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="fontsize11" name="fontsize11" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>12</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Amount" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="left12" name="left12" onkeypress="keyset('bank',event);" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="top12" name="top12" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2"><select name="font_name12" id="font_name12"  class="text_purchase3" onchange="lastmonthcal();" >
      <option value='Arial Narrow'>Arial Narrow</option>
      <option value='Courier New'>Courier New</option>
      <option value='Times New Roman'>Times New Roman</option>
      <option value='Tahoma'>Tahoma</option>
      <option value='Bodoni MT'>Bodoni MT</option>
    </select></td>
    <td colspan="2"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="fontsize12" name="fontsize12" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>13</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Barer 1" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="left13" name="left13" onkeypress="keyset('bank',event);" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="top13" name="top13" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2"><select name="font_name13" id="font_name13"  class="text_purchase3" onchange="lastmonthcal();" >
      <option value='Arial Narrow'>Arial Narrow</option>
      <option value='Courier New'>Courier New</option>
      <option value='Times New Roman'>Times New Roman</option>
      <option value='Tahoma'>Tahoma</option>
      <option value='Bodoni MT'>Bodoni MT</option>
    </select></td>
    <td colspan="2"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="fontsize13" name="fontsize13" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>14</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Barer 2" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="left14" name="left14" onkeypress="keyset('bank',event);" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="top14" name="top14" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2"><select name="font_name14" id="font_name14"  class="text_purchase3" onchange="lastmonthcal();" >
      <option value='Arial Narrow'>Arial Narrow</option>
      <option value='Courier New'>Courier New</option>
      <option value='Times New Roman'>Times New Roman</option>
      <option value='Tahoma'>Tahoma</option>
      <option value='Bodoni MT'>Bodoni MT</option>
    </select></td>
    <td colspan="2"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="fontsize14" name="fontsize14" onkeypress="keyset('bank',event);" />
    </font></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  </table>




  <input type="submit" name="button" id="button" value="Preview" />
  <br />
<fieldset>               
            
<legend>
</legend>
</form>        

</fieldset>    
            
<table width="765" border="0" cellpadding="0">
<tr>
                	<th height="189" colspan="5" align="left" nowrap="nowrap">
              			<div align="left">