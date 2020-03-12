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

function setamt_opr(i)
{
	
	
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="journal_data_acc.php";			
			url=url+"?Command="+"setamt";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			var c_code="accno_deb"+i;
			url=url+"&accno="+document.getElementById(c_code).value;
			
			var amt="jouamt_deb"+i;
			
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


function setamt_opr2(i)
{
	
	
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="journal_data_acc.php";			
			url=url+"?Command="+"setamt2";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			var c_code="accno_cre"+i;
			url=url+"&accno="+document.getElementById(c_code).value;
			
			var amt="jouamt_cre"+i;
			
			url=url+"&amt="+document.getElementById(amt).value;
			
			//alert(url);
			
			xmlHttp.onreadystatechange=del_item_result_opr2;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function del_item_result_opr2()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		document.getElementById('TXT_creTOT').value=xmlHttp.responseText;
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
			
			
	var url="journal_data_acc.php";			
	url=url+"?Command="+"set_acc";
	var c_code="accno_deb"+i;
	url=url+"&txt_entno="+document.getElementById("txt_entno").value;
	url=url+"&accno="+document.getElementById(c_code).value;
	url=url+"&TXT_NARA="+document.getElementById("TXT_DETAILS").value;
	
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
		
		var c_code="accno_deb"+i;
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_code");
		document.getElementById(c_code).value = XMLAddress1[0].childNodes[0].nodeValue;
		
		var c_name="accname_deb"+i;
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_name");
		document.getElementById(c_name).value = XMLAddress1[0].childNodes[0].nodeValue;
		
		var descript="descript_deb"+i;
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TXT_NARA");
		document.getElementById(descript).value = XMLAddress1[0].childNodes[0].nodeValue;
		
	}
}

function set_acc2(old_accno, i)
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
			
	var url="journal_data_acc.php";			
	url=url+"?Command="+"set_acc2";
	var c_code="accno_cre"+i;
	
	url=url+"&txt_entno="+document.getElementById("txt_entno").value;
	url=url+"&accno="+document.getElementById(c_code).value;
	url=url+"&TXT_NARA="+document.getElementById("TXT_DETAILS").value;
	
	url=url+"&i="+i;
	url=url+"&old_accno="+old_accno;
	//alert(url);
					
	xmlHttp.onreadystatechange=result_set_acc2;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
			
}

function result_set_acc2()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("i");
		var i = XMLAddress1[0].childNodes[0].nodeValue;
		
		var c_code="accno_cre"+i;
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_code");
		document.getElementById(c_code).value = XMLAddress1[0].childNodes[0].nodeValue;
		
		var c_name="accname_cre"+i;
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_name");
		document.getElementById(c_name).value = XMLAddress1[0].childNodes[0].nodeValue;
		
		var descript="descript_cre"+i;
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TXT_NARA");
		document.getElementById(descript).value = XMLAddress1[0].childNodes[0].nodeValue;
		
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
			document.getElementById('TXT_DETAILS').value="";
			
		
			document.getElementById('chq_table1').innerHTML="";
			document.getElementById('chq_table2').innerHTML="";
			
			document.getElementById('TXT_DEBTOT').value="";
			document.getElementById('TXT_creTOT').value="";
		
		
			document.getElementById('new1').value=1;
			document.getElementById('edit').value=0;
			document.getElementById('chkprint').value=0;
			
			var url="journal_data_acc.php";			
			url=url+"?Command="+"new_rec";
			//url=url+"&com_cas="+document.getElementById('com_cas').value;
		  
			xmlHttp.onreadystatechange=assign_invno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function assign_invno(){
	//alert(xmlHttp.responseText);
	//location.reload(true);
	
	//document.getElementById('txt_entno').value= xmlHttp.responseText;
	
	
		
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_entno");	
	document.getElementById('txt_entno').value= XMLAddress1[0].childNodes[0].nodeValue;
		
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_curdate");	
	document.getElementById('txt_Date').value= XMLAddress1[0].childNodes[0].nodeValue;
	
	//document.getElementById('searchcust2').focus();
	
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
		alert("You can be edit");
		//alert(xmlHttp.responseText);
		
		document.getElementById('chkprint').value="1";
			document.getElementById('edit').value="1";
			document.getElementById('new1').value="0";
	}
}

function del_item1(code)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="journal_data_acc.php";			
			url=url+"?Command="+"del_item1";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&accno1="+code;
			//alert(url);
			
			xmlHttp.onreadystatechange=itemresultdel1;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function itemresultdel1()
{
	//	alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");	
		document.getElementById('chq_table1').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamt");	
		document.getElementById('TXT_DEBTOT').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		document.getElementById('accno1').value="";
		document.getElementById('acc_name1').value="";
		document.getElementById('descript1').value="";
		document.getElementById('amt1').value="";
		
		document.getElementById('accno1').focus();
}


function del_item2(code)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="journal_data_acc.php";			
			url=url+"?Command="+"del_item2";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&accno2="+code;
			//alert(url);
			
			xmlHttp.onreadystatechange=itemresultdel2;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function itemresultdel2()
{
	//	alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");	
		document.getElementById('chq_table2').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamt");	
		document.getElementById('TXT_creTOT').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('accno2').value="";
		document.getElementById('acc_name2').value="";
		document.getElementById('descript2').value="";
		document.getElementById('amt2').value="";
		
		document.getElementById('accno2').focus();
}



function setamt(accno, i)
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="journal_data_acc.php";			
			url=url+"?Command="+"setamt";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&accno="+accno;
			
			var jouamt="jouamt"+i;
			
			url=url+"&amt="+document.getElementById(jouamt).value;
			
			//alert(url);
			
			xmlHttp.onreadystatechange=setamt_result11;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}


function setamt2(accno, i)
{
	
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="journal_data_acc.php";			
			url=url+"?Command="+"setamt2";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&accno="+accno;
			
			var jouamt="jouamt_cre"+i;
			
			url=url+"&amt="+document.getElementById(jouamt).value;
			
			//alert(url);
			
			xmlHttp.onreadystatechange=setamt_result112;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function setamt_result11()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		document.getElementById("TXT_DEBTOT").value=xmlHttp.responseText;
		
	}
}
function setamt_result112()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		document.getElementById("TXT_creTOT").value=xmlHttp.responseText;
		
	}
}



function addchq_cash_rec1()
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="journal_data_acc.php";			
			url=url+"?Command="+"addchq_cash_rec1";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			
			myString=document.getElementById("TXT_DETAILS").value;
			myString = myString.replace(/[\r\n]/g, "<br/>");
			myString = myString.replace(/\s/g, "&nbsp;");
			myString = myString.replace(/'/g, "''");
			myString = myString.replace(/&/g,"~");
			url=url+"&TXT_DETAILS="+myString;
			
			
			url=url+"&accno1="+document.getElementById('accno1').value;
			url=url+"&acc_name1="+document.getElementById('acc_name1').value;
			
			myString=document.getElementById("descript1").value;
			myString = myString.replace(/[\r\n]/g, "<br/>");
			myString = myString.replace(/\s/g, "&nbsp;");
			myString = myString.replace(/'/g, "''");
			myString = myString.replace(/&/g,"~");
			url=url+"&descript1="+myString;
			
			url=url+"&amt1="+document.getElementById('amt1').value;
			//alert(url);
			xmlHttp.onreadystatechange=addchq_cash_rec_result1;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function addchq_cash_rec_result1()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamt");	
		//document.getElementById('TXT_DEBTOT').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");	
		document.getElementById('chq_table1').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamt");	
		document.getElementById('TXT_DEBTOT').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		document.getElementById('accno1').value="";
		document.getElementById('acc_name1').value="";
		document.getElementById('descript1').value="";
		document.getElementById('amt1').value="";
		
		document.getElementById('accno1').focus();
		//document.getElementById('chq_table').innerHTML= xmlHttp.responseText;
		
	}
}


function addchq_cash_rec2()
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="journal_data_acc.php";			
			url=url+"?Command="+"addchq_cash_rec2";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&accno2="+document.getElementById('accno2').value;
			url=url+"&acc_name2="+document.getElementById('acc_name2').value;
			
			myString=document.getElementById("descript2").value;
			myString = myString.replace(/[\r\n]/g, "<br/>");
			myString = myString.replace(/\s/g, "&nbsp;");
			myString = myString.replace(/'/g, "''");
			myString = myString.replace(/&/g,"~");
			url=url+"&descript2="+myString;
			
			
			url=url+"&amt2="+document.getElementById('amt2').value;
			//alert (url);
			xmlHttp.onreadystatechange=addchq_cash_rec_result2;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function addchq_cash_rec_result2()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamt");	
		//document.getElementById('TXT_DEBTOT').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");	
		document.getElementById('chq_table2').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamt");	
		document.getElementById('TXT_creTOT').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('accno2').value="";
		document.getElementById('acc_name2').value="";
		document.getElementById('descript2').value="";
		document.getElementById('amt2').value="";
		
		document.getElementById('accno2').focus();
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
			
			var url="journal_data_acc.php";			
			url=url+"?Command="+"delete_rec";
			url=url+"&txt_entno="+document.getElementById("txt_entno").value;
			url=url+"&txt_Date="+document.getElementById("txt_Date").value;
			
			/*url=url+"&invdate="+document.getElementById("invdate").value;
			url=url+"&txtpaytot="+document.getElementById("txtpaytot").value;
			url=url+"&cuscode="+document.getElementById("cuscode").value;*/
			
	
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
	
		if (xmlHttp.responseText=="Canceled"){
			location.reload(true);
			//setTimeout("location.reload(true);",500);
		}
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
			var url="journal_data_acc.php";			
			url=url+"?Command="+"save_crec";
			url=url+"&txt_entno="+document.getElementById("txt_entno").value;
			url=url+"&txt_Date="+document.getElementById("txt_Date").value;
			url=url+"&Com_job="+document.getElementById("Com_job").value;
			
			
			myString=document.getElementById("TXT_DETAILS").value;
			myString = myString.replace(/[\r\n]/g, "<br/>");
			myString = myString.replace(/\s/g, "&nbsp;");
			myString = myString.replace(/'/g, "''");
			myString = myString.replace(/&/g,"~");
			url=url+"&TXT_DETAILS="+myString;
			
			url=url+"&TXT_DEBTOT="+document.getElementById("TXT_DEBTOT").value;
			url=url+"&TXT_creTOT="+document.getElementById("TXT_creTOT").value;
			
			
			
			
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
		alert(xmlHttp.responseText);
		
		if (xmlHttp.responseText=="Saved"){
			document.getElementById('new1').value=0;
			document.getElementById('edit').value=0;
			document.getElementById('chkprint').value=1;
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
			
			if (stname=="vat_schedule"){
				var url="search_ledger_data_acc.php";			
				url=url+"?Command="+"pass_ledger_sel";
				url=url+"&ledgno="+custno;
							
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_vat_schedule;
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
				url=url+"&ledgno="+custno;
							
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_cheque_pay;
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
				url=url+"&ledgno="+document.getElementById('accno1').value;
							
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
				url=url+"&ledgno="+document.getElementById('accno2').value;
							
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



function passcusresult_journal_ent1()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_code");	
		document.getElementById('accno1').value =XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_name");	
		document.getElementById('acc_name1').value=XMLAddress1[0].childNodes[0].nodeValue;
		
		//opener.document.form1.descript.value=opener.document.form1.TXT_NARA.value;
		
		document.getElementById('amt1').focus();
		//opener.document.form1.amt1.focus();
		
		//self.close();
	}
}

function passcusresult_journal_ent2()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_code");	
		document.getElementById('accno2').value =XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_name");	
		document.getElementById('acc_name2').value=XMLAddress1[0].childNodes[0].nodeValue;
		
		//opener.document.form1.descript.value=opener.document.form1.TXT_NARA.value;
		
		document.getElementById('amt2').focus();
		//opener.document.form1.amt1.focus();
		
		//self.close();
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
			
			
			var url="cash_rec_data_acc.php";			
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
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Txtrecno");
//		document.getElementById('invno1').value = XMLAddress1[0].childNodes[0].nodeValue;
	//	alert(XMLAddress1[0].childNodes[0].nodeValue);
		opener.document.form1.Txtrecno.value = XMLAddress1[0].childNodes[0].nodeValue;
		//opener.document.form1.invno.value = "111111111";
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtDATE");
		opener.document.form1.txtDATE.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Txtcusco");
		opener.document.form1.Txtcusco.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcusname");
		opener.document.form1.txtcusname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_accode");
		opener.document.form1.txt_accode.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_accname");
		opener.document.form1.txt_accname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_accode1");
		opener.document.form1.txt_accode1.value = XMLAddress1[0].childNodes[0].nodeValue;
		//alert("okkl");
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_accname1");
		opener.document.form1.txt_accname1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcash");
		opener.document.form1.txtcash.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Txtchtot");
		opener.document.form1.Txtchtot.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtpaytot");
		opener.document.form1.txtpaytot.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");
		window.opener.document.getElementById('chq_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		
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