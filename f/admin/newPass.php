<?php
    $page_title = "Reset Password";
    include '../includes/header.php';
    require '../../vendor/autoload.php';
    echo "<link rel='stylesheet' type='text/css' href='../css/newForPass.css'>";
    echo "<script src='../script/showPass.js'></script>";

    //$pdo = new PDO("mysql:host=127.0.0.1;dbname=hub", 'root', '');
    $pdo = new PDO("mysql:host=sql209.infinityfree.com; dbname=if0_36132900_hub", "if0_36132900", "Hs96nqZI1Gd9ED");

    $errMsg = "";
    $sucMsg = "";

    if(isset($_GET['code'])) {
        $reset_code = $_GET['code'];

        // Select query
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE rescode = :rescode");
        $stmt->execute([':rescode' => $reset_code]);
        $user = $stmt->fetch();

        if (!$user) {
            $errMsg = "This link is invalid. Request a new one.";
        } else {
            if (isset($_POST['submit'])) {
                $pass = $_POST['pass'];
                $passRpt = $_POST['passRpt'];
                $hashedPass = password_hash($pass, PASSWORD_BCRYPT);

                $updateStmt = $pdo->prepare("UPDATE admin SET pass = :hashedPass WHERE rescode = :rescode"); // Corrected parameter name
                $updateStmt->bindParam(':hashedPass', $hashedPass);
                $updateStmt->bindParam(':rescode', $reset_code);
                $updateStmt->execute();

                $sucMsg = "Password successfully updated. You may now log into your admin account using this <a href='https://localhost/hub/f/admin/aSignIn.php'>link</a>.";
            }
        }
    }
?>

<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" method="post" class="text-center p-5 rounded shadow-lg" style="background-color: #00308F;">
                <h1 class="mb-5">Reset password</h1>

                <?php if ($errMsg !== "") { ?>
                    <div class="alert alert-warning w-60 mb-4" role="alert">
                        <?php echo $errMsg; ?>
                    </div>
                    <script>
                        setTimeout(function () {
                            document.querySelector('.alert-warning').style.display = 'none';
                        }, 5000);
                    </script>
                <?php } elseif ($sucMsg !== "") { ?>
                    <div class="alert alert-success w-60 mb-4" role="alert">
                        <?php echo $sucMsg; ?>
                    </div>
                <?php } else { ?>
                    <div style="display: none;" class="alert alert-danger" role="alert"></div>
                    <div style="display: none;" class="alert alert-success" role="alert"></div>
                <?php } ?>

                <div class="input-group mb-3 mx-auto">
                    <input type="password" name="pass" class="form-control" placeholder="New password" id="cPassword">
                </div>
                <div class="input-group mb-3 mx-auto">
                    <input type="password" name="passRpt" class="form-control" placeholder="Confirm password" id="password">
                </div>

                <!-- Correct the hidden field name -->
                <input type="hidden" name="rescode" value="<?php echo isset($_GET['rescode']) ? $_GET['rescode'] : ''; ?>">

                <div class="row mb-5">
                    <div class="col-auto">
                        <input class="form-check-input" type="checkbox" value="" id="showPass" onclick="show()">
                        <label class="form-check-label" for="showPass">
                            Show password
                        </label>
                    </div>
                </div>

                <div class="mb-3 mx-auto">
                    <button type="submit" name="submit" class="btn btn-warning w-100">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
