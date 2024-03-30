<?php
// Initialize $totalSearchResults
$totalSearchResults = 0;
$filteredStudies = array();

session_start();

$page_title = "Dashboard";
include '../includes/header.php';
include 'sidebarUser.php';
echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";

// Get the year from the url
$year = isset($_GET['year']) ? intval($_GET['year']) : null;

// Check if search param is set otherwise null
$searchTerm = isset($_GET['search']) ? $_GET['search'] : null;

// Pagination variables
$studiesPerPage = 10; // Change this as needed
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($currentPage - 1) * $studiesPerPage;

// Fetch studies with pagination
$stmt = $pdo->prepare("SELECT * FROM `studies`" . ($year ? " WHERE year = :year AND verified = 1" : " WHERE verified = 1") . " LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $studiesPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
if ($year) {
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
}
$stmt->execute();
$studies = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count total studies (considering search filter)
if ($searchTerm !== null) {
    $totalStudies = count($filteredStudies);
} else {
    $totalStudies = $pdo->query("SELECT COUNT(*) FROM `studies`" . ($year ? " WHERE year = $year AND verified = 1" : " WHERE verified = 1"))->fetchColumn();
}

// Get studies based on the year from the URL
if(isset($_GET['year'])) {
    $stmt = $pdo->prepare('SELECT * FROM `studies` WHERE year = :year LIMIT :limit OFFSET :offset');
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $studiesPerPage, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $studies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Fetch all studies if year is not provided
    $stmt = $pdo->prepare("SELECT * FROM `studies` LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $studiesPerPage, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $studies = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Search
    if($searchTerm !== null) {
        foreach($studies as $study) {
            if($year === null || $study['year'] == $year) {
                if (stripos($study['title'], $searchTerm) !== false || stripos($study['abstract'], $searchTerm) !== false || stripos($study['keywords'], $searchTerm) !== false) {
                    $filteredStudies[] = $study;
                }
            }
        }
        $studies = $filteredStudies;
        
        // Count total search results
        $totalSearchResults = count($filteredStudies);
    }
?>

<!-- Content Area -->
<div id="content">
    <!-- Search bar -->
    <form class="search" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
        <input type="hidden" name="year" value="<?php echo isset($_GET['year']) ? $_GET['year'] : ''; ?>">
        <input type="text" class="form-control" name="search" placeholder="Search for a study" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit" class="btn btn-warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </button>
    </form>

    <!-- List of studies -->
    <ul class="list-group mb-5 mt-5">
        <li class="list-group-item p-4">
            <?php if (isset($_GET['search'])): ?>
                <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                    <i class="text-muted"><?php echo $totalSearchResults; ?> results found for "<?php echo htmlspecialchars($_GET['search']); ?>"<br></i>
                <?php endif; ?>
            <?php endif; ?>
            <a href="results.php" class="text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                </svg> Back to Home
            </a>
            <?php foreach ($studies as $study): ?>
                <!-- loop to display studies -->
                <ul style="list-style-type: none;" class="p-3 rounded ulInside mb-4 mt-3">
                    <!-- Title -->
                    <li class="list-group-item-title d-flex">
                        <a href="display_dash.php?id=<?php echo $study['id']; ?>">
                            <?php $title = $study['title'];
                                if (strlen($title) > 50) {
                                    $words = explode(' ', $title);
                                    $new_title = '';
                                    $line_length = 0;

                                    foreach ($words as $word) {
                                        if ($line_length + strlen($word) > 70) {
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
                        </a>
                    </li>

                    <!-- Information about the study -->
                    <li><?php echo substr($study['abstract'], 0, 300) . "..."; ?></li>
                    <li class="text-muted">Authors: <?php echo $study['authors']; ?></li>
                    <li class="text-muted">Department: <?php echo $study['dept']; ?></li>
                    <li class="text-muted">Adviser: <?php echo $study['adviser']; ?></li>
                    <li class="text-muted">Published <?php echo $study['year']; ?></li>
                    <hr>
                    <li class="text-muted">Keywords: <?php echo $study['keywords']; ?></li>
                </ul>
            <?php endforeach; ?>
        </li>
    </ul>        

<!-- Pagination -->
<?php if ($totalStudies > $studiesPerPage): ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?year=<?php echo $year; ?>&page=<?php echo $currentPage - 1; ?>">Previous</a>
                    </li>
                <?php endif; ?>
                <?php
                $totalPages = ceil($totalStudies / $studiesPerPage);
                for ($i = 1; $i <= $totalPages; $i++):
                    ?>
                    <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link" href="?year=<?php echo $year; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?year=<?php echo $year; ?>&page=<?php echo $currentPage + 1; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>
