<?php
    $page_title = "Forgot password";
    include '../includes/header.php';

    echo "<link rel='stylesheet' type='text/css' href='../css/newForPass.css'>";

?>

<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" method="post" class="text-center p-5 rounded shadow-lg" style="background-color: #00308F;">
                <h1 class="mb-4">Reset password</h1>
                <div class="alert alert-warning w-60 mb-4" role="alert">
                    A new code has been resend. Check your email
                </div>
                <div class="input-group mb-3 mx-auto">
                    <input type="text" class="form-control" placeholder="Email">
                </div>
                <button type="button" class="btn btn-warning w-100" style="background-color: #FFEA00;">Forgot password</button>

                <p class="mt-5 mb-0">Have an admin account? <a href="../admin/aSignIn.php">Sign in</a> instead</p>
            </form>    
        </div>
    </div>
</div>