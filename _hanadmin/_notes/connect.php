<?php
/* Database config */
if(!$mysql) $mysql = $mysql1;
$link = mysql_connect($mysql['db_host'],$mysql['db_user'],$mysql['db_pass']) or die('Unable to establish a DB connection');

mysql_select_db($mysql['db_name'] ,$link);
mysql_query("SET names UTF8");

?>