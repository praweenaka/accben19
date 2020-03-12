function GetXmlHttpObject()
{
    var xmlHttp = null;
    try
    {
        // Firefox, Opera 8.0+, Safari
        xmlHttp = new XMLHttpRequest();
    } catch (e)
    {
        // Internet Explorer
        try
        {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e)
        {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}


function keyset(key, e)
{

    if (e.keyCode == 13) {
        document.getElementById(key).focus();
    }
}

function got_focus(key)
{
    document.getElementById(key).style.backgroundColor = "#000066";

}

function lost_focus(key)
{
    document.getElementById(key).style.backgroundColor = "#000000";

}

function sess_chk(cdata, cdata1) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    

    var url = "chk_session.php";
    url = url + "?Command=" + "chk_sess";
    url = url + "&action=" + cdata;
    url = url + "&form=" + cdata1;

    xmlHttp.onreadystatechange = result_sess_chk;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function result_sess_chk()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("stat");
        if (XMLAddress1[0].childNodes[0].nodeValue == "ok") {
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("action");
            if (XMLAddress1[0].childNodes[0].nodeValue =="save") {
                save_inv();
            }
            
        } else {
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("action");
            document.getElementById('action').value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("form");
            document.getElementById('form').value =  XMLAddress1[0].childNodes[0].nodeValue;
            $('#myModal').modal('show');
        }
    }
}


function itno_undeliver(itno, stname)
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_item_data.php";
    url = url + "?Command=" + "pass_itno";
    url = url + "&itno=" + itno;
    url = url + "&stname=" + stname;

    //alert(url);
    xmlHttp.onreadystatechange = itno_undeliver_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);



}

function itno_undeliver_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_code");
        opener.document.form1.itemCode.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");
        opener.document.form1.itemDesc.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("actual_selling");
        opener.document.form1.itemPrice.value = XMLAddress1[0].childNodes[0].nodeValue;



        self.close();
        opener.document.form1.qty.focus();



    }
}



function loadcur() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "currency_data.php";
    url = url + "?Command=" + "get_rate";
    url = url + "&code=" + document.getElementById('currency').value;

    //alert(url);
    xmlHttp.onreadystatechange = pass_cur;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}


function pass_cur()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("rate");
        document.getElementById('txt_rate').value = XMLAddress1[0].childNodes[0].nodeValue;


    }
}


function calrate() {
    document.getElementById('txt_amount_lkr').value = document.getElementById('txt_amount').value * document.getElementById('txt_rate').value
}

/****************************************************
 Author: Eric King
 Url: http://redrival.com/eak/index.shtml
 This script is free to use as long as this info is left in
 Featured on Dynamic Drive script library (http://www.dynamicdrive.com)
 ****************************************************/

function NewWindow(mypage, myname, w, h, scroll, pos) {
    var win = null;
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
 