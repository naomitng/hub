<?php
session_start();
if (!isset($_SESSION['fname'])) {
    // Redirect the user to the sign-in page
    header('Location: ../admin/aSignIn.php');
    exit(); 
}

$page_title = "Contribute";
require '../../vendor/autoload.php';
include '../includes/header.php';
include '../includes/sidebarAdmin.php';

echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";
echo "<link rel='stylesheet' href='../css/contribute.css'>";

$pdo = new PDO("mysql:host=127.0.0.1;dbname=hub", 'root', '');
?>

<!-- Content Area -->
<div id="content">
    <!-- List of studies -->
    <ul class="list-group">
        <li class="list-group-item p-4">
            <a href="../admin/aDashboard.php" class="text-decoration-none"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                </svg> Back to home
            </a>
            <form id="uploadForm" action="" method="post" enctype="multipart/form-data">
                <div class="row justify-content-center align-items-center">
                    <div class="col mt-4">
                        <input class="form-control" name="file" type="file" id="formFile" accept=".pdf">
                    </div>
                    <div hidden class="col-md-3">
                        <button type="button" name="submit" class="btn btn-warning mt-4 w-100 submit">Submit</button>
                    </div>
                </div>

                <!-- Hidden section to be shown after parsing -->
                <div id="parsedData">
                    <div class="form-floating mb-4 mt-4">
                        <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                        <label for="authors">Title</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="text" name="authors" class="form-control" id="authors" placeholder="Authors">
                        <label for="authors">Authors</label>
                        <p class="text-muted mt-1">Ex. Haesser Naomi Ting, Mizzy Perez, Iresh Sajulga, Frahser Jay Tayag, Jed Allen Gubot</p>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-floating">
                                <textarea class="form-control abstract" name="abstract" placeholder="Abstract" id="abstract" style="height: 330px;"></textarea>
                                <label for="abstract">Abstract</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating mb-4">
                                <input type="text" name="year" class="form-control" id="year" placeholder="Year" oninput="validateNumericInput(this)">
                                <label for="year">Year</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="text" name="adviser" class="form-control" id="adviser" placeholder="Adviser">
                                <label for="adviser">Adviser</label>
                            </div>
                            <div class="form-floating">
                                <select class="form-select" name="dept" id="selectDept" aria-label="Floating label select example">
                                    <option selected>Choose a department</option>
                                    <option value="Information Technology">Information Technology</option>
                                    <option value="Computer Engineering">Computer Engineering</option>
                                </select>
                                <label for="selectDept">Department</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form> 
        </li>
    </ul>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<script>
    document.getElementById('formFile').addEventListener('change', function(event) {
        var file = event.target.files[0];
        if (file) {
            var fileReader = new FileReader();
            fileReader.onload = function() {
                var typedarray = new Uint8Array(this.result);
                pdfjsLib.getDocument(typedarray).promise.then(function(pdf) {
                    var total_pages = pdf.numPages;
                    for (var i = 1; i <= total_pages; i++) {
                        pdf.getPage(i).then(function(page) {
                            page.getTextContent().then(function(textContent) {
                                var text = textContent.items.map(function(item) {
                                    return item.str;
                                }).join(' ');

                                var titleRegex = /Title:\s*([\s\S]+?)\s*Proponents?/;
                                var proponentsRegex = /Proponents?:\s*([\s\S]+?)\s*Capstone/;
                                var adviserRegex = /Capstone\s*Adviser:\s*([\s\S]+?)\s*Capstone\s*Professor/;
                                var professorRegex = /Capstone\s*Professor:\s*([\s\S]+?)\s*(January|February|March|April|May|June|July|August|September|October|November|December)/;
                                var yearRegex = /(January|February|March|April|May|June|July|August|September|October|November|December)\s*\d{4}/;
                                
                                var titleMatch = text.match(titleRegex);
                                var proponentsMatch = text.match(proponentsRegex);
                                var adviserMatch = text.match(adviserRegex);
                                var professorMatch = text.match(professorRegex);
                                var yearMatch = text.match(yearRegex);

                                console.log("Title match:", titleMatch);
                                console.log("Proponents match:", proponentsMatch);
                                console.log("Adviser match:", adviserMatch);
                                console.log("Professor match:", professorMatch);
                                console.log("Year match:", yearMatch);

                                if (titleMatch) {
                                    document.getElementById('title').value = titleMatch[1].trim();
                                }
                                if (proponentsMatch) {
                                    document.getElementById('proponents').value = proponentsMatch[1].trim();
                                }
                                if (adviserMatch) {
                                    document.getElementById('adviser').value = adviserMatch[1].trim();
                                }
                                if (professorMatch) {
                                    document.getElementById('professor').value = professorMatch[1].trim();
                                }
                                if (yearMatch) {
                                    document.getElementById('year').value = yearMatch[2];
                                }
                            }).catch(function(error) {
                                console.error("Error extracting text content:", error);
                            });
                        });
                    }
                }).catch(function(error) {
                    console.error("Error loading PDF:", error);
                });
            };
            fileReader.readAsArrayBuffer(file);
        }
    });
</script>





