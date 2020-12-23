<?php
$servername = "localhost";
$username = "root";
$password ="";
$dbname= "watchshop";

$connection = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
$connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//$connection->exec("SET CHARACTER utf-8");