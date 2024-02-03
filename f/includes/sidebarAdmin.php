<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>

    <!-- Sidebar -->
    <div class="flex-shrink-0 p-3 dash" style="width: 280px; height: 100%;">
        <div class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">

            <!-- Logo -->
            <a href="../admin/aDashboard.php" style=" text-decoration: none;"><img src="../img/logo.png" alt="" style="width: 40px;"></a>
            <span style="font-size: 25px; color: #28282B;">Research Hub</span>
            
        </div>
        <ul class="list-unstyled ps-0">

            <!-- List for the departments -->
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                    Departments
                </button>

                <!-- Departments -->
                <div class="collapse show" id="home-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-dark rounded">Information Technology</a></li>
                        <li><a href="#" class="link-dark rounded">Computer Engineering</a></li>
                    </ul>
                </div>
            </li>

            <!-- List for the dashboard -->
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                    Dashboard
                </button>

                <!-- Under dashboard -->
                <div class="collapse" id="dashboard-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="contribute.php" class="link-dark rounded">Contribute</a></li>
                        <li><a href="#" class="link-dark rounded">See statistics</a></li>
                        <li><a href="mAdvisers.php" class="link-dark rounded">Manage advisers</a></li>
                    </ul>
                </div>
            </li>

            <!-- List for filter -->
            <li class="">
                <button class="btn btn-toggle align-items-center rounded collapsed mt-3" data-bs-toggle="collapse" data-bs-target="#filter-collapse" aria-expanded="true">
                    Filter searches
                </button>

                <!-- Year -->
                <div class="collapse show" id="filter-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-dark rounded">Anytime</a></li>
                        <li><a href="#" class="link-dark rounded">Since 2020</a></li>
                        <li><a href="#" class="link-dark rounded">Since 2021</a></li>
                        <li><a href="#" class="link-dark rounded">Since 2022</a></li>
                        <li><a href="#" class="link-dark rounded">Since 2023</a></li>
                        <li><a href="#" class="link-dark rounded">Since 2024</a></li>
                    </ul>
                </div>
            </li>

            <!-- Account setting -->
            <li class="border-top">
                <button class="btn btn-toggle align-items-center rounded collapsed mt-3" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                    <?php echo "Hello, admin " . $_SESSION['fname']; ?>
                </button>

                <!-- Under account settings -->
                <div class="collapse" id="account-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-dark rounded">Sign out</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</body>
</html>