<?php

$hostname = 'localhost';
$username = 'SWije_lotterix';
$password = 'Shan#123@';

$dbacc = mysql_connect($hostname, $username, $password);
$dbinv = mysql_connect($hostname, $username, $password, true);

mysql_select_db('swijesooriya_ben', $dbben);
mysql_select_db('swijesooriya_tht', $dbtht);	
//$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die                      ('Error connecting to mysql server!');

//$dbname = 'milhosp';
//$dbname = 'dberp';
//$dbname = 'acc';
//$dbname = 'ben';
//$dbname = 'dberp_e';
//mysql_select_db($dbname);

/*

$hostname = 'localhost';
$username = 'lotterix_admin';
$password = 'shan@123';

$dbacc = mysql_connect($hostname, $username, $password);
$dbinv = mysql_connect($hostname, $username, $password, true);

mysql_select_db('lotterix_accben', $dbacc);
mysql_select_db('lotterix_ben', $dbinv);*/
?>
