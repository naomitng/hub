<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create new password - Research Hub</title>

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

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/newForPass.css" type="text/css">

    <!-- Javascript -->
    <script src="../script/showPass.js"></script>

</head>
<body>
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
    
</body>
</html>
