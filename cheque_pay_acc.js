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

function update_vat()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
				var url="cheque_pay_data_acc.php";			
				url=url+"?Command="+"update_vat";
				url=url+"&txt_bea="+document.getElementById('txt_bea').value;
				url=url+"&txtVATNO="+document.getElementById('txtVATNO').value;
				
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_update_vat;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function passcusresult_update_vat()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		
		alert("VAT No is Updated");	
		document.getElementById('vatno').innerHTML=document.getElementById('txtVATNO').value;
	}
	
}

function ledgno_ind(stname)
{   
			//alert(stname);
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			if (stname=="ledger"){
				var url="search_ledger_data_acc.php";			
				url=url+"?Command="+"pass_ledger";
				url=url+"&ledgno="+custno;
							
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_ledger;
			}
			
			if (stname=="ledger_sel"){
				var url="search_ledger_data_acc.php";			
				url=url+"?Command="+"pass_ledger_sel";
				url=url+"&ledgno="+custno;
							
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_ledger_sel;
			}
			
			if (stname=="cash_rec1"){
				var url="search_ledger_data_acc.php";			
				url=url+"?Command="+"pass_cash_rec";
				url=url+"&ledgno="+custno;
							
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_cash_rec1;
			}
			
			if (stname=="cash_rec2"){
				var url="search_ledger_data_acc.php";			
				url=url+"?Command="+"pass_cash_rec";
				url=url+"&ledgno="+custno;
							
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_cash_rec2;
			}
			
			if (stname=="cash_pay"){
				var url="search_ledger_data_acc.php";			
				url=url+"?Command="+"pass_cash_rec";
				url=url+"&ledgno="+custno;
							
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_cash_pay;
			}
			
			if (stname=="cheque_pay"){
				var url="search_ledger_data_acc.php";			
				url=url+"?Command="+"pass_cash_rec";
				url=url+"&ledgno="+document.getElementById('accno').value;
							
				
				xmlHttp.onreadystatechange=passcusresult_cheque_pay_ind;
			}
			
			if (stname=="rec_ent"){
				var url="search_ledger_data_acc.php";			
				url=url+"?Command="+"pass_rec_ent";
				url=url+"&ledgno="+custno;
							
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_rec_ent;
			}
			
			if (stname=="rec_ent2"){
				var url="search_ledger_data_acc.php";			
				url=url+"?Command="+"rec_ent2";
				url=url+"&ledgno="+custno;
							
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_rec_ent2;
			}
			
			if (stname=="journal_ent1"){
				var url="search_ledger_data_acc.php";			
				url=url+"?Command="+"journal_ent1";
				url=url+"&ledgno="+custno;
							
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_journal_ent1;
			}
			
			if (stname=="bankdepo_ent1"){
				var url="search_ledger_data_acc.php";			
				url=url+"?Command="+"bankdepo_ent1";
				url=url+"&ledgno="+custno;
							
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_bankdepo_ent1;
			}
			
			if (stname=="journal_ent2"){
				var url="search_ledger_data_acc.php";			
				url=url+"?Command="+"journal_ent2";
				url=url+"&ledgno="+custno;
							
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_journal_ent2;
			}
			
			if (stname=="bank_trans"){
				var url="search_ledger_data_acc.php";			
				url=url+"?Command="+"bank_trans";
				url=url+"&ledgno="+custno;
							
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_bank_trans;
			}
			
			if (stname=="bank_trans_acc"){
				var url="search_ledger_data_acc.php";			
				url=url+"?Command="+"bank_trans";
				url=url+"&ledgno="+custno;
							
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_bank_trans;
			}
			
			
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}


function passcusresult_cheque_pay_ind()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_code");	
		document.getElementById('accno').value =XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_name");	
		document.getElementById('acc_name').value =XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('descript').value =document.getElementById('TXT_NARA').value;
		
		document.getElementById('amt').focus();
		//opener.document.form1.amt.focus();
		//alert("OK");
		
	}
}


function set_nara_comm()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
	var url="cheque_pay_data_acc.php";			
				url=url+"?Command="+"set_nara_comm";
				url=url+"&Combo1="+document.getElementById('Combo1').value;
				//url=url+"&TXT_NARA="+document.getElementById('TXT_NARA').value;
					//alert(url);		
				
				xmlHttp.onreadystatechange=passcusresult_set_nara_comm;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);	
}

function passcusresult_set_nara_comm()
{
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cheque_no");	
		document.getElementById('TXT_NARA').value=document.getElementById('TXT_NARA').value+xmlHttp.responseText;
		
		
		
	}
}

function set_nara()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
	var url="cheque_pay_data_acc.php";			
				url=url+"?Command="+"set_nara";
				url=url+"&Combo2="+document.getElementById('Combo2').value;
				url=url+"&TXT_NARA="+document.getElementById('TXT_NARA').value;
							
				
				xmlHttp.onreadystatechange=passcusresult_set_nara;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);	
}


function passcusresult_set_nara()
{
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cheque_no");	
		document.getElementById('TXT_NARA').value=xmlHttp.responseText;
		
		
		
	}
}

function set_nara_inc()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
	var url="cheque_pay_data_acc.php";			
				url=url+"?Command="+"set_nara_inc";
				url=url+"&Combo3="+document.getElementById('Combo3').value;
				url=url+"&TXT_NARA="+document.getElementById('TXT_NARA').value;
							
				
				xmlHttp.onreadystatechange=passcusresult_set_nara;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);	
}


function passcusresult_set_inc()
{
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cheque_no");	
		document.getElementById('TXT_NARA').value=xmlHttp.responseText;
		
		
		
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
	
	vatno=xmlHttp.responseText;
	
	document.getElementById('txt_cheno').value= vatno.substring(1, 7);
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
			
			
			document.getElementById('new1').value=1;
			document.getElementById('edit').value=0;
			document.getElementById('chkprint').value=0;
			
			document.getElementById('txt_entno').value="";
			document.getElementById('TXT_HEADING').value="";
			document.getElementById('txt_bea').value="";
		
			
			document.getElementById('txtINVNO').value="";
			document.getElementById('TXT_NARA').value="";
			document.getElementById('Check1').checked=false;
			document.getElementById('DTinv_date').value="";
			document.getElementById('txtVATNO').value="";
			
			document.getElementById('txt_amoinword').value="";
			document.getElementById('txt_bea1').value="";
			document.getElementById('txt_bea2').value="";
			document.getElementById('txt_bea3').value="";
			
			document.getElementById('txtVATNO').value="";
			document.getElementById('txtVATNO1').value="";
			document.getElementById('txtVATNO2').value="";
			document.getElementById('txtVATNO3').value="";
			document.getElementById('txt_cheno').value="";
			
			document.getElementById('accno').value="";
			document.getElementById('acc_name').value="";
			document.getElementById('descript').value="";
			document.getElementById('amt').value="";
		
			document.getElementById('chq_table').innerHTML="";
			
			document.getElementById('TXT_DEBTOT').value="";
			
			document.getElementById('txtvatbea').value="";
			document.getElementById('Combo1').value="";
			
			document.getElementById('Combo2').value="";
			document.getElementById('com_cas').value="";
			document.getElementById('txt_cheno').value="";
			
			document.getElementById('vatno').innerHTML="";
			
			document.getElementById('txt_bea').disabled =false;
			document.getElementById('txtINVNO').disabled =false;
			document.getElementById('DTinv_date').disabled =false;
			document.getElementById('Calendar1').disabled =false;
			
			document.getElementById('txtVATNO').disabled =false;
			document.getElementById('Combo1').disabled =false;
			document.getElementById('Combo2').disabled =false;
			document.getElementById('com_cas').disabled =false;
			document.getElementById('txt_cheno').disabled =false;
			document.getElementById('additem_tmp').disabled =false;
			document.getElementById('searchinv6').disabled =false;
			document.getElementById('txtVATNO1').disabled =false;
			document.getElementById('txt_bea2').disabled =false;
			document.getElementById('searchinv7').disabled =false;
			document.getElementById('txtVATNO2').disabled =false;
			document.getElementById('txt_bea3').disabled =false;
			document.getElementById('searchinv8').disabled =false;
			document.getElementById('txtVATNO3').disabled =false;
			document.getElementById('chqdate').disabled =false;
			document.getElementById('searchinv2').disabled =false;
			document.getElementById('Check1').disabled =false;
			
			
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
	
	//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_cheno");	
	//document.getElementById('txt_cheno').value= XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Calendar1");	
	document.getElementById('Calendar1').value= XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqdate");	
	document.getElementById('chqdate').value= XMLAddress1[0].childNodes[0].nodeValue;
		
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("incentive");	
	document.getElementById('incent').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;	
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("commission");	
	document.getElementById('commi').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;	
		
	//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");	
	//document.getElementById('Txtcusco').value= XMLAddress1[0].childNodes[0].nodeValue;
		
	//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");	
	//document.getElementById('txtcusname').value= XMLAddress1[0].childNodes[0].nodeValue;
	
	//document.getElementById('searchcust2').focus();
	
}


function chk_vat()
{
	var txtVATNO=document.getElementById('txtVATNO').value;
	
	if (txtVATNO.length==14){
		var spase=txtVATNO.substring(9, 10);
		
		if(spase!=" "){
			alert("Invalid VAT No");	
		}
	} else {
		alert("Invalid VAT No");		
	}
}

function chk_vat1()
{
	var txtVATNO=document.getElementById('txtVATNO1').value;
	
	if (txtVATNO.length==14){
		var spase=txtVATNO.substring(9, 10);
		
		if(spase!=" "){
			alert("Invalid VAT No");	
		}
	} else {
		alert("Invalid VAT No");		
	}
}

function chk_vat2()
{
	var txtVATNO=document.getElementById('txtVATNO2').value;
	
	if (txtVATNO.length==14){
		var spase=txtVATNO.substring(9, 10);
		
		if(spase!=" "){
			alert("Invalid VAT No");	
		}
	} else {
		alert("Invalid VAT No");		
	}
}

function chk_vat3()
{
	var txtVATNO=document.getElementById('txtVATNO3').value;
	
	if (txtVATNO.length==14){
		var spase=txtVATNO.substring(9, 10);
		
		if(spase!=" "){
			alert("Invalid VAT No");	
		}
	} else {
		alert("Invalid VAT No");		
	}
}

/*
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
*/
function addchq_cash_rec()
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		if ((document.getElementById('new1').value==1) || (document.getElementById('edit').value==1)){ 	
			var url="cheque_pay_data_acc.php";			
			url=url+"?Command="+"addchq_cash_rec";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&accno="+document.getElementById('accno').value;
			url=url+"&acc_name="+document.getElementById('acc_name').value;
			
			myString=document.getElementById("descript").value;
			myString = myString.replace(/[\r\n]/g, "<br/>");
			url=url+"&descript="+myString;
			
			
			url=url+"&amt="+document.getElementById('amt').value;
			url=url+"&txt_bea="+document.getElementById('txt_bea').value;
			
			
			xmlHttp.onreadystatechange=addchq_cash_rec_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		} else {
			alert("Can't Add Items"); 	
		}
}

function addchq_cash_rec_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamt");	
		document.getElementById('TXT_DEBTOT').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");	
		document.getElementById('chq_table').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vatno");	
		
		if (XMLAddress1[0].childNodes[0].nodeValue!=""){
			document.getElementById('txtVATNO').value= XMLAddress1[0].childNodes[0].nodeValue;
		}
		
	
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("bea1");	
		
		if (XMLAddress1[0].childNodes[0].nodeValue!=""){
			document.getElementById('txtvatbea').value= XMLAddress1[0].childNodes[0].nodeValue;
		}
		
		
		
		
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
			
			var amt="amt_acc"+i;
			
			url=url+"&amt="+document.getElementById(amt).value;
			
			//alert(url);
			
			xmlHttp.onreadystatechange=del_item_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function setamt_opr(i)
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
			var c_code="accno_acc"+i;
			url=url+"&accno="+document.getElementById(c_code).value;
			
			var amt="amt_acc"+i;
			
			url=url+"&amt="+document.getElementById(amt).value;
			
			//alert(url);
			
			xmlHttp.onreadystatechange=del_item_result_opr;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function del_item_result_opr()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		document.getElementById('TXT_DEBTOT').value=xmlHttp.responseText;
	}
}

/*
function setamt_opr(accno, i)
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
			
			//alert(url);
			
			xmlHttp.onreadystatechange=del_item_result_opr;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}*/

function del_item_result_opr()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		document.getElementById('TXT_DEBTOT').value=xmlHttp.responseText;
	}
}

function del_item(accno)
{
	if ((document.getElementById('new1').value==1) || (document.getElementById('edit').value==1)){	
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
			//alert(url);
			
			xmlHttp.onreadystatechange=del_item_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	} else {
		alert("Can't Edit");	
	}
}

function del_item_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamt");	
		document.getElementById('TXT_DEBTOT').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");	
		document.getElementById('chq_table').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		
		amoword_cal();
		
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
			
			//alert(url);
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
 if (document.getElementById('new1').value==0){	
 
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
			url=url+"&com_cas="+document.getElementById("com_cas").value;
		
			//alert(url);
	
		xmlHttp.onreadystatechange=result_delete_rec;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
  }
 } else {
	alert("You can't be DELETE!!! You are trying to add NEW Record"); 
 }
}

function result_delete_rec()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		if (xmlHttp.responseText=="Canceled"){
			location.reload(true);
			//setTimeout("location.reload(true);",500);
		}
	}
}

function edit_rec()
{
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		
	if (document.getElementById('new1').value==0){	
			document.getElementById('new1').value=0;
			document.getElementById('edit').value=1;
			document.getElementById('chkprint').value=1;
			
		
	/*	opener.document.form1.Calendar1.disabled =false;
		opener.document.form1.chqdate.disabled =false;
		opener.document.form1.Check1.disabled =false;
		opener.document.form1.txt_bea.disabled =false;
		opener.document.form1.txtINVNO.disabled =false;
		opener.document.form1.DTinv_date.disabled =false;
		opener.document.form1.txtVATNO.disabled =false;
		opener.document.form1.txt_bea1.disabled =false;
		opener.document.form1.searchinv6.disabled =false;
		opener.document.form1.txtVATNO1.disabled =false;
		opener.document.form1.txt_bea2.disabled =false;
		opener.document.form1.searchinv7.disabled =false;
		opener.document.form1.txtVATNO2.disabled =false;
		opener.document.form1.txt_bea3.disabled =false;
		opener.document.form1.searchinv8.disabled =false;
		opener.document.form1.txtVATNO3.disabled =false;
		opener.document.form1.TXT_NARA.disabled =false;
		opener.document.form1.txtvatbea.disabled =false;
		opener.document.form1.Combo1.disabled =false;
		opener.document.form1.Combo2.disabled =false;
		opener.document.form1.txt_amoinword.disabled =false;
		opener.document.form1.com_cas.disabled =false;
		opener.document.form1.txt_cheno.disabled =false;
		opener.document.form1.additem_tmp2.disabled =false;
		opener.document.form1.additem_tmp.disabled =false;
		opener.document.form1.accno.disabled =false;
		opener.document.form1.acc_name.disabled =false;
		opener.document.form1.descript.disabled =false;
		opener.document.form1.amt.disabled =false;
		opener.document.form1.TXT_DEBTOT.disabled =false;*/
			
			var url="cheque_pay_data_acc.php";			
			url=url+"?Command="+"edit_rec";
			xmlHttp.onreadystatechange=result_edit_rec;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	} else {
		alert ("You	can't be EDIT!!!     You are trying to add NEW Record");
	}
			
}


function result_edit_rec()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		
		document.getElementById('txt_bea').disabled =false;
			document.getElementById('txtINVNO').disabled =false;
			document.getElementById('DTinv_date').disabled =false;
			document.getElementById('txtVATNO').disabled =false;
			document.getElementById('Combo1').disabled =false;
			document.getElementById('Combo2').disabled =false;
			document.getElementById('com_cas').disabled =false;
			document.getElementById('txt_cheno').disabled =false;
			document.getElementById('additem_tmp').disabled =false;
			document.getElementById('txt_bea1').disabled =false;
			document.getElementById('searchinv6').disabled =false;
			document.getElementById('txtVATNO1').disabled =false;
			document.getElementById('txt_bea2').disabled =false;
			document.getElementById('searchinv7').disabled =false;
			document.getElementById('txtVATNO2').disabled =false;
			document.getElementById('txt_bea3').disabled =false;
			document.getElementById('searchinv8').disabled =false;
			document.getElementById('txtVATNO3').disabled =false;
			document.getElementById('searchinv2').disabled =false;
			
		alert("You can be edit");
		//alert(xmlHttp.responseText);
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
			
			
		if ((document.getElementById('new1').value==1) || (document.getElementById('edit').value==1)){ 	
			var url="cheque_pay_data_acc.php";			
			url=url+"?Command="+"save_crec";
			url=url+"&txt_entno="+document.getElementById("txt_entno").value;
			url=url+"&TXT_HEADING="+document.getElementById("TXT_HEADING").value;
			
			myString=document.getElementById('txt_bea').value;
			myString = myString.replace(/[\r\n]/g, "<br/>");
			myString = myString.replace(/\s/g, "&nbsp;");
			myString = myString.replace(/'/g, "''");
			myString = myString.replace(/&/g,"~");
	
			url=url+"&txt_bea="+myString;
			
			url=url+"&txtINVNO="+document.getElementById("txtINVNO").value;
			
			myString=document.getElementById("TXT_NARA").value;
			myString = myString.replace(/[\r\n]/g, "<br/>");
			myString = myString.replace(/\s/g, "&nbsp;");
			myString = myString.replace(/'/g, "''");
			myString = myString.replace(/&/g,"~");
			
			str=myString;
			var TXT_NARA=str;
			
			url=url+"&TXT_NARA="+TXT_NARA;
			
			myString=document.getElementById('txtvatbea').value;
			myString = myString.replace(/[\r\n]/g, "<br/>");
			myString = myString.replace(/\s/g, "&nbsp;");
			myString = myString.replace(/'/g, "''");
			myString = myString.replace(/&/g,"~");
			
			url=url+"&txtvatbea="+myString;
			
			url=url+"&Combo1="+document.getElementById("Combo1").value;
			url=url+"&Calendar1="+document.getElementById("Calendar1").value;
			url=url+"&chqdate="+document.getElementById("chqdate").value;
			url=url+"&Check1="+document.getElementById("Check1").checked;
			url=url+"&DTinv_date="+document.getElementById("DTinv_date").value;
			url=url+"&txtVATNO="+document.getElementById("txtVATNO").value;
			url=url+"&txtVATNO1="+document.getElementById("txtVATNO1").value;
			url=url+"&txtVATNO2="+document.getElementById("txtVATNO2").value;
			url=url+"&txtVATNO3="+document.getElementById("txtVATNO3").value;
			
			myString=document.getElementById('txt_bea1').value;
			myString = myString.replace(/[\r\n]/g, "<br/>");
			myString = myString.replace(/\s/g, "&nbsp;");
			myString = myString.replace(/'/g, "''");
			myString = myString.replace(/&/g,"~");
			url=url+"&txt_bea1="+myString;
			
			myString=document.getElementById('txt_bea2').value;
			myString = myString.replace(/[\r\n]/g, "<br/>");
			myString = myString.replace(/\s/g, "&nbsp;");
			myString = myString.replace(/'/g, "''");
			myString = myString.replace(/&/g,"~");
			url=url+"&txt_bea2="+myString;
			
			myString=document.getElementById('txt_bea3').value;
			myString = myString.replace(/[\r\n]/g, "<br/>");
			myString = myString.replace(/\s/g, "&nbsp;");
			myString = myString.replace(/'/g, "''");
			myString = myString.replace(/&/g,"~");
			url=url+"&txt_bea3="+myString;
			
			url=url+"&Combo2="+document.getElementById("Combo2").value;
			url=url+"&Combo3="+document.getElementById("Combo3").value;
			
			url=url+"&txt_amoinword="+document.getElementById("txt_amoinword").value;
			url=url+"&com_cas="+document.getElementById("com_cas").value;
			url=url+"&txt_cheno="+document.getElementById("txt_cheno").value;
						
			url=url+"&accno="+document.getElementById("accno").value;
			url=url+"&acc_name="+document.getElementById("acc_name").value;
			
			
			myString=document.getElementById("descript").value;
			myString = myString.replace(/[\r\n]/g, "<br/>");
			url=url+"&descript="+myString;
			
			url=url+"&amt="+document.getElementById("amt").value;
			
			url=url+"&TXT_DEBTOT="+document.getElementById('TXT_DEBTOT').value;
			
			
			
			
			//alert(url);
			xmlHttp.onreadystatechange=result_save_crec;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
		} else {
			alert ("Can't Save");	
		}
}

function result_save_crec()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		if (xmlHttp.responseText=="Please login again"){
			alert(xmlHttp.responseText);
		} else if (xmlHttp.responseText=="VAT Details Not Completed"){
			alert(xmlHttp.responseText);
		} else if (xmlHttp.responseText=="Invalid Option, Please Select Option New and Enter Cheque"){
			alert(xmlHttp.responseText);
		} else if (xmlHttp.responseText=="Cheque Number Not Selected"){
			alert(xmlHttp.responseText);
		} else if (xmlHttp.responseText=="Jouirnal No Not Entered"){
			alert(xmlHttp.responseText);
		} else if (xmlHttp.responseText=="Ledger Entry Is Incomplete"){
			alert(xmlHttp.responseText);
		} else if (xmlHttp.responseText=="Please Enter Barer Name"){
			alert(xmlHttp.responseText);
		} else if (xmlHttp.responseText=="Please select Bank"){
			alert(xmlHttp.responseText);
		} else  if (xmlHttp.responseText=="Sorry You Have Changed The Cheque Value"){
			alert(xmlHttp.responseText);
		} else  if (xmlHttp.responseText=="Invalid Bank"){
			alert(xmlHttp.responseText);
		} else  if (xmlHttp.responseText=="Locked"){
			alert(xmlHttp.responseText);
		} else  if (xmlHttp.responseText=="Can't ADD or EDIT. This Transaction id Locked!!!"){
			alert(xmlHttp.responseText);
		} else  if (xmlHttp.responseText=="Out of Current Accounting Year"){
			alert(xmlHttp.responseText);
		} else  if (xmlHttp.responseText=="Transaction NOT Saved !!!"){	
			alert(xmlHttp.responseText);
		} else if (xmlHttp.responseText=="Can't ADD or EDIT Transaction. Reconciliation is Completed!!!"){	
			alert(xmlHttp.responseText);
		} else if (xmlHttp.responseText=="Can't EDIT Date. Reconciliation is Completed!!!"){	
			alert(xmlHttp.responseText);	
		} else {  
		
			
			document.getElementById('txt_entno').value = xmlHttp.responseText;
			
			alert("Records are saved as - "+xmlHttp.responseText);
			
			document.getElementById('new1').value=0;
			document.getElementById('edit').value=0;
			document.getElementById('chkprint').value=1;
		
		
			document.getElementById('txt_bea').disabled =true;
			document.getElementById('txtINVNO').disabled =true;
			document.getElementById('DTinv_date').disabled =true;
			document.getElementById('txtVATNO').disabled =true;
			document.getElementById('Combo1').disabled =true;
			document.getElementById('Combo2').disabled =true;
			document.getElementById('com_cas').disabled =true;
			document.getElementById('txt_cheno').disabled =true;
			document.getElementById('additem_tmp').disabled =true;
			document.getElementById('txt_bea1').disabled =true;
			document.getElementById('searchinv6').disabled =true;
			document.getElementById('txtVATNO1').disabled =true;
			document.getElementById('txt_bea2').disabled =true;
			document.getElementById('searchinv7').disabled =true;
			document.getElementById('txtVATNO2').disabled =true;
			document.getElementById('txt_bea3').disabled =true;
			document.getElementById('searchinv8').disabled =true;
			document.getElementById('txtVATNO3').disabled =true;
			
		}
		
		
	
		
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

function chq_print_las() {
  
  if (document.getElementById('chkprint').value=="1"){
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 	
	
	var url="disp_chq.php";			
	url=url+"?Command="+"chq_print_las";
	url=url+"&txt_entno="+document.getElementById('txt_entno').value;
	url=url+"&com_cas="+document.getElementById('com_cas').value;
	//url=url+"&com_cas="+document.getElementById('com_cas').value;
	
	str=document.getElementById('txt_bea').value;
	var txt_bea=str.replace("&","~");
	
	url=url+"&txt_bea="+txt_bea
	url=url+"&txt_cheno="+document.getElementById('txt_cheno').value;
	url=url+"&Calendar1="+document.getElementById('Calendar1').value;
	url=url+"&chqdate="+document.getElementById('chqdate').value;
	url=url+"&txt_amoinword="+document.getElementById('txt_amoinword').value;
	url=url+"&TXT_DEBTOT="+document.getElementById('TXT_DEBTOT').value;
	url=url+"&chkprint="+document.getElementById('chkprint').value;
	url=url+"&Check1="+document.getElementById('Check1').checked;
	
		//alert(url);	
	window.open(url); 
  } else {
	alert("Please save before print");	  
  }
}

function vou_print_las() {
	
  if (document.getElementById('chkprint').value=="1"){	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 	
	
	var url="report_chq_pay_vouchar.php";			
	
	url=url+"?txt_entno="+document.getElementById('txt_entno').value;
	url=url+"&com_cas="+document.getElementById('com_cas').value;
	
	str=document.getElementById('txt_bea').value;
	var txt_bea=str.replace("&","~");
	url=url+"&txt_bea="+txt_bea;
	url=url+"&txt_cheno="+document.getElementById('txt_cheno').value;
	
	str=document.getElementById('TXT_NARA').value;
	//str.replace(/foo/g, "bar")
	//var TXT_NARA=str.replace("&","~");
	var TXT_NARA=str.replace(/&/g,"~");
	url=url+"&TXT_NARA="+TXT_NARA;
			
	window.open(url); 
  } else {
		alert("Please save before print");  
  }
			
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
			
			
			var url="cheque_pay_data_acc.php";			
			url=url+"?Command="+"search_rec";
			url=url+"&mstatus="+stname;
			
				
			if (document.getElementById('recno').value!=""){
				
				url=url+"&mfield=recno";
				url=url+"&recno="+document.getElementById('recno').value;
				
			} else if (document.getElementById('chqno').value!=""){
				
				url=url+"&mfield=chqno";
				url=url+"&chqno="+document.getElementById('chqno').value;
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

function set_acc(old_accno, i)
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
			
	var url="cheque_pay_data_acc.php";			
	url=url+"?Command="+"set_acc";
	var c_code="accno_acc"+i;
	
	url=url+"&txt_entno="+document.getElementById("txt_entno").value;
	url=url+"&accno="+document.getElementById(c_code).value;
	url=url+"&TXT_NARA="+document.getElementById("TXT_NARA").value;
	
	url=url+"&i="+i;
	url=url+"&old_accno="+old_accno;
	//alert(url);
					
	xmlHttp.onreadystatechange=result_set_acc;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
			
}

function result_set_acc()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("i");
		var i = XMLAddress1[0].childNodes[0].nodeValue;
		
		var c_code="accno_acc"+i;
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_code");
		document.getElementById(c_code).value = XMLAddress1[0].childNodes[0].nodeValue;
		
		var c_name="accname_acc"+i;
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_name");
		document.getElementById(c_name).value = XMLAddress1[0].childNodes[0].nodeValue;
		
		var descript="descript_acc"+i;
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TXT_NARA");
		document.getElementById(descript).value = XMLAddress1[0].childNodes[0].nodeValue;
		
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
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_entno");
//		document.getElementById('invno1').value = XMLAddress1[0].childNodes[0].nodeValue;
	//	alert(XMLAddress1[0].childNodes[0].nodeValue);
		opener.document.form1.txt_entno.value = XMLAddress1[0].childNodes[0].nodeValue;
		//opener.document.form1.invno.value = "111111111";
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Calendar1");
		opener.document.form1.Calendar1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqdate");
		opener.document.form1.chqdate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TXT_HEADING");
		opener.document.form1.TXT_HEADING.value=XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TXT_NARA");
		text=XMLAddress1[0].childNodes[0].nodeValue;
		
		//myString=document.getElementById("TXT_NARA").value;
		//myString = text.replace("<br />", "\n");
		myString = text.replace(/<br\s*\/?>/mg,"\n");
		
		
		//text = text.replace(/\r?\n/g, '<br />');
		//text = text.replace(/ <br /> /g,"\r\n");
		
		//text="aaaaa \r\n sadnknbaksd\r\n askndbasd";
		opener.document.form1.TXT_NARA.value = myString;
		
		
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
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("v_barer1");
		opener.document.form1.txt_bea1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vat1");
		opener.document.form1.txtVATNO1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("v_barer2");
		opener.document.form1.txt_bea2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vat2");
		opener.document.form1.txtVATNO2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("v_barer3");
		opener.document.form1.txt_bea3.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vat3");
		opener.document.form1.txtVATNO3.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Combo1");
		opener.document.form1.Combo1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");
		window.opener.document.getElementById('chq_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TXT_DEBTOT");
		opener.document.form1.TXT_DEBTOT.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		opener.document.form1.chkprint.value=1;
		opener.document.form1.edit.value=0;
		opener.document.form1.new1.value=0;
		
		
		
		opener.document.form1.chqdate.disabled =true;
		opener.document.form1.searchinv2.disabled =true;
		opener.document.form1.com_cas.disabled =true;
		opener.document.form1.txt_cheno.disabled =true;
		opener.document.form1.Check1.disabled =true;
		opener.document.form1.Combo1.disabled =true;
		opener.document.form1.Combo2.disabled =true;
		opener.document.form1.txt_amoinword.disabled =true;
		opener.document.form1.txt_bea.disabled =true;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("canedit");
		var canedit = XMLAddress1[0].childNodes[0].nodeValue;
		if (canedit=="0"){
			opener.document.form1.Calendar1.disabled =true;	
		} else {
			opener.document.form1.Calendar1.disabled =false;		
		}
		/*opener.document.form1.txt_entno.disabled =true;
		opener.document.form1.Calendar1.disabled =true;
		opener.document.form1.chqdate.disabled =true;
		opener.document.form1.Check1.disabled =true;
		opener.document.form1.txt_bea.disabled =true;
		opener.document.form1.txtINVNO.disabled =true;
		opener.document.form1.DTinv_date.disabled =true;
		opener.document.form1.txtVATNO.disabled =true;
		opener.document.form1.txt_bea1.disabled =true;
		opener.document.form1.searchinv6.disabled =true;
		opener.document.form1.txtVATNO1.disabled =true;
		opener.document.form1.txt_bea2.disabled =true;
		opener.document.form1.searchinv7.disabled =true;
		opener.document.form1.txtVATNO2.disabled =true;
		opener.document.form1.txt_bea3.disabled =true;
		opener.document.form1.searchinv8.disabled =true;
		opener.document.form1.txtVATNO3.disabled =true;
		opener.document.form1.TXT_NARA.disabled =true;
		opener.document.form1.txtvatbea.disabled =true;
		opener.document.form1.Combo1.disabled =true;
		opener.document.form1.Combo2.disabled =true;
		opener.document.form1.txt_amoinword.disabled =true;
		opener.document.form1.com_cas.disabled =true;
		opener.document.form1.txt_cheno.disabled =true;
		opener.document.form1.additem_tmp2.disabled =true;
		opener.document.form1.additem_tmp.disabled =true;
		opener.document.form1.accno.disabled =true;
		opener.document.form1.acc_name.disabled =true;
		opener.document.form1.descript.disabled =true;
		opener.document.form1.amt.disabled =true;
		opener.document.form1.TXT_DEBTOT.disabled =true;*/
		
		
		
		amoword_cal_opt();
		
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
		document.getElementById('txt_amoinword').value=" And Cents "+m_cent;
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
	if (m_bel999.trim()!=""){
   		document.getElementById('txt_amoinword').value=m_bel999+" Hundred "+document.getElementById('txt_amoinword').value;
	}
	
 
   
   //.....Thousand.............................................................................
    m_say = "";
    m_say1 = "";
	
	m_amo="";
 	M_AMO1="";
	m_amo2="";
	
	if (M_INPUTLEN>=8){
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
	   
	   m_amoH  = M_INPUT.substring(M_INPUTLEN - 8, M_INPUTLEN-6)
	   m_amoH1  = M_INPUT.substring(M_INPUTLEN - 6, M_INPUTLEN-3)
	   
	}
    m_bel100000 = m_say;
 	
	//alert(m_bel100000);
	debtot=document.getElementById('TXT_DEBTOT').value;
	if (m_bel100000.trim()!=""){
     	if (debtot.length>=9){
		  var txt_amoinword=document.getElementById('txt_amoinword').value;
		  a=txt_amoinword.search('Thousand')
		 // alert(document.getElementById('txt_amoinword').value);
		  
		  if (debtot>=100000){
			  if (m_amoH>0){
		  		document.getElementById('txt_amoinword').value=m_bel100000+" Hundred "+document.getElementById('txt_amoinword').value;
			  } else {
				  if (m_amoH1>0){
					document.getElementById('txt_amoinword').value=m_bel100000+" Hundred Thousand And "+document.getElementById('txt_amoinword').value;
				  } else {
					  document.getElementById('txt_amoinword').value=m_bel100000+" Hundred Thousand "+document.getElementById('txt_amoinword').value;
				  }
			  }
		  } else {
			document.getElementById('txt_amoinword').value=m_bel100000+" Hundred  "+document.getElementById('txt_amoinword').value;	  
		  }
		  /*if (Number(a)>0){
			document.getElementById('txt_amoinword').value=m_bel100000+" Hundred  "+document.getElementById('txt_amoinword').value;
		  } else {
			document.getElementById('txt_amoinword').value=m_bel100000+" Hundred  "+document.getElementById('txt_amoinword').value+" Thousand";  
		  }*/
		} else {
			document.getElementById('txt_amoinword').value=m_bel100000+" Hundred  "+document.getElementById('txt_amoinword').value;
		}
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
	if (m_overmil.trim()!=""){
     	document.getElementById('txt_amoinword').value=m_overmil+" Million "+document.getElementById('txt_amoinword').value;
	} 
  
  document.getElementById('txt_amoinword').value=document.getElementById('txt_amoinword').value+"  Only ";
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


function amoword_cal_opt(){
	
    var M_TXT = "";
   
    M_INPUT = opener.document.form1.TXT_DEBTOT.value; 
	
    M_INPUTLEN = M_INPUT.length;
    //Cents.........................................................................
    m_cent = "";
    ii = 0;
    m_ok = false;
	
	TXT_DEBTOT=opener.document.form1.TXT_DEBTOT.value;
	
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
		
       opener.document.form1.Text3.value = m_amo;
	   
       BEL_ninten_opt();
       m_say = opener.document.form1.Text3.value;
	} else {
		
       opener.document.form1.Text3.value = M_AMO1;
       BEL_TY_opt();
       m_say = opener.document.form1.Text3.value;
       
       opener.document.form1.Text3.value = m_amo2;
       BEL_ninten_opt();
       m_say1 = opener.document.form1.Text3.value;
	   
	}
	
    m_cent = m_say + " " + m_say1;
	if(m_cent!=" "){
		opener.document.form1.txt_amoinword.value="And Cents "+m_cent;
	} else {
		opener.document.form1.txt_amoinword.value=m_cent;	
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
       opener.document.form1.Text3.value = m_amo;
       BEL_ninten_opt();
       m_say = opener.document.form1.Text3.value;
	} else {
		
       opener.document.form1.Text3.value = M_AMO1;
       BEL_TY_opt();
       m_say = opener.document.form1.Text3.value;
      
       opener.document.form1.Text3.value = m_amo2;
       BEL_ninten_opt();
       m_say1 = opener.document.form1.Text3.value;
	  
	}
	
    m_bel99 = m_say + " " + m_say1;
	
 	opener.document.form1.txt_amoinword.value=m_bel99+" "+opener.document.form1.txt_amoinword.value;
  
    //99-999..........................................................................
  
 
    m_bel999 = "";
    i = 1;
    opener.document.form1.Text3.value = M_INPUT.substring(M_INPUTLEN - 6, M_INPUTLEN-5); //Val(Mid(M_INPUT, M_INPUTLEN - 2, 1))
	
	//alert(opener.document.form1.Text3.value);
    if (opener.document.form1.Text3.value > 0) {
       BEL_ninten_opt();
       m_bel999 = opener.document.form1.Text3.value;
	}
	if (m_bel999.trim()!=""){
   		opener.document.form1.txt_amoinword.value=m_bel999+" Hundred "+opener.document.form1.txt_amoinword.value;
		
	}
	
 
   
   //.....Thousand.............................................................................
    m_say = "";
    m_say1 = "";
	
	m_amo="";
 	M_AMO1="";
	m_amo2="";
	
	if (M_INPUTLEN>=8){
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
       opener.document.form1.Text3.value = m_amo;
       BEL_ninten_opt();
       m_say = opener.document.form1.Text3.value;
	   
	   
	} else {
       opener.document.form1.Text3.value = M_AMO1;
	  // alert(M_AMO1);
       BEL_TY_opt();
       m_say = opener.document.form1.Text3.value;
      // alert(m_amo2);
       opener.document.form1.Text3.value = m_amo2;
       BEL_ninten_opt();
       m_say1 = opener.document.form1.Text3.value;
	}
    m_bel1000 = m_say + " " + m_say1;
	
	
	if (m_bel1000.trim()!=""){
     	opener.document.form1.txt_amoinword.value=m_bel1000+" Thousand "+opener.document.form1.txt_amoinword.value;
	} 
  
   
    //....Lack..............................................................................
    m_say = "";
 
 
  	m_amo = M_INPUT.substring(M_INPUTLEN - 9, M_INPUTLEN-8);//  Mid(M_INPUT, M_INPUTLEN - 5, 1)
	
    if (m_amo <= 9) {
		
       opener.document.form1.Text3.value = m_amo;
       BEL_ninten_opt();
       m_say = opener.document.form1.Text3.value;
	   
	   m_amoH  = M_INPUT.substring(M_INPUTLEN - 8, M_INPUTLEN-6)
	   m_amoH1  = M_INPUT.substring(M_INPUTLEN - 6, M_INPUTLEN-3)
	   
	}
    m_bel100000 = m_say;
 	
	//alert(m_bel100000);
	debtot=opener.document.form1.TXT_DEBTOT.value;
	if (m_bel100000.trim()!=""){
     	if (debtot.length>=9){
		  var txt_amoinword= opener.document.form1.txt_amoinword.value;
		  a=txt_amoinword.search('Thousand')
		 // alert(document.getElementById('txt_amoinword').value);
		  
		  if (debtot>=100000){
			  if (m_amoH>0){
		  		opener.document.form1.txt_amoinword.value =m_bel100000+" Hundred "+ opener.document.form1.txt_amoinword.value ;
			  } else {
				  if (m_amoH1>0){
					opener.document.form1.txt_amoinword.value =m_bel100000+" Hundred Thousand And "+opener.document.form1.txt_amoinword.value ;
				  } else {
					  opener.document.form1.txt_amoinword.value =m_bel100000+" Hundred Thousand "+ opener.document.form1.txt_amoinword.value;
				  }
			  }
		  } else {
			opener.document.form1.txt_amoinword.value=m_bel100000+" Hundred  "+ opener.document.form1.txt_amoinword.value ;	  
		  }
		  /*if (Number(a)>0){
			document.getElementById('txt_amoinword').value=m_bel100000+" Hundred  "+document.getElementById('txt_amoinword').value;
		  } else {
			document.getElementById('txt_amoinword').value=m_bel100000+" Hundred  "+document.getElementById('txt_amoinword').value+" Thousand";  
		  }*/
		} else {
			opener.document.form1.txt_amoinword.value=m_bel100000+" Hundred  "+opener.document.form1.txt_amoinword.value ;
		}
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
       opener.document.form1.Text3.value = m_amo;
       BEL_ninten_opt();
       m_say = opener.document.form1.Text3.value;
	} else {
       opener.document.form1.Text3.value = M_AMO1;
       BEL_TY_opt();
       m_say = opener.document.form1.Text3.value;
       
       opener.document.form1.Text3.value = m_amo2;
       BEL_ninten_opt();
       m_say1 = opener.document.form1.Text3.value;
	}
	
    m_overmil = m_say + " " + m_say1;
	if (m_overmil.trim()!=""){
     	opener.document.form1.txt_amoinword.value=m_overmil+" Million "+opener.document.form1.txt_amoinword.value;
	} 
  
  opener.document.form1.txt_amoinword.value=opener.document.form1.txt_amoinword.value+" Only";
  
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

function BEL_ninten_opt(){
  m_amo = opener.document.form1.Text3.value;
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
  opener.document.form1.Text3.value = M_TXT;
}

function  BEL_TY_opt(){
 m_amo = opener.document.form1.Text3.value;
 if ((m_amo >= 20) && (m_amo < 30)) { M_TXT = "Twenty"; }
 if ((m_amo >= 30) && (m_amo < 40)) { M_TXT = "Thirty"; }
 if ((m_amo >= 40) && (m_amo < 50)) { M_TXT = "Forty"; }
 if ((m_amo >= 50) && (m_amo < 60)) { M_TXT = "Fifty"; }
 if ((m_amo >= 60) && (m_amo < 70)) { M_TXT = "Sixty"; }
 if ((m_amo >= 70) && (m_amo < 80)) { M_TXT = "Seventy"; }
 if ((m_amo >= 80) && (m_amo < 90)) { M_TXT = "Eighty"; }
 if ((m_amo >= 90) && (m_amo < 99)) { M_TXT = "Ninety"; }
 opener.document.form1.Text3.value = M_TXT;
}