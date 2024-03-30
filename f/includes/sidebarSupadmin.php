 <!-- Sidebar -->
    <div class="flex-shrink-0 p-3 dash" id="adminside" style="width: 280px; height: 100%;">
        <div class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">

            <!-- Logo -->
            <a href="aDashboard.php" style=" text-decoration: none;"><img src="../img/logo.png" alt="" style="width: 40px;">
            <span style="font-size: 25px; color: #28282B;">Research Hub</span></a>
            
        </div>
        <ul class="list-unstyled ps-0">

            <!-- List for the departments -->
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
                    Data Analytics
                </button>

                <!-- Departments -->
                <div class="collapse" id="home-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="popularity.php" class="link-dark rounded">Popular studies</a></li>
                        <li><a href="contributor.php" class="link-dark rounded">Admin contributors</a></li>
                        <li><a href="statistics.php" class="link-dark rounded">Statistical report</a></li>
                    </ul>
                </div>
            </li>

            <!-- List for the dashboard -->
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                    Manage requests
                </button>

                <!-- Under dashboard -->
                <div class="collapse" id="dashboard-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="aRequests.php" class="link-dark rounded">Account request approval </a></li>
                        <li><a href="capstone_reqs.php" class="link-dark rounded">Capstone request approval</a></li>
                    </ul>
                </div>
            </li>

            <!-- Account setting -->
            <li class="border-top">
                <button class="btn btn-toggle align-items-center rounded collapsed mt-3" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                    <?php echo "Hello, Super Admin"; ?>
                </button>

                <!-- Under account settings -->
                <div class="collapse" id="account-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="../supadmin/logout.php" class="link-dark rounded">Sign out</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</body>
</html>