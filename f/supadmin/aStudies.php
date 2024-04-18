<?php
session_start();

if (!isset($_SESSION['supadmin'])) {
    // Redirect the user to the sign-in page
    header('Location: ../admin/aSignIn.php');
    exit();
}

$page_title = "Contributor";
include '../includes/header.php';
include '../includes/sidebarSupadmin.php';
echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";

$id = $_GET['id'];

//$pdo = new PDO("mysql:host=127.0.0.1; dbname=hub", "root", "");

try {
    $stmt = $pdo->prepare("SELECT a.fname AS contributor_fname, a.lname AS contributor_lname, s.* FROM `studies` s INNER JOIN `admin` a ON s.contributor = a.id WHERE s.contributor = :id AND s.verified = 1");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute(); 
    $studies = $stmt->fetchAll(PDO::FETCH_ASSOC); 
} catch (PDOException $e) {
    echo $e->getMessage();
}

// Pagination variables
$studiesPerPage = 10;
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the offset based on the current page
$offset = ($currentPage - 1) * $studiesPerPage;

$totalSearchResults = 0;

try {
    if (isset($_GET['search'])) {
        $searchQuery = '%' . $_GET['search'] . '%';

        $stmt = $pdo->prepare("
            SELECT COUNT(*) AS total_results
            FROM `studies` s 
            INNER JOIN `admin` a ON s.contributor = a.id 
            WHERE s.contributor = :id AND s.verified = 1 AND (s.title LIKE :search OR s.authors LIKE :search)
        ");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':search', $searchQuery, PDO::PARAM_STR);
        $stmt->execute();
        $totalSearchResults = $stmt->fetchColumn();

        $stmt = $pdo->prepare("
            SELECT a.fname AS contributor_fname, a.lname AS contributor_lname, s.* 
            FROM `studies` s 
            INNER JOIN `admin` a ON s.contributor = a.id 
            WHERE s.contributor = :id AND s.verified = 1 AND (s.title LIKE :search OR s.authors LIKE :search)
            ORDER BY s.popularity DESC
            LIMIT :offset, :limit
        ");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':search', $searchQuery, PDO::PARAM_STR);
    } else {

        $stmt = $pdo->prepare("
            SELECT a.fname AS contributor_fname, a.lname AS contributor_lname, s.* 
            FROM `studies` s 
            INNER JOIN `admin` a ON s.contributor = a.id 
            WHERE s.contributor = :id AND s.verified = 1
            LIMIT :offset, :limit
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    }

    // Bind offset and limit for pagination
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $studiesPerPage, PDO::PARAM_INT);

    // Execute the prepared statement
    $stmt->execute();
    $studies = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows

    // Fetch total number of studies for pagination
    $totalStudies = count($studies);
} catch (PDOException $e) {
    // Handle database errors here
    echo "Error: " . $e->getMessage();
}

$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
?>

<!-- Content Area -->
<div id="content">
    <!-- Search bar -->
    <form class="search" method="get" action="aStudies.php">
        <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
        <input type="text" class="form-control" placeholder="Search" name="search">
        <button class="btn btn-warning" type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </button>
    </form>

    <!-- List of studies -->
    <ul class="list-group mt-5 mb-5">   
        <li class="list-group-item p-4">
            <h3>Uploaded studies by <b><i><?= !empty($studies) ? $studies[0]['contributor_fname'] . ' ' . $studies[0]['contributor_lname'] : 'Unknown Contributor' ?></i></b></h3>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Previous/back link -->
                <a href="<?=$referrer?>" class="text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg> Back
                </a>
            </div>

            <div class="mb-4">
                <?php if (!empty($_GET['search'])): ?>
                    <?php if ($totalSearchResults === 0): ?>
                        <i class="text-muted">No results found for "<?php echo htmlspecialchars($_GET['search']); ?>"</i>
                    <?php elseif ($totalSearchResults === 1): ?>
                        <i class="text-muted">1 result found for "<?php echo htmlspecialchars($_GET['search']); ?>"</i>
                    <?php else: ?>
                        <i class="text-muted"><?php echo $totalSearchResults; ?> results found for "<?php echo htmlspecialchars($_GET['search']); ?>"</i>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- loop to display studies -->
            <?php foreach ($studies as $study): ?>
                <ul style="list-style-type: none;" class="p-3 rounded ulInside mb-4">
                    <!-- Title -->
                    <li class="list-group-item-title d-flex">
                        <h4>
                            <?php $title = $study['title'];
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
                    <!-- <hr>
                    <li class="text-muted">
                        &nbsp;
                        <span class="float-end" style="font-weight: bold; color: blue;">Uploaded by: <?= $study['contributor_fname'] . ' ' . $study['contributor_lname'] ?></span>
                    </li> -->
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
                        <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>&id=<?php echo $id; ?>">Previous</a>
                    </li>
                <?php endif; ?>
                <?php
                    $totalPages = ceil($totalStudies / $studiesPerPage);
                    for ($i = 1; $i <= $totalPages; $i++):
                ?>
                    <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&id=<?php echo $id; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>&id=<?php echo $id; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>
