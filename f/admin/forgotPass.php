<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot password - Research Hub</title>

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

</head>
<body>
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
</body>
</html>