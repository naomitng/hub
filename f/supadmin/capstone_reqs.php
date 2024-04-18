<?php 
session_start();
if (!isset($_SESSION['supadmin'])) {
    // Redirect the user to the sign-in page
    header('Location: ../admin/aSignIn.php');
    exit();
}

$page_title = "Capstone Request Approval";
include '../includes/header.php';
include '../includes/sidebarSupadmin.php';
echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";

try {
    // Pagination variables
    $studiesPerPage = 10;
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($currentPage - 1) * $studiesPerPage;

    // Retrieve capstone requests with pagination
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM studies WHERE verified = 0");
    $stmt->execute();
    $totalStudies = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM studies WHERE verified = 0 LIMIT :offset, :limit");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $studiesPerPage, PDO::PARAM_INT);
    $stmt->execute();
    $studies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('" . $e->getMessage() . "')</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['approve']) && isset($_POST['study_id'])) {
        $study_id = $_POST['study_id'];
        try {
            $stmt = $pdo->prepare("UPDATE studies SET verified = 1 WHERE id = :id");
            $stmt->bindParam(':id', $study_id);
            $stmt->execute();

            echo '<script>window.location.href = "../supadmin/capstone_reqs.php";</script>';
            exit();

        } catch (PDOException $e) {
            echo "<script>alert('" . $e->getMessage() . "')</script>";
        }
    }
}
?>

<!-- Content Area -->
<div id="content">
    <!-- Search bar -->
    <form class="search" action="" method="GET">
        <i class="fa fa-search"></i>
        <input type="text" class="form-control" name="search" placeholder="Search for a study" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit" class="btn btn-warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </button>
    </form>
    <!-- List of studies -->
    <ul class="list-group mt-5">
        <li class="list-group-item p-4">
            <h3>Capstone Request Approval</h3>
            <a href="aDashboard.php" class="text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                </svg> 
                Back to Dashboard
            </a>
            <?php foreach ($studies as $study): ?>
                <ul style="list-style-type: none; " class="p-3 rounded ulInside mt-3">
                    <li class="list-group-item-title d-flex">
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
                        <div class="ml-auto">
                            <!-- Accept -->
                            <button title="Accept" type="button" name="accept" class="btn btn-link text-secondary" data-bs-toggle="modal" data-bs-target="#check_<?php echo $study['id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                                </svg>
                            </button>
                            <!-- Decline -->
                            <button title="Decline" type="button" name="decline" class="btn btn-link text-secondary" data-bs-toggle="modal" data-bs-target="#decline_<?php echo $study['id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                </svg>
                            </button>
                        </div>
                    </li>
                    <div class="text-muted">
                        <li>Authors: <?php echo $study['authors']; ?></li>
                        <li>Department: <?php echo $study['dept']; ?></li>
                        <li>Year: <?php echo $study['year']; ?></li>
                        <hr>
                        <li>Request by: Naomi Ting</li>
                        <li>Department of Information Technology</li>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="study_id" value="<?php echo $study['id']; ?>" >
                        <input type="hidden" name="study_title" value="<?php echo $study['title']; ?>"> 
                        <input type="hidden" name="study_auth" value="<?php echo $study['authors']; ?>">
                        <input type="hidden" name="study_year" value="<?php echo $study['year']; ?>">

                        <!-- Modal for approval confirmation -->    
                        <div class="modal fade" id="check_<?php echo $study['id']; ?>" tabindex="-1" aria-labelledby="appId=<?php echo $study['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="appId=<?php echo $study['id']; ?>">Approve Capstone Request</h5>
                                    </div>
                                    <div class="modal-body" style="font-size: 17px;"> <!-- Set the font size here -->
                                        Are you sure you want to approve <span style="color: blue; font-weight: bold;"> <?php echo $study['title'];?> </span> study request?
                                    </div>
                                    <div class="modal-footer mr-auto">
                                        <div class="row">
                                            <div class="col">
                                                <button type="button" class="btn btn-danger btn-block" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                            <div class="col">
                                                <button type="submit" class="btn btn-success btn-block" name="approve">Yes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Decline Modal -->
                        <div class="modal fade" id="decline_<?php echo $study['id']; ?>" tabindex="-1" aria-labelledby="decId=<?php echo $study['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="decId=<?php echo $study['id']; ?>">Decline Capstone Request</h5>
                                    </div>
                                    <div class="modal-body" style="font-size: 17px;">
                                        Are you sure you want to decline <span style="color: blue; font-weight: bold;"> <?php echo $study['title'];?> </span> study request?
                                    </div>
                                    <div class="modal-footer mr-auto">
                                        <div class="row">
                                            <div class="col">
                                                <button type="button" class="btn btn-danger btn-block" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                            <div class="col">
                                                <button type="submit" class="btn btn-success btn-block" name="decline">Yes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </ul>
            <?php endforeach; ?>
        </li>
    </ul>

    <!-- Pagination -->
    <?php if ($totalStudies > $studiesPerPage): ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center mt-4">
                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>&search=<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">Previous</a>
                    </li>
                <?php endif; ?>
                <?php
                    $totalPages = ceil($totalStudies / $studiesPerPage);
                    for ($i = 1; $i <= $totalPages; $i++):
                ?>
                    <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>&search=<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>
 