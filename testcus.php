<?php

include_once("connection.php");

$sql="select * from che_customers  where  active='1' order by id ";
			//echo $sql;
			$result=mysql_query($sql, $dbacc);
			while($row = mysql_fetch_array($result)){
				if (is_null($row["vat"])==true){
					$sql1="update che_customers  set vat='' where  id='".$row["id"]."' ";
			//echo $sql;
			$result1=mysql_query($sql1, $dbacc);
				//echo $row["id"]."</br>";
				}	
			}
?>