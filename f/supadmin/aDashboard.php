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
    
        // count infotech studies
        $sql_it = "SELECT COUNT(*) AS it_count FROM studies WHERE dept = 'Information Technology'";
        $stmt_it = $pdo->prepare($sql_it);
        $stmt_it->execute();
        $result_it = $stmt_it->fetch(PDO::FETCH_ASSOC);
        $it_count = $result_it['it_count'];

        // count comeng studies
        $sql_cpe = "SELECT COUNT(*) AS cpe_count FROM studies WHERE dept = 'Computer Engineering'";
        $stmt_cpe = $pdo->prepare($sql_cpe);
        $stmt_cpe->execute();
        $result_cpe = $stmt_cpe->fetch(PDO::FETCH_ASSOC);
        $cpe_count = $result_cpe['cpe_count'];
    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
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
                        <li>Number of Advisers</li> <br>
                        <span style="font-size: 78px;">
                            <?php echo $adviser_count ?>
                        </span>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul style="list-style-type: none; height: 200px;" class="p-3 rounded ulInside mb-3">
                        <li>Number of Registered Admins</li> <br>
                        <span style="font-size: 78px;">
                            <?php echo $admin_count ?>
                        </span>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <ul style="list-style-type: none; height: 200px;" class="p-3 rounded ulInside mb-3">
                        <li>Total IT Capstone Records</li> <br>
                        <span style="font-size: 78px;">
                            <?php echo $it_count ?>
                        </span>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul style="list-style-type: none; height: 200px;" class="p-3 rounded ulInside">
                        <li>Total CpE Capstone Records</li> <br>
                        <span style="font-size: 78px;">
                            <?php echo $cpe_count ?>
                        </span>
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


