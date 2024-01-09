<?php

include 'dashboard/sidebar.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Research Hub</title>

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
    <link rel="stylesheet" href="../css/aDashStyle.css">

</head>
<body>


    <!-- Content Area -->
    <div id="content">

        <!-- Search bar -->
        <!-- <form class="d-flex mt-4" role="search">
            <input class="form-control me-2" type="search" placeholder="Search for a study" aria-label="Search">
            <button type="button" class="btn btn-warning">Search</button>
        </form> --> 
        <div class="search">
            <i class="fa fa-search"></i>
            <input type="text" class="form-control" placeholder="Search for a study">
            <button class="btn btn-warning">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg> Search
            </button>
        </div>

        <!-- List of studies -->
        <ul class="list-group mt-5 mb-5">
            <li class="list-group-item p-4">
                <ul style="list-style-type: none;" class="p-3 rounded ulInside">

                    <!-- Title -->
                    <li class="list-group-item-title">
                        Research Hub: Capstone Projects Repository

                        <!-- Button for edit and delete -->
                        <button type="button" class="btn btn-warning btn-sm" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                        </svg></button>
                    </li>

                    <!-- Information about the study -->
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi alias similique ab veritatis veniam adipisci laudantium, tempora molestiae, cumque quidem atque non iusto rem voluptas illum. Officiis ullam, itaque cumque adipisci delectus soluta esse perspiciatis aut eveniet, necessitatibus numquam? Ex blanditiis recusandae eum cupiditate tempore molestiae saepe esse at odio.</li>
                    <li class="text-muted">Authors: Mizzy Perez, Haesser Naomi Ting, Iresh May Sajulga, Frahser Jay Tayag, Jed Allen Gubot</li>
                    <li class="text-muted">Department: Information Technology</li>
                    <li class="text-muted">Adviser: Lea Nisperos</li>
                </ul>
            </li>
            <li class="list-group-item p-4">
                <ul style="list-style-type: none;" class="p-3 rounded ulInside">
                    <li class="list-group-item-title">
                        Research Hub: Capstone Projects Repository
                        <button type="button" class="btn btn-warning btn-sm" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                        </svg></button>
                    </li>
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi alias similique ab veritatis veniam adipisci laudantium, tempora molestiae, cumque quidem atque non iusto rem voluptas illum. Officiis ullam, itaque cumque adipisci delectus soluta esse perspiciatis aut eveniet, necessitatibus numquam? Ex blanditiis recusandae eum cupiditate tempore molestiae saepe esse at odio.</li>
                    <li class="text-muted">Authors: Mizzy Perez, Haesser Naomi Ting, Iresh May Sajulga, Frahser Jay Tayag, Jed Allen Gubot</li>
                    <li class="text-muted">Department: Information Technology</li>
                    <li class="text-muted">Adviser: Lea Nisperos</li>
                </ul>
            </li>
            <li class="list-group-item p-4">
                <ul style="list-style-type: none;" class="p-3 rounded ulInside">
                    <li class="list-group-item-title">
                        Research Hub: Capstone Projects Repository
                        <button type="button" class="btn btn-warning btn-sm" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                        </svg></button>
                    </li>
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi alias similique ab veritatis veniam adipisci laudantium, tempora molestiae, cumque quidem atque non iusto rem voluptas illum. Officiis ullam, itaque cumque adipisci delectus soluta esse perspiciatis aut eveniet, necessitatibus numquam? Ex blanditiis recusandae eum cupiditate tempore molestiae saepe esse at odio.</li>
                    <li class="text-muted">Authors: Mizzy Perez, Haesser Naomi Ting, Iresh May Sajulga, Frahser Jay Tayag, Jed Allen Gubot</li>
                    <li class="text-muted">Department: Information Technology</li>
                    <li class="text-muted">Adviser: Lea Nisperos</li>
                </ul>
            </li>
            <li class="list-group-item p-4">
                <ul style="list-style-type: none;" class="p-3 rounded ulInside">
                    <li class="list-group-item-title">
                    Research Hub: Capstone Projects Repository
                        <button type="button" class="btn btn-warning btn-sm" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                            </svg>
                        </button>
                    </li>
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi alias similique ab veritatis veniam adipisci laudantium, tempora molestiae, cumque quidem atque non iusto rem voluptas illum. Officiis ullam, itaque cumque adipisci delectus soluta esse perspiciatis aut eveniet, necessitatibus numquam? Ex blanditiis recusandae eum cupiditate tempore molestiae saepe esse at odio.</li>
                    <li class="text-muted">Authors: Mizzy Perez, Haesser Naomi Ting, Iresh May Sajulga, Frahser Jay Tayag, Jed Allen Gubot</li>
                    <li class="text-muted">Department: Information Technology</li>
                    <li class="text-muted">Adviser: Lea Nisperos</li>
                </ul>
            </li>
        </ul>

        <!-- Pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>

    </div>
</body>
</html>
