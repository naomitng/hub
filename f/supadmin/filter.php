<?php
    // Initialize $totalSearchResults
    $totalSearchResults = 0;
    $filteredStudies = array();

    session_start();
    if (!isset($_SESSION['supadmin'])) {
        // Redirect the user to the sign-in page
        header('Location: ../admin/aSignIn.php');
        exit();
    }

    $page_title = "Dashboard";
    include '../includes/header.php';
    include '../includes/sidebarSupadmin.php';
    echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";

    $pdo = new PDO("mysql:host=sql209.infinityfree.com; dbname=if0_36132900_hub", "if0_36132900", "Hs96nqZI1Gd9ED");
    //$pdo = new PDO("mysql:host=127.0.0.1; dbname=hub", "root", "");

    // Get the year from the url
    $year = isset($_GET['year']) ? intval($_GET['year']) : null;

    // Check if search param is set otherwise null
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : null;

    // Pagination variables
    $studiesPerPage = 10; // Change this as needed
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($currentPage - 1) * $studiesPerPage;

    // Fetch studies with pagination
    $stmt = $pdo->prepare("SELECT * FROM `studies`" . ($year ? " WHERE year = :year" : "") . " LIMIT :limit OFFSET :offset");
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
        $totalStudies = $pdo->query("SELECT COUNT(*) FROM `studies`" . ($year ? " WHERE year = $year" : ""))->fetchColumn();
    }


    // delete 
    if(isset($_POST['delete'])) {
        $study_id = $_POST['study_id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM `studies` WHERE id = :id");
            $stmt->bindParam(':id', $study_id);
            $stmt->execute();
            echo '<script>window.location.href = "../supadmin/filter.php?='.$year.'";</script>';
            exit();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // ARCHIVE 
    if(isset($_POST['archive'])) {
        $study_id = $_POST['study_id'];
        try {
            // Get study details from 'studies' table
            $stmt_select = $pdo->prepare("SELECT * FROM `studies` WHERE id = :study_id");
            $stmt_select->bindParam(':study_id', $study_id);
            $stmt_select->execute();
            $study = $stmt_select->fetch(PDO::FETCH_ASSOC);
            
            // Insert the study into the 'archive' table
            $stmt_insert_archive = $pdo->prepare("INSERT INTO `archive`(`title`, `authors`, `abstract`, `year`, `adviser`, `dept`, `filename`, `keywords`) VALUES (:title, :authors, :abstract, :year, :adviser, :dept, :filename, :keywords)");
            $stmt_insert_archive->bindParam(':title', $study['title']);
            $stmt_insert_archive->bindParam(':authors', $study['authors']);
            $stmt_insert_archive->bindParam(':abstract', $study['abstract']);
            $stmt_insert_archive->bindParam(':year', $study['year']);
            $stmt_insert_archive->bindParam(':adviser', $study['adviser']);
            $stmt_insert_archive->bindParam(':dept', $study['dept']);
            $stmt_insert_archive->bindParam(':filename', $study['filename']);
            $stmt_insert_archive->bindParam(':keywords', $study['keywords']);
            $stmt_insert_archive->execute();
            
            // Delete the study from the 'studies' table
            $stmt_delete = $pdo->prepare("DELETE FROM `studies` WHERE id = :study_id");
            $stmt_delete->bindParam(':study_id', $study_id);
            $stmt_delete->execute();
            
            // Redirect back to the filter
            echo '<script>window.location.href = "../supadmin/filter.php?'.$year.'";</script>';
            exit();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
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

    // EDIT
    if(isset($_POST['saveChanges'])) {
        $study_id = $_POST['study_id'];
        $title = $_POST['title'];
        $authors = $_POST['authors'];
        $abstract = $_POST['abstract'];
        $year = $_POST['year'];
        $adviser = $_POST['adviser'];
        $dept = $_POST['dept']; 

        try {
            $stmt = $pdo->prepare("UPDATE `studies` SET `title`=:title, `authors`=:authors, `abstract`=:abstract, `year`=:year, `adviser`=:adviser, `dept`=:dept WHERE id = :study_id");
            $stmt->bindParam(':study_id', $study_id);
            $stmt->bindParam(':title', $title); 
            $stmt->bindParam(':authors', $authors); 
            $stmt->bindParam(':abstract', $abstract); 
            $stmt->bindParam(':year', $year); 
            $stmt->bindParam(':adviser', $adviser); 
            $stmt->bindParam(':dept', $dept); 
            $stmt->execute();
            echo '<script>window.location.href = "../supadmin/filter.php?year='.$year.'";</script>';
            exit();
        } catch (PDOException $e) {
            echo $e->getMessage(); 
        }
    }
    
?>

<!-- Content Area -->
<div id="content">

    <!-- Search bar -->
    <form class="search" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
        <input type="hidden" name="year" value="<?php echo isset($_GET['year']) ? $_GET['year'] : ''; ?>">
        <i class="fa fa-search"></i>
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
            <!-- number of search results -->
            <?php if (isset($_GET['search'])): ?>
                <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                    <i class="text-muted"><?php echo $totalSearchResults; ?> results found for "<?php echo htmlspecialchars($_GET['search']); ?>"</i>
                <?php endif; ?>
            <?php endif; ?>
            <!-- Back link to dashboard -->
            <a href="../supadmin/aDashboard.php" class="text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                </svg> Back to dashboard
            </a>
            <?php foreach ($studies as $study): ?>
                <!-- loop to display studies -->
                <ul style="list-style-type: none;" class="p-3 rounded ulInside mb-4 mt-3">
                    <!-- Title -->
                    <li class="list-group-item-title d-flex">
                        <a href="../supadmin/display_dash.php?id=<?php echo $study['id']; ?>">
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

                        <!-- Button group for edit and delete -->
                        <div class="ml-auto">
                            <!-- Edit btn -->
                            <button type="button" class="btn btn-link text-secondary" data-bs-toggle="modal" data-bs-target="#editModal_<?php echo $study['id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </button>

                            <!-- Delete btn -->
                            <button type="submit" class="btn btn-link text-secondary" name="delete" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal_<?php echo $study['id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>                            
                            </button>

                            <!-- Archive btn -->
                            <button type="button" class="btn btn-link text-secondary" data-bs-toggle="modal" name="archive" title="Archive" data-bs-target="#archiveModal_<?php echo $study['id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-zip" viewBox="0 0 16 16">
                                <path d="M5 7.5a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v.938l.4 1.599a1 1 0 0 1-.416 1.074l-.93.62a1 1 0 0 1-1.11 0l-.929-.62a1 1 0 0 1-.415-1.074L5 8.438zm2 0H6v.938a1 1 0 0 1-.03.243l-.4 1.598.93.62.929-.62-.4-1.598A1 1 0 0 1 7 8.438z"/>
                                <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1h-2v1h-1v1h1v1h-1v1h1v1H6V5H5V4h1V3H5V2h1V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
                                </svg>                            
                            </button>
                        </div>
                    </li>

                    <!-- For archive -->
                    <form action="" method="post">
                        <input type="hidden" name="study_id" value="<?php echo $study['id']; ?>" >
                        <!-- Modal for archive confirmation -->
                        <div class="modal fade" id="archiveModal_<?php echo $study['id']; ?>" tabindex="-1" aria-labelledby="archiveModalLabel_<?php echo $study['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="archiveModalLabel_<?php echo $study['id']; ?>">Archive study</h5>
                                    </div>
                                    <div class="modal-body" style="font-size: 17px;"> <!-- Set the font size here -->
                                        Are you sure you want to move <span style="color: blue; font-weight: bold;"> <?php echo $study['title']; ?> </span> to archive?
                                    </div>
                                    <div class="modal-footer mr-auto">
                                        <div class="row">
                                            <div class="col">
                                                <button type="button" class="btn btn-danger btn-block" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                            <div class="col">
                                                <button type="submit" class="btn btn-secondary btn-block" name="archive">Archive</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

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
                                    <div class="modal-body" style="font-size: 17px;"> <!-- Set the font size here -->
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
                
                    <!-- Edit -->
                    <form action="" method="post">
                        <!-- Modal for edit confirmation -->
                        <div class="modal fade" id="editModal_<?php echo $study['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel_<?php echo $study['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="" method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel_<?php echo $study['id']; ?>">Edit Study</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 17px;"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="study_id" value="<?php echo $study['id']; ?>">
                                            <div class="mb-3">
                                                <label for="title" class="col-form-label" style="font-size: 17px;">Title</label>
                                                <input type="text" name="title" class="form-control" id="title" value="<?php echo $study['title']; ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="authors" class="col-form-label" style="font-size: 17px;">Authors</label>
                                                <input type="text" name="authors" class="form-control" id="authors" value="<?php echo $study['authors']; ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="abstract" class="col-form-label" style="font-size: 17px;">Abstract</label>
                                                <textarea class="form-control abstract" name="abstract" id="abstract" style="height: 330px;"><?php echo $study['abstract']; ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="dept" class="col-form-label" style="font-size: 17px;">Department:</label>
                                                <select class="form-select" aria-label="Default select example" name="dept" id="dept">
                                                    <option selected>Choose a department</option>
                                                    <option value="Information Technology" <?php if($study['dept'] == 'Information Technology') echo 'selected'; ?>>Information Technology</option>
                                                    <option value="Computer Engineering" <?php if($study['dept'] == 'Computer Engineering') echo 'selected'; ?>>Computer Engineering</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="adviser" class="col-form-label" style="font-size: 17px;">Adviser</label>
                                                <input type="text" name="adviser" class="form-control" id="adviser" value="<?php echo $study['adviser']; ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="year" class="col-form-label" style="font-size: 17px;">Year</label>
                                                <input type="text" name="year" class="form-control" id="year" value="<?php echo $study['year']; ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="keywords" class="col-form-label" style="font-size: 17px;">Keywords</label>
                                                <input type="text" name="keywords" class="form-control" id="keywords" value="<?php echo $study['keywords']; ?>">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="saveChanges" class="btn btn-warning addbtn">Save changes</button>
                                        </div>
                                    </form>
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
                    <hr>
                    <li class="text-muted">Keywords: <?php echo $study['keywords']; ?></li>
                </ul>
            <?php endforeach; ?>
        </li>
    </ul>        
    <?php if ($totalStudies > $studiesPerPage): ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?year=<?php echo $year; ?>&search=<?php echo $searchTerm ?? ''; ?>&page=<?php echo $currentPage - 1; ?>">Previous</a>
                    </li>
                <?php endif; ?>
                <?php
                $totalPages = ceil($totalStudies / $studiesPerPage);
                for ($i = 1; $i <= $totalPages; $i++):
                    ?>
                    <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link" href="?year=<?php echo $year; ?>&search=<?php echo $searchTerm ?? ''; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?year=<?php echo $year; ?>&search=<?php echo $searchTerm ?? ''; ?>&page=<?php echo $currentPage + 1; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>

</div>
