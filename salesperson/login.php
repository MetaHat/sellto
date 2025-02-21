<?php
session_start();
include '../config/_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM salesperson WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['salesperson_id'] = $user['id'];
        $_SESSION['salesperson_name'] = $user['name'];  // Store name for UI
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salesperson Login</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Apple-Inspired Design */
:root {
    --primary-color: #007aff;
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

/* Login Container */
.container {
    background: var(--card-bg-light);
    backdrop-filter: blur(15px);
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    max-width: 400px;
    width: 100%;
    text-align: center;
}

/* Title */
h2 {
    font-size: 24px;
    font-weight: bold;
    color: var(--primary-color);
}

/* Input Fields */
.input-group {
    margin-bottom: 15px;
}

input {
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    border: 1px solid #ccc;
    font-size: 16px;
    transition: all 0.3s ease;
}

input:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 8px rgba(0, 122, 255, 0.5);
}

/* Button */
.btn {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 12px;
    font-size: 16px;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.btn:hover {
    opacity: 0.85;
    transform: scale(1.05);
}

/* Error Message */
.error {
    color: red;
    font-size: 14px;
    margin-bottom: 15px;
}

    </style>
</head>
<body>

<div class="container">
    <h2>Salesperson Login</h2>

    <?php if (isset($error)) { ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>

    <form method="post">
        <div class="input-group">
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn">Login</button>
    </form>
</div>

</body>
</html>
