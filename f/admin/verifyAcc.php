<?php
    $page_title = "Verify Account";
    include '../includes/header.php';

    echo "<link rel='stylesheet' type='text/css' href='../css/verifyAcc.css'>";

?>

<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" method="post" class="text-center p-5 rounded shadow-lg" style="background-color: #00308F;">
                <h1 class="mb-2">Verify your Email</h1>
                <p>Please enter the code that was sent to <b>example@gmail.com</b><br>
                to verify your Research Hub admin account.</p>
                <div class="alert alert-warning w-60" role="alert">
                    A new code has been resend. Check your email
                </div>
                <div class="input-group mb-3 mx-auto" style="width: 70%;">
                    <input type="text" class="form-control">
                </div>
                <button type="button" class="btn btn-warning w-50">Verify</button>

                <p class="mt-5 mb-0">You can <a href="">resend</a> in <span>1:00</span></p>
            </form>    
        </div>
    </div>
</div>
