<?php
session_start();
$server = "localhost";
$user = "root"; //username
$password = ""; //password
$database = "inventory_system";
$connect = mysqli_connect($server,$user,$password,$database);

?>