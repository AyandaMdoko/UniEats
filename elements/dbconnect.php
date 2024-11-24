<?php

$servername = 'localhost'; // Usually 'localhost' on shared hosting
$username = 'unieatsc_admin'; // Database user
$password = '$lAM8?r3,)28'; // Your database password
$dbname = 'unieatsc_unieats'; // Your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
