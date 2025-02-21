<?php
include '../config/_config.php';

if (!isset($_SESSION['salesperson_id'])) {
    header("Location: login.php");
    exit();
}

$salesperson_id = $_SESSION['salesperson_id'];
$total_reports = $conn->query("SELECT COUNT(*) as count FROM client_visits WHERE salesperson_id='$salesperson_id'")->fetch_assoc()['count'];
$pending_reports = $conn->query("SELECT COUNT(*) as count FROM client_visits WHERE salesperson_id='$salesperson_id' AND status='Pending'")->fetch_assoc()['count'];
$approved_reports = $conn->query("SELECT COUNT(*) as count FROM client_visits WHERE salesperson_id='$salesperson_id' AND status='Approved'")->fetch_assoc()['count'];
$rejected_reports = $conn->query("SELECT COUNT(*) as count FROM client_visits WHERE salesperson_id='$salesperson_id' AND status='Rejected'")->fetch_assoc()['count'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salesperson Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Apple-Inspired Design */
:root {
    --primary-color: #007aff;
    --secondary-color: #34c759;
    --error-color: #ff3b30;
    --background-light: #f5f5f7;
    --background-dark: #1c1c1e;
    --card-bg-light: rgba(255, 255, 255, 0.9);
    --card-bg-dark: rgba(28, 28, 30, 0.9);
    --text-light: #1d1d1f;
    --text-dark: #f2f2f2;
}

/* Dark Mode */
@media (prefers-color-scheme: dark) {
    body {
        background: var(--background-dark);
        color: var(--text-dark);
    }
    .container {
        background: var(--card-bg-dark);
    }
    .btn {
        background: var(--primary-color);
    }
}

/* Global Styles */
body {
    font-family: -apple-system, BlinkMacSystemFont, "San Francisco", "Helvetica Neue", Arial, sans-serif;
    background: var(--background-light);
    color: var(--text-light);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    padding: 20px;
}

/* Dashboard Container */
.container {
    background: var(--card-bg-light);
    backdrop-filter: blur(15px);
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    max-width: 600px;
    width: 100%;
    text-align: center;
}

/* Title */
h2 {
    font-size: 24px;
    font-weight: bold;
    color: var(--primary-color);
}

/* Statistics */
.stats {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 10px;
    margin: 20px 0;
}

.stat {
    flex: 1;
    min-width: 120px;
    padding: 15px;
    border-radius: 12px;
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    background-color: aqua;
    color: white;
}

.stat h3 {
    font-size: 24px;
    margin: 5px 0;
    
}

/* Status Colors */
.pending {
    background: #ffcc00;
}

.approved {
    background: var(--secondary-color);
}

.rejected {
    background: var(--error-color);
}

/* Buttons */
.actions {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 10px;
}

.btn {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 12px;
    font-size: 16px;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    flex: 1;
    text-align: center;
}

.btn:hover {
    opacity: 0.85;
    transform: scale(1.05);
}

/* Logout Button */
.logout {
    background: var(--error-color);
}

/* Responsive Design */
@media (max-width: 600px) {
    .stats {
        flex-direction: column;
    }
    .actions {
        flex-direction: column;
    }
    .btn {
        width: 100%;
    }
}

    </style>
</head>
<body>

<div class="container">
    <h2>Welcome, Salesperson</h2>
    
    <div class="stats">
        <div class="stat">
            <h3><?php echo $total_reports; ?></h3>
            <p>Total Reports</p>
        </div>
        <div class="stat pending">
            <h3><?php echo $pending_reports; ?></h3>
            <p>Pending Reports</p>
        </div>
        <div class="stat approved">
            <h3><?php echo $approved_reports; ?></h3>
            <p>Approved Reports</p>
        </div>
        <div class="stat rejected">
            <h3><?php echo $rejected_reports; ?></h3>
            <p>Rejected Reports</p>
        </div>
    </div>

    <div class="actions">
        <a href="submit_report.php" class="btn">Submit New Report</a>
        <a href="view_reports.php" class="btn">View Reports</a>
        <a href="../logout.php" class="btn logout">Logout</a>
    </div>
</div>

</body>
</html>
