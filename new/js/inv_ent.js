function GetXmlHttpObject() {
    var xmlHttp = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlHttp = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}

function keyset(key, e) {

    if (e.keyCode == 13) {
        document.getElementById(key).focus();
    }
}

function got_focus(key) {
    document.getElementById(key).style.backgroundColor = "#000066";

}

function lost_focus(key) {
    document.getElementById(key).style.backgroundColor = "#000000";

}

 

function add_tmp() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
	
	document.getElementById('msg_box').innerHTML = "";

    if (document.getElementById('tmpno').value == "") {
       document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Invalid</span></div>";
	   return;	
	}
	
	if (parseFloat(document.getElementById('qtyinhand').value) < parseFloat(document.getElementById('qty').value)){
		document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Insufficent Qty</span></div>";
		return;	
	}	
	
	
    if (document.getElementById('invno').value == "") {
       document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Invalid</span></div>";
	   return;	
    }

    if ((document.getElementById('invno').value != "")) {

        var url = "inv_ent_data.php";
        url = url + "?Command=" + "add_tmp";
        url = url + "&invno=" + document.getElementById('invno').value;
        url = url + "&itemCode=" + document.getElementById('itemCode').value;
        url = url + "&itemDesc=" + document.getElementById('itemDesc').value;
        url = url + "&qty=" + document.getElementById('qty').value;
        url = url + "&tmpno=" + document.getElementById('tmpno').value;
        url = url + "&from_dep=" + document.getElementById('from_dep').value;



        xmlHttp.onreadystatechange = showarmyresultdel;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);

    }  

}

function showarmyresultdel() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("item_count");
        document.getElementById('item_count').value = XMLAddress1[0].childNodes[0].nodeValue;

         

        document.getElementById('itemCode').value = "";
        document.getElementById('itemDesc').value = "";
        document.getElementById('qty').value = "";
        
		document.getElementById('qtyinhand').value =0;
        document.getElementById('itemCode').focus();
    }
}



function save_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
	document.getElementById('msg_box').innerHTML = "";

    var url = "inv_ent_data.php";
    url = url + "?Command=" + "save_item";

    url = url + "&invno=" + document.getElementById('invno').value;
    url = url + "&sdate=" + document.getElementById('sdate').value;		
    url = url + "&l_lmem=" + document.getElementById('decript').value;
 
 
	var deb_count = document.getElementById('tb_deb').value;
    var i = 1;
	url = url + "&tb_deb=" + document.getElementById('tb_deb').value;
 
    while (deb_count > i) {
		
		var lcode_d = "l_code_d" + i;

        var l_amount_d = "l_amount_d" + i;

		url = url + '&' + lcode_d + '=' + document.getElementById(lcode_d).value;

        url = url + '&' + l_amount_d + '=' + document.getElementById(l_amount_d).value;
		
		i = i+1	;
	}	
	
	
	var cre_count = document.getElementById('tb_cre').value;
    var i = 1;
	url = url + "&tb_cre=" + document.getElementById('tb_cre').value;
 
    while (cre_count > i) {
		
		var lcode_c = "l_code_c" + i;

        var l_amount_c = "l_amount_c" + i;

		url = url + '&' + lcode_c + '=' + document.getElementById(lcode_c).value;

        url = url + '&' + l_amount_c + '=' + document.getElementById(l_amount_c).value;
		
i = i+1;		
	}
 
 
     
    
    
    xmlHttp.onreadystatechange = salessaveresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function salessaveresult() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Saved") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Saved</span></div>";
            print_inv();
			setTimeout(function(){
				window.location.reload(1);
			}, 3);
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}

 

function new_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var paymethod;

    document.getElementById('invno').value = "";

    document.getElementById('invno').value = "";

    document.getElementById('decript').value = "";

          


    document.getElementById('itemdetails').innerHTML = "";
    document.getElementById('msg_box').innerHTML = "";
    

	document.getElementById('itemdetails1').innerHTML = "";

    
    

}

 
 



function update_list(stname)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_inv_ent_data.php";			
			url=url+"?Command="+"search_inv";
			
			if (document.getElementById('invno').value!=""){
				url=url+"&mstatus=invno";
			} else if (document.getElementById('customername').value!=""){
				url=url+"&mstatus=from";
			} else if (document.getElementById('invdate').value!=""){
				url=url+"&mstatus=to";
			}
			
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&customername="+document.getElementById('customername').value;
			url=url+"&invdate="+document.getElementById('invdate').value;
			url=url+"&stname="+stname;
			//alert(url);
					
			xmlHttp.onreadystatechange=showinvresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	
}

function showinvresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		
		document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
	}
}



function gin(invno)
{   
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
			
			
			
				var url="inv_ent_data.php";	
				url=url+"?Command="+"gin";
				url=url+"&invno="+invno;
				//alert(url);
				xmlHttp.onreadystatechange=passginresult;
				xmlHttp.open("GET",url,true);
				xmlHttp.send(null);
				
			
			
			
			
			
}

function passginresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		 		
	 
		 
		window.opener.document.getElementById('msg_box').innerHTML = "";
    
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tb_deb");
		window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tb_cre");
		window.opener.document.getElementById('itemdetails1').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("l_refno");
        window.opener.document.getElementById('invno').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("l_date");
        window.opener.document.getElementById('sdate').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("l_lmem");
        window.opener.document.getElementById('decript').value = XMLAddress1[0].childNodes[0].nodeValue;
	 
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("count_d");
        window.opener.document.getElementById('tb_deb').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("count_c");
        window.opener.document.getElementById('tb_cre').value = XMLAddress1[0].childNodes[0].nodeValue;
				
		
		
		self.close();
	}
}

 

function cancel_result() {
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {


        if (xmlHttp.responseText == "ok") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Cancelled</span></div>";
            setTimeout(function () {
                window.location.reload(1);
            }, 3000);
        } else {
            if (xmlHttp.responseText != "") {
                document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
            }
        }
    }
}
