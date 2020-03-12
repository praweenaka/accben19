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
			document.getElementById('Com_bank').value="";
			document.getElementById('chq_table1').innerHTML="";
			document.getElementById('chq_table2').innerHTML="";
			document.getElementById('chq_table3').innerHTML="";
			
			document.getElementById('txtCreTot').value="";
			document.getElementById('txtDebTot').value="";
			document.getElementById('txtcash').value="";
			document.getElementById('totval').value="";
			
			document.getElementById('Calendar1').disabled=false;
			document.getElementById('TXT_HEADING').disabled=false;
			document.getElementById('Com_bank').disabled=false;
			document.getElementById('additem_tmp').disabled=false;
			document.getElementById('additem_tmp1').disabled=false;
			document.getElementById('additem_tmp2').disabled=false;
						
			document.getElementById('chkprint').value="0";
			document.getElementById('edit').value="0";
			document.getElementById('new1').value="1";
		
			
			var url="bankdepo_data_acc.php";			
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
	
	
		
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("recno");	
	document.getElementById('txt_entno').value= XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("current_date");	
	document.getElementById('Calendar1').value= XMLAddress1[0].childNodes[0].nodeValue;
		
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
			
			
	
			var url="bankdepo_data_acc.php";			
			url=url+"?Command="+"del_item";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&accno="+code;
			
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


function setamt(accno, i)
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="bankdepo_data_acc.php";			
			url=url+"?Command="+"setamt";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&accno="+accno;
			
			var amtedit="amt_acc"+i;
			
			url=url+"&amt="+document.getElementById(amtedit).value;
			
			//alert(url);
			
			xmlHttp.onreadystatechange=setamt_result11;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}


function setamt_result11()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		document.getElementById("txtCreTot").value=xmlHttp.responseText;
		document.getElementById("totval").value=xmlHttp.responseText;
	}
}
/*
function setamt2(chqno, i)
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="bankdepo_data_acc.php";			
			url=url+"?Command="+"setamt2";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&chqno="+chqno;
			
			var amt="amteditchq"+i;
			
			url=url+"&amt="+document.getElementById(amt).value;
			
			//alert(url);
			
			xmlHttp.onreadystatechange=del_item_result11;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}


function setamt_result11()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		document.getElementById("txtDebTot").value=xmlHttp.responseText;
		//document.getElementById("totval").value=xmlHttp.responseText;
	}
}*/


function addchq_cash_rec1()
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="bankdepo_data_acc.php";			
			url=url+"?Command="+"addchq_cash_rec1";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&accno1="+document.getElementById('accno1').value;
			url=url+"&acc_name1="+document.getElementById('acc_name1').value;
			
			myString=document.getElementById("descript1").value;
			myString = myString.replace(/[\r\n]/g, "<br/>");
			myString = myString.replace(/\s/g, "&nbsp;");
			myString = myString.replace(/'/g, "''");
			myString = myString.replace(/&/g,"~");
			url=url+"&descript1="+myString;
			
			
			url=url+"&amt1="+document.getElementById('amt1').value;
			
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
		document.getElementById('txtCreTot').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamt");	
		document.getElementById('totval').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('accno1').value="";
		document.getElementById('acc_name1').value="";
		document.getElementById('descript1').value="";
		document.getElementById('amt1').value="";
		
		document.getElementById('accno1').focus();
		//document.getElementById('chq_table').innerHTML= xmlHttp.responseText;
		
	}
}

function del_item1(accno1)
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="bankdepo_data_acc.php";			
			url=url+"?Command="+"del_item1";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&accno1="+accno1;
			
			//alert(url);
			xmlHttp.onreadystatechange=del_item_result1;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function del_item_result1()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamt");	
		//document.getElementById('TXT_DEBTOT').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");	
		document.getElementById('chq_table1').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamt");	
		document.getElementById('txtCreTot').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('totval').value=parseFloat(document.getElementById('txtDebTot').value)+parseFloat(document.getElementById('txtCreTot').value)
		
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
			
			var url="bankdepo_data_acc.php";			
			url=url+"?Command="+"addchq_cash_rec2";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&chqno="+document.getElementById('chqno').value;
			
			myString=document.getElementById("TXT_HEADING").value;
			myString = myString.replace(/[\r\n]/g, "<br/>");
			myString = myString.replace(/\s/g, "&nbsp;");
			myString = myString.replace(/'/g, "''");
			myString = myString.replace(/&/g,"~");
						
			url=url+"&TXT_HEADING="+myString;
			url=url+"&chqdate="+document.getElementById('chqdate').value;
			
			myString=document.getElementById("narration").value;
			myString = myString.replace(/[\r\n]/g, "<br/>");
			myString = myString.replace(/\s/g, "&nbsp;");
			myString = myString.replace(/'/g, "''");
			myString = myString.replace(/&/g,"~");
			url=url+"&narration="+myString;
			url=url+"&bank="+document.getElementById('bank').value;
			url=url+"&chqamt="+document.getElementById('chqamt').value;
			url=url+"&id="+document.getElementById('id').value;
			
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
		document.getElementById('txtDebTot').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamt");	
		document.getElementById('totval').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('chqno').value="";
		document.getElementById('chqdate').value="";
		document.getElementById('narration').value="";
		document.getElementById('bank').value="";
		document.getElementById('chqamt').value="";
		document.getElementById('id').value="0";
		
		document.getElementById('additem_tmp1').focus();
		//document.getElementById('chq_table').innerHTML= xmlHttp.responseText;
		
	}
}


function del_item2(accno1)
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="bankdepo_data_acc.php";			
			url=url+"?Command="+"del_item2";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&accno1="+accno1;
			
			//alert(url);
			xmlHttp.onreadystatechange=del_item_result2;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function del_item_result2()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamt");	
		//document.getElementById('TXT_DEBTOT').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");	
		document.getElementById('chq_table2').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamt");	
		document.getElementById('txtDebTot').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('totval').value=parseFloat(document.getElementById('txtDebTot').value)+parseFloat(document.getElementById('txtCreTot').value)
		
		document.getElementById('chqno').value="";
		document.getElementById('chqdate').value="";
		document.getElementById('narration').value="";
		document.getElementById('bank').value="";
		document.getElementById('chqamt').value="";
		
		document.getElementById('additem_tmp1').focus();
		//document.getElementById('chq_table').innerHTML= xmlHttp.responseText;
		
	}
}

function addchq_cash_rec3()
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="bankdepo_data_acc.php";			
			url=url+"?Command="+"addchq_cash_rec3";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&accno2="+document.getElementById('accno2').value;
			url=url+"&acc_name2="+document.getElementById('acc_name2').value;
			url=url+"&descript2="+document.getElementById('descript2').value;
			url=url+"&amt2="+document.getElementById('amt2').value;
			
			xmlHttp.onreadystatechange=addchq_cash_rec_result3;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function addchq_cash_rec_result3()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamt");	
		//document.getElementById('TXT_DEBTOT').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");	
		document.getElementById('chq_table3').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
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
  var smg1;
  msg=confirm("Are you sure to CANCEL this Diposit ! ");
  if (msg==true){
	
	var today = new Date()
	if (today!=document.getElementById("Calendar1").value){
		msg=confirm("Not a today diposit. Do you want to porceed ? ");
	} 
	if (msg==true){
		xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="bankdepo_data_acc.php";			
			url=url+"?Command="+"delete_rec";
			url=url+"&txt_entno="+document.getElementById("txt_entno").value;
			url=url+"&Calendar1="+document.getElementById("Calendar1").value;
			url=url+"&Com_bank="+document.getElementById("Com_bank").value;
			
			
	
		xmlHttp.onreadystatechange=result_delete_rec;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	}
  }
}

function result_delete_rec()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		
		if (xmlHttp.responseText=="Canceled"){
			//setTimeout("location.reload(true);",500);
			location.reload(true);
		}
	}
}


function save_crec()
{
	//if (document.getElementById("txtCreTot").value==document.getElementById("txtDebTot").value){
		xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		
		if ((document.getElementById("new1").value=="1") || (document.getElementById("edit").value=="1")){
			
		  if (document.getElementById("Com_bank").value!=""){	
			var url="bankdepo_data_acc.php";			
			url=url+"?Command="+"save_crec";
			url=url+"&txt_entno="+document.getElementById("txt_entno").value;
			url=url+"&Calendar1="+document.getElementById("Calendar1").value;
			url=url+"&Com_job="+document.getElementById("Com_job").value;
			//url=url+"&TXT_HEADING="+document.getElementById("TXT_HEADING").value;
			
			myString=document.getElementById("TXT_HEADING").value;
			myString = myString.replace(/[\r\n]/g, "<br/>");
			myString = myString.replace(/\s/g, "&nbsp;");
			myString = myString.replace(/'/g, "''");
			myString = myString.replace(/&/g,"~");
			
	
			url=url+"&TXT_HEADING="+myString;
			
			url=url+"&Com_bank="+document.getElementById("Com_bank").value;
			url=url+"&txtCreTot="+document.getElementById("txtCreTot").value;
			url=url+"&txtDebTot="+document.getElementById("txtDebTot").value;
			url=url+"&totval="+document.getElementById("totval").value;
			
			
			
			
			
			//alert(url);
			xmlHttp.onreadystatechange=result_save_crec;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		  } else {
			alert("Please Select Bank");	  
		  }
	 } else {
		alert("Cannot Save");	
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
		} else if (xmlHttp.responseText=="Invalid Option, Please Select Option 'New' and Save Entry"){
			alert(xmlHttp.responseText);
		} else if (xmlHttp.responseText=="Cheque Deposit Account Total and ,Cheque Total Not Tallying"){
			alert(xmlHttp.responseText);
		} else if (xmlHttp.responseText=="Reference No Not Entered"){
			alert(xmlHttp.responseText);
		} else if (xmlHttp.responseText=="Entry Is Incomplete"){
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
		} else  if (xmlHttp.responseText=="Can't Add NEW Transaction. Reconcilation is Completed!!!"){
			alert(xmlHttp.responseText);
		} else  if (xmlHttp.responseText=="Out of Current Accounting Year"){
			alert(xmlHttp.responseText);
		} else  if (xmlHttp.responseText=="Can't EDIT Date. Reconciliation is Completed!!!"){
			alert(xmlHttp.responseText);
		} else  if (xmlHttp.responseText=="Entry No is Already Exist !!!"){
			alert(xmlHttp.responseText);	
		} else  {
			document.getElementById('txt_entno').value = xmlHttp.responseText;
			
			alert("Records are saved as - "+xmlHttp.responseText);
			
			document.getElementById('Calendar1').disabled=true;
			document.getElementById('TXT_HEADING').disabled=true;
			document.getElementById('Com_bank').disabled=true;
			document.getElementById('additem_tmp').disabled=true;
			document.getElementById('additem_tmp1').disabled=true;
			document.getElementById('additem_tmp2').disabled=true;
						
			document.getElementById('chkprint').value="1";
			document.getElementById('edit').value="0";
			document.getElementById('new1').value="0";
			
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
			
			
			var url="bankdepo_data_acc.php";			
			url=url+"?Command="+"search_rec";
			url=url+"&mstatus="+stname;
			
			//if (document.getElementById('recno').value!=""){
				
				url=url+"&mfield=recno";
				url=url+"&recno="+document.getElementById('recno').value;
				
			/*} else if (document.getElementById('recdate').value!=""){
				
				url=url+"&mfield=recdate";
				url=url+"&recdate="+document.getElementById('recdate').value;
				
			} else if (document.getElementById('recamt').value!=""){
				
				url=url+"&mfield=recamt";
				url=url+"&recamt="+document.getElementById('recamt').value;
				
			}*/
			
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


function edit_rec()
{   
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
		
		if (document.getElementById('new1').value==0){	
			var url="bankdepo_data_acc.php";			
			url=url+"?Command="+"pass_edit_rec";
			//url=url+"&recno="+recno;
			//alert(url);
					
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
		alert("Can be EDIT");
		
		document.getElementById('Calendar1').disabled=false;
			document.getElementById('TXT_HEADING').disabled=false;
			document.getElementById('Com_bank').disabled=false;
			document.getElementById('additem_tmp').disabled=false;
			document.getElementById('additem_tmp1').disabled=false;
			document.getElementById('additem_tmp2').disabled=false;
						
			document.getElementById('chkprint').value="1";
			document.getElementById('edit').value="1";
			document.getElementById('new1').value="0";
			
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
			
			
	var url="bankdepo_data_acc.php";			
	url=url+"?Command="+"set_acc";
	var c_code="accno_acc"+i;
	
	url=url+"&txt_entno="+document.getElementById("txt_entno").value;
	url=url+"&accno="+document.getElementById(c_code).value;
	url=url+"&TXT_NARA="+document.getElementById("TXT_HEADING").value;
	
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

function setamt_opr(i)
{
	
	
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="bankdepo_data_acc.php";			
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
		document.getElementById('txtCreTot').value=xmlHttp.responseText;
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
			
			
			var url="bankdepo_data_acc.php";			
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
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("refno");
		opener.document.form1.txt_entno.value = XMLAddress1[0].childNodes[0].nodeValue;
		//opener.document.form1.invno.value = "111111111";
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("bdate");
		opener.document.form1.Calendar1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");
		opener.document.form1.Com_bank.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("heading");
		
		text=XMLAddress1[0].childNodes[0].nodeValue;
		myString = text.replace(/<br\s*\/?>/mg,"\n");
		
		opener.document.form1.TXT_HEADING.value = myString;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cancel");
		window.opener.document.getElementById("cancel").innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		

		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("acc_table");
		window.opener.document.getElementById("chq_table1").innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");
		window.opener.document.getElementById("chq_table2").innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("acc_totamt");
		opener.document.form1.txtCreTot.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_totamt");
		opener.document.form1.txtDebTot.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_totamt");
		opener.document.form1.totval.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		opener.document.form1.Calendar1.disabled=true;
		opener.document.form1.TXT_HEADING.disabled=true;
		opener.document.form1.Com_bank.disabled=true;
		opener.document.form1.additem_tmp.disabled=true;
		opener.document.form1.additem_tmp1.disabled=true;
		opener.document.form1.additem_tmp2.disabled=true;
			
		opener.document.form1.chkprint.value="1";
		opener.document.form1.edit.value="0";
		opener.document.form1.new1.value="0";
						
		
		
		
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
				url=url+"&ledgno="+custno;
							
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_journal_ent1;
			}
			
			if (stname=="bankdepo_ent1"){ 
				var url="search_ledger_data_acc.php";			
				url=url+"?Command="+"bankdepo_ent1";
				url=url+"&ledgno="+document.getElementById('accno1').value;
							
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

function passcusresult_bankdepo_ent1()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_code");	
		document.getElementById('accno1').value=XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_name");	
		document.getElementById('acc_name1').value=XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('descript1').value=document.getElementById('TXT_HEADING').value;
		//opener.document.form1.descript.value=opener.document.form1.TXT_NARA.value;
		
		document.getElementById('amt1').focus();
		//opener.document.form1.amt1.focus();
		
		//self.close();
	}
}


function chqno_inf(stname)
{   
			//alert(stname);
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			if (stname=="bankdepo"){
				var url="search_chq_data_acc.php";			
				url=url+"?Command="+"pass_chqno_chqno";
				url=url+"&chqno="+document.getElementById('chqno').value;
							
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_depochqno;
				xmlHttp.open("GET",url,true);
				xmlHttp.send(null);
			}
}

function passcusresult_depochqno()
{
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cheque_no");	
		document.getElementById('chqno').value=XMLAddress1[0].childNodes[0].nodeValue;
		
		if (XMLAddress1[0].childNodes[0].nodeValue!="CASH TT"){
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("che_date");	
			document.getElementById('chqdate').value =XMLAddress1[0].childNodes[0].nodeValue;
		
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");	
			document.getElementById('id').value =XMLAddress1[0].childNodes[0].nodeValue;
		
				
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("che_amount");	
			document.getElementById('chqamt').value =XMLAddress1[0].childNodes[0].nodeValue;
		
			document.getElementById('narration').value = document.getElementById('TXT_HEADING').value;
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("che_date");	
		//opener.document.form1.chqdate.value=XMLAddress1[0].childNodes[0].nodeValue;
		
		//opener.document.form1.descript.value=opener.document.form1.TXT_NARA.value;
		
			document.getElementById('additem_tmp1').focus();
		} else {
			document.getElementById('chqamt').focus();	
		}
		//opener.document.form1.additem_tmp1.focus();
		
		//self.close();
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