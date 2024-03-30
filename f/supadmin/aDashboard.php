<?php
    session_start();
    if (!isset($_SESSION['supadmin'])) {
        // Redirect the user to the sign-in page
        header('Location: ../admin/aSignIn.php');
        exit();
    }

    $page_title = "Dashboard";
    include '../includes/header.php';
    include '../includes/sidebarSupadmin.php';
    echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";

?>

<!-- Content Area -->
<div id="content">
    <!-- List of studies -->
    <ul class="list-group">
        <li class="list-group-item p-4">
            <h3>Dashboard</h3>
            <div class="row">
                <div class="col-md-6">
                    <ul style="list-style-type: none; height: 200px;" class="p-3 rounded ulInside mb-3">
                        <li>Number of Advisers</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul style="list-style-type: none; height: 200px;" class="p-3 rounded ulInside mb-3">
                        <li>Number of Registered Admins</li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <ul style="list-style-type: none; height: 200px;" class="p-3 rounded ulInside mb-3">
                        <li>Total Capstone Records</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul style="list-style-type: none; height: 200px;" class="p-3 rounded ulInside">
                        <li>Total Capstone Records</li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <h4>Popular adviser</h4>
                <div class="col-md-6">
                    <ul style="list-style-type: none; height: 200px;" class="p-3 rounded ulInside mb-3">
                        <li>IT Dept</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul style="list-style-type: none; height: 200px;" class="p-3 rounded ulInside">
                        <li>CpE Dept</li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>
</div>


