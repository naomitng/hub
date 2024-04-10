<?php
session_start();
if (!isset($_SESSION['supadmin'])) {
    header('Location: ../admin/aSignIn.php');
    exit();
}

$page_title = "Popular Adviser";
include '../includes/header.php';
include '../includes/sidebarSupadmin.php';
echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";

$totalSearchResults = 0;

// Pagination variables
$studiesPerPage = 10;
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($currentPage - 1) * $studiesPerPage;

// Check if adviser and dept are provided in the GET method
if (isset($_GET['adviser'], $_GET['dept'])) {
    $adviser = htmlspecialchars($_GET['adviser']);
    $dept = htmlspecialchars($_GET['dept']);

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=hub", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve adviser ID based on adviser name
        $stmt_adviser_id = $pdo->prepare("SELECT id FROM advisers WHERE name = :adviser");
        $stmt_adviser_id->bindParam(':adviser', $adviser);
        $stmt_adviser_id->execute();
        $adviser_id = $stmt_adviser_id->fetchColumn();

        $sql = "SELECT * FROM studies WHERE adviser = :adviser_id AND dept = :dept";
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = '%' . htmlspecialchars($_GET['search']) . '%';
            $sql .= " AND title LIKE :searchTerm";
        }

        $stmt_studies = $pdo->prepare($sql);
        $stmt_studies->bindParam(':adviser_id', $adviser_id);
        $stmt_studies->bindParam(':dept', $dept);

        if (isset($searchTerm)) {
            $stmt_studies->bindParam(':searchTerm', $searchTerm);
        }

        $stmt_studies->execute();
        $studies = $stmt_studies->fetchAll(PDO::FETCH_ASSOC);

        $totalStudies = $stmt_studies->rowCount();
    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    // Adviser and/or department not provided, handle accordingly
    $error_message = "Please provide both adviser and department.";
}

?>

<div id="content">
    <!-- Display error message if adviser and/or department not provided -->
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <!-- Search bar -->
    <form class="search" action="" method="GET">
        <input type="text" class="form-control" name="search" placeholder="Search for a study" autocomplete="off" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit" class="btn btn-warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </button>
        <!-- Pass adviser name and department in hidden inputs -->
        <input type="hidden" name="adviser" value="<?php echo isset($_GET['adviser']) ? htmlspecialchars($_GET['adviser']) : ''; ?>">
        <input type="hidden" name="dept" value="<?php echo isset($_GET['dept']) ? htmlspecialchars($_GET['dept']) : ''; ?>">
    </form>

    <!-- List of studies -->
    <?php if (!isset($error_message)): ?>
        <ul class="list-group mt-5 mb-5">
            <li class="list-group-item p-4">
                <h3>Popular Adviser</h3>
                <h6>Advisory of <b><i><?=$adviser?></i></b> in department of <b><i><?=$dept?></i></b></h6>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <!-- Previous/back link -->
                    <a href="aDashboard.php" class="text-decoration-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                        </svg> Back to dashboard
                    </a>
                </div>

                <?php if (isset($_GET['search'])): ?>
                    <div class="mb-4">
                        <i class="text-muted"><?php echo $totalStudies; ?> results found for "<?php echo htmlspecialchars($_GET['search']); ?>"</i>
                    </div>
                <?php endif; ?>

                <!-- loop to display studies -->
                <?php if (!empty($studies)): ?>
                    <?php foreach ($studies as $study): ?>
                        <ul style="list-style-type: none;" class="p-3 rounded ulInside mb-4">
                            <!-- Title -->
                            <li class="list-group-item-title d-flex">
                                <h4>
                                    <?php 
                                    $title = $study['title'];
                                    if (strlen($title) > 50) {
                                        $words = explode(' ', $title);
                                        $new_title = '';
                                        $line_length = 0;

                                        foreach ($words as $word) {
                                            if ($line_length + strlen($word) > 50) {
                                                $new_title .= '<br>' . $word . ' ';
                                                $line_length = strlen($word) + 1; 
                                            } else {
                                                $new_title .= $word . ' ';
                                                $line_length += strlen($word) + 1; 
                                            }
                                        }
                                        echo $new_title;
                                    } else {
                                        echo $title;
                                    } 
                                    ?>
                                </h4>
                            </li>

                            <!-- Information about the study -->
                            <div class="text-muted">
                                <li>Department: <?= $study['dept']; ?></li>
                                <li>Year: <?= $study['year']; ?></li>
                            </div>
                        </ul>
                    <?php endforeach; ?>
                <?php endif; ?>
            </li>
        </ul>

        <!-- Pagination -->
        <?php if ($totalStudies > $studiesPerPage): ?>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
                        </li>
                    <?php endif; ?>
                    <?php
                        $totalPages = ceil($totalStudies / $studiesPerPage);
                        for ($i = 1; $i <= $totalPages; $i++):
                    ?>
                        <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>
