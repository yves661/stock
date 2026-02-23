<?php
// Database connection - update credentials for your environment
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'stockshop');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME,3307);
if ($conn->connect_error) {
    die('Database connection error: ' . $conn->connect_error);
}
?>