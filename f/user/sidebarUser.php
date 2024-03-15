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
                                echo "<li><a href='./results.php?search=" . urlencode($keyword) . "' class='link-dark rounded'>$keyword ($count)</a></li>";
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
                        <li><a href="filter.php" class="link-dark rounded">Anytime</a></li>
                        <li><a href="filter.php?year=2020" class="link-dark rounded">Since 2020</a></li>
                        <li><a href="filter.php?year=2021" class="link-dark rounded">Since 2021</a></li>
                        <li><a href="filter.php?year=2022" class="link-dark rounded">Since 2022</a></li>
                        <li><a href="filter.php?year=2023" class="link-dark rounded">Since 2023</a></li>
                        <li><a href="filter.php?year=2024" class="link-dark rounded">Since 2024</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</body>