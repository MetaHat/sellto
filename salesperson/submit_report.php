<?php
session_start();
include '../config/_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $salesperson_id = $_SESSION['salesperson_id'] ?? null;
    if (!$salesperson_id) {
        die("Unauthorized access.");
    }

    // Use the existing sanitize() function from _config.php
    $client_name = sanitize($_POST['client_name']);
    $client_phone = sanitize($_POST['client_phone']);
    $institute_name = sanitize($_POST['institute_name']);
    $visit_desc = sanitize($_POST['visit_desc']);

    // Handle file uploads securely
    $upload_dir = "../uploads/";
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];

    function uploadFile($file, $upload_dir, $allowed_types) {
        if (!empty($file['name'])) {
            $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $new_filename = uniqid() . "." . $file_ext;
            $target_path = $upload_dir . $new_filename;

            if (in_array($file['type'], $allowed_types) && $file['size'] <= 2 * 1024 * 1024) {
                if (move_uploaded_file($file['tmp_name'], $target_path)) {
                    return "uploads/" . $new_filename;
                }
            }
        }
        return null;
    }

    $photo_1 = uploadFile($_FILES['photo_1'], $upload_dir, $allowed_types);
    $photo_2 = uploadFile($_FILES['photo_2'], $upload_dir, $allowed_types);
    $photo_3 = uploadFile($_FILES['photo_3'], $upload_dir, $allowed_types);

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO client_visits (salesperson_id, client_name, client_phone, institute_name, visit_description, photo_1, photo_2, photo_3) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $salesperson_id, $client_name, $client_phone, $institute_name, $visit_desc, $photo_1, $photo_2, $photo_3);
    
    if ($stmt->execute()) {
        // Send email notification to admin
        $admin_email = "help.instamedia@gmail.com";
        $subject = "New Client Visit Report Submitted";
        $message = "<p>A new client visit report has been submitted by Salesperson ID: $salesperson_id.</p>";
        sendEmail($admin_email, $subject, $message);

        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Report</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Apple-Inspired Modern UI */
:root {
    --primary: #007aff;
    --success: #34c759;
    --danger: #ff3b30;
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

/* Glassmorphism Form Container */
.container {
    background: var(--card-light);
    backdrop-filter: blur(15px);
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    max-width: 500px;
    width: 100%;
    text-align: center;
}

/* Form Inputs */
form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

label {
    font-weight: bold;
    text-align: left;
    display: block;
    margin-top: 10px;
}

input, textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 16px;
}

/* File Upload */
input[type="file"] {
    background: white;
    padding: 10px;
    cursor: pointer;
}

/* Buttons */
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

.back {
    background: gray;
}

/* Success & Error Messages */
.success {
    color: var(--success);
    font-weight: bold;
}

.error {
    color: var(--danger);
    font-weight: bold;
}

/* Responsive Design */
@media (max-width: 600px) {
    .container {
        width: 90%;
    }
}

    </style>
</head>
<body>

<div class="container">
    <h2>Submit New Report</h2>
    
    <form method="post" enctype="multipart/form-data">
        <label>Client Name</label>
        <input type="text" name="client_name" required>

        <label>Client Phone</label>
        <input type="text" name="client_phone" required>

        <label>Institute Name</label>
        <input type="text" name="institute_name">

        <label>Visit Description</label>
        <textarea name="visit_desc" required></textarea>

        <label>Upload Photos</label>
        <input type="file" name="photo_1" required>
        <input type="file" name="photo_2">
        <input type="file" name="photo_3">

        <button type="submit" class="btn">Submit</button>
    </form>

    <a href="dashboard.php" class="btn back">Back to Dashboard</a>
</div>

</body>
</html>

