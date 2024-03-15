<?php 
    session_start();
    unset($_SESSION['fname']);
    header('location: ../admin/aSignIn.php');
    exit();
?>