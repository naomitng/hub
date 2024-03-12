<?php
    $page_title = "Account successfully activated";
    include '../includes/header.php';
    
    // Establish database connection
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=hub", 'root', '');

    if(isset($_GET['code'])) {
        $verification_code = $_GET['code'];

        // Select query
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE vercode = :vercode");
        $stmt->execute([':vercode' => $verification_code]);
        $user = $stmt->fetch();

        if($user) {
            // Update the verified column to 1 
            // If 0 means not verified if 1 means verified
            $updateStmt = $pdo->prepare("UPDATE admin SET verified = 1 WHERE vercode = :vercode");
            $updateStmt->execute([':vercode' => $verification_code]);
            $sucMsg = "Please wait for the Super Admin approval.";
            echo "<center><h3 style='margin-top: 20%;'>You have successfully activated your admin account.<br>Kindly wait for the Super Admin to approve your account.<br>
                    You will be redirected to the log in page shortly.</h3></center>";
            // Javascript for timeout
            echo "<script>
                // Function to redirect to the desired PHP file after 5 seconds
                function redirectToPHPFile() {
                    window.location.href = '../admin/aSignIn.php'
                }
            
                // Execute the redirection after 5 seconds when the page loads
                window.onload = function () {
                    setTimeout(redirectToPHPFile, 5000); // 5000 milliseconds = 5 seconds
                };
            </script>";
            exit();
        } else {
            // Handle the case where the user is not found or verification code is invalid
            echo "Invalid verification code or user not found.";
        }
    } else {
        // Handle the case where the code parameter is not present in the URL
        echo "Verification code not provided.";
    }

    $pdo = null;
?>



