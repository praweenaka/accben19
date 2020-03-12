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





function update_inv()
{
    var msg = confirm("Do you want to Active this Cheque ! ");
    if (msg == true) {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    
    if (document.getElementById('Cheque_No').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Cheque No Is Not Entered</span></div>";
//        setTimeout("location.reload(true);", 500);
        return false;
    }


    var url = "lock_release_chq_data.php";
    url = url + "?Command=" + "update_inv";

    url = url + "&Cheque_No=" + document.getElementById('Cheque_No').value;
    document.getElementById('msg_box').innerHTML = "";
    xmlHttp.onreadystatechange = updateresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
    }


}

function updateresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Saved") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Updated</span></div>";

            setTimeout("location.reload(true);", 500);

        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}

/////////////////////////////////////////////////////

function update_invcom()
{
    var msg = confirm("Do you want to Active this Cheque ! ");
    if (msg == true) {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    
    if (document.getElementById('Cheque_No_comm').value == "") {
        document.getElementById('msg_box1').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Cheque No Is Not Entered</span></div>";
//        setTimeout("location.reload(true);", 500);
        return false;
    }


    var url = "lock_release_chq_data.php";
    url = url + "?Command=" + "update_invcom";

    url = url + "&Cheque_No_comm=" + document.getElementById('Cheque_No_comm').value;
    document.getElementById('msg_box1').innerHTML = "";
    xmlHttp.onreadystatechange = updatecomresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
    }


}

function updatecomresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Saved") {
            document.getElementById('msg_box1').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Updated</span></div>";

            setTimeout("location.reload(true);", 500);

        } else {
            document.getElementById('msg_box1').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}



  
