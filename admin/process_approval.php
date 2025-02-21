<?php
require_once __DIR__ . '/../config/_config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: /admin/login.php");
    exit();
}

if (isset($_POST['approve'])) {
    $report_id = intval($_POST['report_id']);
    $reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';

    $stmt = $conn->prepare("UPDATE client_visits SET status='Approved', admin_comment=? WHERE id=?");
    $stmt->bind_param("si", $reason, $report_id);
    $stmt->execute();
    
    header("Location: /admin/view_reports.php");
    exit();
}
?>
