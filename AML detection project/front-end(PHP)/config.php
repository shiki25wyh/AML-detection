<?php

// Database configuration
$dbHost     = "localhost";
$dbUsername = "wtjiahmy_fintech";
$dbPassword = "Fintech0403";
$dbName     = "wtjiahmy_fintech";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);


// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}



?>