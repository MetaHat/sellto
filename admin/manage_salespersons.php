<?php
include '../config/_config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle adding a salesperson
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_salesperson'])) {
    $name = sanitize($_POST['name']);
    $phone = sanitize($_POST['phone']);
    $email = sanitize($_POST['email']);
    $address = sanitize($_POST['address']);
    $aadhaar_number = sanitize($_POST['aadhaar']); // Use correct column name
    $username = sanitize($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO salesperson (name, phone, email, address, aadhaar_number, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        die("Error in preparing statement: " . $conn->error); // Debugging step
    }
    
    $stmt->bind_param("sssssss", $name, $phone, $email, $address, $aadhaar_number, $username, $password);
    
    if ($stmt->execute()) {
        require_once '../config/smtp_settings.php';
        sendEmail($email, "Your Salesperson Account", "Your login credentials: Username: $username, Password: ".$_POST['password']);
        echo "Salesperson added successfully!";
    } else {
        die("Error executing statement: " . $stmt->error); // Debugging step
    }
    
    $stmt->close();
}

// Fetch salespersons
$salespersons = $conn->query("SELECT * FROM salesperson");

if (!$salespersons) {
    die("Error fetching salespersons: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Salespersons</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Apple-Inspired UI */
:root {
    --primary-color: #007aff;
    --background-light: #f5f5f7;
    --background-dark: #1c1c1e;
    --card-bg-light: rgba(255, 255, 255, 0.85);
    --card-bg-dark: rgba(28, 28, 30, 0.85);
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
    .input-group input {
        background: #2c2c2e;
        color: var(--text-dark);
        border: 1px solid #3a3a3c;
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

/* Container */
.main-container {
    display: flex;
    gap: 30px;
    max-width: 900px;
    width: 100%;
    transition: all 0.3s ease-in-out;
}

/* Forms & Tables - Responsive Layout */
.container {
    background: var(--card-bg-light);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    flex: 1;
    transition: all 0.3s ease-in-out;
}

/* Title Styling */
h2, h3 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 15px;
    color: var(--primary-color);
    text-align: center;
}

/* Form */
.salesperson-form {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 20px;
}

/* Input Fields */
.input-group {
    display: flex;
    flex-direction: column;
    text-align: left;
}

.input-group label {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 5px;
}

.input-group input {
    width: 100%;
    padding: 12px;
    border: 1px solid #d1d1d6;
    border-radius: 12px;
    font-size: 16px;
    background: white;
    transition: all 0.3s ease;
}

.input-group input:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 8px rgba(0, 122, 255, 0.3);
}

/* iPhone-Like Button */
.btn {
    width: 100%;
    font-size: 18px;
    font-weight: 600;
    color: white;
    background: var(--primary-color);
    padding: 14px;
    border-radius: 14px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn:hover {
    background: #005ecb;
    transform: scale(1.02);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
    margin-top: 15px;
}

thead {
    background: var(--primary-color);
    color: white;
    font-size: 16px;
    border-radius: 12px;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    background: white;
    border-radius: 12px;
    color:black;
}

/* Hover Effect */
tbody tr:hover {
    background: rgba(0, 122, 255, 0.1);
}

/* RESPONSIVE DESIGN */

/* Mobile View (Vertical Layout) */
@media (max-width: 768px) {
    .main-container {
        flex-direction: column;
        gap: 15px;
    }

    .container {
        width: 100%;
        max-width: 100%;
    }

    h2 {
        font-size: 22px;
    }

    .btn {
        font-size: 16px;
        padding: 12px;
    }
}

    </style>
</head>
<body>

    <div class="main-container">

        <!-- Left Side (Form) -->
        <div class="container">
            <h2>Salesperson Management</h2>
            <form method="post" class="salesperson-form">
                <div class="input-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" required>
                </div>
                <div class="input-group">
                    <label for="phone">Phone:</label>
                    <input type="text" name="phone" required>
                </div>
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="address">Address:</label>
                    <input type="text" name="address" required>
                </div>
                <div class="input-group">
                    <label for="aadhaar">Aadhaar:</label>
                    <input type="text" name="aadhaar" required>
                </div>
                <div class="input-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" name="add_salesperson" class="btn">Add Salesperson</button>
            </form>
        </div>

        <!-- Right Side (Table) -->
        <div class="container">
            <h3>Existing Salespersons</h3>
            <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $salespersons->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        </div>

    </div>

</body>
</html>

