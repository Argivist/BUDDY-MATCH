<?php
// Declare constant variables to store the database connection parameters
//$HOST = 'localhost:3309'; 
//$USERNAME = 'root';
//$PASSWORD = '!@#456yui';
//$NAME = 'khapdb';

//try {
    // Create a new PDO instance
  //  $pdo = new PDO("mysql:host=$HOST;dbname=$NAME;charset=utf8mb4", $USERNAME, $PASSWORD);
    // Set PDO error mode to exception
 //   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//} catch (PDOException $e) {
    // If connection fails, throw an exception with the error message
  //  die("Connection failed: " . $e->getMessage());
//}

// Declare constant variables to store the database connection parameters
$HOST = 'sql201.infinityfree.com'; 
$USERNAME = 'if0_37054537';
$PASSWORD = 'KHAPBMswe1';
$NAME = 'if0_37054537_khapdbnew';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$HOST;dbname=$NAME;charset=utf8mb4", $USERNAME, $PASSWORD);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If connection fails, throw an exception with the error message
    die("Connection failed: " . $e->getMessage());
}
?>