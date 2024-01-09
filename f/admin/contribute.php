<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contribute - Research Hub</title>

    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz@6..12&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="../img/logo.png">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/aDashStyle.css" type="text/css">
    <link rel="stylesheet" href="../css/contribute.css" type="text/css">
    <meta name="theme-color" content="#7952b3">
</head>
<body>

    <!-- Script for importing the sidebar -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var sidebarContainer = document.getElementById("sidebar-container");

            fetch("../admin/dashboard/sidebar.php")
                .then(response => response.text())
                .then(data => {
                    sidebarContainer.innerHTML = data;
                })
                .catch(error => console.error("Error fetching sidebar:", error));
        });
    </script>
    
    <!-- Sidebar container -->
    <div id="sidebar-container"></div>

</body>
</html>