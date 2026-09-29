<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'lab_equipment_db');

// Create connection
function getConnection() {


    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    
    // Check connection
    if ($conn->connect_error) {

        die("Connection failed: " . $conn->connect_error);
        
    }

    
    return $conn;

}

// Create a PDO connection
function getPDOConnection() {

    try {


        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;

    } 
    
    catch(PDOException $e) {

        die("Connection failed: " . $e->getMessage());

    }
}
?>