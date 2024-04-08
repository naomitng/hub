<?php
session_start();

$page_title = "Dashboard";
include '../includes/header.php';
include 'sidebarUser.php';
echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";

// Fetch the study in table studies
$study = null;
if (isset($_GET['id'])) {
    $study_id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("SELECT s.*, a.name as adviser_name FROM `studies` s JOIN `advisers` a ON s.adviser = a.id WHERE s.id = ?");
        $stmt->execute([$study_id]);
        $study = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single row
        // Set the page title to the study title if a study is found
        if ($study) {
            $page_title = $study['title'];

            // popularity
            $increment_stmt = $pdo->prepare("UPDATE `studies` SET `popularity` = `popularity` + 1 WHERE id = ?");
            $increment_stmt->execute([$study_id]);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

if(isset($_POST['sendto'])) {
    try {
        $title = $_POST['title'];
        $email = $_POST['email'];
        $name = $_POST['name'];

        $stmt = $pdo->prepare("INSERT INTO `pdf request`(`title`, `name`, `email`) VALUES (:title, :name, :email)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Redirect after successful submission
        echo '<script>window.location.href = "display_dash.php";</script>';
        exit();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>


<!-- Content Area -->
<div id="content">

    <!-- List of studies -->
    <ul class="list-group mb-5">
        <li class="list-group-item p-4">
            <a href="<?php echo $referrer; ?>" class="text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                </svg> Back
            </a>
            <ul style="list-style-type: none;" class="p-3 rounded ulInside mt-3">
                <?php if ($study): ?>
                <!-- Display study details -->
                <li class="list-group-item-title mb-3"><?php echo $study['title']; ?></li>
                <li>Authors: <?php echo $study['authors']; ?></li>
                <li>Department: <?php echo $study['dept']; ?></li>
                <li>Adviser: <?php echo $study['adviser_name']; ?></li>
                <li class="">Year: <?php echo $study['year']; ?></li>
                <button type="button" class="btn btn-warning mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Request access to this PDF
                </button>
                <!-- Request access modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Send a request</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="post" action="">
                                <div class="modal-body">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="title" class="form-control" id="title" placeholder="Title" value="<?php echo $study['title']; ?>">
                                        <label for="title">Title</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
                                        <label for="email">Email</label>
                                        <p style="font-size: 14px;" class="text-muted">Enter your institutional email so we can contact you</p>
                                    </div>
                                    <div class="form-floating">
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Your Name">
                                        <label for="name">Name</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="sendto" class="btn btn-warning">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <hr>
                <li class="mb-4" style="font-size: 20px;">Abstract</li>
                <li><?php echo $study['abstract']; ?></li>
                <?php else: ?>
                <!-- If no study found -->
                <li>No study found</li>
                <?php endif; ?>
            </ul>
        </li>
    </ul>        

</div>
