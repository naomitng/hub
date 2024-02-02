<?php
    $page_title = "Account activation";
    include '../includes/header.php';
    
    // Establish database connection
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=hub", 'root', '');

    if(isset($_GET['code'])) {
        $verification_code = $_GET['code'];

        $stmt = $pdo->prepare("SELECT * FROM admin WHERE vercode = :vercode");
        $stmt->execute([':vercode' => $verification_code]);
        $user = $stmt->fetch();

        if($user) {
            // Update the verified column to 1
            $updateStmt = $pdo->prepare("UPDATE admin SET verified = 1 WHERE vercode = :vercode");
            $updateStmt->execute([':vercode' => $verification_code]);

            // Optional: You might want to redirect the user to a login page or a confirmation page
            //header("Location: ../admin/aSignIn.php");
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




