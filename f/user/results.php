<?php
    $page_title = "";
    include '../includes/header.php';
    include '../user/sidebarUser.php';

    echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";
?>

<!-- Content Area -->
<div id="content">

<!-- Form for search -->
<form action="" method="post" class="search landing-s result-s">

    <i class="fa fa-search"></i>
    <input type="text" class="form-control" placeholder="Search">
    <!-- Search Button -->
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
                <li class="list-group-item-title"> <a href="">Research Hub: Capstone Projects Repository</a></li>

                <!-- Information about the study -->
                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi alias similique ab veritatis veniam adipisci laudantium, tempora molestiae, cumque quidem atque non iusto rem voluptas illum. Officiis ullam, itaque cumque adipisci delectus soluta esse perspiciatis aut eveniet, necessitatibus numquam? Ex blanditiis recusandae eum cupiditate tempore molestiae saepe esse at odio.</li>
                <li class="text-muted">Authors: Mizzy Perez, Haesser Naomi Ting, Iresh May Sajulga, Frahser Jay Tayag, Jed Allen Gubot</li>
                <li class="text-muted">Department: Information Technology</li>
                <li class="text-muted">Adviser: Lea Nisperos</li>
            </ul>
        </li>
        <li class="list-group-item p-4">
            <ul style="list-style-type: none;" class="p-3 rounded ulInside">
                <li class="list-group-item-title"> <a href="">Research Hub: Capstone Projects Repository</a> </li>
                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi alias similique ab veritatis veniam adipisci laudantium, tempora molestiae, cumque quidem atque non iusto rem voluptas illum. Officiis ullam, itaque cumque adipisci delectus soluta esse perspiciatis aut eveniet, necessitatibus numquam? Ex blanditiis recusandae eum cupiditate tempore molestiae saepe esse at odio.</li>
                <li class="text-muted">Authors: Mizzy Perez, Haesser Naomi Ting, Iresh May Sajulga, Frahser Jay Tayag, Jed Allen Gubot</li>
                <li class="text-muted">Department: Information Technology</li>
                <li class="text-muted">Adviser: Lea Nisperos</li>
            </ul>
        </li>
        <li class="list-group-item p-4">
            <ul style="list-style-type: none;" class="p-3 rounded ulInside">
                <li class="list-group-item-title"> <a href="">Research Hub: Capstone Projects Repository</a> </li>
                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi alias similique ab veritatis veniam adipisci laudantium, tempora molestiae, cumque quidem atque non iusto rem voluptas illum. Officiis ullam, itaque cumque adipisci delectus soluta esse perspiciatis aut eveniet, necessitatibus numquam? Ex blanditiis recusandae eum cupiditate tempore molestiae saepe esse at odio.</li>
                <li class="text-muted">Authors: Mizzy Perez, Haesser Naomi Ting, Iresh May Sajulga, Frahser Jay Tayag, Jed Allen Gubot</li>
                <li class="text-muted">Department: Information Technology</li>
                <li class="text-muted">Adviser: Lea Nisperos</li>
            </ul>
        </li>
        <li class="list-group-item p-4">
            <ul style="list-style-type: none;" class="p-3 rounded ulInside">
                <li class="list-group-item-title"> <a href="">Research Hub: Capstone Projects Repository</a> </li>
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