<?php
session_start();
if (!isset($_SESSION['supadmin'])) {
    // Redirect the user to the sign-in page
    header('Location: ../admin/aSignIn.php');
    exit();
}

$page_title = "Archive";
include '../includes/header.php';
include '../includes/sidebarSupadmin.php';
echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";

$pdo = new PDO("mysql:host=127.0.0.1; dbname=hub", "root", "");

// Pagination variables
$studiesPerPage = 10;
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($currentPage - 1) * $studiesPerPage;

// Fetch studies
try {
    if(isset($_GET['search'])) {
        $search = '%' . $_GET['search'] . '%';
        $stmt = $pdo->prepare("SELECT * FROM `archive` WHERE title LIKE :search LIMIT :offset, :limit");
        $stmt->bindParam(':search', $search, PDO::PARAM_STR);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $studiesPerPage, PDO::PARAM_INT);

        // Fetch total number of studies for search results
        $totalStmt = $pdo->prepare("SELECT COUNT(*) AS total FROM `archive` WHERE title LIKE :search");
        $totalStmt->bindValue(':search', $search, PDO::PARAM_STR);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM `archive` LIMIT :offset, :limit");
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $studiesPerPage, PDO::PARAM_INT);

        // Fetch total number of all studies
        $totalStmt = $pdo->prepare("SELECT COUNT(*) AS total FROM `archive`");
    }
    
    $stmt->execute(); // Execute the prepared statement
    $studies = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows

    // Execute totalStmt to get total number of studies
    $totalStmt->execute();
    $totalStudies = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!-- Content Area -->
<div id="content">

    <!-- Search bar -->
    <form class="search" method="get">
        <i class="fa fa-search"></i>
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
            <div class="mb-2">
                <?php if(isset($_GET['search'])): ?>
                    <i class="text-muted"><?php echo $totalStudies;?> results found for "<?php echo $_GET['search']; ?>"</i>
                <?php else: ?>
                    <i class="text-muted"><?php echo $totalStudies;?> studies in archive</i>
                <?php endif; ?>
            </div>
            <a href="<?php echo isset($_GET['search']) ? 'archive.php' : 'aDashboard.php'; ?>" class="text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                </svg> 
                <?php echo isset($_GET['search']) ? "Back to Archive" : "Back to Dashboard"; ?>
            </a>

            <?php foreach ($studies as $study): ?>
                <ul style="list-style-type: none;" class="p-3 rounded ulInside mb-4 mt-3">

                    <!-- Title -->
                    <li class="list-group-item-title d-flex">
                    <a href="display_arch.php?id=<?php echo $study['id']; ?>">
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
                        } ?>
                    </a>
                        <!-- Button group for edit and delete -->
                        <div class="ml-auto">
                            <!-- Delete btn -->
                            <button type="submit" class="btn btn-link text-secondary" name="delete" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal_<?php echo $study['id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>                            
                            </button>
                        </div>
                    </li>

                    <!-- For delete -->
                    <form action="" method="post">
                        <input type="hidden" name="study_id" value="<?php echo $study['id']; ?>" >
                        <!-- Modal for delete confirmation -->
                        <div class="modal fade" id="deleteModal_<?php echo $study['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel_<?php echo $study['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel_<?php echo $study['id']; ?>">Confirm deletion</h5>
                                    </div>
                                    <div class="modal-body" style="font-size: 17px;">
                                        Are you sure you want to delete <span style="color: blue; font-weight: bold;"> <?php echo $study['title']; ?> </span> from the list?
                                    </div>
                                    <div class="modal-footer mr-auto">
                                        <div class="row">
                                            <div class="col">
                                                <button type="button" class="btn btn-danger btn-block" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                            <div class="col">
                                                <button type="submit" class="btn btn-secondary btn-block" name="delete">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Information about the study -->
                    <li><?php echo substr($study['abstract'], 0, 300) . "..."; ?></li>
                    <li class="text-muted">Authors: <?php echo $study['authors']; ?></li>
                    <li class="text-muted">Department: <?php echo $study['dept']; ?></li>
                    <li class="text-muted">Adviser: <?php echo $study['adviser']; ?></li>
                    <li class="text-muted">Published <?php echo $study['year']; ?></li>
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

</div>
