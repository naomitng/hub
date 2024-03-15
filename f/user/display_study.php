<?php

$page_title = "";
include '../includes/header.php';
include '../user/sidebarUser.php';
echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";

//$pdo = new PDO("mysql:host=127.0.0.1; dbname=hub", "root", "");
$pdo = new PDO("mysql:host=sql209.infinityfree.com; dbname=if0_36132900_hub", "if0_36132900", "Hs96nqZI1Gd9ED");

$studies = [];
$totalStudies = 0;
$study = null;
$back_text = "Back to Home";
$back_link = "results.php";

// Fetch the study from the database
if (isset($_GET['id'])) {
    $study_id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM `studies` WHERE id = ?");
        $stmt->execute([$study_id]);
        $study = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($study) {
            $page_title = isset($_GET['title']) ? $_GET['title'] : ""; // Set the page title to the study title
            // Set the title directly within the HTML output
            echo "<title>$page_title</title>";
        }
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
            <a href="<?php echo $back_link; ?>" class="text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                </svg> <?php echo $back_text; ?>
            </a>
            <ul style="list-style-type: none;" class="p-3 rounded ulInside mt-3">
                <?php if ($study): ?>
                <li class="list-group-item-title mb-3"><?php echo $study['title']; ?></li>
                <li>Authors: <?php echo $study['authors']; ?></li>
                <li>Department: <?php echo $study['dept']; ?></li>
                <li>Adviser: <?php echo $study['adviser']; ?></li>
                <li class="">Year: <?php echo $study['year']; ?></li>
                <hr>
                <li class="mb-4" style="font-size: 20px;">Abstract</li>
                <li><?php echo $study['abstract']; ?></li>
                <?php else: ?>
                <li>No study found</li>
                <?php endif; ?>
            </ul>
        </li>
    </ul>        
</div>

