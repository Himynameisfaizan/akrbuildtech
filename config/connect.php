<?php
if (session_status() === PHP_SESSION_NONE) {
    // session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Automatic Localhost vs Live Server Detection
$is_localhost = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false);

if ($is_localhost) {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbName = 'akrbuild';
    $site = "http://localhost/office_php_project/akrbuild/";
} else {
    $host = 'localhost';
    $username = 'u799879276_bhagirath_db';
    $password = 'Bhagi@rath1';
    $dbName = 'u799879276_bhagirath_db';
    $site = 'https://www.akrbuildtech.com/'; // Live domain with www
}

global $site;

// Create Database Connection
$conn = new mysqli($host, $username, $password, $dbName);

// Check Connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Set Character Encoding to UTF-8mb4
$conn->set_charset("utf8mb4");
?>