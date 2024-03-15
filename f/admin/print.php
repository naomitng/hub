<?php

ob_start();

date_default_timezone_set('Asia/Manila');
include '../includes/header.php';
$page_title = "Statistics";


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

require_once('../../vendor/tcpdf/tcpdf.php');  
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator('Research Hub');
$pdf->SetAuthor('Research Hub');
$pdf->SetTitle('Statistics Report');
$pdf->SetSubject('Statistics Report');
$pdf->SetKeywords('Statistics, PDF');

$pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, 'Research Hub', 'Statistics Report Generated on ' . date('Y-m-d H:i:s'));
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->AddPage();

$pdf->Image('../img/logo.png', 33, 1, 15, 15, 'PNG', '', '', false, 300, '', false, false, 0);

$pdf->SetFont('dejavusans', '', 10);  
$content = '';  
$content .= '
    <h2 align="center">Statistics Report</h2>
    <table border="1" cellspacing="0" cellpadding="3">  
';  

$content .= '<tr><td width="80%">Total Studies</td><td width="20%" align="center">' . $totalStudies . '</td></tr>';

$content .= '<tr><th colspan="2" align="center" style="font-weight: bold;">Studies by Department</th></tr>';
foreach ($deptData as $dept) {
    $content .= '<tr><td>' . $dept['dept'] . '</td><td align="center">' . $dept['count'] . '</td></tr>';
}

$content .= '<tr><th colspan="2" align="center" style="font-weight: bold;">Studies by Year</th></tr>';
foreach ($yearData as $year) {
    $content .= '<tr><td>' . $year['year'] . '</td><td align="center">' . $year['count'] . '</td></tr>';
}

$content .= '<tr><th colspan="2" align="center" style="font-weight: bold;">Number of Studies in Archive</th></tr>';
$content .= '<tr><td>Archive Count</td><td align="center">' . $archiveCount . '</td></tr>';

$content .= '</table>';  

$pdf->writeHTML($content);  

ob_end_clean();

$pdf->Output('ResearchHub_Statistics_Report_' . date('Y-m-d_H-i-s') . '.pdf', 'I');
?>
