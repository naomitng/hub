<?php
    session_start();
    $page_title = "Sign Up";
    include '../includes/header.php';
    require '../../vendor/autoload.php';
    echo "<link rel='stylesheet' type='text/css' href='../css/signUpStyle.css'>";
    echo "<script src='../script/showPass.js'></script>";
    // PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    $errMsg = "";
    $sucMsg = "";
    if(isset($_POST['submit-btn'])) {
        $fname = $_POST['fName'];
        $lname = $_POST['lName'];        
        $email = $_POST['email'];
        $dept = $_POST['dept'];
        $pass = $_POST['pass'];
        $passRpt = $_POST['passRpt'];
        $mail = new PHPMailer(true);
        $hubEmail = 'uresearch.hub@gmail.com';
        $hubPass = 'ucha lrxy ebcf kfps';
        //Check if email is already used
        $emailToCheck = $email;
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = :email");
        $stmt->execute([':email' => $emailToCheck]);
        $user = $stmt->fetch();
        if ($pass !== $passRpt) {
            $errMsg = "Passwords do not match. Please try again.";
        } elseif ($user) {
            $errMsg = "Email already exist. Please use a different email address.";
        } elseif (strlen($_POST["pass"]) <= 8) {
            $errMsg = "Your Password Must Contain At Least 8 Characters!";
        } elseif (!preg_match("#[0-9]+#", $pass)) {
            $errMsg = "Your Password Must Contain At Least 1 Number!";
        } elseif (!preg_match("#[A-Z]+#", $pass)) {
            $errMsg = "Your Password Must Contain At Least Capital Letter!";
        } elseif (!preg_match("#[a-z]+#", $pass)) {
            $errMsg = "Your Password Must Contain At Least 1 Lowercase Letter!";
        } else {
            try {
                $hashedPass = password_hash($pass, PASSWORD_BCRYPT);
                $data = [
                    'fname' => $fname,
                    'lname' => $lname,
                    'email' => $email,
                    'dept' => $dept,
                    'hashedPass' => $hashedPass,
                ];
                $stmt = $pdo->prepare("INSERT INTO `admin`(`fname`, `lname`, `email`, `dept`, `pass`) VALUES (:fname, :lname, :email, :dept, :hashedPass)");
                $stmt->execute($data);
                $sucMsg = "Your account is successfully created. Check your email address for the activation link.";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
    $pdo = null;
?>

<body class="d-flex align-items-center">
    <a href="../user/landing.php" class="logo-container" id="logoText" title="Back to landing page">
        <img src="../img/logo.png" alt="Research Hub logo" class="logo-img">
        <span>Research Hub</span>
    </a>    
    <div class="row">
        <!-- Image column -->
        <div class="col-md-3 p-0 img-container">
            <img src="../img/bg-rtu.jpg" alt="" class="img-fluid h-100 rounded-start shadow-left">
        </div>
        <!-- Form column -->
        <div class="col-md-6 p-0">
            <form action="" method="post" class="shadow-lg p-5 rounded-end form-container">
                <h1 class="mb-4 text-center">Request for an admin account</h1>
                <!-- Alert signing up -->
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
                <div class="row">
                    <!-- First name -->
                    <div class="col">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="fName" name="fName" placeholder="First name" autocomplete="off" required>
                        </div>
                    </div>
                    <!-- Last name -->
                    <div class="col">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="lName" name="lName" placeholder="Last name" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <!-- Email -->
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                <path
                                    d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
                            </svg>
                        </span>
                        <input type="text" class="form-control" placeholder="Email" name="email" aria-label="Email"
                            aria-describedby="basic-addon1" autocomplete="off" required>
                    </div>
                    <p>You can use letters, numbers & periods</p>
                </div>
                <!-- Department -->
                <div class="mb-3">
                    <div class="input-group">
                        <select class="form-select" id="inputGroupSelect04"
                            aria-label="Example select with button addon" name="dept">
                            <option selected>Choose a department</option>
                            <option value="IT Department">IT Department</option>
                            <option value="CpE Department">CpE Department</option>
                        </select>
                    </div>
                </div>
                <!-- Password -->
                <div class="row">
                    <!-- Input password -->
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-asterisk" viewBox="0 0 16 16">
                                    <path
                                        d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1" />
                                </svg>
                            </span>
                            <input type="password" id="password" class="form-control" placeholder="Password"
                                aria-label="Password" aria-describedby="basic-addon2" name="pass" required>
                        </div>
                    </div>
                    <!-- Confirm password -->
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-asterisk" viewBox="0 0 16 16">
                                    <path
                                        d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1" />
                                </svg>
                            </span>
                            <input type="password" id="cPassword" class="form-control"
                                placeholder="Confirm password" aria-label="Password"
                                aria-describedby="basic-addon2" name="passRpt" required>
                        </div>
                    </div>
                </div>
                <p>Use 8 or more characters with a mix of letters, numbers & <br>symbols</p>
                <!-- Checkbox for password visibility -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="showPass" onclick="show()">
                    <label class="form-check-label" for="showPass">
                        Show password
                    </label>
                </div>
                <div class="row mt-4 text-center">
                    <!-- Sign in link -->
                    <div class="col d-flex align-items-center">
                        <a href="../admin/aSignIn.php">Sign In instead</a>
                    </div>
                    <!-- Sign up button -->
                    <div class="col text-end">
                        <button type="submit" id="signUp-btn" name="submit-btn" class="btn btn-warning">Sign Up</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
