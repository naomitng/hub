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


if (isset($_POST['submit'])) {
    $dir = 'uploads/';
    $filename = basename($_FILES['file']['name']);
    $newname = $dir . $filename;
    $filetype = pathinfo($newname, PATHINFO_EXTENSION);

    if ($filetype == "pdf") {
        if(move_uploaded_file($_FILES['file']['tmp_name'], $newname)) { // corrected typo here
            $title = $_POST['title'];
            $authors = $_POST['authors'];
            $abstract = $_POST['abstract'];
            $dept = $_POST['dept'];
            $adviser = $_POST['adviser'];
            $year = $_POST['year'];
            $keywords = $_POST['keywords'];

            try {
                $stmt = $pdo->prepare("INSERT INTO `studies`(`title`, `authors`, `abstract`, `year`, `adviser`, `dept`, `filename`, `keywords`) VALUES (:title, :authors, :abstract, :year, :adviser, :dept, :filename, :keywords)");
                $stmt->execute(array(
                    ':title' => $title,
                    ':authors' => $authors,
                    ':abstract' => $abstract,
                    ':year' => $year,
                    ':adviser' => $adviser,
                    ':dept' => $dept,
                    ':filename' => $newname,
                    ':keywords' => $keywords
                ));
                echo "<script>alert('File uploaded successfully');</script>";
            } catch (\Throwable $th) {
                echo "<script>alert('" . $th->getMessage() . "');</script>";
            }
        } else {
            echo "<script>alert('Failed to upload file');</script>";
        }
    }
}

?>

<!-- Content Area -->
<div id="content">
    <!-- List of studies -->
    <ul class="list-group">
        <li class="list-group-item p-4">
            <a href="../admin/aDashboard.php" class="text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                </svg> Back to home
            </a>
            <form id="uploadForm" action="" method="post" enctype="multipart/form-data">
                <div class="row justify-content-center align-items-center">
                    <div class="col mt-4">
                        <input class="form-control" name="file" type="file" id="formFile" accept=".pdf">
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
                            <div class="form-floating mt-4">
                                <input type="text" name="keywords" class="form-control" id="keywords" placeholder="Keywords">
                                <label for="keywords">keywords</label>
                            </div>
                            <div class="mt-3">
                                <button type="submit" name="submit" class="btn btn-warning submit w-100">Add to database</button>
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
    function isEmptyOrSpaces(str) {
        return str == null || str == " " || str == "";
    }

    document.getElementById('formFile').addEventListener('change', function(event) {
        var abstract;
        var title;
        var arr = [];
        var firstPage = [];

        var file = event.target.files[0];

        let fr = new FileReader();
        fr.readAsDataURL(file);
        fr.onload = () => {
            let res = fr.result;
            extractText(res);
            extractFirstpage(res);
        }

        async function extractFirstpage(url) {
            let pdf;
            let alltxt;

            pdf = await pdfjsLib.getDocument(url).promise;
            let pages = pdf.numPages;
            let page = await pdf.getPage(1);
            let txt = await page.getTextContent();
            let text = txt.items.map((s)=> {
                s.str;
                if (!isEmptyOrSpaces(s.str.trim())) {
                    firstPage.push(s.str.trim());
                }
            }); 
        }

        async function extractText(url) {
            let pdf;
            let alltxt;

            pdf = await pdfjsLib.getDocument(url).promise;
            let pages = pdf.numPages;

            for (let i = 1; i <= pages; i++) {
                let page = await pdf.getPage(i);
                let txt = await page.getTextContent();
                let text = txt.items.map((s)=> {
                    s.str;
                    if (!isEmptyOrSpaces(s.str.trim())) {
                        arr.push(s.str.trim());
                    }
                });       
            }
            
            // Clean the extracted text
            arr = cleanExtractedText(arr);
            // END

            // Extract Year
            alltxt = arr.join(' ');
            var year = extractYear(alltxt);
            // END

            // EXTRACT ABSTRACT
            abstract = arr.slice(arr.indexOf('ABSTRACT')+1, arr.indexOf('Keywords:'));
            let fabstract = abstract.join(' ');
            // END 

            // EXTRACT KEYWORDS
            const keywordsRegex = /Keywords\s*:/i;
            const tableOfContentsRegex = /\bTABLE\b/i; // ITO LANG BINAGO KO

            const keywordsIndex = arr.findIndex(line => keywordsRegex.test(line));
            const tableOfContentsIndex = arr.findIndex(line => tableOfContentsRegex.test(line));

            if (keywordsIndex !== -1 && tableOfContentsIndex !== -1) {
                keys = arr.slice(keywordsIndex + 1, tableOfContentsIndex - 1); // NILAGYAN KO LANG NG -1 PARA MATANGGAL YUNG PAGE
                let keywords = keys.join(' ');
                document.getElementById('keywords').value = keywords;
            } else {
                keys = [];
                let keywords = '';
                document.getElementById('keywords').value = keywords;
            }
            // END



            // EXTRACT FIRST PAGE
            title = firstPage.slice(0, firstPage.indexOf("A"));
            let ftitle = title.join(' ');
            // END
            
            document.getElementById('title').value = ftitle;
            document.getElementById('year').value = year;
            document.getElementById('abstract').value = fabstract;
            document.getElementById('keywords').value = keywords;

            // Show the hidden section
            document.getElementById('parsedData').removeAttribute('hidden');
        }
    });

    function extractYear(text) {
        var yearRegex = /\b\d{4}\b/;
        var matches = text.match(yearRegex);
        if (matches) {
            var year = parseInt(matches[0]);
            if (year >= 1900 && year <= 2100) {
                return year.toString();
            }
        }
        return '';
    }

    document.querySelector('.submit').addEventListener('click', function() {
        document.getElementById('uploadForm').submit();
    });

    // Function to clean extracted text
    function cleanExtractedText(textArray) {
        let cleanedText = [];
        let skip = false;
        
        for (let word of textArray) {
            if (word.includes('Title')) {
                skip = true;
                continue;
            } else if (word.includes('Technology') || word.includes('Engineering')) {
                skip = false;
                continue;
            }
            
            if (!skip) {
                cleanedText.push(word);
            }
        }
        
        return cleanedText;
    }
</script>
