<?php
// Database connection file for the employee management project.

$host = "127.0.0.1";
$port = 3307;
$username = "root";
$password = "";
$database = "employee_db";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $username, $password, $database, $port);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    error_log('MySQL connection error: ' . $e->getMessage());
    die('Connection failed: Could not connect to database. Check MySQL server and port.');
}
?>
