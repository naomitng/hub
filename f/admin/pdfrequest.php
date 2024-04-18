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
    $totalRequestsStmt = $pdo->query("SELECT COUNT(*) FROM `pdf request`");
    $totalRequests = $totalRequestsStmt->fetchColumn();

    $requestsPerPage = 10;
    $totalPages = ceil($totalRequests / $requestsPerPage);

    $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset = ($currentPage - 1) * $requestsPerPage;

    $stmt = $pdo->prepare("SELECT * FROM `pdf request` LIMIT $offset, $requestsPerPage");
    $stmt->execute();
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert(\"Error: " . $e->getMessage() . "\");</script>";
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
        
        <p>Hello " . $_POST['name'] . ", </p>

        <p>We appreciate your interest in our research. We are pleased to provide a copy of ". $_POST['title'] ."  per your request. For your convenience, the PDF is attached to this email.</p>

        <p>Please <strong>BE AWARE<strong> of the following in order to ensure appropriate use of this study:</p>

        <p>Copyright: Research Hub owns the copyright to this document. It can only be used for academic or personal study.</p>

        <p>Citation: In your own work, if you use a quote from or mention the study.</p>

        <p>Distribution: Without our previous written agreement, please do not disseminate this PDF to any third parties.</p>

        <p style='font-style: italic; color: #888;'>Best regards,</p>
        <p style='font-style: italic; color: #888;'>Research Hub Team</p>


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
    <!-- Pagination -->
    <?php if ($totalPages > 1) : ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center mt-4">
                <?php if ($currentPage > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>&search=<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">Previous</a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($currentPage < $totalPages) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>&search=<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>
