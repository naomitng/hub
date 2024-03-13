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
                    Departments
                </button>

                <!-- Departments -->
                <div class="collapse" id="home-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="infotech.php" class="link-dark rounded">Information Technology</a></li>
                        <li><a href="comEng.php" class="link-dark rounded">Computer Engineering</a></li>
                    </ul>
                </div>
            </li>

            <!-- List for the dashboard -->
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                    Dashboard
                </button>

                <!-- Under dashboard -->
                <div class="collapse" id="dashboard-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="contribute.php" class="link-dark rounded">Contribute</a></li>
                        <li><a href="statistics.php" class="link-dark rounded">See Statistics</a></li>
                        <li><a href="mAdvisers.php" class="link-dark rounded">Manage Advisers</a></li>
                        <li><a href="aRequests.php" class="link-dark rounded">Admin Account Requests</a></li>
                        <li><a href="archive.php" class="link-dark rounded">Archive</a></li>
                    </ul>
                </div>
            </li>

            <!-- List for filter -->
            <li class="">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#filter-collapse" aria-expanded="false">
                    Filter searches
                </button>

                <!-- Year -->
                <div class="collapse" id="filter-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="filter.php?year=2020" class="link-dark rounded">Since 2020</a></li>
                        <li><a href="filter.php?year=2021" class="link-dark rounded">Since 2021</a></li>
                        <li><a href="filter.php?year=2022" class="link-dark rounded">Since 2022</a></li>
                        <li><a href="filter.php?year=2023" class="link-dark rounded">Since 2023</a></li>
                        <li><a href="filter.php?year=2024" class="link-dark rounded">Since 2024</a></li>
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