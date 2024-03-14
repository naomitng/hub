<?php
$page_title = "Home";
include '../includes/header.php';
include '../user/sidebarUser.php';

echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";

$pdo = new PDO("mysql:host=127.0.0.1; dbname=hub", "root", "");

// Pagination variables
$studiesPerPage = 10;
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($currentPage - 1) * $studiesPerPage;

// Initialize $studies and $totalStudies
$studies = [];
$totalStudies = 0;

// display advisers
try {
    // Check if a search query is submitted
    if(isset($_GET['search']) && !empty($_GET['search'])) {
        $searchQuery = '%' . $_GET['search'] . '%';
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM `studies` WHERE `title` LIKE :search OR `abstract` LIKE :search OR `keywords` LIKE :keywords");
        $stmt->bindValue(':search', $searchQuery, PDO::PARAM_STR);
        $stmt->bindValue(':keywords', $searchQuery, PDO::PARAM_STR);
        $stmt->execute();
        $totalStudies = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Retrieve studies for the current page
        $stmt = $pdo->prepare("SELECT * FROM `studies` WHERE `title` LIKE :search OR `abstract` LIKE :search OR `keywords` LIKE :keywords LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':search', $searchQuery, PDO::PARAM_STR);
        $stmt->bindValue(':keywords', $searchQuery, PDO::PARAM_STR);
    } else {
        // If no search query is submitted, retrieve all studies
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM `studies`");
        $stmt->execute();
        $totalStudies = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $stmt = $pdo->prepare("SELECT * FROM `studies` LIMIT :limit OFFSET :offset");
    }

    // Bind pagination parameters
    $stmt->bindValue(':limit', $studiesPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute(); // Execute the prepared statement
    $studies = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch only the subset of studies
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<!-- Content Area -->
<div id="content">
    <!-- Form for search -->
    <form action="" method="get" class="search landing-s result-s">
        <input type="text" class="form-control" name="search" placeholder="Search" autocomplete="off">
        <!-- Search Button -->
        <button type="submit" class="btn btn-warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </button>
    </form>
    <!-- List of studies -->
    <ul class="list-group mt-5 mb-5">
        <li class="list-group-item p-4">
            <?php foreach ($studies as $study): ?>
                <ul style="list-style-type: none;" class="p-3 rounded ulInside">
                    <!-- Title -->
                    <li class="list-group-item-title d-flex">
                        <a href="../user/display_study.php?id=<?php echo $study['id']; ?>">
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
                        <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>&search=<?php echo urlencode($_GET['search']); ?>">Previous</a>
                    </li>
                <?php endif; ?>
                <?php
                    $totalPages = ceil($totalStudies / $studiesPerPage);
                    for ($i = 1; $i <= $totalPages; $i++):
                ?>
                    <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($_GET['search']); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>&search=<?php echo urlencode($_GET['search']); ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>
