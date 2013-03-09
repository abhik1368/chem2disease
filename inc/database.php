<?php
$hostname = "localhost";
$database = "chemdisease";
$username = "abhik";
$password = "abhik96321";
$conndb = mysqli_connect($hostname,$username,$password) or die('could not connect to the database because:' . mysqli_connect_error());
?>