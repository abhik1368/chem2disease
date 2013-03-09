<?php
$hostname = "localhost";
$database = "chemdisease";
$username = "abhik";
$password = "abhik96321";
$conndb =  mysql_pconnect($hostname,$username,$password) or trigger_error(mysql_error());
?>