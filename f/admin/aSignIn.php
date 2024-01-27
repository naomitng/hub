<?php
    $page_title = "Sign In";
    include '../includes/header.php';

    echo "<link rel='stylesheet' type='text/css' href='../css/signInStyle.css'>";

    echo "<script src='../script/slideshow.js'></script>"
?>


<body class="d-flex align-items-center vh-100">

    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-md-6 d-flex align-items-center justify-content-center shadow-lg" style="background-color: white;">
                <form id="loginForm" method="post" action="" class="container shadow-lg p-5 mb-6 rounded py-5" style="max-width: 70%; background-color: #00308F;"> 
                    <!-- Sign In Text -->
                    <h1 class="row justify-content-center mb-3">Sign In as Admin</h1>
                    <div class="row justify-content-start">
                        <div class="col-md-12">
                            <!-- Incorrect email/pass alert -->
                            <div class="alert alert-danger" role="alert">
                                This is a warning alert—check it out!
                            </div>
                            <!-- Email Input -->
                            <div class="mb-3">
                                <div class="input-group mt-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1">
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
                                    <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
                                </div>
                            </div>
                            <!-- Submit Button -->
                            <div class="mb-3">
                                <div class="input-group">
                                    <button type="button" class="col-md-12 btn btn-warning">Sign In</button>
                                </div>
                                <div class="register-link">
                                    <p class="text-center mt-2">No account? Register <a href="../admin/aSignUp.php">here</a></p>
                                </div>
                            </div>
                            <div class="register-link">
                                <p class="text-center mt-5"><a href="../admin/forgotPass.php">Forgot password?</a></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6 d-none d-md-block container-two"></div>
        </div>
    </div>
</body>
    
