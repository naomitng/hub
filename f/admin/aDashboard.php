<?php

    session_start();
    if (!isset($_SESSION['fname'])) {
        // Redirect the user to the sign-in page
        header('Location: ../admin/aSignIn.php');
        exit();
    }

    $page_title = "Dashboard";
    include '../includes/header.php';
    include '../includes/sidebarAdmin.php';
    echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";

?>

<!-- Content Area -->
<div id="content">

    <!-- Search bar -->
    <form class="search">
        <i class="fa fa-search"></i>
        <input type="text" class="form-control" placeholder="Search for a study">
        <button class="btn btn-warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </button>
    </form>

    <!-- List of studies -->
    <ul class="list-group mt-5 mb-5">
        <li class="list-group-item p-4">
            <ul style="list-style-type: none;" class="p-3 rounded ulInside">

                <!-- Title -->
                <li class="list-group-item-title d-flex">
                <a href="">Research Hub: Capstone Projects Repository</a>

                    <!-- Button group for edit and delete -->
                    <div class="ml-auto">
                        <!-- Edit btn -->
                        <button type="button" class="btn btn-link text-secondary" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                        </button>

                        <!-- Delete btn -->
                        <button type="button" class="btn btn-link text-secondary" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>                            
                        </button>
                    </div>
                </li>


                <!-- Information about the study -->
                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi alias similique ab veritatis veniam adipisci laudantium, tempora molestiae, cumque quidem atque non iusto rem voluptas illum. Officiis ullam, itaque cumque adipisci delectus soluta esse perspiciatis aut eveniet, necessitatibus numquam? Ex blanditiis recusandae eum cupiditate tempore molestiae saepe esse at odio.</li>
                <li class="text-muted">Authors: Mizzy Perez, Haesser Naomi Ting, Iresh May Sajulga, Frahser Jay Tayag, Jed Allen Gubot</li>
                <li class="text-muted">Department: Information Technology</li>
                <li class="text-muted">Adviser: Lea Nisperos</li>
                <li class="text-muted">Published 2024</li>
            </ul>
        </li>
        <li class="list-group-item p-4">
            <ul style="list-style-type: none;" class="p-3 rounded ulInside">
                <li class="list-group-item-title">
                <a href="">Research Hub: Capstone Projects Repository</a>
                    <!-- Button group for edit and delete -->
                    <div class="ml-auto">
                        <!-- Edit btn -->
                        <button type="button" class="btn btn-link text-secondary" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                        </button>

                        <!-- Delete btn -->
                        <button type="button" class="btn btn-link text-secondary" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>                            
                        </button>
                    </div>
                </li>
                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi alias similique ab veritatis veniam adipisci laudantium, tempora molestiae, cumque quidem atque non iusto rem voluptas illum. Officiis ullam, itaque cumque adipisci delectus soluta esse perspiciatis aut eveniet, necessitatibus numquam? Ex blanditiis recusandae eum cupiditate tempore molestiae saepe esse at odio.</li>
                <li class="text-muted">Authors: Mizzy Perez, Haesser Naomi Ting, Iresh May Sajulga, Frahser Jay Tayag, Jed Allen Gubot</li>
                <li class="text-muted">Department: Information Technology</li>
                <li class="text-muted">Adviser: Lea Nisperos</li>
                <li class="text-muted">Published 2024</li>
            </ul>
        </li>
        <li class="list-group-item p-4">
            <ul style="list-style-type: none;" class="p-3 rounded ulInside">
                <li class="list-group-item-title">
                <a href="">Research Hub: Capstone Projects Repository</a>
                    <!-- Button group for edit and delete -->
                    <div class="ml-auto">
                        <!-- Edit btn -->
                        <button type="button" class="btn btn-link text-secondary" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                        </button>

                        <!-- Delete btn -->
                        <button type="button" class="btn btn-link text-secondary" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>                            
                        </button>
                    </div>
                </li>
                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi alias similique ab veritatis veniam adipisci laudantium, tempora molestiae, cumque quidem atque non iusto rem voluptas illum. Officiis ullam, itaque cumque adipisci delectus soluta esse perspiciatis aut eveniet, necessitatibus numquam? Ex blanditiis recusandae eum cupiditate tempore molestiae saepe esse at odio.</li>
                <li class="text-muted">Authors: Mizzy Perez, Haesser Naomi Ting, Iresh May Sajulga, Frahser Jay Tayag, Jed Allen Gubot</li>
                <li class="text-muted">Department: Information Technology</li>
                <li class="text-muted">Adviser: Lea Nisperos</li>
                <li class="text-muted">Published 2024</li>
            </ul>
        </li>
        <li class="list-group-item p-4">
            <ul style="list-style-type: none;" class="p-3 rounded ulInside">
                <li class="list-group-item-title">
                <a href="">Research Hub: Capstone Projects Repository</a>
                    <!-- Button group for edit and delete -->
                    <div class="ml-auto">
                        <!-- Edit btn -->
                        <button type="button" class="btn btn-link text-secondary" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                        </button>

                        <!-- Delete btn -->
                        <button type="button" class="btn btn-link text-secondary" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>                            
                        </button>
                    </div>
                </li>
                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi alias similique ab veritatis veniam adipisci laudantium, tempora molestiae, cumque quidem atque non iusto rem voluptas illum. Officiis ullam, itaque cumque adipisci delectus soluta esse perspiciatis aut eveniet, necessitatibus numquam? Ex blanditiis recusandae eum cupiditate tempore molestiae saepe esse at odio.</li>
                <li class="text-muted">Authors: Mizzy Perez, Haesser Naomi Ting, Iresh May Sajulga, Frahser Jay Tayag, Jed Allen Gubot</li>
                <li class="text-muted">Department: Information Technology</li>
                <li class="text-muted">Adviser: Lea Nisperos</li>
                <li class="text-muted">Published 2024</li>
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
