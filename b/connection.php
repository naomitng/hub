<?php
    $server = "localhost";
    $user = "root";
    $pass = ""; 

    try {
        $conn = new PDO("mysql:host=$server;dbname=hub", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "connected";
    } catch (PDOException $e) {
        echo "failed: " . $e->getMessage();
    }
?>
