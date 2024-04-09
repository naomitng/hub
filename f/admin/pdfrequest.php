<?php 

session_start();
if (!isset($_SESSION['fname'])) {
    // Redirect the user to the sign-in page
    header('Location: ../admin/aSignIn.php');
    exit();
}

$page_title = "PDF Requests";
include '../includes/header.php';
include '../includes/sidebarAdmin.php';
require '../../vendor/autoload.php';
echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

try {
    $stmt = $pdo->prepare("SELECT * FROM `pdf request`");
    $stmt->execute();
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

if(isset($_POST['sendto'])) {
    try {
        $pdfName = $_FILES['file']['name'];
        $pdfPath = $_FILES['file']['tmp_name'];
        $pdfSize = $_FILES['file']['size'];
        $pdfType = $_FILES['file']['type'];

        $requestId = $_POST['request_id'];

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = 'uresearch.hub@gmail.com';
        $mail->Password = 'hhqw syqz eawo rrdb';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->setFrom('uresearch.hub@gmail.com', 'Research Hub');
        $mail->addAddress($_POST['email']);
        $mail->addAttachment($pdfPath, $pdfName);
        $mail->isHTML(true);
        $mail->Subject = 'Requested PDF';
        $mail->Body = "
        
        <p>Hello " . $_POST['name'] . ",</p>

        <p>We have received your request regarding the copy of ". $_POST['title'] .". To grant your request, the PDF of your requested study is attatched in this email. </p>
        
        ";

        $mail->send();

        $deleteStmt = $pdo->prepare("DELETE FROM `pdf request` WHERE id = ?");
        $deleteStmt->execute([$requestId]);

        echo '<script>alert("Email sent successfully");</script>';
        echo "<script>window.location.reload();</script>";
    } catch (Exception $e) {
        echo '<script>alert("Email could not be sent. Error: ' . $mail->ErrorInfo . '");</script>';
    }
}

?>

<div id="content">
    <!-- Search bar -->
    <form class="search" method="get">
        <input type="text" class="form-control" placeholder="Search" name="search">
        <button class="btn btn-warning" type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </button>
    </form>
    <ul class="list-group mt-5">
        <li class="list-group-item p-4">
            <h3 class="text-muted">PDF Requests</h3>
            <div class="d-flex justify-content-between align-items-center">
                <!-- Previous/back link -->
                <a href="../admin/aDashboard.php" class="text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg> Back to dashboard
                </a>
            </div>
            <?php foreach ($requests as $request): ?>
                <ul style="list-style-type: none;" class="p-3 rounded ulInside mt-3">
                    <li><span style="font-weight: bold;">Name of requestor: </span><?php echo $request['name'];?></li>
                    <li><span style="font-weight: bold;">Email address: </span><?php echo $request['email'];?></li>
                    <hr>
                    <li><span style="font-weight: bold;">Requested PDF:</span> <?php echo  $request['title']; ?></li>
                    <button type="button" class="btn btn-warning mt-2" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $request['id']; ?>">
                        Send PDF
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal<?php echo $request['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Send PDF</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="post" enctype="multipart/form-data"> 
                                <div class="modal-body">
                                    <p>Send <u><?php echo $request['email'];?></u> a copy of <span style="font-weight: bold; color: blue;"><?php echo $request['title'];?></span></p>
                                    <input class="form-control" name="file" type="file" id="formFile" accept=".pdf">
                                    <input type="hidden" name="email" value="<?php echo $request['email']; ?>"> 
                                    <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>"> 
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="sendto" class="btn btn-warning">Send</button> 
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </ul>
            <?php endforeach; ?>
        </li>
    </ul>
</div>
