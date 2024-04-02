<?php
session_start();
if (!isset($_SESSION['supadmin'])) {
    // Redirect the user to the sign-in page
    header('Location: ../admin/aSignIn.php');
    exit(); 
}

$page_title = "Statistics";
include '../includes/header.php';
include '../includes/sidebarSupadmin.php';
echo "<link rel='stylesheet' type='text/css' href='../css/aDashStyle.css'>";
echo "<link rel='stylesheet' type='text/css' href='../css/scrollbar.css'>";
echo "<link rel='stylesheet' type='text/css' href='../css/statistics.css'>";

// Retrieve data and count occurrences
$stmt = $pdo->query("SELECT COUNT(*) AS total FROM `studies`");
$totalStudies = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Example: Count studies by department
$stmtDept = $pdo->query("SELECT dept, COUNT(*) AS count FROM `studies` GROUP BY dept");
$deptData = $stmtDept->fetchAll(PDO::FETCH_ASSOC);

// Example: Count studies by year
$stmtYear = $pdo->query("SELECT year, COUNT(*) AS count FROM `studies` GROUP BY year");
$yearData = $stmtYear->fetchAll(PDO::FETCH_ASSOC);

$yearLabels = [];
$yearlyStudiesData = [];

$currentYear = 2020;
$currentYearIndex = 0;

for ($i = $currentYear; $i <= date('Y'); $i++) {
    // Check if data exists for the current year
    if ($currentYearIndex < count($yearData) && $yearData[$currentYearIndex]['year'] == $i) {
        $yearLabels[] = $i;
        $yearlyStudiesData[] = $yearData[$currentYearIndex]['count'];
        $currentYearIndex++;
    } else {
        // If no data exists for the current year, set count to 0
        $yearLabels[] = $i;
        $yearlyStudiesData[] = 0;
    }
}

// Count number of studies in the archive table
$stmtArchive = $pdo->query("SELECT COUNT(*) AS count FROM `archive`");
$archiveCount = $stmtArchive->fetch(PDO::FETCH_ASSOC)['count'];

// Get number of studies in IT and CpE departments
$stmtITCpE = $pdo->query("SELECT dept, COUNT(*) AS count FROM `studies` WHERE dept IN ('Information Technology', 'Computer Engineering') GROUP BY dept");
$itCpeData = $stmtITCpE->fetchAll(PDO::FETCH_ASSOC);
$itCount = 0;
$cpeCount = 0;
foreach ($itCpeData as $dept) {
    if ($dept['dept'] == 'Information Technology') {
        $itCount = $dept['count'];
    } elseif ($dept['dept'] == 'Computer Engineering') {
        $cpeCount = $dept['count'];
    }
}

// popular stuidies
$stmtPopularity = $pdo->prepare("SELECT title, popularity FROM studies WHERE verified = 1");
$stmtPopularity->execute();
$popularity_data = $stmtPopularity->fetchAll(PDO::FETCH_ASSOC);

// admin contributors
$stmt_contributions = $pdo->prepare("SELECT CONCAT(a.fname, ' ', a.lname) AS full_name, COUNT(*) as contribution_count FROM studies s JOIN admin a ON s.contributor = a.id GROUP BY s.contributor");
$stmt_contributions->execute();
$contributions = $stmt_contributions->fetchAll(PDO::FETCH_ASSOC);

$admin_names = [];
$contribution_counts = [];

foreach ($contributions as $contribution) {
    $admin_names[] = $contribution['full_name'];
    $contribution_counts[] = $contribution['contribution_count'];
}


?>

<div id="content" class="h-100">
    <ul class="list-group">
        <li class="list-group-item p-4">
            <h2>Statistical for Research Hub Database
                <a href="print.php" target="_blank" class="btn btn-warning float-end">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                    </svg> Download report
                </a>
            </h2>

            <div class="d-flex justify-content-between align-items-center">
                <!-- Previous/back link -->
                <a href="aDashboard.php" class="text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg> Back to dashboard
                </a>
            </div>

            <ul style="list-style-type: none; margin: 0; padding: 0;" class="p-3 rounded ulInside mt-3">
                <h3 style="margin: 0;">Total Studies: <?php echo $totalStudies; ?></h3>
            </ul>


            <ul style="list-style-type: none;" class="p-3 rounded ulInside mt-3">
                <li>
                    <input type="hidden" name="report_type" value="it_cpe">
                    <h2>IT vs CpE report</h2>
                    <p>This report focuses on studies from the <a href="infotech.php">Information Technology</a> <br>and <a href="comEng.php">Computer Engineering</a> departments stored in the Research Hub database.</p>
                    <!-- place chart here -->
                    <div style="display: flex; justify-content: center;">
                        <canvas id="itCpeChart" width="400" height="300"></canvas>
                        <script>
                            var ctx2 = document.getElementById('itCpeChart').getContext('2d');
                            var itCpeChart = new Chart(ctx2, {
                                type: 'pie',
                                data: {
                                    labels: ['IT', 'CpE'],
                                    datasets: [{
                                        label: 'Total Studies',
                                        data: [<?php echo $itCount; ?>, <?php echo $cpeCount; ?>],
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: false,
                                    maintainAspectRatio: false,
                                    width: 400,
                                    height: 300,
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                        </script>
                    </div>
                </li>
            </ul>
            <ul style="list-style-type: none;" class="p-3 rounded ulInside mt-3">
                <li>
                    <input type="hidden" name="report_type" value="archive">
                    <h2>Archive report</h2>
                    <p>This report shows the number of studies <a href="archive.php">archived</a> in the Research Hub database.</p>
                    <!-- place chart here -->
                    <div style="display: flex; justify-content: center;">
                        <canvas id="archiveChart" width="400" height="300"></canvas>
                        <script>
                            var ctx = document.getElementById('archiveChart').getContext('2d');
                            var archiveChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: ['Archive'],
                                    datasets: [{
                                        label: 'Number of Studies',
                                        data: [<?php echo $archiveCount; ?>],
                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: false,
                                    maintainAspectRatio: false,
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                        </script>
                    </div>
                </li>
            </ul>
            <ul style="list-style-type: none;" class="p-3 rounded ulInside mt-3">
                <li>
                    <input type="hidden" name="report_type" value="yearly_studies">
                    <h2>Yearly Studies Report</h2>
                    <p>This report shows the number of studies conducted each year from 2020 to 2024 in the Research Hub database.</p>
                    <!-- place chart here -->
                    <div style="display: flex; justify-content: center;">
                        <canvas id="yearlyStudiesChart" width="400" height="300"></canvas>
                        <script>
                            var ctx = document.getElementById('yearlyStudiesChart').getContext('2d');
                            var yearlyStudiesChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: <?php echo json_encode($yearLabels); ?>,
                                    datasets: [{
                                        label: 'Number of Studies',
                                        data: <?php echo json_encode($yearlyStudiesData); ?>,
                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: false,
                                    maintainAspectRatio: false,
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                        </script>
                    </div>
                </li>
            </ul>
            <ul style="list-style-type: none;" class="p-3 rounded ulInside mt-3">
                <li>
                    <input type="hidden" name="report_type" value="contribution">
                    <h2>Popularity</h2>
                    <p>This report focuses on popularity of a study based on clicks or visits.</p>
                    <!-- place chart here -->
                    <div style="display: flex; justify-content: center;">
                        <canvas id="popularityChart" width="400" height="300"></canvas>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var ctx = document.getElementById('popularityChart').getContext('2d');

                                // PHP variables containing popularity data
                                var studies = <?php echo json_encode(array_column($popularity_data, 'title')); ?>;
                                var popularityData = <?php echo json_encode(array_column($popularity_data, 'popularity')); ?>;
                                
                                // Filter out data points with zero popularity
                                var filteredStudies = [];
                                var filteredPopularityData = [];
                                for (var i = 0; i < popularityData.length; i++) {
                                    if (popularityData[i] !== 0) {
                                        filteredStudies.push(studies[i]);
                                        filteredPopularityData.push(popularityData[i]);
                                    }
                                }

                                var customLabels = filteredStudies.map(function(title, index) {
                                    return 'Study ' + (index + 1);
                                });

                                var popularityChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: customLabels,
                                        datasets: [{
                                            label: 'Popularity',
                                            data: filteredPopularityData,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.2)',
                                                'rgba(54, 162, 235, 0.2)',
                                                'rgba(255, 206, 86, 0.2)',
                                                'rgba(75, 192, 192, 0.2)',
                                                'rgba(153, 102, 255, 0.2)',
                                                'rgba(255, 159, 64, 0.2)'
                                            ],
                                            borderColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(255, 159, 64, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: false,
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        },
                                        plugins: {
                                            tooltip: {
                                                callbacks: {
                                                    label: function(context) {
                                                        var dataIndex = context.dataIndex;
                                                        var studyTitle = filteredStudies[dataIndex];
                                                        var popularityCount = filteredPopularityData[dataIndex];
                                                        return popularityCount + ': ' + studyTitle;
                                                    }
                                                }
                                            },
                                            legend: {
                                                display: false,
                                            }
                                        }
                                    }
                                });
                            });
                        </script>
                    </div>
                </li>
            </ul>
            <ul style="list-style-type: none;" class="p-3 rounded ulInside mt-3">
                <li>
                    <input type="hidden" name="report_type" value="contribution">
                    <h2>Contribution</h2>
                    <p>This report focuses on how many studies uploaded by each admin.</p>
                    <!-- place chart here -->
                    <div style="display: flex; justify-content: center;">
                        <canvas id="contributionsChart" width="400" height="300"></canvas>
                        <script>
                            var ctx = document.getElementById('contributionsChart').getContext('2d');
                            var adminNames = <?php echo json_encode($admin_names); ?>;
                            var contributionCounts = <?php echo json_encode($contribution_counts); ?>;

                            var contributionChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: adminNames,
                                    datasets: [{
                                        label: 'Contributions',
                                        data: contributionCounts,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true,

                                            precision: 0
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: false,
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</div>
</body>
</html>
