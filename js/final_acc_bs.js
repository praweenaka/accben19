function GetXmlHttpObject()
{
    var xmlHttp = null;
    try
    {
        // Firefox, Opera 8.0+, Safari
        xmlHttp = new XMLHttpRequest();
    }
    catch (e)
    {
        // Internet Explorer
        try
        {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}

function close_form()
{
    self.close();
}





function view_del(i, j)
{
    view_frame(i, j);
}


function dis_val()
{

    if (document.getElementById('descr').checked == true) {

        document.getElementById('sheet_desc').style.visibility = "visible";

        document.getElementById('searchacc').style.visibility = "hidden";
        document.getElementById('viewacc').style.visibility = "hidden";
        document.getElementById('acc_table').style.visibility = "hidden";

        document.getElementById('calc_cell').style.visibility = "hidden";

    } else if (document.getElementById('coll_acc').checked == true) {

        document.getElementById('sheet_desc').style.visibility = "hidden";

        document.getElementById('searchacc').style.visibility = "visible";
        document.getElementById('viewacc').style.visibility = "visible";
        document.getElementById('acc_table').style.visibility = "visible";

        document.getElementById('calc_cell').style.visibility = "hidden";

    } else if (document.getElementById('calc_cell_r').checked == true) {

        document.getElementById('sheet_desc').style.visibility = "hidden";

        document.getElementById('searchacc').style.visibility = "hidden";
        document.getElementById('viewacc').style.visibility = "hidden";
        document.getElementById('acc_table').style.visibility = "hidden";

        document.getElementById('calc_cell').style.visibility = "visible";
    }
}

function print_inv()
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    //alert(xmlHttp.responseText);

    var url = "rep_final_2.php";
    url = url + "?dtfrom=" + document.getElementById('dtfrom').value;
    url = url + "&dtto=" + document.getElementById('dtto').value;
	url = url + "&type=" + document.getElementById('type').value;
    window.open(url);


}


function print_notes()
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    //alert(xmlHttp.responseText);

    var url = "print_notes.php";
    url = url + "?dtfrom=" + document.getElementById('dtfrom').value;
    url = url + "&dtto=" + document.getElementById('dtto').value;
    url = url + "&row=" + document.getElementById('dtto').value;
    window.open(url);


}

function view_frame(i, j)
{
    document.getElementById('set_acc_frame').style.visibility = "visible";
    document.getElementById('sheet_desc').style.visibility = "visible";
    document.getElementById('descr').checked = true;
    var top = (i * 15) + 180;
    var left = (j * 165) + 35;
    document.getElementById('set_acc_frame').style.top = top + "px";
    document.getElementById('set_acc_frame').style.left = left + "px";
    var name = "td_" + i + "_" + j;
    document.getElementById(name).style.backgroundColor = "#fff";

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "final_acc_data_bs.php";
    url = url + "?Command=" + "view_frame";
    url = url + "&i=" + i;
    url = url + "&j=" + j;

    xmlHttp.onreadystatechange = res_view_frame;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}


function res_view_frame()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        //setTimeout("location.reload(true);",500);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cell_type");
        if (XMLAddress1[0].childNodes[0].nodeValue == "text") {

            document.getElementById("descr").checked = true;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("description");
            document.getElementById("sheet_desc").value = XMLAddress1[0].childNodes[0].nodeValue;

        } else if (XMLAddress1[0].childNodes[0].nodeValue == "acc") {

            document.getElementById("coll_acc").checked = true;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("description");
            document.getElementById("acc_table").innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        } else if (XMLAddress1[0].childNodes[0].nodeValue == "opr") {

            document.getElementById("calc_cell_r").checked = true;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("r1");
            document.getElementById("row1").value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c1");
            document.getElementById("col1").value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("r2");
            document.getElementById("row2").value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c2");
            document.getElementById("col2").value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("r3");
            document.getElementById("row3").value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c3");
            document.getElementById("col3").value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("r4");
            document.getElementById("row4").value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c4");
            document.getElementById("col4").value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("operat");
            document.getElementById("opr").value = XMLAddress1[0].childNodes[0].nodeValue;



        }


        dis_val();


    }
}


function hide_frame()
{

    document.getElementById('sheet_desc').value = "";

    document.getElementById('set_acc_frame').style.visibility = "hidden";
    document.getElementById('sheet_desc').style.visibility = "hidden";

    document.getElementById('searchacc').style.visibility = "hidden";
    document.getElementById('viewacc').style.visibility = "hidden";
    document.getElementById('acc_table').style.visibility = "hidden";

    document.getElementById('calc_cell').style.visibility = "hidden";

    i = 1;
    while (i < 50) {
        j = 1;
        while (j < 6) {
            var name = "td_" + i + "_" + j;
            document.getElementById(name).style.backgroundColor = "transparent";
            j = j + 1;
        }
        i = i + 1;
    }
}




function save_mettrix()
{
    //alert("ok");

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "final_acc_data_bs.php";

    if (document.getElementById('descr').checked == true) {
        url = url + "?Command=" + "save_mettrix_text";

        myString = document.getElementById('sheet_desc').value;
        myString = myString.replace(/&/g, "~");
        url = url + "&sheet_desc=" + myString;

        xmlHttp.onreadystatechange = res_save_mettrix_text;

    } else if (document.getElementById('coll_acc').checked == true) {
        url = url + "?Command=" + "save_mettrix_coll_acc";
        url = url + "&txt_acc=" + document.getElementById('txt_acc').value;
        url = url + "&val_acc=" + document.getElementById('val_acc').value;
        url = url + "&txt_acc_last=" + document.getElementById('txt_acc_last').value;
        url = url + "&val_acc_last=" + document.getElementById('val_acc_last').value;

        if (document.getElementById('opr_acc').value == "+") {
            url = url + "&opr_acc=~";
        } else {
            url = url + "&opr_acc=-";
        }

        if (document.getElementById('opr_acc_last').value == "+") {
            url = url + "&opr_acc_last=~";
        } else {
            url = url + "&opr_acc_last=-";
        }
        alert(url);
        xmlHttp.onreadystatechange = res_save_mettrix_coll_acc;

    } else if (document.getElementById('calc_cell_r').checked == true) {

        url = url + "?Command=" + "save_mettrix_cell_r";
        url = url + "&row1=" + document.getElementById('row1').value;
        url = url + "&col1=" + document.getElementById('col1').value;
        url = url + "&row2=" + document.getElementById('row2').value;
        url = url + "&col2=" + document.getElementById('col2').value;
        url = url + "&row3=" + document.getElementById('row3').value;
        url = url + "&col3=" + document.getElementById('col3').value;
        url = url + "&row4=" + document.getElementById('row4').value;
        url = url + "&col4=" + document.getElementById('col4').value;

        if (document.getElementById('opr').value == "+") {
            url = url + "&opr=~";
        } else {
            url = url + "&opr=-";
        }

        xmlHttp.onreadystatechange = res_save_mettrix_cell_r;
    }
//alert(url);

    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function res_save_mettrix_text()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        //setTimeout("location.reload(true);",500);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("i");
        i = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("j");
        j = XMLAddress1[0].childNodes[0].nodeValue;

        var cell = "td_" + i + "_" + j;
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sheet_desc");
        document.getElementById(cell).innerHTML = XMLAddress1[0].childNodes[0].nodeValue;


    }
}

function res_save_mettrix_coll_acc()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);
        //setTimeout("location.reload(true);",500);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("i");
        i = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("j");
        j = XMLAddress1[0].childNodes[0].nodeValue;

        var cell = "td_" + i + "_" + j;
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("acc_list");
        document.getElementById(cell).innerHTML = XMLAddress1[0].childNodes[0].nodeValue;


    }
}

function res_save_mettrix_cell_r()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        //setTimeout("location.reload(true);",500);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("i");
        i = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("j");
        j = XMLAddress1[0].childNodes[0].nodeValue;

        var cell = "td_" + i + "_" + j;
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("opr_str");
        document.getElementById(cell).innerHTML = XMLAddress1[0].childNodes[0].nodeValue;


    }
}





function del_item(c_code, mrow, mcol)
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "final_acc_data_bs.php";
    url = url + "?Command=" + "del_item";
    url = url + "&mrow=" + mrow;
    url = url + "&mcol=" + mcol;
    url = url + "&c_code=" + c_code;

    xmlHttp.onreadystatechange = itemresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function itemresultdel()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("acc_table");
        document.getElementById("acc_table").innerHTML = (xmlHttp.responseText);
    }
}



function save_bank()
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "bankmast_data.php";
    url = url + "?Command=" + "save_bank";
    url = url + "&bcode=" + document.getElementById('bcode').value;
    url = url + "&bbcode=" + document.getElementById('bbcode').value;
    url = url + "&bname=" + document.getElementById('bname').value;
    url = url + "&shname=" + document.getElementById('shname').value;

    xmlHttp.onreadystatechange = salessaveresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function salessaveresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        document.getElementById('bank_table').innerHTML = xmlHttp.responseText;
        document.getElementById('bcode').value = "";
        document.getElementById('bbcode').value = "";
        document.getElementById('bname').value = "";
        document.getElementById('shname').value = "";

    }
}




function bankno(bcode, bbcode, bname, shname)
{

    document.getElementById('bcode').value = bcode;
    document.getElementById('bbcode').value = bbcode;
    document.getElementById('bname').value = bname;
    document.getElementById('shname').value = shname;
}

function delete_bank()
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "bankmast_data.php";
    url = url + "?Command=" + "delete_bank";
    url = url + "&bcode=" + document.getElementById('bcode').value;

    xmlHttp.onreadystatechange = bankdeletresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function bankdeletresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        document.getElementById('bank_table').innerHTML = xmlHttp.responseText;
        document.getElementById('bcode').value = "";
        document.getElementById('bbcode').value = "";
        document.getElementById('bname').value = "";
        document.getElementById('shname').value = "";
        alert("Deleted");

    }

}







function new_item()
{
    document.getElementById('bcode').value = "";
    document.getElementById('bbcode').value = "";
    document.getElementById('bname').value = "";
    document.getElementById('shname').value = '';
    document.getElementById('bcode').focus();
}



function loadnt()
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "final_acc_data_bs.php";
    url = url + "?Command=" + "loadnt";
    url = url + "&row=" + document.getElementById('row').value;
    xmlHttp.onreadystatechange = loadresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function loadresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("acc_table");
        document.getElementById("loadnt").innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
        
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("count");
        document.getElementById("count").value = XMLAddress1[0].childNodes[0].nodeValue;
        
        
    }
}




function save_note()
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "final_acc_data_bs.php";
    url = url + "?Command=" + "save_note";

   var i = 1;
 

    var t = parseFloat(document.getElementById('count').value);
 


    while (i < t) {
        test_desc = "test_desc" + i;
        unit = "unit" + i;
        

        url = url + "&" + test_desc + "=" + encodeURIComponent(document.getElementById(test_desc).value);
        url = url + "&" + unit + "=" + document.getElementById(unit).value;
         
        i = i + 1;
    }
    
    url = url + "&count=" + t;



    xmlHttp.onreadystatechange = salessaveresult_nt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function salessaveresult_nt()
{
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "200")
    {
     alert('Saved');
    }
}