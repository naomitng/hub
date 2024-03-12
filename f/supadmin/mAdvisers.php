<?php

    session_start();
    if (!isset($_SESSION['supadmin'])) {
        // Redirect the user to the sign-in page
        header('Location: ../admin/aSignIn.php');
        exit();
    }

    $page_title = "Manage Advisers";
    include '../includes/header.php';
    include '../includes/sidebarSupadmin.php';

    echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/mAdvisers.css'>";

    $pdo = new PDO("mysql:host=127.0.0.1;dbname=hub", 'root', '');

    $sucMsg = "";
    $errMsg = "";

    // save/add advisers
    if(isset($_POST['save'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $dept = $_POST['dept'];
        try {
            $stmt = $pdo->prepare("INSERT INTO `advisers` (`name`, `email`, `dept`) VALUES (:name, :email, :dept)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':dept', $dept);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $errMsg = "Error: " . $e->getMessage();
        }
    } 
    
    // delete button
    if(isset($_POST['delete'])) {
        $adviser_id = $_POST['adviser_id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM `advisers` WHERE id = :id");
            $stmt->bindParam(':id', $adviser_id);
            $stmt->execute();
            
        } catch (PDOException $e) {
            $errMsg = "Error deleting adviser: " . $e->getMessage();
        }
    }
    
    // edit button
    if(isset($_POST['saveChanges'])) {
        $adviser_id = $_POST['adviser_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $dept = $_POST['dept'];
        try {
            $stmt = $pdo->prepare("UPDATE advisers SET name = :name, email = :email, dept = :dept WHERE id = :id");
            $stmt->bindParam(':id', $adviser_id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':dept', $dept);
            $stmt->execute();
        } catch (PDOException $e) {
            
        }
    }

    // display advisers
    try {
        $stmt = $pdo->prepare("SELECT * FROM `advisers`");
        $advisers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $errMsg = "Error fetching advisers: " . $e->getMessage();
    }

    try {
        // Check if a search term is provided
        if(isset($_GET['search'])) {
            $search = $_GET['search'];
            $stmt = $pdo->prepare("SELECT * FROM `advisers` WHERE name LIKE :search");
            $stmt->bindValue(':search', "%$search%");
        } else {
            // If no search term provided, fetch all advisers
            $stmt = $pdo->prepare("SELECT * FROM `advisers`");
        }
        $stmt->execute();
        $advisers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $errMsg = "Error fetching advisers: " . $e->getMessage();
    }
?>

<!-- Content Area -->
<div id="content">
    <!-- Search bar -->
    <form class="search" method="get">
        <i class="fa fa-search"></i>
        <input type="text" class="form-control" placeholder="Search" name="search">
        <button class="btn btn-warning" type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </button>
    </form>

    <!-- List of advisers -->
    <ul class="list-group mt-5 mb-5">
        <li class="list-group-item p-4">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Previous/back link -->
                <a href="aDashboard.php" class="text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg> Back to dashboard
                </a>
                <!-- Add adviser button -->
                <button type="button" class="btn btn-warning addbtn" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                    </svg>
                </button>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                    <!-- Form for add adviser -->
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="" method="post">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="addModalLabel">Add adviser</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 17px;"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" class="form-control" id="id">
                                    <div class="mb-3">
                                        <label for="name" class="col-form-label" style="font-size: 17px;">Name:</label>
                                        <input type="text" name="name" class="form-control" id="name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="col-form-label" style="font-size: 17px;">Email address:</label>
                                        <input type="text" name="email" class="form-control" id="email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="dept" class="col-form-label" style="font-size: 17px;">Department:</label>
                                        <select class="form-select" aria-label="Default select example" name="dept" id="dept">
                                            <option selected>Choose a department</option>
                                            <option value="Information Technology">Information Technology</option>
                                            <option value="Computer Engineering">Computer Engineering</option>
                                        </select>
                                    </div>  
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="save" class="btn btn-warning addbtn">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Advisers --> 
            <?php foreach ($advisers as $adviser): ?>
                <ul style="list-style-type: none;" class="p-3 rounded ulInside mt-4">
                    <!-- Name -->
                    <li class="list-group-item-title d-flex">
                        <a href="" class=" text-decoration-none text-dark" style="pointer-events: none;"><?php echo $adviser['name']; ?></a>
                        <!-- Button group for edit and delete -->
                        <div class="ml-auto">
                            <!-- Delete form -->
                            <form action="" method="post">
                                <input type="hidden" name="adviser_id" value="<?php echo $adviser['id']; ?>" >
                                <button type="button" name="delete" class="btn btn-link text-secondary" data-bs-toggle="modal" data-bs-target="#delete_<?php echo $adviser['id']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>  
                                </button>
                                <!-- Modal for delete confirmation -->
                                <div class="modal fade" id="delete_<?php echo $adviser['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel_<?php echo $adviser['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel_<?php echo $adviser['id']; ?>">Confirm deletion</h5>
                                            </div>
                                            <div class="modal-body" style="font-size: 17px;"> <!-- Set the font size here -->
                                                Are you sure you want to delete <span style="color: blue; font-weight: bold;"> <?php echo $adviser['name']; ?> </span> from the list?
                                            </div>
                                            <div class="modal-footer mr-auto">
                                                <div class="row">
                                                    <div class="col">
                                                        <button type="button" class="btn btn-danger btn-block" data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                    <div class="col">
                                                        <button type="submit" class="btn btn-secondary btn-block" name="delete">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button to trigger edit modal -->
                                <button type="button" class="btn btn-link text-secondary" data-bs-toggle="modal" data-bs-target="#editModal_<?php echo $adviser['id']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </button>
                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal_<?php echo $adviser['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel_<?php echo $adviser['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel_<?php echo $adviser['id']; ?>">Edit adviser</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 17px;"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="adviser_id" value="<?php echo $adviser['id']; ?>">
                                                    <div class="mb-3">
                                                        <label for="name" class="col-form-label" style="font-size: 17px;">Name:</label>
                                                        <input type="text" name="name" class="form-control" id="name" value="<?php echo $adviser['name']; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email" class="col-form-label" style="font-size: 17px;">Email address:</label>
                                                        <input type="text" name="email" class="form-control" id="email" value="<?php echo $adviser['email']; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="dept" class="col-form-label" style="font-size: 17px;">Department:</label>
                                                        <select class="form-select" aria-label="Default select example" name="dept" id="dept">
                                                            <option selected>Choose a department</option>
                                                            <option value="Information Technology" <?php if($adviser['dept'] == 'Information Technology') echo 'selected'; ?>>Information Technology</option>
                                                            <option value="Computer Engineering" <?php if($adviser['dept'] == 'Computer Engineering') echo 'selected'; ?>>Computer Engineering</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="saveChanges" class="btn btn-warning addbtn">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                    <!-- Adviser information -->
                    <li class="text-muted">Email: <?php echo $adviser['email']; ?></li>
                    <li class="text-muted">Department of <?php echo $adviser['dept']; ?> </li>
                </ul>
            <?php endforeach; ?>
       </li>
    </ul>
    <?php
    // Check if there are 5 or more entries
    if (count($advisers) >= 5) {
        echo '
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
            ';
        }   
    ?>
</div>
