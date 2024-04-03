<?php
    session_start();
    if (!isset($_SESSION['supadmin'])) {
        // Redirect the user to the sign-in page
        header('Location: ../admin/aSignIn.php');
        exit();
    }

    // dashboard count
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=hub", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql_advisers = "SELECT COUNT(*) AS adviser_count FROM advisers";
        $stmt_advisers = $pdo->prepare($sql_advisers);
        $stmt_advisers->execute();
        $result_advisers = $stmt_advisers->fetch(PDO::FETCH_ASSOC);
        $adviser_count = $result_advisers['adviser_count'];
    
        // count admins
        $sql_admins = "SELECT COUNT(*) AS admin_count FROM admin";
        $stmt_admins = $pdo->prepare($sql_admins);
        $stmt_admins->execute();
        $result_admins = $stmt_admins->fetch(PDO::FETCH_ASSOC);
        $admin_count = $result_admins['admin_count'];
    
        // count studies it
        $sql_studies = "SELECT COUNT(*) AS countIT FROM studies WHERE dept = 'Information Technology'";
        $stmt_studies = $pdo->prepare($sql_studies);
        $stmt_studies->execute();
        $result_studies = $stmt_studies->fetch(PDO::FETCH_ASSOC);
        $countIT = $result_studies['countIT'];

        // count studies cpe
        $sql_studies = "SELECT COUNT(*) AS countCpE FROM studies WHERE dept = 'Computer Engineering'";
        $stmt_studies = $pdo->prepare($sql_studies);
        $stmt_studies->execute();
        $result_studies = $stmt_studies->fetch(PDO::FETCH_ASSOC);
        $countCpE = $result_studies['countCpE'];

        // IT popular adviser
        $sql_popular = "SELECT a.name AS adviser_name, COUNT(s.id) AS advisee_count
        FROM studies s
        JOIN advisers a ON s.adviser = a.id
        WHERE s.dept = 'Information Technology'
        GROUP BY s.adviser
        ORDER BY advisee_count DESC
        LIMIT 1";

        $stmt_popular = $pdo->query($sql_popular);
        $result_popular = $stmt_popular->fetch(PDO::FETCH_ASSOC);
        $adviser_IT = $result_popular['adviser_name'];
        $countITadviser = $result_popular['advisee_count'];

        // CpE popular adviser
        $sql_popular = "SELECT a.name AS adviser_name, COUNT(s.id) AS advisee_count
                FROM studies s
                JOIN advisers a ON s.adviser = a.id
                WHERE s.dept = 'Computer Engineering'
                GROUP BY s.adviser
                ORDER BY advisee_count DESC
                LIMIT 1";
        $stmt_popular = $pdo->query($sql_popular);
        $result_popular = $stmt_popular->fetch(PDO::FETCH_ASSOC);
        $adviser_CpE = $result_popular['adviser_name'];
        $countCpEadviser = $result_popular['advisee_count'];
    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }

    $page_title = "Dashboard";
    include '../includes/header.php';
    include '../includes/sidebarSupadmin.php';
    echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";

?>

<style>
    .viewDetails {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        background-color: rgba(0, 0, 0, 0.7); 
        padding: 5px 10px;
        border-radius: 5px;
        opacity: 0; 
        transition: opacity 0.3s ease; 
        text-decoration: none;
    }
    .ulInside:hover .viewDetails {
        opacity: 1;
    }
    .cardPic {
        position: absolute; 
        top: 0; 
        right: 0; 
        width: 55%; 
        height: 100%; 
        background-image: url('../img/bg-quad.jpg'); 
        background-size: cover; 
        background-position: center; 
        border-radius: 0 5px 5px 0;"
    }
</style>

<div id="content">
    <!-- List of studies -->
    <ul class="list-group">
        <li class="list-group-item p-4">
            <h3>Dashboard</h3>
            <div class="row">
                <div class="col-md-6">
                    <!-- Apply background image to the left half of the ul -->
                    <ul style="list-style-type: none; height: 200px; position: relative;" class="p-3 rounded ulInside mb-3">
                        <!-- Background image container with rounded corners -->
                        <div class="cardPic"></div>
                        <!-- Content -->
                        <div style="position: relative; z-index: 1;">
                            <li>Number of Advisers</li> <br><br>
                            <span style="font-size: 78px;">
                                <?php echo $adviser_count ?>
                            </span>
                            <!-- Hover button -->
                            <a href="mAdvisers.php" id="viewDetails1" class="viewDetails">View Details</a>
                        </div>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul style="list-style-type  : none; height: 200px; position: relative;" class="p-3 rounded ulInside mb-3">
                        <div class="cardPic"></div>
                        <div style="position: relative; z-index: 1;">
                            <li>Number of Registered <br>Admins</li> <br>
                            <span style="font-size: 78px;">
                                <?php echo $admin_count ?>
                            </span>
                            <!-- Hover button -->
                            <a href="mAdmins.php" id="viewDetails1" class="viewDetails">View Details</a>
                        </div>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <ul style="list-style-type: none; height: 200px; position: relative;" class="p-3 rounded ulInside mb-3">
                        <div class="cardPic"></div>   
                        <li>Total Capstone Records <br>for IT Department</li> <br>
                        <span style="font-size: 78px;">
                            <?php echo $countIT ?>
                        </span>
                        <!-- Hover button -->
                        <a href="infotech.php" id="viewDetails1" class="viewDetails">View Details</a>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul style="list-style-type: none; height: 200px; position: relative;" class="p-3 rounded ulInside">
                        <div class="cardPic"></div>
                        <li>Total Capstone Records <br>for CpE Department</li> <br>
                        <span style="font-size: 78px;">
                            <?php echo $countCpE ?>
                        </span>
                        <!-- Hover button -->
                        <a href="comEng.php" id="viewDetails1" class="viewDetails">View Details</a>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <h4>Popular adviser</h4>
                <div class="col-md-6">
                    <ul style="list-style-type: none; height: 200px; position: relative;" class="p-3 rounded ulInside mb-3">
                        <div class="cardPic"></div>
                        <li>Information Technology <br> Department</li> <br>
                        <span style="font-size: 17px;">
                            <?php echo $adviser_IT ?>
                        </span><br>
                        <span style="font-size: 15px;">
                            <?php echo $countITadviser . " Advisee" ?>
                        </span>
                        <!-- Hover button -->
                        <a href="#" id="viewDetails1" class="viewDetails">View Details</a>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul style="list-style-type: none; height: 200px; position: relative;" class="p-3 rounded ulInside">
                        <div class="cardPic"></div>    
                        <li>Computer Engineering <br> Department</li> <br>
                        <span style="font-size: 17px;">
                            <?php echo $adviser_CpE ?>
                        </span><br>
                        <span style="font-size: 15px;">
                            <?php echo $countCpEadviser . " Advisee" ?>
                        </span>
                        <!-- Hover button -->
                        <a href="#" id="viewDetails1" class="viewDetails">View Details</a>
                    </ul>
                </div>
            </div>
        </li>
    </ul>
</div>