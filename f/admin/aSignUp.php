<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up - Research Hub</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz@6..12&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="../img/logo.png">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/signUpStyle.css" type="text/css">
    <!-- Javscript -->
    <script src="../script/showPass.js"></script>
</head>

<body class="d-flex align-items-center">
    <div class="row">
        <!-- Image column -->
        <div class="col-md-3 p-0 img-container">
            <img src="../img/bg-rtu.jpg" alt="" class="img-fluid h-100 rounded-start shadow-left">
        </div>
        <!-- Form column -->
        <div class="col-md-6 p-0">
            <form action="" method="post" class="shadow-lg p-5 rounded-end form-container">
                <h1 class="mb-4 text-center">Register for an admin account</h1>
                <!-- Alert signing up -->
                <div class="alert alert-danger" role="alert">
                    This is a warning alert—check it out!
                </div>
                <div class="row">
                    <!-- First name -->
                    <div class="col">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="fName" placeholder="First name">
                        </div>
                    </div>
                    <!-- Last name -->
                    <div class="col">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="lName" placeholder="Last name">
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
                        <input type="text" class="form-control" placeholder="Email" aria-label="Email"
                            aria-describedby="basic-addon1">
                    </div>
                    <p>You can use letters, numbers & periods</p>
                </div>
                <!-- Department -->
                <div class="mb-3">
                    <div class="input-group">
                        <select class="form-select" id="inputGroupSelect04"
                            aria-label="Example select with button addon">
                            <option selected>Choose a department</option>
                            <option value="1">IT Department</option>
                            <option value="2">CpE Department</option>
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
                                aria-label="Password" aria-describedby="basic-addon2">
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
                                aria-describedby="basic-addon2">
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
                        <button type="button" id="signUp-btn" class="btn btn-warning">Sign Up</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
