<?php
ob_start();

date_default_timezone_set('Asia/Manila');

include '../includes/header.php';

$stmt = $pdo->query("SELECT COUNT(*) AS total FROM `studies`");
$totalStudies = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmtDept = $pdo->query("SELECT dept, COUNT(*) AS count FROM `studies` GROUP BY dept");
$deptData = $stmtDept->fetchAll(PDO::FETCH_ASSOC);

$stmtYear = $pdo->query("SELECT year, COUNT(*) AS count FROM `studies` GROUP BY year");
$yearData = $stmtYear->fetchAll(PDO::FETCH_ASSOC);

$stmtArchive = $pdo->query("SELECT COUNT(*) AS count FROM `archive`");
$archiveCount = $stmtArchive->fetch(PDO::FETCH_ASSOC)['count'];

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

$stmtPopularity = $pdo->prepare("SELECT title, popularity FROM studies WHERE verified = 1 ORDER BY popularity DESC LIMIT 10");
$stmtPopularity->execute();
$popularity_data = $stmtPopularity->fetchAll(PDO::FETCH_ASSOC);

$stmt_contributions = $pdo->prepare("SELECT CONCAT(a.fname, ' ', a.lname) AS full_name, COUNT(*) as contribution_count FROM studies s JOIN admin a ON s.contributor = a.id GROUP BY s.contributor ORDER BY contribution_count DESC");
$stmt_contributions->execute();
$contributions = $stmt_contributions->fetchAll(PDO::FETCH_ASSOC);

require_once('../../vendor/tcpdf/tcpdf.php');  
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator('Research Hub');
$pdf->SetAuthor('Research Hub');
$pdf->SetTitle('Statistics Report');
$pdf->SetSubject('Statistics Report');
$pdf->SetKeywords('Statistics, PDF');

$pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, 'Reseach Hub', 'Statistics Report Generated on ' . date('Y-m-d H:i:s'));
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

$content .= '<tr><th colspan="2" align="center" style="font-weight: bold;">Top 10 Popular Studies</th></tr>';
foreach ($popularity_data as $study) {
    $content .= '<tr><td>' . $study['title'] . '</td><td align="center">' . $study['popularity'] . '</td></tr>';
}

$content .= '<tr><th colspan="2" align="center" style="font-weight: bold;">Contribution</th></tr>';
foreach ($contributions as $contribution) {
    $content .= '<tr><td>' . $contribution['full_name'] . '</td><td align="center">' . $contribution['contribution_count'] . '</td></tr>';
}

$content .= '</table>';  

$pdf->writeHTML($content);  

ob_end_clean();

$pdf->Output('ResearchHub_Statistics_Report_' . date('Y-m-d_H-i-s') . '.pdf', 'I');
?>
