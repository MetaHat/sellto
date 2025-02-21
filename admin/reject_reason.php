<?php
require_once __DIR__ . '/../config/_config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: /admin/login.php");
    exit();
}

// Validate report_id
if (!isset($_GET['report_id'])) {
    die("Invalid request!");
}

$report_id = intval($_GET['report_id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reason = sanitize($_POST['reason']);

    $stmt = $conn->prepare("UPDATE client_visits SET status='Rejected', admin_comment=? WHERE id=?");
    $stmt->bind_param("si", $reason, $report_id);
    $stmt->execute();

    header("Location: /admin/view_reports.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head><title>Reject Report</title></head>
<body>
<h2>Reject Report</h2>
<form method="post">
    <label>Reason for Rejection:</label><br>
    <textarea name="reason" required></textarea><br>
    <button type="submit">Submit</button>
</form>
<a href="view_reports.php">Cancel</a>
</body>
</html>
