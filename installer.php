<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db_host = trim($_POST['db_host']);
    $db_user = trim($_POST['db_user']);
    $db_pass = trim($_POST['db_pass']);
    $db_name = trim($_POST['db_name']);

    // Attempt to connect to MySQL
    $conn = new mysqli($db_host, $db_user, $db_pass);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Create database if it does not exist
    if (!$conn->query("CREATE DATABASE IF NOT EXISTS `$db_name`")) {
        die("Database creation failed: " . $conn->error);
    }

    // Select database
    $conn->select_db($db_name);

    // Import SQL file
    $sql_file = "database.sql";
    if (!file_exists($sql_file)) {
        die("Error: `database.sql` file not found.");
    }

    $sql_content = file_get_contents($sql_file);
    $queries = explode(";", $sql_content); // Splitting SQL statements

    foreach ($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            if (!$conn->query($query)) {
                die("Error importing database: " . $conn->error);
            }
        }
    }
    // Insert default admin if not exists
$admin_username = "admin";
$admin_email = "admin@example.com";
$admin_password = password_hash("admin123", PASSWORD_BCRYPT);

$conn->query("INSERT INTO admin (username, email, password) 
    SELECT '$admin_username', '$admin_email', '$admin_password' 
    WHERE NOT EXISTS (SELECT * FROM admin WHERE email = '$admin_email')");


    // Create `config.php`
    $config_content = <<<PHP
<?php
session_start();
\$host = "$db_host";
\$user = "$db_user";
\$pass = "$db_pass";
\$dbname = "$db_name";

\$conn = new mysqli(\$host, \$user, \$pass, \$dbname);
if (\$conn->connect_error) {
    die("Connection failed: " . \$conn->connect_error);
}

function sanitize(\$data) {
    return htmlspecialchars(strip_tags(trim(\$data)));
}

require 'smtp_settings.php';
?>
PHP;

    file_put_contents("config/_config.php", $config_content);

    // Mark installation as complete
    file_put_contents("installed.txt", "true");

    echo "<h2>Installation Completed Successfully</h2>";
    echo "<p>The system is now installed. <a href='index.php'>Go to Home</a></p>";

    $conn->close();
    exit();
}


// If already installed, prevent reinstallation
if (file_exists("installed.txt")) {
    die("Installation is already completed. <a href='index.php'>Go to Home</a>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installer - Salesperson Management System</title>
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
    --error: #ff3b30;
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

/* Error Message */
.error {
    color: var(--error);
    font-size: 14px;
    margin-bottom: 10px;
}

/* Form */
form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

label {
    font-weight: bold;
    font-size: 14px;
    text-align: left;
}

input {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 2px solid #ddd;
    border-radius: 8px;
    transition: 0.3s ease-in-out;
}

input:focus {
    border-color: var(--primary);
    outline: none;
}

/* Buttons */
button {
    padding: 12px;
    font-size: 16px;
    border-radius: 12px;
    background: var(--primary);
    color: white;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

button:hover {
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
    <h1>Install System</h1>
    <p>Enter database details to set up the system.</p>

    <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>

    <form method="POST">
        <label>Database Host</label>
        <input type="text" name="db_host" required value="localhost">

        <label>Database Username</label>
        <input type="text" name="db_user" required>

        <label>Database Password</label>
        <input type="password" name="db_pass">

        <label>Database Name</label>
        <input type="text" name="db_name" required>

        <button type="submit">Install System</button>
    </form>
</div>

</body>
</html>
