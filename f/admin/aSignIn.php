<?php
    session_start();

    if (isset($_SESSION['fname'])) {
        // Redirect if already logged in
        header('Location: aDashboard.php');
        exit(); 
    }

    else if (isset($_SESSION['supadmin'])) {
        header('location: ../supadmin/aDashboard.php');
        exit();
    }

    $page_title = "Sign In";
    include '../includes/header.php';
    echo "<link rel='stylesheet' type='text/css' href='../css/signInStyle.css'>";
    echo "<script src='../script/showPass.js'></script>";

    $errMsg = "";

    if (isset($_POST['signinBtn'])) {

        $email = $_POST['email'];
        $pass = $_POST['pass'];

        // Check if the user is a superadmin
        $stmt_superadmin = $pdo->prepare("SELECT * FROM superadmin WHERE `username` = :username");
        $stmt_superadmin->bindParam(':username', $email);
        $stmt_superadmin->execute();
        $superadmin_result = $stmt_superadmin->fetch(PDO::FETCH_ASSOC);

        if ($superadmin_result && password_verify($pass, $superadmin_result['password'])) {
            $_SESSION['supadmin'] = true;
            header('Location: ../supadmin/aDashboard.php');
            exit();
        }

        // Check if the user is an admin
        $stmt_admin = $pdo->prepare("SELECT * FROM admin WHERE `email` = :email");
        $stmt_admin->bindParam(':email', $email);
        $stmt_admin->execute();
        $admin_result = $stmt_admin->fetch(PDO::FETCH_ASSOC);

        if ($admin_result) {
            $isVerified = $admin_result['verified'];
            $isApproved = $admin_result['approval'];

            if ($isVerified == 1) {
                if ($isApproved == 1) {
                    if (password_verify($pass, $admin_result['pass'])) {
                        $_SESSION['fname'] = $admin_result['fname'];
                        $_SESSION['lname'] = $admin_result['lname'];
                        $_SESSION['contri'] = $admin_result['id'];
                        header('Location: ../admin/aDashboard.php');
                        exit(); 
                    } else {
                        $errMsg = "Invalid email or password";
                    }
                } else {
                    $errMsg = "Please wait for the Super Admin to review your account request.";
                }
            } else {
                $errMsg = "Please verify your admin account. A verification link is sent to your email address.";
            }
        } else {
            $errMsg = "No user found with this email";
        }
    } 

    $pdo = null;
?>



<body class="d-flex align-items-center vh-100">
    <a href="../user/landing.php" class="logo-container" id="logoText" title="Back to landing page">
        <img src="../img/logo.png" alt="Research Hub logo" class="logo-img">
        <span>Research Hub</span>
    </a> 
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-md-6 d-flex align-items-center justify-content-center shadow-lg" style="background-color: white;">
                <form id="loginForm" method="post" action="" class="container shadow-lg p-5 mb-6 rounded py-5" style="max-width: 70%; background-color: #00308F;"> 
                    <!-- Sign In Text -->
                    <h1 class="row justify-content-center mb-3">Sign In as Admin</h1>
                    <div class="row justify-content-start">
                        <div class="col-md-12">
                            <!-- Incorrect email/pass alert -->
                            <?php if($errMsg !== "") { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $errMsg; ?>
                                    <script>setTimeout(function() { document.querySelector('.alert-danger').style.display = 'none'; }, 5000);</script>
                                </div>
                            <?php } else { ?> 
                                    <!-- Hidden alert div -->
                                    <div style="display: none;" class="alert alert-danger" role="alert"></div>    
                            <?php } ?>

                            

                            <!-- Email Input -->
                            <div class="mb-3">
                                <div class="input-group mt-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                                        </svg>
                                    </span>
                                    <input type="text" id="email" name="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" autocomplete="off" required>
                                </div>
                            </div>
                            <!-- Password Input -->
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-asterisk" viewBox="0 0 16 16">
                                            <path d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1"/>
                                        </svg>
                                    </span>
                                    <input type="password" id="password" name="pass" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2" required>
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="showPass" onclick="show()">
                                <label class="form-check-label" for="showPass">
                                    Show password
                                </label>
                            </div>
                            <!-- Submit Button -->
                            <div class="mb-3 mt-3">
                                <div class="input-group">
                                    <button type="submit" name="signinBtn" class="col-md-12 btn btn-warning">Sign In</button>
                                </div>
                                <div class="register-link">
                                    <p class="text-center mt-2">No account? Request <a href="../admin/aSignUp.php"  id="register">here</a></p>
                                </div>
                            </div>
                            <div class="register-link">
                                <p class="text-center mt-5"><a href="../admin/forgotPass.php" id="forgotpass">Forgot password?</a></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6 d-none d-md-block container-two"></div>
        </div>
    </div>
    <script>
        const imgPaths = [
            '../img/bg-quad.jpg',
            '../img/bg-rtu.jpg',
        ];

        let currentIndex = 0;

        function changeBackground() {
            document.body.style.backgroundImage = `url(${imgPaths[currentIndex]})`;
            currentIndex = (currentIndex + 1) % imgPaths.length;
        }

        const intervalId = setInterval(changeBackground, 3000); // Change image every 3 seconds

        window.addEventListener('beforeunload', () => {
            clearInterval(intervalId);
        });
    </script>
</body>