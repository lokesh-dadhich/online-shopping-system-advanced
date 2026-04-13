<?php

$servername = "mysql-db";   // container name (IMPORTANT)
$username = "lokesh";       // from your docker env
$password = "lokesh@123";   // from your docker env
$db = "onlineshop";

// Create connection
$con = mysqli_connect("mysql-db", "lokesh", "lokesh@123", "onlineshop");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
