function GetXmlHttpObject()
	{
		var xmlHttp=null;	
		try
		 {
			 // Firefox, Opera 8.0+, Safari
			 xmlHttp=new XMLHttpRequest();			
		 }
		catch (e)
		 {
			 // Internet Explorer
			 try
			  {
				  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");				
			  }
			 catch (e)
			  {
				 xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");			
			  }
		 }
		return xmlHttp;		
}


function load_bank()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
				var url="cheque_setup_data_acc.php";			
				url=url+"?Command="+"load_bank";
				url=url+"&com_bank="+document.getElementById('com_bank').value;
							
				
				xmlHttp.onreadystatechange=passcusresult_load_bank;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);	
}


function passcusresult_load_bank()
{
	
	var XMLAddress1;
	
	//alert(xmlHttp.responseText);
	
	//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName('font_size1');	
		//document.getElementById('fontsize1').value=XMLAddress1[0].childNodes[0].nodeValue;
		
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		i=1;
	  while (i<=14){	
		font_name="font_name"+i;
		font_size="font_size"+i;
		left_loc="left_loc"+i;
		top_loc="top_loc"+i;
		
		txtfont_name="font_name"+i;
		txtfontsize="fontsize"+i;
		txtleft="left"+i;
		txttop="top"+i;
		
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName(font_name);	
		document.getElementById(txtfont_name).value=XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName(font_size);	
		document.getElementById(txtfontsize).value=XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName(left_loc);	
		document.getElementById(txtleft).value=XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName(top_loc);	
		document.getElementById(txttop).value=XMLAddress1[0].childNodes[0].nodeValue;
		
		i=i+1;
	  }
		
		
	}
}

function set_vatno()
{

	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
	var url="search_chq_data_acc.php";			
				url=url+"?Command="+"set_vatno";
				url=url+"&txtvatbea="+document.getElementById('txtvatbea').value;
							
				
				xmlHttp.onreadystatechange=passcusresult_set_vatno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);	
				
}

function passcusresult_set_vatno()
{
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cheque_no");	
		document.getElementById('txtVATNO').value=xmlHttp.responseText;
		
		
		
	}
}

function get_bank()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			}
			
			var url="cash_rec_data_acc.php";			
			url=url+"?Command="+"get_bank";
			url=url+"&bankcode="+document.getElementById('bank').value;
			xmlHttp.onreadystatechange=assign_get_bank;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function assign_get_bank(){
	//alert(xmlHttp.responseText);
	//location.reload(true);
	document.getElementById('bank').value=xmlHttp.responseText;	
	//document.getElementById('searchcust2').focus();
	
}

function set_chno()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			}
			
	var url="cheque_pay_data_acc.php";			
			url=url+"?Command="+"set_chno";
			url=url+"&com_cas="+document.getElementById('com_cas').value;
			//alert(url);
		  
			xmlHttp.onreadystatechange=assign_set_chno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);		
}

function assign_set_chno(){
	//alert(xmlHttp.responseText);
	//location.reload(true);
	
	
	document.getElementById('txt_cheno').value= xmlHttp.responseText;
}

function new_inv()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			

		/*	document.getElementById('debit_acc').value="";
			document.getElementById('debit').value="";
			document.getElementById('credit_acc').value="";
			document.getElementById('credit').value="";*/
				
			//var objsalesrep = document.getElementById("cmbBarer");
			//objsalesrep.options[0].selected=true;
			
			//alert("ok");
			
			document.getElementById('txt_entno').value="";
			document.getElementById('TXT_HEADING').value="";
			document.getElementById('txt_bea').value="";
		
			
			document.getElementById('txtINVNO').value="";
			document.getElementById('TXT_NARA').value="";
			document.getElementById('Check1').checked=false;
			document.getElementById('DTinv_date').value="";
			document.getElementById('txtVATNO').value="";
			document.getElementById('txt_amoinword').value="";
			document.getElementById('txtVATNO').value="";
			document.getElementById('txt_cheno').value="";
			
			document.getElementById('accno').value="";
			document.getElementById('acc_name').value="";
			document.getElementById('descript').value="";
			document.getElementById('amt').value="";
		
			document.getElementById('chq_table').innerHTML="";
			
			document.getElementById('TXT_DEBTOT').value="";
		
		
			
			var url="cheque_pay_data_acc.php";			
			url=url+"?Command="+"new_rec";
			url=url+"&com_cas="+document.getElementById('com_cas').value;
		 // alert(url);
			xmlHttp.onreadystatechange=assign_invno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function assign_invno(){
	//alert(xmlHttp.responseText);
	//location.reload(true);
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_entno");	
	document.getElementById('txt_entno').value= XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_cheno");	
	document.getElementById('txt_cheno').value= XMLAddress1[0].childNodes[0].nodeValue;
		
	//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");	
	//document.getElementById('Txtcusco').value= XMLAddress1[0].childNodes[0].nodeValue;
		
	//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");	
	//document.getElementById('txtcusname').value= XMLAddress1[0].childNodes[0].nodeValue;
	
	//document.getElementById('searchcust2').focus();
	
}


function del_item(code)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="cash_rec_data.php";			
			url=url+"?Command="+"del_item";
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&chqno="+code;
			//alert(url);
			
			xmlHttp.onreadystatechange=itemresultdel;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function itemresultdel()
{
	//	alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		document.getElementById('chqtot').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");	
		document.getElementById('chq_table').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqbal");	
		document.getElementById('chq_balance1').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('chqno').value="";
		document.getElementById('chqdate').value="";
		document.getElementById('bank').value="";
		document.getElementById('chqamt').value="";
		
		document.getElementById('chqno').focus();
}

function addchq_cash_rec()
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="cheque_pay_data_acc.php";			
			url=url+"?Command="+"addchq_cash_rec";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&accno="+document.getElementById('accno').value;
			url=url+"&acc_name="+document.getElementById('acc_name').value;
			url=url+"&descript="+document.getElementById('descript').value;
			url=url+"&amt="+document.getElementById('amt').value;
			
			xmlHttp.onreadystatechange=addchq_cash_rec_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function addchq_cash_rec_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamt");	
		document.getElementById('TXT_DEBTOT').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");	
		document.getElementById('chq_table').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		document.getElementById('accno').value="";
		document.getElementById('acc_name').value="";
		document.getElementById('descript').value="";
		document.getElementById('amt').value="";
		
		amoword_cal();
		
		document.getElementById('accno').focus();
		//document.getElementById('chq_table').innerHTML= xmlHttp.responseText;
		
	}
}

function setamt(accno, i)
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="cheque_pay_data_acc.php";			
			url=url+"?Command="+"setamt";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&accno="+accno;
			
			var amt="amt"+i;
			
			url=url+"&amt="+document.getElementById(amt).value;
			
			alert(url);
			
			xmlHttp.onreadystatechange=del_item_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}


function del_item(accno)
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="cheque_pay_data_acc.php";			
			url=url+"?Command="+"del_item_ledg";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&accno="+accno;
			alert(url);
			
			xmlHttp.onreadystatechange=del_item_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function del_item_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamt");	
		document.getElementById('TXT_DEBTOT').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");	
		document.getElementById('chq_table').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		document.getElementById('accno').value="";
		document.getElementById('acc_name').value="";
		document.getElementById('descript').value="";
		document.getElementById('amt').value="";
		
		document.getElementById('accno').focus();
		//document.getElementById('chq_table').innerHTML= xmlHttp.responseText;
		
	}
}



function keyset(key, e)
{	

   if(e.keyCode==13){
	document.getElementById(key).focus();
   }
}


function keysetvalue(key1, key2, key3, e)
{	
	
	
   if(e.keyCode==13){
	 //  alert("ok");
	document.getElementById(key2).value=document.getElementById(key1).value-document.getElementById(key3).value;   
	document.getElementById(key2).focus();
   }
}

function calc_bal_cash(overdue, cash_pay_next, chq_pay, inv_balance, cash_pay, e)
{	
	var overdue_v;
	var chq_pay_v;
	var cash_pay_v;
	
	
	if (isNaN(document.getElementById(overdue).value)==false){
		overdue_v=document.getElementById(overdue).value;
	} else {
		overdue_v=0;
	}
	
	if (isNaN(document.getElementById(chq_pay).value)==false){
		chq_pay_v=document.getElementById(chq_pay).value;
	} else {
		chq_pay_v=0;
	}
	
	if (isNaN(document.getElementById(cash_pay).value)==false){
		cash_pay_v=document.getElementById(cash_pay).value;
	} else {
		cash_pay_v=0;
	}
	
	
 // if(e.keyCode==13){
	 //  alert("ok");
	document.getElementById(inv_balance).value=overdue_v-chq_pay_v-cash_pay_v;
	
	var mcou=document.getElementById("hiddencount").value;
	var i=1;
	var pay_tot=0;
	var pay_cash=0;
	var pay_cheq=0;
	var over=0;
	
	while (mcou>=i){
		
		var chq_pay_val="chq_pay"+i;
		var cash_pay_val="cash_pay"+i;
		var inv_balance_val="inv_balance"+i;
		
		if (isNaN(document.getElementById(chq_pay_val).value)==false){
			pay_tot=pay_tot+Number(document.getElementById(chq_pay_val).value);
			pay_cheq=pay_cheq+Number(document.getElementById(chq_pay_val).value);
		}
		
		if (isNaN(document.getElementById(cash_pay_val).value)==false){
			pay_cash=pay_cash+Number(document.getElementById(cash_pay_val).value);
			pay_tot=pay_tot+Number(document.getElementById(cash_pay_val).value);
		}
		if (Number(document.getElementById(inv_balance_val).value)<0){
			over=over+Number(document.getElementById(inv_balance_val).value);
		}
		
		document.getElementById("cashtot").value=pay_cash;
		document.getElementById("txtpaytot").value=pay_tot;
		//alert(over);
				
		document.getElementById("txtoverpay").value=over;
		
		i=i+1;

	}
	document.getElementById(cash_pay_next).focus();
  // }
 }
  

function custno(stname)
{   
			//alert(stname);
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"pass_cus_cash_rec";
			url=url+"&custno="+document.getElementById("cuscode").value;
			url=url+"&refno="+document.getElementById("salesrep").value;
			xmlHttp.onreadystatechange=passcusresult_cash_rec;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function passcusresult_cash_rec()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcount");	
		document.getElementById("hiddencount").value=XMLAddress1[0].childNodes[0].nodeValue;
		
	/*	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");	
		document.getElementById("cuscode").value = XMLAddress1[0].childNodes[0].nodeValue;
			
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");	
		document.getElementById("cusname").value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("address");	
		document.getElementById("cus_address").value = XMLAddress1[0].childNodes[0].nodeValue;*/
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");	
		//alert( XMLAddress1[0].childNodes[0].nodeValue);
		document.getElementById("inv_details").innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		//alert("ok");
		
		
		//opener.document.form1.txtdetar.focus();
	}
}


function calc_bal(overdue, chq_pay, inv_balance, chq_balance, chq_balance_next, cash_pay, i, e)
{	
	
	
 // alert(document.getElementById(overdue).value);
 	var overdue_v;
	var chq_pay_v;
	var cash_pay_v;
	
	
	if (isNaN(document.getElementById(overdue).value)==false){
		overdue_v=document.getElementById(overdue).value;
	} else {
		overdue_v=0;
	}
	
	
	if (isNaN(document.getElementById(chq_pay).value)==false){
		chq_pay_v=document.getElementById(chq_pay).value;
	} else {
		chq_pay_v=0;
	}
	

	if (isNaN(document.getElementById(cash_pay).value)==false){
		cash_pay_v=document.getElementById(cash_pay).value;
	} else {
		cash_pay_v=0;
	}
	
	document.getElementById(inv_balance).value=overdue_v-chq_pay_v-cash_pay_v;  
	
	document.getElementById(chq_balance_next).value=document.getElementById(chq_balance).value-document.getElementById(chq_pay).value;
	
	document.getElementById('txtoverpay').value=document.getElementById(chq_balance_next).value;
	
	var mcou=document.getElementById("hiddencount").value;
	var i=1;
	var pay_tot=0;
	var over=0;
	
	while (mcou>=i){
		
		var chq_pay_val="chq_pay"+i;
		var cash_pay_val="cash_pay"+i;
		var inv_balance_val="inv_balance"+i;
		
		if (isNaN(document.getElementById(chq_pay_val).value)==false){
			pay_tot=pay_tot+Number(document.getElementById(chq_pay_val).value);
		}
		if (isNaN(document.getElementById(cash_pay_val).value)==false){
			pay_tot=pay_tot+Number(document.getElementById(cash_pay_val).value);
		}
		
		if (Number(document.getElementById(inv_balance_val).value)<0){
			over=over+Number(document.getElementById(inv_balance_val).value);
		}
		
		document.getElementById("txtpaytot").value=pay_tot;
	//	document.getElementById("txtoverpay").value=over;
		
		i=i+1;

	}
	
		
/*	var j=1;
	var sel_inv_tot=0;
	while (j<=i){
		var chq_pay_all="chq_pay"+j;
		var cash_pay_all="cash_pay"+j;
		alert(document.getElementById(cash_pay_all).value);
		sel_inv_tot= sel_inv_tot+document.getElementById(chq_pay_all).value+document.getElementById(cash_pay_all).value;  
		//alert(sel_inv_tot);
		
		j=j+1;
	}
	
	document.getElementById('txtpaytot').value=sel_inv_tot;
	document.getElementById('txtoverpay').value=(document.getElementById('cashtot').value+document.getElementById('chqtot').value)-sel_inv_tot;*/
	//document.getElementById(key2).focus();
  } 


function got_focus(key)
{	
	document.getElementById(key).style.backgroundColor="#000066";
  
}

function lost_focus(key)
{	
	document.getElementById(key).style.backgroundColor="#000000";
  
}

function utilization()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
	
	var txtpaytot = Number(document.getElementById("txtpaytot").value);
	var txtoverpay = Number(document.getElementById("txtoverpay").value);
	var chqtot=Number(document.getElementById("chqtot").value);
	var cashtot= Number(document.getElementById("cashtot").value);
													
	if (txtpaytot+txtoverpay != chqtot+cashtot){
																																																 	alert("Payment amount and settlement amount not equal");
																																																	 	} else {
			var url="cash_rec_data.php";			
			url=url+"?Command="+"utilization";
			url=url+"&mcount="+document.getElementById('hiddencount').value;
			url=url+"&recno="+document.getElementById("invno").value;
			url=url+"&paytype="+document.getElementById("paytype").value;
			url=url+"&dt="+document.getElementById("dt").value;
			
			
			mcount=document.getElementById('hiddencount').value;
			
			var i=1;
			while (mcount > i){
				delidate="delidate"+i;
				chq_pay="chq_pay"+i;
				chq_balance="chq_balance"+i;
				invno="invno"+i;
				cash_pay="cash_pay"+i;
				invval="invval"+i;
				inv_balance="inv_balance"+i;
				
				if (isNaN(document.getElementById(chq_pay).value)==false){
					url=url+"&"+delidate+"="+document.getElementById(delidate).innerHTML;
					url=url+"&"+invno+"="+document.getElementById(invno).innerHTML;
					url=url+"&"+chq_pay+"="+document.getElementById(chq_pay).value;
					url=url+"&"+chq_balance+"="+document.getElementById(chq_balance).value;
					url=url+"&"+cash_pay+"="+document.getElementById(cash_pay).value;	
					url=url+"&"+invval+"="+document.getElementById(invval).innerHTML;	
					url=url+"&"+inv_balance+"="+document.getElementById(inv_balance).value;	
				}
				i=i+1;
			}
			
			alert(url);
			xmlHttp.onreadystatechange=utilization_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
																																																 	}
}



function utilization_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uti_table");	
		document.getElementById('utilization').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
	
		
	}
}


function delete_rec()
{
  var msg;
  msg=confirm("Are you sure to CANCEL this Reciept ! ");
  if (msg==true){
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="cheque_pay_data_acc.php";			
			url=url+"?Command="+"delete_rec";
			url=url+"&txt_entno="+document.getElementById("txt_entno").value;
			url=url+"&invdate="+document.getElementById("Calendar1").value;
		
			alert(url);
	
		xmlHttp.onreadystatechange=result_delete_rec;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
  }
}

function result_delete_rec()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		setTimeout("location.reload(true);",500);
	}
}


function save_crec()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="cheque_setup_data_acc.php";			
			url=url+"?Command="+"save_crec";
			url=url+"&com_bank="+document.getElementById("com_bank").value;
			
			var i=1;
			while (i<=14){
				name="left"+i;
				url=url+"&"+name+"="+document.getElementById(name).value;
				i=i+1;
			}
			
			var i=1;
			while (i<=14){
				name="top"+i;
				url=url+"&"+name+"="+document.getElementById(name).value;
				i=i+1;
			}
			
			var i=1;
			while (i<=14){
				name="font_name"+i;
				url=url+"&"+name+"="+document.getElementById(name).value;
				i=i+1;
			}
			
			var i=1;
			while (i<=14){
				name="fontsize"+i;
				url=url+"&"+name+"="+document.getElementById(name).value;
				i=i+1;
			}
			
			
			
			alert(url);
			xmlHttp.onreadystatechange=result_save_crec;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function result_save_crec()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
	/*	var i=0;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("msg_dup");	
		if (XMLAddress1[0].childNodes[0].nodeValue != "0"){
			alert(XMLAddress1[0].childNodes[0].nodeValue);
			i=1;
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("msg_incom");	
		if (XMLAddress1[0].childNodes[0].nodeValue != "0"){
			alert(XMLAddress1[0].childNodes[0].nodeValue);	
			i=1;
		}*/
		
	/*	var strpaytot=document.getElementById('txtpaytot').value
		paytot=strpaytot.replace(",","");
		
		var url="rep_rec_acc.php";			
		url=url+"?Txtrecno="+document.getElementById('Txtrecno').value+"&txtDATE="+document.getElementById('txtDATE').value+"&txtpaytot="+paytot;
		window.open(url);*/
			
		//if (i==0){
		//	alert("Saved");
		//	setTimeout("location.reload(true);",500);	
		//}
		
	/*	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		document.getElementById('chqtot').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");	
		document.getElementById('chq_table').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqbal");	
		document.getElementById('chq_balance1').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('chqno').value="";
		document.getElementById('chqdate').value="";
		document.getElementById('bank').value="";
		document.getElementById('chqamt').value="";
		
		//document.getElementById('chq_table').innerHTML= xmlHttp.responseText;*/
		
	}
}
function vou_print_las() {
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 	
	
	var url="cheque_pay_data_acc.php";			
	url=url+"?Command="+"vou_print_las";
	url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			
	xmlHttp.onreadystatechange=result_vou_print_las;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
			
}

function result_vou_print_las()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
		//document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		//document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
	}
}

function print_inv(){
		var strpaytot=document.getElementById('txtpaytot').value
		paytot=strpaytot.replace(",","");
		
		var url="rep_rec_acc.php";			
		url=url+"?Txtrecno="+document.getElementById('Txtrecno').value+"&txtDATE="+document.getElementById('txtDATE').value+"&txtpaytot="+paytot;
		window.open(url);
	
}
		
function update_list(stname)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="cash_rec_data_acc.php";			
			url=url+"?Command="+"search_rec";
			url=url+"&mstatus="+stname;
			
			if (document.getElementById('recno').value!=""){
				
				url=url+"&mfield=recno";
				url=url+"&recno="+document.getElementById('recno').value;
				
			} else if (document.getElementById('recdate').value!=""){
				
				url=url+"&mfield=recdate";
				url=url+"&recdate="+document.getElementById('recdate').value;
				
			} else if (document.getElementById('recamt').value!=""){
				
				url=url+"&mfield=recamt";
				url=url+"&recamt="+document.getElementById('recamt').value;
				
			}
			
			//alert(url);
					
			xmlHttp.onreadystatechange=result_update_list;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	
}

function result_update_list()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
				
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
		//document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
	}
}


function update_bank(stname)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="cash_rec_data_acc.php";			
			url=url+"?Command="+"search_bank";
			url=url+"&mstatus="+stname;
			
			if (document.getElementById('bcode').value!=""){
				
				url=url+"&mfield=bcode";
				url=url+"&bcode="+document.getElementById('bcode').value;
				
			} else if (document.getElementById('bank').value!=""){
				
				url=url+"&mfield=bank";
				url=url+"&bank="+document.getElementById('bank').value;
				
			} 
			
			//alert(url);
					
			xmlHttp.onreadystatechange=result_update_bank;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	
}

function result_update_bank()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
				
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
		//document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
	}
}
function recno(recno, stname)
{   
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="cheque_pay_data_acc.php";			
			url=url+"?Command="+"pass_recno";
			url=url+"&recno="+recno;
			//alert(url);
					
			xmlHttp.onreadystatechange=result_recno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}


function result_recno()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_entno");
//		document.getElementById('invno1').value = XMLAddress1[0].childNodes[0].nodeValue;
	//	alert(XMLAddress1[0].childNodes[0].nodeValue);
		opener.document.form1.txt_entno.value = XMLAddress1[0].childNodes[0].nodeValue;
		//opener.document.form1.invno.value = "111111111";
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Calendar1");
		opener.document.form1.Calendar1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TXT_HEADING");
		opener.document.form1.TXT_HEADING.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TXT_NARA");
		opener.document.form1.TXT_NARA.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_bea");
		opener.document.form1.txt_bea.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("com_cas");
		opener.document.form1.com_cas.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_cheno");
		opener.document.form1.txt_cheno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mTick1");
		if (XMLAddress1[0].childNodes[0].nodeValue=="1"){
			opener.document.form1.Check1.checked = true;
		} else {
			opener.document.form1.Check1.checked = false;	
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("labcan");
		if (XMLAddress1[0].childNodes[0].nodeValue=="1"){
			window.opener.document.getElementById('labcan').innerHTML = "Cancel";
		} else {
			window.opener.document.getElementById('labcan').innerHTML = "";	
		}
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtINVNO");
		opener.document.form1.txtINVNO.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtVATNIO");
		//opener.document.form1.txtVATNIO.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DTinv_date");
		opener.document.form1.DTinv_date.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtvatbea");
		opener.document.form1.txtvatbea.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtVATNO");
		opener.document.form1.txtVATNO.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Combo1");
		opener.document.form1.Combo1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");
		window.opener.document.getElementById('chq_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TXT_DEBTOT");
		opener.document.form1.TXT_DEBTOT.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		
		//window.opener.document.getElementById("test").innerHTML="TESTNBMSVMS"
		//opener.document.forminv.invno.value = "123";
		//myWindow.opener.document.invno.value = "123";
		self.close();
		//alert(myWindow.opener.document.getElementById('invno').value);
		//forminv.getElementById('invno').value="125";
		
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
				
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
		//document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		//document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
	}
}


function selbank(bcode, stname)
{   
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="cash_rec_data_acc.php";			
			url=url+"?Command="+"pass_selbank";
			url=url+"&bcode="+bcode;
			url=url+"&stname="+stname;
			//alert(url);
					
			xmlHttp.onreadystatechange=result_selbank;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}


function result_selbank()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("bname");
		opener.document.form1.bank.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		self.close();	
	}
}


function close_form()
{
	self.close();	
}

function amoword_cal(){
    var M_TXT = "";
   
    M_INPUT = document.getElementById('TXT_DEBTOT').value; 
    M_INPUTLEN = M_INPUT.length;
    //Cents.........................................................................
    m_cent = "";
    ii = 0;
    m_ok = false;
	
	TXT_DEBTOT=document.getElementById('TXT_DEBTOT').value;
	
    while (ii < TXT_DEBTOT.length){
		next=ii+1;
		
       if (m_ok == true) { m_cent = m_cent + TXT_DEBTOT.substring(ii, next); }
       if (TXT_DEBTOT.substring(ii, next) == ".") { m_ok = true; }
	   
       ii = ii + 1;
	}
    m_say = "";
    m_say1 = "";
    m_amo = m_cent.substring(0, 2);
    
    M_AMO1 = m_cent.substring(0, 1)  + "0";
    m_amo2 = m_cent.substring(1, 2);
	
    if (m_amo <= 19) {
       document.getElementById('Text3').value = m_amo;
       BEL_ninten();
       m_say = document.getElementById('Text3').value;
	} else {
       document.getElementById('Text3').value = M_AMO1;
       BEL_TY();
       m_say = document.getElementById('Text3').value;
       
       document.getElementById('Text3').value = m_amo2;
       BEL_ninten();
       m_say1 = document.getElementById('Text3').value;
	   
	}
    m_cent = m_say + " " + m_say1;
	if(m_cent!=" "){
		document.getElementById('txt_amoinword').value="Cents "+m_cent;
	} else {
		document.getElementById('txt_amoinword').value=m_cent;	
	}
    //1-99..........................................................................
  m_say = "";
  m_say1 = "";
	
 
  	m_say = "";
    m_say1 = "";
    m_amo = M_INPUT.substring(M_INPUTLEN - 5, M_INPUTLEN-3); //Mid(M_INPUT, M_INPUTLEN - 1, 2)
    
    M_AMO1 = M_INPUT.substring(M_INPUTLEN - 5, M_INPUTLEN-4)+ "0"; //Mid(M_INPUT, M_INPUTLEN - 1, 1) + "0"
    m_amo2 = M_INPUT.substring(M_INPUTLEN - 4, M_INPUTLEN-3) //Mid(M_INPUT, M_INPUTLEN, 1)
    
    if (m_amo <= 19) {
       document.getElementById('Text3').value = m_amo;
       BEL_ninten();
       m_say = document.getElementById('Text3').value;
	} else {
		
       document.getElementById('Text3').value = M_AMO1;
       BEL_TY();
       m_say = document.getElementById('Text3').value;
      
       document.getElementById('Text3').value = m_amo2;
       BEL_ninten();
       m_say1 = document.getElementById('Text3').value;
	  
	}
	
    m_bel99 = m_say + " " + m_say1;
	
 	document.getElementById('txt_amoinword').value=m_bel99+" "+document.getElementById('txt_amoinword').value;
  
    //99-999..........................................................................
  
 
    m_bel999 = "";
    i = 1;
    document.getElementById('Text3').value = M_INPUT.substring(M_INPUTLEN - 6, M_INPUTLEN-5); //Val(Mid(M_INPUT, M_INPUTLEN - 2, 1))
	
	//alert(document.getElementById('Text3').value);
    if (document.getElementById('Text3').value > 0) {
       BEL_ninten();
       m_bel999 = document.getElementById('Text3').value;
	}
   document.getElementById('txt_amoinword').value=m_bel999+" "+document.getElementById('txt_amoinword').value;
	
 
   
   //.....Thousand.............................................................................
    m_say = "";
    m_say1 = "";
	
	m_amo="";
 	M_AMO1="";
	m_amo2="";
	
	if (M_INPUTLEN==8){
    	m_amo = M_INPUT.substring(M_INPUTLEN - 8, M_INPUTLEN-6); // Mid(M_INPUT, M_INPUTLEN - 4, 2)
    
    	M_AMO1 = M_INPUT.substring(M_INPUTLEN - 8, M_INPUTLEN-7)+"0";  //Mid(M_INPUT, M_INPUTLEN - 4, 1) + "0"
    	m_amo2 = M_INPUT.substring(M_INPUTLEN - 7, M_INPUTLEN-6); // Mid(M_INPUT, M_INPUTLEN - 3, 1)
	} else if (M_INPUTLEN==7){
		m_amo = M_INPUT.substring(M_INPUTLEN - 7, M_INPUTLEN-6); // Mid(M_INPUT, M_INPUTLEN - 4, 2)
    	
		M_AMO1="0";
    	//M_AMO1 = M_INPUT.substring(M_INPUTLEN - 7, M_INPUTLEN-6)+"0";  //Mid(M_INPUT, M_INPUTLEN - 4, 1) + "0"
    	m_amo2 = M_INPUT.substring(M_INPUTLEN - 7, M_INPUTLEN-6); // Mid(M_INPUT, M_INPUTLEN - 3, 1)
			
	}

    if (m_amo <= 19) {
       document.getElementById('Text3').value = m_amo;
       BEL_ninten();
       m_say = document.getElementById('Text3').value;
	   
	   
	} else {
       document.getElementById('Text3').value = M_AMO1;
	  // alert(M_AMO1);
       BEL_TY();
       m_say = document.getElementById('Text3').value;
      // alert(m_amo2);
       document.getElementById('Text3').value = m_amo2;
       BEL_ninten();
       m_say1 = document.getElementById('Text3').value;
	}
    m_bel1000 = m_say + " " + m_say1;
	
	
	if (m_bel1000.trim()!=""){
     	document.getElementById('txt_amoinword').value=m_bel1000+" Thousand "+document.getElementById('txt_amoinword').value;
	} 
  
    //....Lack..............................................................................
    m_say = "";
  
 
  	m_amo = M_INPUT.substring(M_INPUTLEN - 9, M_INPUTLEN-8);//  Mid(M_INPUT, M_INPUTLEN - 5, 1)
    if (m_amo <= 9) {
       document.getElementById('Text3').value = m_amo;
       BEL_ninten();
       m_say = document.getElementById('Text3').value;
	}
    m_bel100000 = m_say;
 	alert(m_bel100000);
	if (m_bel100000.trim()!=""){
     	document.getElementById('txt_amoinword').value=m_bel100000+" Lack  "+document.getElementById('txt_amoinword').value;
	} 
  
    //.....Million.............................................................................
    m_say = "";
    m_say1 = "";
    
	m_amo="";
 	M_AMO1="";
	m_amo2="";
 
	  
	if (M_INPUTLEN==11){
    	m_amo = M_INPUT.substring(M_INPUTLEN - 11, M_INPUTLEN-9); // Mid(M_INPUT, M_INPUTLEN - 4, 2)
    
    	M_AMO1 = M_INPUT.substring(M_INPUTLEN - 11, M_INPUTLEN-10)+"0";  //Mid(M_INPUT, M_INPUTLEN - 4, 1) + "0"
    	m_amo2 = M_INPUT.substring(M_INPUTLEN - 10, M_INPUTLEN-9); // Mid(M_INPUT, M_INPUTLEN - 3, 1)
	} else if (M_INPUTLEN==10){
		m_amo = M_INPUT.substring(M_INPUTLEN - 10, M_INPUTLEN-9); // Mid(M_INPUT, M_INPUTLEN - 4, 2)
    	
		M_AMO1="0";
    	//M_AMO1 = M_INPUT.substring(M_INPUTLEN - 7, M_INPUTLEN-6)+"0";  //Mid(M_INPUT, M_INPUTLEN - 4, 1) + "0"
    	m_amo2 = M_INPUT.substring(M_INPUTLEN - 10, M_INPUTLEN-9); // Mid(M_INPUT, M_INPUTLEN - 3, 1)
			
	}
	
    if (m_amo <= 19) {
       document.getElementById('Text3').value = m_amo;
       BEL_ninten();
       m_say = document.getElementById('Text3').value;
	} else {
       document.getElementById('Text3').value = M_AMO1;
       BEL_TY();
       m_say = document.getElementById('Text3').value;
       
       document.getElementById('Text3').value = m_amo2;
       BEL_ninten();
       m_say1 = document.getElementById('Text3').value;
	}
	
    m_overmil = m_say + " " + m_say1;
	
  
  
    //document.getElementById('txt_amoinword').value = "   " + "And";
    //..................................................................................
	
/*	txt_amoinword=document.getElementById('txt_amoinword').value;
	txt_amoinword_len=txt_amoinword.length;
    if (m_overmil != "") {
		//Mid(Me.txt_amoinword, Len(Me.txt_amoinword) - 2, 3)
       if (txt_amoinword.substring(txt_amoinword_len - 3, txt_amoinword_len)  != "And"){
          document.getElementById('txt_amoinword').value = document.getElementById('txt_amoinword').value + "   ";
	   }
       document.getElementById('txt_amoinword').value = document.getElementById('txt_amoinword').value + " " + m_overmil + " Million ";
	}
    
    if (m_bel100000 != "") {
		// Mid(Me.txt_amoinword, Len(Me.txt_amoinword) - 2, 3)
       if (txt_amoinword.substring(txt_amoinword_len - 3, txt_amoinword_len)   != "  ") {
          document.getElementById('txt_amoinword').value = document.getElementById('txt_amoinword').value + "   ";
	   }
       document.getElementById('txt_amoinword').value = document.getElementById('txt_amoinword').value + " " + m_bel100000 + " Hundred";
       if (m_bel1000 == "") { document.getElementById('txt_amoinword').value = document.getElementById('txt_amoinword').value + " Thousand"; }
	}
    
    if (m_bel1000 != "") {
		//Mid(Me.txt_amoinword, Len(Me.txt_amoinword) - 2, 3)
       if (txt_amoinword.substring(txt_amoinword_len - 3, txt_amoinword_len)   != "And") {
          document.getElementById('txt_amoinword').value = document.getElementById('txt_amoinword').value + "   ";
	   }
       document.getElementById('txt_amoinword').value = document.getElementById('txt_amoinword').value + " " + m_bel1000 + " Thousand ";
	}
    
    if (m_bel999 != "") {
		//Mid(Me.txt_amoinword, Len(Me.txt_amoinword) - 2, 3)
       if (txt_amoinword.substring(txt_amoinword_len - 3, txt_amoinword_len)   != "And") {
          document.getElementById('txt_amoinword').value = document.getElementById('txt_amoinword').value + "   ";
	   }
       document.getElementById('txt_amoinword').value = document.getElementById('txt_amoinword').value + " " + m_bel999 + " Hundred ";
	}
    
    if (m_bel99 != "") {
		//Mid(Me.txt_amoinword, Len(Me.txt_amoinword) - 2, 3)
       if (txt_amoinword.substring(txt_amoinword_len - 3, txt_amoinword_len)  != "And") {
          document.getElementById('txt_amoinword').value = document.getElementById('txt_amoinword').value + "   ";
	   }
       document.getElementById('txt_amoinword').value = document.getElementById('txt_amoinword').value + " " + m_bel99;
	}
    
    if (m_cent != "") {
		//Mid(Me.txt_amoinword, Len(Me.txt_amoinword) - 2, 3)
       if (txt_amoinword.substring(txt_amoinword_len - 3, txt_amoinword_len)   != "And") {
          document.getElementById('txt_amoinword').value = document.getElementById('txt_amoinword').value + " And";
	   }
       document.getElementById('txt_amoinword').value = document.getElementById('txt_amoinword').value + " Cents " + m_cent;
	}*/
   // document.getElementById('txt_amoinword').value = txt_amoinword.substring(6, txt_amoinword_len - 2); //txt_amoinword_len) Mid(Me.txt_amoinword, 5, Len(Me.txt_amoinword) - 3)
    //999..........................................................................
}

function BEL_ninten(){
  m_amo = document.getElementById('Text3').value;
  if (m_amo == 0) { M_TXT = ""; }
  if (m_amo == 1) { M_TXT = "One"; }
  if (m_amo == 2) { M_TXT = "Two"; }
  if (m_amo == 3) { M_TXT = "Three"; }
  if (m_amo == 4) { M_TXT = "Four"; }
  if (m_amo == 5) { M_TXT = "Five"; }
  if (m_amo == 6) { M_TXT = "Six"; }
  if (m_amo == 7) { M_TXT = "Seven"; }
  if (m_amo == 8) { M_TXT = "Eight"; }
  if (m_amo == 9) { M_TXT = "Nine"; }
  if (m_amo == 10) { M_TXT = "Ten"; }
  if (m_amo == 11) { M_TXT = "Eleven"; }
  if (m_amo == 12) { M_TXT = "Twelve"; }
  if (m_amo == 13) { M_TXT = "Thirteen"; }
  if (m_amo == 14) { M_TXT = "Fourteen"; }
  if (m_amo == 15) { M_TXT = "Fifteen"; }
  if (m_amo == 16) { M_TXT = "Sixteen"; }
  if (m_amo == 17) { M_TXT = "Seventeen"; }
  if (m_amo == 18) { M_TXT = "Eighteen"; }
  if (m_amo == 19) { M_TXT = "Nineteen"; }
  document.getElementById('Text3').value = M_TXT;
}

function  BEL_TY(){
 m_amo = document.getElementById('Text3').value;
 if ((m_amo >= 20) && (m_amo < 30)) { M_TXT = "Twenty"; }
 if ((m_amo >= 30) && (m_amo < 40)) { M_TXT = "Thirty"; }
 if ((m_amo >= 40) && (m_amo < 50)) { M_TXT = "Forty"; }
 if ((m_amo >= 50) && (m_amo < 60)) { M_TXT = "Fifty"; }
 if ((m_amo >= 60) && (m_amo < 70)) { M_TXT = "Sixty"; }
 if ((m_amo >= 70) && (m_amo < 80)) { M_TXT = "Seventy"; }
 if ((m_amo >= 80) && (m_amo < 90)) { M_TXT = "Eighty"; }
 if ((m_amo >= 90) && (m_amo < 99)) { M_TXT = "Ninety"; }
 document.getElementById('Text3').value = M_TXT;
}