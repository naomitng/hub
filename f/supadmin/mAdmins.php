<?php
session_start();
if (!isset($_SESSION['supadmin'])) {
    // Redirect the user to the sign-in page
    header('Location: ../admin/aSignIn.php');
    exit();
}
$page_title = "Manage Admins";
include '../includes/header.php';
include '../includes/sidebarSupadmin.php';
echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";
echo "<link rel='stylesheet' type='text/css' href='../css/mAdmins.css'>";
echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>";
echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js'></script>";

$sucMsg = "";
$errMsg = "";

// Set the number of admins to display per page
$adminsPerPage = 10;

// display admins
try {
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $stmt = $pdo->prepare("SELECT * FROM `admin` WHERE lname LIKE :search OR fname LIKE :search");
        $stmt->bindValue(':search', "%$search%");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM `admin`");
    }
    $stmt->execute();
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errMsg = "Error fetching admins: " . $e->getMessage();
}

// Calculate the total number of pages for pagination
$totalPages = ceil(count($admins) / $adminsPerPage);

// Calculate the offset based on the current page
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * $adminsPerPage;

// Fetch admins for the current page
try {
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $stmt = $pdo->prepare("SELECT * FROM `admin` WHERE lname LIKE :search OR fname LIKE :search LIMIT :offset, :perPage");
        $stmt->bindValue(':search', "%$search%");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM `admin` LIMIT :offset, :perPage");
    }
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':perPage', $adminsPerPage, PDO::PARAM_INT);
    $stmt->execute();
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errMsg = "Error fetching admins: " . $e->getMessage();
}
?>

<!-- Content Area -->
<div id="content">
    <!-- Search bar -->
    <form class="search" method="get">
        <input type="text" class="form-control" placeholder="Search" name="search">
        <button class="btn btn-warning" type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </button>
    </form>

    <!-- List of admins -->
    <ul class="list-group mt-5 mb-5">
        <li class="list-group-item p-4">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Previous/back link -->
                <a href="aDashboard.php" class="text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg> Back to dashboard
                </a>
            </div>
            <!-- Admins -->
            <?php foreach ($admins as $admin): ?>
                <ul style="list-style-type: none;" class="p-3 rounded ulInside mt-4">
                    <!-- Full Name -->
                    <li class="list-group-item-title d-flex">
                        <a href="" class=" text-decoration-none text-dark" style="pointer-events: none;"><?php echo $admin['lname'] . ", " . $admin['fname']; ?></a>
                    </li>
                    <li class="text-muted">Email: <?php echo $admin['email']; ?></li>
                    <li class="text-muted">Account:
                        <?php
                            if ($admin['verified'] == '1') { echo 'Verified'; } else { echo 'Not Verified'; }
                        ?> 
                    </li>
                </ul>
            <?php endforeach; ?>
        </li>
    </ul>
    <?php
        // Check if there are 5 or more entries
        if (count($admins) >= 5) {
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