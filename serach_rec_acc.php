<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="stylesheet" href="calendar.css">
<link type="text/css" rel="stylesheet" href="maincss/form.css"/>
<link type="text/css" rel="stylesheet" href="maincss/industrial_dark.css" />


<title>Search Customer</title>
<link rel="stylesheet" href="css/table.css" type="text/css"/>
<script language="JavaScript" src="js/cash_acc.js"></script>
<style type="text/css">

	/* START CSS NEEDED ONLY IN DEMO */
	html{
		height:100%;
	}
	
	
	#mainContainer{
		width:700px;
		margin:0 auto;
		text-align:left;
		height:100%;
		background-color:#FFF;
		border-left:3px double #000;
		border-right:3px double #000;
	}
	#formContent{
		padding:5px;
	}
	/* END CSS ONLY NEEDED IN DEMO */
	
	
	/* Big box with list of options */
	#ajax_listOfOptions{
		position:absolute;	/* Never change this one */
		width:175px;	/* Width of box */
		height:250px;	/* Height of box */
		overflow:auto;	/* Scrolling features */
		border:1px solid #317082;	/* Dark green border */
		background-color:#FFF;	/* White background color */
		text-align:left;
		font-size:0.9em;
		z-index:100;
	}
	#ajax_listOfOptions div{	/* General rule for both .optionDiv and .optionDivSelected */
		margin:1px;		
		padding:1px;
		cursor:pointer;
		font-size:0.9em;
	}
	#ajax_listOfOptions .optionDiv{	/* Div for each item in list */
		
	}
	#ajax_listOfOptions .optionDivSelected{ /* Selected item in the list */
		background-color:#317082;
		color:#FFF;
	}
	#ajax_listOfOptions_iframe{
		background-color:#F00;
		position:absolute;
		z-index:5;
	}
	
	form{
		display:inline;
	}

	#article {font: 12pt Verdana, geneva, arial, sans-serif;  background: white; color: black; padding: 10pt 15pt 0 5pt}
    </style>
	

</head>

<body>

 <table width="997" border="0">
 
<tr>					
						<?php 
	  				$stname = $_GET["stname"];
					?>
                             <td width="215"  background="images/headingbg.gif" ><input type="text" size="20" name="recno" id="recno" value="" class="txtbox"  onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
    <td width="194"  background="images/headingbg.gif" ><input type="text" size="29" name="recdate" id="recdate" value="" class="txtbox"/></td>
    <td width="195"  background="images/headingbg.gif" ><input type="text" size="29" name="recamt" id="recamt" value="" class="txtbox"/></td>
    <td width="5"  background="images/headingbg.gif" >
    <td width="32"  background="images/headingbg.gif" >&nbsp;</td>
    <td width="330"></td>
                             
   </tr>  </table>    
<div id="filt_table" class="CSSTableGenerator">  <table width="919" border="0" class=\"form-matrix-table\">
<tr>
                              <td width="123"  background="images/headingbg.gif" ><font color="#FFFFFF">Ref No</font></td>
                              <td width="177"  background="images/headingbg.gif"><font color="#FFFFFF">Date</font></td>
                              <td width="176"  background="images/headingbg.gif"><font color="#FFFFFF">Amount</font></td>
                              
   </tr>
                            <?php 
							
							include('connection.php');
							
							$sql="select CA_REFNO, CA_DATE, CA_AMOUNT, cus_ref  from s_crec where DEPARTMENT != 'S' and CANCELL='0' and FLAG = 'REC-A'  ORDER BY CA_DATE desc limit 50";
						
							$result=mysql_query($sql, $dbinv);
							while($row = mysql_fetch_array($result)){
					
							echo "<tr>               
                              <td onclick=\"recno('".$row['CA_REFNO']."');\">".$row['CA_REFNO']."</a></td>
                              <td onclick=\"recno('".$row['CA_REFNO']."');\">".$row["CA_DATE"]."</a></td>
                              <td onclick=\"recno('".$row['CA_REFNO']."');\">".$row['CA_AMOUNT']."</a></td></tr>";
							
							}
							  ?>
                    </table>
</div>

</body>
</html>
