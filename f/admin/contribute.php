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
    
$errMsg = '';
if (isset($_POST['submit'])) {
    $dir = 'uploads/';
    $filename = basename($_FILES['file']['name']);
    $newname = $dir . $filename;
    $filetype = pathinfo($newname, PATHINFO_EXTENSION);

    if ($filetype == "jpg" || $filetype == "png") {
        if(move_uploaded_file($_FILES['file']['tmp_name'], $newname)) {
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

            <!-- file upload && form -->
            <form id="uploadForm" action="" method="post" enctype="multipart/form-data">
                <div class="row justify-content-center align-items-center">
                    <div class="col mt-4">
                        <input class="form-control" name="file" type="file" id="formFile" accept=".pdf, image/*" multiple required>
                    </div>
                </div>

                <div id="parsedData">
                    <!-- title -->
                    <div class="form-floating mb-4 mt-4">
                        <input type="text" name="title" class="form-control" id="title" placeholder="Title" required>
                        <label for="authors">Title</label>
                    </div>
                    <!-- authors -->
                    <div class="form-floating mb-4">
                        <input type="text" name="authors" class="form-control" id="authors" placeholder="Authors" required>
                        <label for="authors">Authors</label>
                        <p class="text-muted mt-1">Ex. Haesser Naomi Ting, Mizzy Perez, Iresh Sajulga, Frahser Jay Tayag, Jed Allen Gubot</p>
                    </div>
                    <div class="row">
                        <!-- abstract -->
                        <div class="col-md">
                            <div class="form-floating">
                                <textarea class="form-control abstract" name="abstract" placeholder="Abstract" id="abstract" style="height: 408px;" required></textarea>
                                <label for="abstract">Abstract</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <!-- year -->
                            <div class="form-floating mb-4">
                                <input type="text" name="year" class="form-control" id="year" placeholder="Year" oninput="validateNumericInput(this)" required>
                                <label for="year">Year</label>
                            </div>
                            <!-- adviser -->
                            <div class="form-floating mb-4">
                                <input type="text" name="adviser" class="form-control" id="adviser" placeholder="Adviser" required>
                                <label for="adviser">Adviser</label>
                            </div>
                            <!-- department -->
                            <div class="form-floating">
                                <select class="form-select" name="dept" id="selectDept" aria-label="Floating label select example" required>
                                    <option value='' selected disabled>Choose a department</option>
                                    <option value="Information Technology">Information Technology</option>
                                    <option value="Computer Engineering">Computer Engineering</option>
                                </select>
                                <label for="selectDept">Department</label>
                            </div>
                            <!-- keywords -->
                            <div class="form-floating mt-4">
                                <input type="text" name="keywords" class="form-control" id="keywords" placeholder="Keywords" required>
                                <label for="keywords">Keywords</label>
                            </div>
                            <!-- Terms -->
                            <div class="mb-3 mt-3">
                                <input type="checkbox" name="check" id="check" required>
                                <label for="check" class=""> Agree to our<button type="button" class="btn btn-link check" data-bs-toggle="modal" name="privacypol" title="privacypol" data-bs-target="#privacypol">Terms, Conditions, Privacy and Policies</button>
</label>
                            </div>

                            <!-- Modal for Terms and Conditions -->
                            <div class="modal fade" id="privacypol" tabindex="-1" aria-labelledby="privacypolLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="termsModalLabel">Terms, Condition, Privacy and Policies</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="privacytxt">
                                            <b>Terms and Conditions</b>
                                                <br>Research Hub Capstone Repository System is governed by these Terms & Conditions. You acknowledge and agree to be governed by these Terms by accessing or using the Library.  You are not permitted to access or use the Library if you disagree with any element of these Terms.

                                                <br><br><b>I. Access and Use</b>
                                                <br>- Students, Alumni and Guest may use this online library solely for instructional purposes.
                                                - The library's resources can be accessed without logging in.
                                                - It is your responsibility to use the library in a civil and compliant manner.

                                                <br><br><b>II. Content and Copyright</b>
                                                <br>- Copyright and other intellectual property laws protecting the materials in the library.
                                                - Without express explicit consent from the copyright holder, you are not permitted to distribute, alter, or sell any of the library's content.
                                                - It is your obligation to ascertain and abide by any particular copyright limitations connected to particular resources.

                                                <br><br><b>III. User Conduct</b>
                                                <br>- You commit to making polite and legal use of the Research Hub.
                                                - You promise not to use the Library for any unlawful or illegal activities.

                                                <br><br><b>IV. Intellectual Property</b>
                                                <br>- The Research Hub is copyright protected, as is everything on it.

                                                <br><br><b>V. Changes to Terms & Conditions</b>
                                                <br>- We reserve the right to update this website with revisions to these Terms.
                                                - Any updates shall be binding on you, so you should routinely check this page to make sure you are aware of the most recent Terms.

                                                <br><br><b>VI. Termination</b>
                                                <br>- Your capstone research may be terminated by us at any moment and for any reason.
                                                - Additionally, we may end these Terms at any time by sending you notice.

                                                <br><br><b>VII. Contact Us</b>
                                                <br>- Please contact the head of the RTU BS Information Technology Department Faculty if you have any issues concerning these terms.

                                                <br><br><b>Privacy Policy</b>
                                                <br>Research Hub is dedicated to maintaining our faculty, staff, and former students' private information. This privacy statement describes how we gather, use, share, and protect the information we get from you on our website and other services.

                                                <br><br><b>I. Information Gathering</b>
                                                <br>Your name, email address, student ID, and any other information required to deliver our services are among the details we may have collected from you when you turned in your capstone project on our head of the BS Information Technology Department.

                                                <br><br><b>II. Security of Information</b>
                                                <br>We have put in place the proper organizational and technical precautions to ensure the protection of any personal data we handle. Please keep in mind, nevertheless, that we are unable to provide complete security on the internet. You bear all liability for the transmission of personal information to and from our website, even if we will take reasonable precautions to protect it. Only in a safe and secure setting should you use the services.

                                                <br><br><b>III. Access to Your Data</b>
                                                <br>You are entitled to see, edit, or remove your personal data. Please visit the head of the department for BS Information Technology to accomplish this.

                                                <br><br><B>IV. Modifications to this Privacy Statement</B>
                                                <br>This Privacy Policy may be updated periodically by us for operational, legal, or regulatory purposes, or to reflect changes to our operations, among other reasons.

                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- submit button -->
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

<script src="../script/ocr.js"></script>
<script src="../script/pdf.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
