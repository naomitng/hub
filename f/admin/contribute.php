<?php

    session_start();
    if (!isset($_SESSION['fname'])) {
        // Redirect the user to the sign-in page
        header('Location: ../admin/aSignIn.php');
        exit(); 
    }

    $page_title = "Contribute";
    include '../includes/header.php';
    include '../includes/sidebarAdmin.php';
    require '../../vendor/autoload.php';

    echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";
    echo "<link rel='stylesheet' href='../css/contribute.css'>";

    $pdo = new PDO("mysql:host=127.0.0.1;dbname=hub", 'root', '');

    if(isset($_POST['submit'])) {
        $title = $_POST['title'];
        $authors = $_POST['authors'];
        $abstract = $_POST['abstract'];
        $year = $_POST['year'];
        $adviser = $_POST['adviser'];
        $dept = $_POST['dept'];
        $file = $_POST['file'];

        try {
            $stmt = $pdo->prepare(" ");
        } catch (PDOException $e) {
            //throw $th;
        }

        if(isset($_FILES['file']['title'])) {
            $fileName = basename($_FILES['file']['title']);
            $fileType = pathinfo($fileName, PATHINFO_BASENAME);

           $parser = new \Smalot\PdfParser\Parser();
           $file = $_FILES['file']['tempname'];
           $pdf = $parser->parseFile($file);
           $text = $pdf->getText();
           $pdfText = nlbr($text);
        }
    }
    

?>

<!-- Content Area -->
<div id="content">
    
    <!-- List of studies -->
    <ul class="list-group mt-5">
        <li class="list-group-item p-4">
            <a href="../admin/aDashboard.php" class="text-decoration-none"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                </svg> Back to home
            </a>
            <form action="result.php" method="post" enctype="multipart/form-data">
                <div class="form-floating mb-4 mt-4">
                    <input type="text" name="title" class="form-control" id="title" placeholder="Title" required>
                    <label for="authors">Title</label>
                </div>

                <div class="form-floating mb-4">
                    <input type="text" name="authors" class="form-control" id="authors" placeholder="Authors" required>
                    <label for="authors">Authors</label>
                    <p class="text-muted mt-1">Ex. Haesser Naomi Ting, Mizzy Perez, Iresh Sajulga, Frahser Jay Tayag, Jed Allen Gubot</p>
                </div>

                <div class="row">
                    <div class="col-md">
                        <div class="form-floating">
                            <textarea class="form-control abstract" name="abstract" placeholder="Abstract" id="abstract" style="height: 330px;" required></textarea>
                            <label for="abstract">Abstract</label>
                        </div>
                    </div>

                    <div class="col-md">
                    <div class="form-floating mb-4">
                        <input type="text" name="year"class="form-control" id="year" placeholder="Year" oninput="validateNumericInput(this)" required>
                        <label for="year">Year</label>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="text" name="adviser" class="form-control" id="adviser" placeholder="sampleTitle" required>
                        <label for="floatingInput">Adviser</label>
                        </div>
                        <div class="form-floating">
                            <select class="form-select" name="dept" id="selectDept" aria-label="Floating label select example" required>
                                <option selected>Choose a department</option>
                                <option value="Information Technology">Information Technology</option>
                                <option value="Computer Engineering">Computer Engineering</option>
                            </select>
                            <label for="selectDept">Department</label>
                        </div>
                        <div class="mt-3">
                            <input class="form-control" name="file" type="file" id="formFile" accept=".pdf"required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-warning mt-4 w-100 submit">Submit</button>
                    </div>
                </div>
            </form>
        </li>
</div>

<script>
    function validateNumericInput(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
    }
</script>