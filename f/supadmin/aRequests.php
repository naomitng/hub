<?php

session_start();

if (!isset($_SESSION['supadmin'])) {
    // Redirect the user to the sign-in page
    header('Location: ../admin/aSignIn.php');
    exit();
}

$page_title = "Account Requests";
include '../includes/header.php';
include '../includes/sidebarSupadmin.php';
require '../../vendor/autoload.php';

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";
echo "<link rel='stylesheet' type='text/css' href='../css/madvisers.css'>";

$pdo = new PDO("mysql:host=127.0.0.1;dbname=hub", 'root', '');

try {
    // Check if a search term is provided
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $stmt = $pdo->prepare("SELECT * FROM `admin` WHERE (fname LIKE :search OR lname LIKE :search) AND approval = 0");
        $stmt->bindValue(':search', "%$search%");
    } else {
        // If no search term provided, fetch all admin where approval is 0
        $stmt = $pdo->prepare("SELECT * FROM `admin` WHERE approval = 0");
    }
    $stmt->execute();
    $admin = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errMsg = "Error fetching admin: " . $e->getMessage();
}

// ----------------------------------------------------------------------------------------------------------

// APPROVE ACC REQUEST
function approve($adname, $ademail) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Username = 'uresearch.hub@gmail.com';
    $mail->Password = 'hhqw syqz eawo rrdb';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->setFrom('uresearch.hub@gmail.com', 'noreply');
    $mail->addAddress($ademail, $adname);
    $mail->isHTML(true);


    $verification_code = md5(uniqid(rand(), true));
    $mail->Subject = 'Account Request Aprroved';
    $mail->Body = "
        <p>Hello $adname!</p>
        
        <p>Welcome to Research Hub. You received this email to inform you that your Research Hub admin account has been approved. You may now sign in your account:</p>

        <p><strong>Sign In Link:</strong> <a href='http://localhost/hub/f/admin/aSignin.php'>https://localhost/hub/f/admin/aSignin.php</a></p>

        <p>Once you are redirected to the login page, you can sign in using your account login credentials.</p>

        <p>If you have any questions or encounter any issues, kindly contact our support team at <a href='mailto:hubsupport@gmail.com'>hubsupport@gmail.com</a></p>

        <br>

        <p style='font-style: italic; color: #888;'>Best regards,</p>
        <p style='font-style: italic; color: #888;'>Research Hub Team</p>
    ";

    $mail->send();

}

// DECLINE ACC REQUEST
function decline($adname, $ademail) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Username = 'uresearch.hub@gmail.com';
    $mail->Password = 'hhqw syqz eawo rrdb';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->setFrom('uresearch.hub@gmail.com', 'noreply');
    $mail->addAddress($ademail, $adname);
    $mail->isHTML(true);


    $verification_code = md5(uniqid(rand(), true));
    $mail->Subject = 'Account Request Declined';
    $mail->Body = "
        <p>Hello $adname!</p>
        
        <p>You received this email to inform you that your Research Hub admin account has been declined.</p>

        <p>If you have any questions or encounter any issues, kindly contact our support team at <a href='mailto:hubsupport@gmail.com'>hubsupport@gmail.com</a></p>

        <br>

        <p style='font-style: italic; color: #888;'>Best regards,</p>
        <p style='font-style: italic; color: #888;'>Research Hub Team</p>
    ";

    $mail->send();

}

if (isset($_POST['approve'])) {
    $id = $_POST['admins_id'];
    $adname = $_POST['admins_name'];
    $ademail = $_POST['admins_email'];
    try {
        $stmt = $pdo->prepare("UPDATE `admin` SET approval = 1 WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        approve($adname, $ademail);
        $_SESSION['success'] = "Admin account approved successfully.";
    } catch (PDOException $e) {
        $_SESSION['error']= "Error updating approval status: " . $e->getMessage();
    }

    echo "<script>window.location.reload();</script>";
    exit();
}

if (isset($_POST['decline'])) {
    $id = $_POST['admins_id'];
    $adname = $_POST['admins_name'];
    $ademail = $_POST['admins_email'];
    try {
        $stmt = $pdo->prepare("DELETE FROM `admin` WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        decline($adname, $ademail);
        $_SESSION['success'] = "Admin account declined.";
    } catch (PDOException $e) {
        $_SESSION['error']= "Error updating approval status: " . $e->getMessage();
    }

    echo "<script>window.location.reload();</script>";
    exit();
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

    <?php

        if (isset($_SESSION['success'])) {
            echo "<br><div class='alert alert-success alert-dismissible fade show' id='myAlert' role='alert'>
                    <strong>Success! </strong>".$_SESSION['success']."
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";

            unset($_SESSION['success']);
        }

        if (isset($_SESSION['error'])) {
            echo "<br><div class='alert alert-danger alert-dismissible fade show' id='myAlert' role='alert'>
                    <strong>Error! </strong>".$_SESSION['error']."
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                
            unset($_SESSION['error']);
        }

    ?>

    <!-- List of admins -->
    <ul class="list-group mt-5 mb-5">
        <li class="list-group-item p-4">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Previous/back link -->
                <a href="aDashboard.php" class="text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg> Back to dashboard
                </a>
    
            </div>
            <!-- Admins --> 
            <?php foreach ($admin as $admins): ?>
                <ul style="list-style-type: none;" class="p-3 rounded ulInside mt-4">
                    <!-- Name -->
                    <li class="list-group-item-title d-flex">
                        <a href="" class=" text-decoration-none text-dark" style="pointer-events: none;"><?php echo $admins['fname'] . " " . $admins['lname']; ?></a>
                        <!-- Button group for edit and delete -->
                        <div class="ml-auto">
                            <!-- Approve form -->
                            <form action="" method="post">
                                <input type="hidden" name="admins_id" value="<?php echo $admins['id']; ?>" >
                                <input type="hidden" name="admins_email" value="<?=$admins['email']?>"> 
                                <input type="hidden" name="admins_name" value="<?=$admins['fname'] . " " . $admins['lname']?>">
                                <button type="button" name="delete" class="btn btn-link text-secondary" data-bs-toggle="modal" data-bs-target="#check_<?php echo $admins['id']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                        <path d="M13.146 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L6 10.293l6.146-6.147a.5.5 0 0 1 .708 0z"/>
                                    </svg>
                                </button>
                                <!-- Modal for approval confirmation -->    
                                <div class="modal fade" id="check_<?php echo $admins['id']; ?>" tabindex="-1" aria-labelledby="appId=<?php echo $admins['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="appId=<?php echo $admins['id']; ?>">Approve Account Request</h5>
                                            </div>
                                            <div class="modal-body" style="font-size: 17px;"> <!-- Set the font size here -->
                                                Are you sure you want to approve <span style="color: blue; font-weight: bold;"> <?php echo $admins['fname'] . " " . $admins['lname']; ?> </span> account request?
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
                                <!-- Button to trigger decline modal -->
                                <button type="button" class="btn btn-link text-secondary" data-bs-toggle="modal" data-bs-target="#decline_<?php echo $admins['id']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M3.146 3.146a.5.5 0 0 1 .708 0L8 7.293l4.146-4.147a.5.5 0 0 1 .708.708L8.707 8l4.147 4.146a.5.5 0 1 1-.708.708L8 8.707l-4.146 4.147a.5.5 0 0 1-.708-.708L7.293 8 3.146 3.854a.5.5 0 0 1 0-.708z"/>
                                    </svg>

                                </button>
                                <!-- Decline Modal -->
                                <div class="modal fade" id="decline_<?php echo $admins['id']; ?>" tabindex="-1" aria-labelledby="decId=<?php echo $admins['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="decId=<?php echo $admins['id']; ?>">Decline Account Request</h5>
                                            </div>
                                            <div class="modal-body" style="font-size: 17px;"> <!-- Set the font size here -->
                                                Are you sure you want to decline <span style="color: blue; font-weight: bold;"> <?php echo $admins['fname'] . " " . $admins['lname']; ?> </span> account request?
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
                        </div>
                    </li>
                    <!-- admins information -->
                    <li class="text-muted">Email: <?php echo $admins['email']; ?></li>
                    <li class="text-muted">Department of <?php echo $admins['dept']; ?> </li>
                </ul>
            <?php endforeach; ?>
       </li>
    </ul>
    <?php
    // Check if there are 5 or more entries
    if (count($admin) >= 5) {
        echo '
            <!-- Pagination -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
            ';
        }   
    ?>
</div>