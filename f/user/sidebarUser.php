<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <style>
        #signInAdmin, #backHome {
            color: black;
            text-decoration: none;
        }
        #signInAdmin:hover, #backHome:hover {
            color: gray;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="flex-shrink-0 p-3 dash" style="width: 280px; height: 100%;">
        <div class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
            <!-- Logo -->
            <a href="../user/results.php" style="text-decoration: none;" class="d-flex align-items-center">
                <img src="../img/logo.png" alt="" style="width: 40px;">
                <span style="font-size: 25px; color: #28282B;">Research Hub</span>
            </a>
        </div>
        <ul class="list-unstyled ps-0">  
            <!-- List for the departments -->
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
                    Departments
                </button>

                <!-- Departments -->
                <div class="collapse" id="home-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="infotech.php" class="link-dark rounded">Information Technology</a></li>
                        <li><a href="comEng.php" class="link-dark rounded">Computer Engineering</a></li>
                    </ul>
                </div>
            </li>

            <!-- List for the dashboard -->
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                    Collections
                </button>

                <!-- Under dashboard -->
                <div class="collapse" id="dashboard-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <?php
                        require_once '../includes/connection.php';

                        try {
                            $sql = "SELECT keywords FROM studies";
                            $stmt = $handler->prepare($sql);
                            $stmt->execute();
                            $keywordCounts = array();
                    
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $keywords = explode(",", $row["keywords"]);
                                
                                foreach ($keywords as $keyword) {
                                    $keyword = trim($keyword); 
                                    if (!empty($keyword)) { 
                                        if (!isset($keywordCounts[$keyword])) {
                                            $keywordCounts[$keyword] = 1;
                                        } else {
                                            $keywordCounts[$keyword]++;
                                        }
                                    }
                                }
                            }

                            arsort($keywordCounts);

                            $counter = 0;
                            foreach ($keywordCounts as $keyword => $count) {
                                if ($counter >= 10) {
                                    break;
                                }
                                echo "<li><a href='./results.php?collection=" . urlencode($keyword) . "' class='link-dark rounded'>$keyword ($count)</a></li>";

                                $counter++;
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                    </ul>
                </div>
            </li>

            <!-- List for the dashboard -->
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#adviser-collapse" aria-expanded="false">
                    Advisers
                </button>

                <!-- Under dashboard -->
                <div class="collapse" id="adviser-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="../user/advisers-it.php" class="link-dark rounded">IT Advisers</a></li>
                        <li><a href="../user/advisers-cpe.php" class="link-dark rounded">CpE Advisers</a></li>
                    </ul>
                </div>
            </li>

            <!-- List for filter -->
            <li class="">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#filter-collapse" aria-expanded="false">
                    Filter searches
                </button>

                <!-- Year -->
                <div class="collapse" id="filter-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="filter.php?year=2020" class="link-dark rounded">Since 2020</a></li>
                        <li><a href="filter.php?year=2021" class="link-dark rounded">Since 2021</a></li>
                        <li><a href="filter.php?year=2022" class="link-dark rounded">Since 2022</a></li>
                        <li><a href="filter.php?year=2023" class="link-dark rounded">Since 2023</a></li>
                        <li><a href="filter.php?year=2024" class="link-dark rounded">Since 2024</a></li>
                    </ul>
                </div>
            </li>
            <div style="position: relative; bottom: 0;" class="border-top mt-3">
                <button type="button" class="btn mt-3" id="backHome" style="align-items: center;">
                    <a href="https://uresearchub.rf.gd" id="backHome">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
                            <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
                        </svg> 
                        <span style="margin-left: 5px;">Back to home</span>
                    </a>
                </button>
                <button type="button" class="btn" id="signInAdmin" style="align-items: center;">
                    <a href="../admin/aSignIn.php" id="signInAdmin">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                    </svg> 
                    <span style="margin-left: 5px;">Sign in as Admin</span>
                    </a>
                </button>
            </div>
        </ul>
    </div>
</body>