<?php
include '../config/_config.php';
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=reports.csv');

$output = fopen("php://output", "w");
fputcsv($output, array('ID', 'Salesperson', 'Client Name', 'Client Number', 'Status', 'Date'));

$result = $conn->query("SELECT id, salesperson_id, client_name, client_phone, status, created_at FROM client_visits");
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}
fclose($output);
?>
