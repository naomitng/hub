<?php
    session_start();
    $page_title = "Manage Advisers";
    include '../includes/header.php';
    include '../user/sidebarUser.php';

    echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";

    //$pdo = new PDO("mysql:host=127.0.0.1;dbname=hub", 'root', '');
    $pdo = new PDO("mysql:host=sql209.infinityfree.com; dbname=if0_36132900_hub", "if0_36132900", "Hs96nqZI1Gd9ED");

    try {
        // Fetch advisers only from the Information Technology department
        $stmt = $pdo->prepare("SELECT * FROM `advisers` WHERE dept = 'Information Technology'");
        $stmt->execute();
        $advisers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $errMsg = "Error fetching advisers: " . $e->getMessage();
    }

    try {
        // Check if a search term is provided
        if(isset($_GET['search'])) {
            $search = $_GET['search'];
            // Fetch advisers from the Information Technology department with the provided search term
            $stmt = $pdo->prepare("SELECT * FROM `advisers` WHERE name LIKE :search AND dept = 'Information Technology'");
            $stmt->bindValue(':search', "%$search%");
        } else {
            // If no search term provided, display all advisers from the Information Technology department
            $stmt = $pdo->prepare("SELECT * FROM `advisers` WHERE dept = 'Information Technology'");
        }
        $stmt->execute();
        $advisers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $errMsg = "Error fetching advisers: " . $e->getMessage();
    }
?>

<!-- Content Area -->
<div id="content">
    <!-- Search bar -->
    <form class="search" method="get"> <!-- Change method to get -->
        <input type="text" class="form-control" placeholder="Search" name="search"> 
        <button class="btn btn-warning" type="submit"> 
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </button>
    </form>

    <!-- List of advisers -->
    <ul class="list-group mt-5 mb-5">
        <li class="list-group-item p-4">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Previous/back link -->
                <a href="../user/results.php" class="text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg> Back to home
                </a>
            </div>
            <!-- Advisers --> 
            <?php foreach ($advisers as $adviser): ?>
                <ul style="list-style-type: none;" class="p-3 rounded ulInside mt-4">
                    <!-- Name -->
                    <li class="list-group-item-title d-flex">
                        <a href="" class=" text-decoration-none text-dark" style="pointer-events: none;"><?php echo $adviser['name']; ?></a>
                    </li>
                    <!-- Adviser information -->
                    <li class="text-muted">Email: <?php echo $adviser['email']; ?></li>
                    <li class="text-muted">Department of <?php echo $adviser['dept']; ?> </li>
                </ul>
            <?php endforeach; ?>
        </li>
    </ul>
    <?php
    // Check if there are 5 or more entries
    if (count($advisers) >= 5) {
        echo '
            <!-- Pagination -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
            ';
    }   
    ?>
</div>
