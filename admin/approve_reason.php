<?php
require_once __DIR__ . '/../config/_config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: /admin/login.php");
    exit();
}

if (!isset($_GET['report_id'])) {
    die("Invalid request.");
}

$report_id = intval($_GET['report_id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approve Report</title>
</head>
<body>
    <h2>Approve Report</h2>

    <form action="/admin/process_approval.php" method="POST">
        <input type="hidden" name="report_id" value="<?php echo $report_id; ?>">
        <label for="reason">Approval Comment (Optional):</label><br>
        <textarea name="reason" id="reason" rows="4" cols="50"></textarea><br><br>
        <button type="submit" name="approve">Approve</button>
    </form>

    <a href="/admin/view_reports.php">Cancel</a>
</body>
</html>
