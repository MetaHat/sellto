<?php
require_once __DIR__ . '/../config/_config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: /admin/login.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['report_id']) || !is_numeric($_POST['report_id'])) {
        die("Invalid report ID.");
    }

    $report_id = intval($_POST['report_id']); // Ensuring it's an integer

    if (isset($_POST['approve'])) {
        $stmt = $conn->prepare("UPDATE client_visits SET status='Approved' WHERE id=?");
        $stmt->bind_param("i", $report_id);
        $stmt->execute();
        $stmt->close();
    }

    if (isset($_POST['reject'])) {
        if (!isset($_POST['reason']) || empty(trim($_POST['reason']))) {
            die("Rejection reason is required.");
        }

        $reason = htmlspecialchars(trim($_POST['reason'])); // Prevents XSS
        $stmt = $conn->prepare("UPDATE client_visits SET status='Rejected', admin_comment=? WHERE id=?");
        $stmt->bind_param("si", $reason, $report_id);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect back to reports page
    header("Location: /admin/view_reports.php");
    exit();
}
?>
