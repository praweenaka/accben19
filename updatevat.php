<?php

include_once("connection.php");

$sql="select * from paymas  where  bea1!='' and vatno!='' order by bdate desc";
			$result=mysql_query($sql, $dbacc);
			while($row = mysql_fetch_array($result)){

			$sql2="select * from  che_customers  where chepay='".$row["bea1"]."' ";
			$result2=mysql_query($sql2, $dbacc);
			if ($row2 = mysql_fetch_array($result2)){
				echo $row2["chepay"];
			}
		$sql1="update che_customers set vat='".$row["vatno"]."'  where chepay='".$row["bea1"]."' ";
			$result1=mysql_query($sql1, $dbacc);
			//echo $sql1;
			
			}

			
?>