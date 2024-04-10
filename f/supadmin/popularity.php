<?php
    session_start();
    if (!isset($_SESSION['supadmin'])) {
        // Redirect the user to the sign-in page
        header('Location: ../admin/aSignIn.php');
        exit();
    }

    $page_title = "Popularity";
    include '../includes/header.php';
    include '../includes/sidebarSupadmin.php';
    echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";

    $pdo = new PDO("mysql:host=127.0.0.1; dbname=hub", "root", "");

    try {
        $stmt = $pdo->prepare("SELECT * FROM `studies` WHERE `verified` = 1 ORDER BY `popularity` DESC");
        $stmt->execute(); // Execute the prepared statement
        $studies = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 
    // Pagination variables
    $studiesPerPage = 10;
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($currentPage - 1) * $studiesPerPage;

    try {
        if(isset($_GET['search'])) {
            $keywords = explode(" ", $_GET['search']);
            $searchTerms = [];
            $bindings = [];

            // Construct the search query for each keyword
            foreach ($keywords as $index => $keyword) {
                $searchTerms[] = "(CONCAT(title, ' ', abstract, ' ', keywords) LIKE :search{$index})";
                $bindings[":search{$index}"] = '%' . $keyword . '%';
            }

            $searchQuery = implode(" AND ", $searchTerms);

            // Construct the final SQL query
            $stmt = $pdo->prepare("SELECT * FROM `studies` WHERE {$searchQuery} AND `verified` = 1 LIMIT :offset, :limit");
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $studiesPerPage, PDO::PARAM_INT);

            // Bind parameters for each search term
            foreach ($bindings as $key => $value) {
                $stmt->bindParam($key, $value, PDO::PARAM_STR);
            }

            // Fetch total number of studies for search results
            $totalStmt = $pdo->prepare("SELECT COUNT(*) AS total FROM `studies` WHERE {$searchQuery} AND `verified` = 1 ORDER BY `popularity` DESC");

            // Bind parameters for totalStmt
            foreach ($bindings as $key => $value) {
                $totalStmt->bindParam($key, $value, PDO::PARAM_STR);
            }
        } else {
            // If no search query is provided, fetch all studies
            $stmt = $pdo->prepare("SELECT * FROM `studies` WHERE `verified` = 1 LIMIT :offset, :limit");
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $studiesPerPage, PDO::PARAM_INT);

            // Fetch total number of all studies
            $totalStmt = $pdo->prepare("SELECT COUNT(*) AS total FROM `studies` WHERE `verified` = 1 ORDER BY `popularity` DESC");
        }
    } catch (PDOException $e) {
        // Handle database errors here
        echo "Error: " . $e->getMessage();
    }

    try {
        // Execute the prepared statement
        $stmt->execute();
        $studies = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows

        // Execute totalStmt to get total number of search results
        $totalStmt->execute();
        $totalSearchResults = $totalStmt->fetchColumn();

        // Count total number of studies for pagination
        $totalStudies = $totalSearchResults; // Total studies equals total search results

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>

<!-- Content Area -->
<div id="content">

    <!-- Search bar -->
    <form class="search" action="" method="GET">
        <input type="text" class="form-control" name="search" placeholder="Search for a study" autocomplete="off" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit" class="btn btn-warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </button>
    </form>

    <!-- List of studies -->
    <ul class="list-group mt-5 mb-5">   
        <li class="list-group-item p-4">
            <h3>Popular studies</h3>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Previous/back link -->
                <a href="aDashboard.php" class="text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg> Back to dashboard
                </a>
    
            </div>
            <!-- number of search results -->
            <?php if (isset($_GET['search'])): ?>
                <div class="mb-4">
                    <i class="text-muted"><?php echo $totalSearchResults; ?> results found for "<?php echo htmlspecialchars($_GET['search']); ?>"</i>
                </div>
            <?php endif; ?>

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
                    <hr>
                    <li class="text-muted">
                        <span style="font-weight: bold; color: blue;">Popularity: <?=$study['popularity']?></span>
                    </li>
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
                        <a class="page-link" href="?page=<?php echo $currentPage - 1 . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''); ?>">Previous</a>
                    </li>
                <?php endif; ?>
                <?php
                    $totalPages = ceil($totalStudies / $studiesPerPage);
                    for ($i = 1; $i <= $totalPages; $i++):
                ?>
                    <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $currentPage + 1 . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''); ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>