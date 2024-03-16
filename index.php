<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Research Hub</title>

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
  <link rel="icon" href="f/img/logo.png">

  <!-- CSS -->
  <link rel="stylesheet" href="f/css/index.css">

  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      padding: 0;
      overflow: hidden; /* Prevent scrollbars */
      background-color: #f5f5f5;
    }

    img {
      max-width: 100%; 
      max-height: 100%;body {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      height: 100vh;
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: #f5f5f5;
    }

    img {
      max-width: 100%; 
      max-height: 100%;
    }

    .d-flex {
      height: 100%; /* Set height to 100% */
      display: flex;
      justify-content: center;
      align-items: center;
    }
  </style>
</head>
<body>

  <script>
    // Function to redirect to the desired PHP file after 2 seconds
    function redirectToPHPFile() {
      window.location.href = 'f/user/landing.php'
    }

    // Execute the redirection after 2 seconds when the page loads
    window.onload = function () {
      setTimeout(redirectToPHPFile, 6000); // 2000 milliseconds = 2 seconds
    };
  </script>

  <div class="d-flex justify-content-center align-items-center text-center">
    <div class="my-auto">
        <img src="f/img/loading.gif" alt="Research Hub logo"><br>
    </div>
  </div>

</body>
</html>
