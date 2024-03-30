<?php
    session_start();

    $page_title = "Dashboard";
    include '../includes/header.php';
    include 'sidebarUser.php';
    echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";

    //$pdo = new PDO("mysql:host=127.0.0.1; dbname=hub", "root", "");
    // display advisers
    try {
        $stmt = $pdo->prepare("SELECT * FROM studies");
        $stmt->execute(); // Execute the prepared statement
        $studies = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    // delete 
    if(isset($_POST['delete'])) {
        $study_id = $_POST['study_id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM studies WHERE id = :id");
            $stmt->bindParam(':id', $study_id);
            $stmt->execute();
            echo '<script>window.location.href = "results.php";</script>';
            exit();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Pagination variables
    $studiesPerPage = 10;
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($currentPage - 1) * $studiesPerPage;

    try {
        if(isset($_GET['search'])) {
            // Search query
            $keywords = explode(" ", $_GET['search']);
            $searchTerms = [];
            $bindings = [];
        
            // Construct the search query for each keyword
            foreach ($keywords as $index => $keyword) {
                $searchTerms[] = "(CONCAT(title, ' ', abstract, ' ', keywords) LIKE :search{$index})";
                $bindings[":search{$index}"] = '%' . $keyword . '%';
            }
        
            $searchQuery = implode(" AND ", $searchTerms);
        
            // Construct the final SQL query with keyword filter and verification check
            $stmt = $pdo->prepare("SELECT * FROM studies WHERE {$searchQuery} AND verified = 1 LIMIT :offset, :limit");
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $studiesPerPage, PDO::PARAM_INT);
        
            // Bind parameters for each search term
            foreach ($bindings as $key => $value) {
                $stmt->bindParam($key, $value, PDO::PARAM_STR);
            }
        
            // Fetch total number of studies for search results
            $totalStmt = $pdo->prepare("SELECT COUNT(*) AS total FROM studies WHERE {$searchQuery} AND verified = 1");
        
            // Bind parameters for totalStmt
            foreach ($bindings as $key => $value) {
                $totalStmt->bindParam($key, $value, PDO::PARAM_STR);
            }
        } elseif(isset($_GET['collection'])) {
            // Collection query
            $keyword = $_GET['collection'];
            $stmt = $pdo->prepare("SELECT * FROM studies WHERE keywords LIKE :keyword AND verified = 1 LIMIT :offset, :limit");
            $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $studiesPerPage, PDO::PARAM_INT);
        
            // Fetch total number of studies for collection results
            $totalStmt = $pdo->prepare("SELECT COUNT(*) AS total FROM studies WHERE keywords LIKE :keyword AND verified = 1");
            $totalStmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        } else {
            // If no search or collection query is provided, fetch all studies where verified = 1
            $stmt = $pdo->prepare("SELECT * FROM studies WHERE verified = 1 LIMIT :offset, :limit");
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $studiesPerPage, PDO::PARAM_INT);
        
            // Fetch total number of all studies where verified = 1
            $totalStmt = $pdo->prepare("SELECT COUNT(*) AS total FROM studies WHERE verified = 1");
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

            <!-- number of search results -->
            <?php if (isset($_GET['search'])): ?>
                <div class="mb-4">
                    <i class="text-muted"><?php echo $totalSearchResults; ?> results found for "<?php echo htmlspecialchars($_GET['search']); ?>"</i>
                </div>
            <?php elseif(isset($_GET['collection'])): ?>
                <div class="mb-4">
                    <i class="text-muted"><?php echo $totalSearchResults; ?> results found for collection "<?php echo htmlspecialchars($_GET['collection']); ?>"</i>
                </div>
            <?php endif; ?>

            <!-- loop to display studies -->
            <?php foreach ($studies as $study): ?>
                <ul style="list-style-type: none;" class="p-3 rounded ulInside mb-4">
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


<!-- Pagination for search results -->
<?php if ($totalStudies > $studiesPerPage && !isset($_GET['collection'])): ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php if ($currentPage > 1): ?>
                <?php
                    $prevPageUrl = isset($_GET['search']) ? "?page=" . ($currentPage - 1) . "&search=" . urlencode($_GET['search']) : "?page=" . ($currentPage - 1);
                ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo $prevPageUrl; ?>">Previous</a>
                </li>
            <?php endif; ?>
            <?php
                $totalPages = ceil($totalStudies / $studiesPerPage);
                for ($i = 1; $i <= $totalPages; $i++):
                    $pageUrl = isset($_GET['search']) ? "?page=$i&search=" . urlencode($_GET['search']) : "?page=$i";
            ?>
                <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                    <a class="page-link" href="<?php echo $pageUrl; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($currentPage < $totalPages): ?>
                <?php
                    $nextPageUrl = isset($_GET['search']) ? "?page=" . ($currentPage + 1) . "&search=" . urlencode($_GET['search']) : "?page=" . ($currentPage + 1);
                ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo $nextPageUrl; ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>

<!-- Pagination for collection results -->
<?php if ($totalStudies > $studiesPerPage && isset($_GET['collection'])): ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php if ($currentPage > 1): ?>
                <?php
                    $prevPageUrl = isset($_GET['collection']) ? "?collection_page=" . ($currentPage - 1) . "&collection=" . urlencode($_GET['collection']) : "?collection_page=" . ($currentPage - 1);
                ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo $prevPageUrl; ?>">Previous</a>
                </li>
            <?php endif; ?>
            <?php
                $totalPages = ceil($totalStudies / $studiesPerPage);
                for ($i = 1; $i <= $totalPages; $i++):
                    $pageUrl = isset($_GET['collection']) ? "?collection_page=$i&collection=" . urlencode($_GET['collection']) : "?collection_page=$i";
            ?>
                <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                    <a class="page-link" href="<?php echo $pageUrl; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($currentPage < $totalPages): ?>
                <?php
                    $nextPageUrl = isset($_GET['collection']) ? "?collection_page=" . ($currentPage + 1) . "&collection=" . urlencode($_GET['collection']) : "?collection_page=" . ($currentPage + 1);
                ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo $nextPageUrl; ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>

</div>
