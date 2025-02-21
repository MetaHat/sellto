<?php
include '../config/_config.php';

if (!isset($_SESSION['salesperson_id'])) {
    header("Location: login.php");
    exit();
}

$salesperson_id = $_SESSION['salesperson_id'];
$result = $conn->query("SELECT * FROM client_visits WHERE salesperson_id='$salesperson_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reports</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Apple-Inspired Modern UI */
:root {
    --primary: #007aff;
    --success: #34c759;
    --danger: #ff3b30;
    --pending: #ffcc00;
    --bg-light: #f5f5f7;
    --bg-dark: #1c1c1e;
    --card-light: rgba(255, 255, 255, 0.9);
    --card-dark: rgba(28, 28, 30, 0.9);
    --text-light: #1d1d1f;
    --text-dark: #f2f2f2;
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    body {
        background: var(--bg-dark);
        color: var(--text-dark);
    }
    .container {
        background: var(--card-dark);
    }
}

/* Basic Styling */
body {
    font-family: -apple-system, BlinkMacSystemFont, "San Francisco", "Helvetica Neue", Arial, sans-serif;
    background: var(--bg-light);
    color: var(--text-light);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    padding: 20px;
}

/* Container */
.container {
    background: var(--card-light);
    backdrop-filter: blur(15px);
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    max-width: 800px;
    width: 100%;
    text-align: center;
}

/* Table Styling */
.table-container {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

thead {
    background: var(--primary);
    color: white;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

tr:nth-child(even) {
    background: rgba(0, 0, 0, 0.05);
}

/* Status Badges */
.status {
    padding: 6px 10px;
    border-radius: 10px;
    font-weight: bold;
    display: inline-block;
}

.status.pending {
    background: var(--pending);
    color: black;
}

.status.approved {
    background: var(--success);
    color: white;
}

.status.rejected {
    background: var(--danger);
    color: white;
}

/* Button */
.btn {
    background: var(--primary);
    color: white;
    border: none;
    padding: 12px;
    font-size: 16px;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    margin-top: 15px;
    width: 100%;
}

.btn:hover {
    opacity: 0.85;
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 600px) {
    .container {
        width: 95%;
    }
    table {
        display: block;
        overflow-x: auto;
    }
    th, td {
        padding: 8px;
    }
}

    </style>
</head>
<body>

<div class="container">
    <h2>My Submitted Reports</h2>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Phone</th>
                    <th>Institute</th>
                    <th>Description</th>
                    <th>Admin Comment</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['client_phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['institute_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['visit_description']); ?></td>
                    <td><?php echo htmlspecialchars($row['admin_comment']); ?></td>
                    <td>
                        <span class="status <?php echo strtolower($row['status']); ?>">
                            <?php echo htmlspecialchars($row['status']); ?>
                        </span>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <a href="dashboard.php" class="btn">Back to Dashboard</a>
</div>

</body>
</html>