<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
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


$pdo = new PDO("mysql:host=127.0.0.1; dbname=hub", "root", "");

// Retrieve data and count occurrences
$stmt = $pdo->query("SELECT COUNT(*) AS total FROM `studies`");
$totalStudies = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Example: Count studies by department
$stmtDept = $pdo->query("SELECT dept, COUNT(*) AS count FROM `studies` GROUP BY dept");
$deptData = $stmtDept->fetchAll(PDO::FETCH_ASSOC);

// Example: Count studies by year
$stmtYear = $pdo->query("SELECT year, COUNT(*) AS count FROM `studies` GROUP BY year");
$yearData = $stmtYear->fetchAll(PDO::FETCH_ASSOC);

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
?>

<div id="content" class="h-100">
    <ul class="list-group">
        <li class="list-group-item p-4">
            <h3>Statistical for Research Hub database:</h3>
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
                                        label: 'IT and CpE Studies',
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
                                    labels: ['2020', '2021', '2022', '2023', '2024'],
                                    datasets: [{
                                        label: 'Number of Studies',
                                        data: [<?php echo $yearData[0]['count']; ?>, <?php echo $yearData[1]['count']; ?>, <?php echo $yearData[2]['count']; ?>, <?php echo $yearData[3]['count']; ?>, <?php echo $yearData[4]['count']; ?>],
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
        </li>
    </ul>
</div>
</body>
</html>
