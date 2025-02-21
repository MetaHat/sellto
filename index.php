<?php
session_start();

// Check if the system is installed
if (!file_exists("installed.txt")) {
    header("Location: installer.php");
    exit();
}

// Redirect based on login status
if (isset($_SESSION['admin_id'])) {
    header("Location: admin/dashboard.php");
    exit();
} elseif (isset($_SESSION['salesperson_id'])) {
    header("Location: salesperson/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salesperson Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Apple-Inspired Modern UI */
:root {
    --primary: #007aff;
    --dark-bg: #1c1c1e;
    --light-bg: #f5f5f7;
    --card-light: rgba(255, 255, 255, 0.9);
    --card-dark: rgba(28, 28, 30, 0.9);
    --text-light: #1d1d1f;
    --text-dark: #f2f2f2;
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    body {
        background: var(--dark-bg);
        color: var(--text-dark);
    }
    .container {
        background: var(--card-dark);
    }
}

/* Basic Styling */
body {
    font-family: -apple-system, BlinkMacSystemFont, "San Francisco", "Helvetica Neue", Arial, sans-serif;
    background: var(--light-bg);
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
    max-width: 400px;
    width: 100%;
    text-align: center;
}

/* Heading */
h1 {
    font-size: 24px;
    margin-bottom: 10px;
}

p {
    font-size: 16px;
    color: gray;
    margin-bottom: 20px;
}

/* Buttons */
.button-group {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.btn {
    padding: 12px;
    font-size: 16px;
    border-radius: 12px;
    text-decoration: none;
    text-align: center;
    display: block;
    transition: all 0.3s ease;
    font-weight: bold;
}

.admin {
    background: var(--primary);
    color: white;
}

.salesperson {
    background: #34c759;
    color: white;
}

.btn:hover {
    opacity: 0.85;
    transform: scale(1.05);
}

/* Responsive */
@media (max-width: 500px) {
    .container {
        width: 90%;
    }
}

    </style>
</head>
<body>

<div class="container">
    <h1>Welcome</h1>
    <p>Manage your sales team with ease.</p>

    <div class="button-group">
        <a href="admin/login.php" class="btn admin">Admin Login</a>
        <a href="salesperson/login.php" class="btn salesperson">Salesperson Login</a>
    </div>
</div>

</body>
</html>
