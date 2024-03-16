<?php
    $page_title = "Research Hub";
    include '../includes/header.php';
    echo "<link rel='stylesheet' type='text/css' href='../css/landing.css'>";
?>
<body style="height: 100vh; background-color: #f5f5f5; margin-bottom: 0;">
    <!-- Header --> 
    <header id="header"></header>
    <!-- Main content --> 
    <div class="d-flex flex-column align-items-center justify-content-center"  style="height: 40%;">
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
    <script>
        const imgPaths = [
            '../img/bg-quad.jpg',
            '../img/bg-rtu.jpg',
        ];
        let currentIndex = 0;
        function changeBackground() {
            const header = document.getElementById('header');
            header.style.backgroundImage = `url(${imgPaths[currentIndex]})`;
            currentIndex = (currentIndex + 1) % imgPaths.length;
        }
        const intervalId = setInterval(changeBackground, 3000); // Change image every 3 seconds
        window.addEventListener('beforeunload', () => {
            clearInterval(intervalId);
        });
    </script>
</body>

