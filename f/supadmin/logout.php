<?php 

    session_start();
    unset($_SESSION['supadmin']);
    header('location: ../admin/aSignIn.php');
    exit();

?>