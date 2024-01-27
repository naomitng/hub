<?php
    $page_title = "Research Hub";
    include '../includes/header.php';

    echo "<link rel='stylesheet' type='text/css' href='../css/landing.css'>";
?>

<body style="height: 100vh; background-color: #f5f5f5; margin-bottom: 0;">

    <!-- Header --> 
    <header></header>

    <!-- Main content --> 
    <div class="d-flex flex-column align-items-center justify-content-center"  style="height: 40%;">

        <!-- Import search bar using php --> 
        <?php
            include '../includes/searchbar.php';
        ?>

        <!-- Quote -->
        <i class="text-muted mt-3">&ldquo;Everything you can imagine is real&rdquo; &#8212; Pablo Picasso</i>

    </div>

    <!-- Footer -->
    <?php 
        include '../includes/footer.php';
    ?>

</body>

