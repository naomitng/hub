<?php
    $page_title = "Forgot password";
    include '../includes/header.php';
    require '../../vendor/autoload.php';
    echo "<link rel='stylesheet' type='text/css' href='../css/newForPass.css'>";

    // PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //$pdo = new PDO("mysql:host=127.0.0.1;dbname=hub", "root", "");
    $pdo = new PDO("mysql:host=sql209.infinityfree.com; dbname=if0_36132900_hub", "if0_36132900", "Hs96nqZI1Gd9ED");

    $errMsg = "";
    $sucMsg = "";

    if(isset($_POST['forgotBtn'])) {
        $email = $_POST['email'];

        $stmt = $pdo->prepare("SELECT * FROM admin WHERE `email` = :email");
        $stmt->execute([':email' => $email]);
        $result = $stmt->fetch();

        if($result) {
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->Username = 'uresearch.hub@gmail.com';
                $mail->Password = 'hhqw syqz eawo rrdb';
                $mail->Port = 587;
                $mail->SMTPAuth = true;

                // Fetch user details
                $fname = $result['fname'];
                $lname = $result['lname'];

                $mail->setFrom('noreply@yourdomain.com', 'noreply');
                $mail->addAddress($email, $fname . ' ' . $lname);
                $mail->isHTML(true);

                $rescode = md5(uniqid(rand(), true));
                $mail->Subject = 'Password reset link for Research Hub';
                $mail->Body = "<p>Hello $fname!</p>
                    
                <p>We have received a request to reset your Research Hub admin account's password. Click the link below to reset your password:</p>
                <p><strong>Reset Link:</strong> <a href='https://localhost/hub/f/admin/newPass.php?code=" . urlencode($rescode) . "'>https://localhost/hub/f/admin/newPass.php?code=" . urlencode($rescode) . "</a></p>
                <p>If you did not request a password reset, please disregard this email and if you have any questions or encounter any issues, kindly contact our support team at <a href='mailto:hubsupport@gmail.com'>hubsupport@gmail.com</a></p>

                <br>

                <p style='font-style: italic; color: #888;'>Best regards,</p>
                <p style='font-style: italic; color: #888;'>Research Hub Team</p>";

                // Send the email
                $mail->send();

                $data = [
                    'rescode' => $rescode,
                    'email' => $email
                ];

                $stmt = $pdo->prepare("UPDATE admin SET rescode = :rescode WHERE email = :email");
                $stmt->execute($data);

                $sucMsg = "Password reset link sent successfully!";
            } catch (Exception $e) {
                $errMsg = "Error: " . $mail->ErrorInfo;
            }
        } else {
            $errMsg = "No user found with this email";
        }
    }
?>

<div class="container-md">
    <a href="../user/landing.php" class="logo-container" id="logoText" title="Back to landing page">
        <img src="../img/logo.png" alt="Research Hub logo" class="logo-img">
        <span>Research Hub</span>
    </a>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" method="post" class="text-center p-5 rounded shadow-lg" style="background-color: #00308F;">
                <h1 class="mb-4">Reset password</h1>
                <?php if($errMsg !== "") { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errMsg; ?>
                    </div> 
                    <script>
                        setTimeout(function() { 
                            document.querySelector('.alert-danger').style.display = 'none';
                        }, 5000);
                    </script>
                <?php } elseif ($sucMsg !== "") { ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $sucMsg; ?>
                        </div>
                        <script>
                            setTimeout(function() { 
                                document.querySelector('.alert-success').style.display = 'none';  // or 'flex'
                            }, 5000);
                        </script>
                <?php } else { ?>
                            <!-- Hidden alert div -->
                            <div style="display: none;" class="alert alert-danger" role="alert"></div>
                            <div style="display: none;" class="alert alert-success" role="alert"></div>
                <?php } ?>
                    
                <div class="input-group mb-3 mx-auto">
                    <input type="text" name="email" class="form-control" placeholder="Email" required>
                </div>
                <button type="submit" name="forgotBtn" class="btn btn-warning w-100">Forgot password</button>
                <p class="mt-5 mb-0">Have an admin account? <a href="../admin/aSignIn.php" id="signin">Sign in</a> instead</p>
            </form>    
        </div>
    </div>
</div>
