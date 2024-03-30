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
    $stmt = $pdo->prepare("SELECT * FROM studies WHERE verified = 0");
    $stmt->execute();
    $studies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
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
            echo $e->getMessage();
        }
    }
}

?>

<!-- Content Area -->
<div id="content">
    <!-- List of studies -->
    <ul class="list-group">
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                    <path d="M13.146 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L6 10.293l6.146-6.147a.5.5 0 0 1 .708 0z"/>
                                </svg>
                            </button>
                            <!-- Decline -->
                            <button title="Decline" type="button" name="decline" class="btn btn-link text-secondary" data-bs-toggle="modal" data-bs-target="#decline_<?php echo $admins['id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M3.146 3.146a.5.5 0 0 1 .708 0L8 7.293l4.146-4.147a.5.5 0 0 1 .708.708L8.707 8l4.147 4.146a.5.5 0 1 1-.708.708L8 8.707l-4.146 4.147a.5.5 0 0 1-.708-.708L7.293 8 3.146 3.854a.5.5 0 0 1 0-.708z"/>
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
</div>
