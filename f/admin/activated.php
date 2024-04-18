<?php
    $page_title = "Account successfully activated";
    include '../includes/header.php';
        if(isset($_GET['code'])) {
        $verification_code = $_GET['code'];
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE vercode = :vercode");
        $stmt->execute([':vercode' => $verification_code]);
        $user = $stmt->fetch();
        if($user) {
            $updateStmt = $pdo->prepare("UPDATE admin SET verified = 1 WHERE vercode = :vercode");
            $updateStmt->execute([':vercode' => $verification_code]);
            echo "<center><h3 style='margin-top: 20%;'>You have successfully activated your admin account.
                    You will be redirected to the log in page shortly.</h3></center>";
            // Javascript for timeout
            echo "<script>
                function redirectToPHPFile() {
                    window.location.href = '../admin/aSignIn.php'
                }
                window.onload = function () {
                    setTimeout(redirectToPHPFile, 5000);
                };
            </script>";
            exit();
        } else {
            echo "Invalid verification code or user not found.";
        }
    } else {
        echo "Verification code not provided.";
    }
    $pdo = null;
?>



