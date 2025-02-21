<?php
require_once '../config/_config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$total_visits = $conn->query("SELECT COUNT(*) as count FROM client_visits")->fetch_assoc()['count'];
$approved_visits = $conn->query("SELECT COUNT(*) as count FROM client_visits WHERE status='Approved'")->fetch_assoc()['count'];
$rejected_visits = $conn->query("SELECT COUNT(*) as count FROM client_visits WHERE status='Rejected'")->fetch_assoc()['count'];
$pending_visits = $conn->query("SELECT COUNT(*) as count FROM client_visits WHERE status='Pending'")->fetch_assoc()['count'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Apple-Inspired Minimalist Design */
body {
    font-family: -apple-system, BlinkMacSystemFont, "San Francisco", "Helvetica Neue", Arial, sans-serif;
    background: linear-gradient(135deg, #e5e5e5, #f5f5f7);
    color: #1d1d1f;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Dashboard Container */
.dashboard-container {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    padding: 40px;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    width: 90%;
    text-align: center;
}

/* Title */
h2 {
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 20px;
}

/* Stats Section */
.stats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin-bottom: 20px;
}

/* Stat Cards */
.stat-card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.stat-card p {
    font-size: 14px;
    color: #555;
    margin: 0;
}

.stat-card h3 {
    font-size: 24px;
    font-weight: 600;
    margin-top: 5px;
}

/* Different Card Colors */
.approved { border-left: 4px solid #28a745; }
.rejected { border-left: 4px solid #dc3545; }
.pending { border-left: 4px solid #ffc107; }

/* Button Group */
.button-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Buttons */
.btn {
    display: block;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    color: white;
    background: #0071e3;
    padding: 12px;
    border-radius: 12px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.btn:hover {
    background: #005bb5;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
}

/* Logout Button */
.logout {
    background: #d9534f;
}

.logout:hover {
    background: #c9302c;
}

/* Responsive Design */
@media (max-width: 600px) {
    h2 {
        font-size: 24px;
    }

    .stat-card h3 {
        font-size: 20px;
    }

    .btn {
        font-size: 14px;
        padding: 10px;
    }
}

    </style>
</head>
<body>

    <div class="dashboard-container">
        <h2>Admin Dashboard</h2>

        <div class="stats">
            <div class="stat-card">
                <p>Total Visits</p>
                <h3><?php echo $total_visits; ?></h3>
            </div>
            <div class="stat-card approved">
                <p>Approved Visits</p>
                <h3><?php echo $approved_visits; ?></h3>
            </div>
            <div class="stat-card rejected">
                <p>Rejected Visits</p>
                <h3><?php echo $rejected_visits; ?></h3>
            </div>
            <div class="stat-card pending">
                <p>Pending Approvals</p>
                <h3><?php echo $pending_visits; ?></h3>
            </div>
        </div>

        <div class="button-group">
            <a href="manage_salespersons.php" class="btn">Manage Salespersons</a>
            <a href="view_reports.php" class="btn">Review Reports</a>
            <a href="export_reports.php" class="btn">Export Reports</a>
            <a href="../logout.php" class="btn logout">Logout</a>
        </div>
    </div>

</body>
</html>

