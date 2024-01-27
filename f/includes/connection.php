<?php
    session_start();
    try {
        $handler = new PDO('mysql:127.0.0.1;dbname=hub', 'root', '');
        $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo $e-> getMessage();
        die();
    }
?>
