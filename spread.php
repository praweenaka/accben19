<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<script language="JavaScript" src="js/cell_setip.js"></script>

</head>

<body>


<table width="1000" border="1">
<?php
	
	$i=1;
	while ($i<201){
		$c1="c".$i."_1";
		$c2="c".$i."_2";
		$c3="c".$i."_3";
		$c4="c".$i."_4";
		$c5="c".$i."_5";
		$c6="c".$i."_6";
  
  echo "<tr>
    <td onclick=\"load_setup('".$c1."');\"><div id=\"".$c1."\">&nbsp;</div></td>
    <td onclick=\"load_setup('".$c2."');\"><div id=\"".$c2."\">&nbsp;</div></td>
    <td onclick=\"load_setup('".$c3."');\"><div id=\"".$c3."\">&nbsp;</div></td>
    <td onclick=\"load_setup('".$c4."');\"><div id=\"".$c4."\">&nbsp;</div></td>
    <td onclick=\"load_setup('".$c5."');\"><div id=\"".$c5."\">&nbsp;</div></td>
    <td onclick=\"load_setup('".$c6."');\"><div id=\"".$c6."\">&nbsp;</div></td>
  </tr>";
  $i=$i+1;
  }
 ?> 
</table>
</body>
</html>
