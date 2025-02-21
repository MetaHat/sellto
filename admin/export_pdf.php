<?php
require('../vendor/autoload.php');
use Dompdf\Dompdf;

$dompdf = new Dompdf();
ob_start();
?>
<html>
<head><title>Client Visit Reports</title></head>
<body>
<h2>Client Visit Reports</h2>
<table border="1">
<tr><th>ID</th><th>Salesperson</th><th>Client</th><th>Status</th><th>Date</th></tr>
<?php
$result = $conn->query("SELECT * FROM client_visits");
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['id']}</td><td>{$row['salesperson_id']}</td><td>{$row['client_name']}</td><td>{$row['status']}</td><td>{$row['created_at']}</td></tr>";
}
?>
</table>
</body>
</html>
<?php
$html = ob_get_clean();
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream("client_reports.pdf");
?>
