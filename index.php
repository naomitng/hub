<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script>
    // Function to redirect to the desired PHP file after 2 seconds
    function redirectToPHPFile() {
      window.location.href = 'f/admin/dashboard/adashboard.php'
    }

    // Execute the redirection after 2 seconds when the page loads
    window.onload = function () {
      setTimeout(redirectToPHPFile, 2000); // 2000 milliseconds = 2 seconds
    };
  </script>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    img {
      max-width: 100%; /* Optional: Ensure the image doesn't exceed its original size */
    }
  </style>
</head>
<body>
  <img src="f/img/logo-w-name.png" alt=""> <br>
  <center><h3>Loading...</h3></center>
</body>
</html>
