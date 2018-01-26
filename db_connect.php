<?php

$dbhost = "lund.cnjs7v2r8dgv.us-east-1.rds.amazonaws.com";
$dbport = "3306";
$dbname = "staketinder";
$charset = 'utf8' ;

$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};charset={$charset}";
$username = "bryce";
$password = "Pantitlan21";


try {
    $conn = new PDO($dsn, $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
    }
catch(PDOException $e)
    {
    echo "Connection failedz: " . $e->getMessage();
    }
?>