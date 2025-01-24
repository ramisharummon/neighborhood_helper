<?php
error_reporting(0); // Turn off all error reporting
session_start(); // Start the session to get user data

// Database connection
$host = 'localhost';
$dbname = 'neighborhoodhelper';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

?>