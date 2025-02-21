<?php
require_once __DIR__ . '/../config/_config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: /admin/login.php");
    exit();
}

// Fetch Reports
$reports = $conn->query("SELECT * FROM client_visits ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Apple-Inspired UI */
:root {
    --primary-color: #007aff;
    --background-light: #f5f5f7;
    --background-dark: #1c1c1e;
    --card-bg-light: rgba(255, 255, 255, 0.9);
    --card-bg-dark: rgba(28, 28, 30, 0.9);
    --text-light: #1d1d1f;
    --text-dark: #f2f2f2;
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    body {
        background: var(--background-dark);
        color: var(--text-dark);
    }
    .container {
        background: var(--card-bg-dark);
    }
    .table-container table {
        background: #2c2c2e;
        color: var(--text-dark);
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
    flex-direction: column;
    height: 100vh;
    margin: 0;
    padding: 20px;
}

/* Container */
.container {
    background: var(--card-bg-light);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    max-width: 1100px;
    width: 100%;
    transition: all 0.3s ease-in-out;
}

/* Title */
h2 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 20px;
    color: var(--primary-color);
    text-align: center;
}

/* Table */
.table-container {
    overflow-x: auto;
    width: 100%;
}

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
    border-radius: 12px;
    overflow: hidden;
}

thead {
    background: var(--primary-color);
    color: white;
    font-size: 16px;
    text-align: left;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    background: white;
    border-radius: 12px;
    text-align: center;
    color:black;
}

/* Status Labels */
.status {
    font-weight: bold;
    padding: 6px 12px;
    border-radius: 12px;
    display: inline-block;
}

.status-pending { background: #ffcc00; color: black; }
.status-approved { background: #28a745; color: white; }
.status-rejected { background: #dc3545; color: white; }

/* Buttons */
.btn {
    padding: 8px 14px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
}

.btn-approve { background: #28a745; color: white; }
.btn-reject { background: #dc3545; color: white; }
.btn-view { background: var(--primary-color); color: white; }

.btn:hover {
    opacity: 0.85;
    transform: scale(1.05);
}

/* Responsive */
@media (max-width: 768px) {
    th, td {
        font-size: 14px;
        padding: 8px;
    }
}

    </style>
</head>
<body>

    <div class="container">
        <h2>Submitted Reports</h2>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Salesperson</th>
                        <th>Client Name</th>
                        <th>Phone</th>
                        <th>Institute</th>
                        <th>Description</th>
                        <th>Admin Comment</th>
                        <th>Status</th>
                        <th>Images</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $reports->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['salesperson_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['client_phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['institute_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['visit_description']); ?></td>
                            <td><?php echo htmlspecialchars($row['admin_comment']); ?></td>
                            <td>
                                <?php
                                    $status_class = strtolower($row['status']) == 'pending' ? 'status-pending' :
                                                    (strtolower($row['status']) == 'approved' ? 'status-approved' :
                                                    'status-rejected');
                                ?>
                                <span class="status <?php echo $status_class; ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="/admin/view_images.php?report_id=<?php echo $row['id']; ?>" class="btn btn-view">View Images</a>
                            </td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <?php if ($row['status'] == 'Pending') { ?>
                                    <a href="/admin/approve_reason.php?report_id=<?php echo $row['id']; ?>" class="btn btn-approve">Approve</a>
                                    <a href="/admin/reject_reason.php?report_id=<?php echo $row['id']; ?>" class="btn btn-reject">Reject</a>
                                <?php } else { echo "Reviewed"; } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <br>
        <a href="/admin/dashboard.php" class="btn btn-view">Back to Dashboard</a>
    </div>

</body>
</html>
