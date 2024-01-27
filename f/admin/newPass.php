<?php
    $page_title = "Forgot password";
    include '../includes/header.php';

    echo "<link rel='stylesheet' type='text/css' href='../css/newForPass.css'>";
    echo "<script src='../script/showPass.js'></script>"
?>

<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" method="post" class="text-center p-5 rounded shadow-lg" style="background-color: #00308F;">
                <h1 class="mb-5">Reset password</h1>

                <!-- Alert for code -->
                <div class="alert alert-warning w-60 mb-4" role="alert">
                    A new code has been resend. Check your email
                </div>
                <!-- Alert for pw doesn't match -->
                <div class="alert alert-danger w-60 mb-4" role="alert">
                    Password doesn't match
                </div>

                <div class="input-group mb-3 mx-auto">
                    <input type="password" class="form-control" placeholder="Current password" id="oPassword">
                </div>
                <div class="input-group mb-3 mx-auto">
                    <input type="password" class="form-control" placeholder="New password" id="password">
                </div>
                <div class="input-group mb-3 mx-auto">
                    <input type="password" class="form-control" placeholder="Confirm password" id="cPassword">
                </div>

                <!-- Checkbox for password visibility -->
                <div class="row mb-5">
                    <div class="col-auto">
                        <input class="form-check-input" type="checkbox" value="" id="showPass" onclick="show()">
                        <label class="form-check-label" for="showPass">
                            Show password
                        </label>
                    </div>
                </div>

                <div class="mb-3 mx-auto">
                    <button type="button" class="btn btn-warning w-100">Reset password</button>
                </div>
            </form>    
        </div>
    </div>
</div>
