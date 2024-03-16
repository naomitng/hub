<?php
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
// Fetch the study in table studies
$study = null;
if (isset($_GET['id'])) {
    $study_id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM `studies` WHERE id = ?");
        $stmt->execute([$study_id]);
        $study = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single row
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// Determine the back link and text based on the referring page
// $back_link = '';
// $back_text = '';
$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
// if (strpos($referrer, 'infotech.php') !== false) {
//     $back_link = 'infotech.php';
//     $back_text = 'Back to Information Technology List';
// } elseif (strpos($referrer, 'comEng.php') !== false) {
//     $back_link = 'comEng.php';
//     $back_text = 'Back to Computer Engineering List';
// } elseif (preg_match('/filter\.php\?year=(20\d{2})/', $referrer, $matches)) {
//     // Extract the year from the referring page URL
//     $year = $matches[1];
//     $back_link = "filter.php?year=$year";
//     $back_text = "Back to $year List";
// } else {
//     // Default back link and text
//     $year = date('Y'); // Set the default year to the current year
//     $back_link = "filter.php?year=$year";
//     $back_text = "Back to $year list";
// }
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
                <li>Adviser: <?php echo $study['adviser']; ?></li>
                <li>Year: <?php echo $study['year']; ?></li> <br>

                <!-- PDF Button -->
                <?php if(isset($study['filename']) && !empty($study['filename'])): ?>
                    <li><a target="_blank" href="<?php echo $study['filename']?>" class="btn btn-warning">Click to see PDF</a></li>
                <?php else: ?>
                    <li><span style="color: red">PDF file not available</span></li>
                <?php endif; ?>

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
