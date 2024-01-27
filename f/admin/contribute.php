<?php
    $page_title = "Contribute";
    include '../includes/header.php';
    include '../includes/sidebarAdmin.php';

    echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";
    echo "<link rel='stylesheet' href='../css/contribute.css'>";

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
            <form action="" method="post" class="needs-validation" novalidate>
                <div class="form-floating mb-4 mt-3 ">
                <label for="title" class="form-label">City</label>
                    <input type="text" class="form-control" id="title" required>
                    <div class="invalid-feedback">
                        Please provide a valid city.
                    </div>
                </div>

                <div class="form-floating mb-4">
                    <input type="text" class="form-control" id="authors" placeholder="Authors">
                    <label for="authors">Authors</label>
                    <div class="invalid-feedback">
                        Author(s) is required
                    </div>
                </div>

                <div class="row">
                    <div class="col-md">
                        <div class="form-floating">
                            <textarea class="form-control abstract" placeholder="Abstract" id="abstract" style="height: 330px;"></textarea>
                            <label for="abstract">Abstract</label>
                        </div>
                        <div class="invalid-feedback">
                            Abstract is require
                        </div>
                    </div>

                    <div class="col-md">
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="year" placeholder="Year" oninput="validateNumericInput(this)">
                        <label for="year">Year</label>
                        <div class="invalid-feedback">
                            Year is required
                        </div>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="adviser" placeholder="sampleTitle">
                        <label for="floatingInput">Adviser</label>
                        </div>
                        <div class="form-floating">
                            <select class="form-select" id="selectDept" aria-label="Floating label select example">
                                <option selected>Choose a department</option>
                                <option value="1">Information Technology</option>
                                <option value="2">Computer Engineering</option>
                            </select>
                            <label for="selectDept">Department</label>
                            <div class="invalid-feedback">
                                Department is required
                            </div>
                        </div>
                        <div class="mt-3">
                            <input class="form-control" type="file" id="formFile">
                            <div class="invalid-feedback">
                                File is required
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning mt-4 w-100 submit">Submit</button>
                    </div>
                </div>
            </form>
        </li>
</div>

<script>
    function validateNumericInput(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
    }

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
        'use strict';

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation');

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>