<?php
$mysqlHost = "127.0.0.1";
$mysqlUser = "astlogger";
$mysqlPasswd = "astavaya";
$mysqlDB = "astlogger";
$db = mysql_connect($mysqlHost, $mysqlUser, $mysqlPasswd) 
or die("Connect to DB failed, please contact system administrator.");
mysql_select_db($mysqlDB, $db) or die("Select DB failed, please contact system administrator.");
?>
