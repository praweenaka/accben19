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


function save_note()
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "final_acc_data.php";
    url = url + "?Command=" + "save_pnldata";
    url = url + "&txt_bal=" + document.getElementById('txt_bal').value;
    url = url + "&txt_code=" + document.getElementById('row').value;
    url = url + "&dtfrom=" + document.getElementById('dtfrom').value;



    xmlHttp.onreadystatechange = salessaveresult_nt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function salessaveresult_nt()
{
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "200")
    {
        document.getElementById("loadnt").innerHTML = xmlHttp.responseText;
    }
}


function del_pnl_dt(cdata) {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "final_acc_data.php";
    url = url + "?Command=" + "del_pnl_dt";
    url = url + "&txtid=" + cdata;
    url = url + "&txt_code=" + document.getElementById('row').value;

    xmlHttp.onreadystatechange = salessaveresult_nt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function loadnt() {
  
      xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "final_acc_data.php";
    url = url + "?Command=" + "load_pnl_dt";
 
    url = url + "&txt_code=" + document.getElementById('row').value;

    xmlHttp.onreadystatechange = salessaveresult_nt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

    
}