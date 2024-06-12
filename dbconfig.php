<?php
$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "todo_list";

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Create PDO instance
try{
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
    // Close connection
}
?>