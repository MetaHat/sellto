<?php
include '../config/_config.php';

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/style.css">
    <style>/* Apple-Inspired Minimalist Design */
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

/* Login Form Container (Glassmorphism) */
.login-container {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    padding: 40px;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    max-width: 350px;
    width: 90%;
    text-align: center;
}

/* Title */
h2 {
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 20px;
}

/* Error Message */
.error {
    color: red;
    font-size: 14px;
    margin-bottom: 10px;
}

/* Input Group */
.input-group {
    text-align: left;
    margin-bottom: 15px;
}

.input-group label {
    font-size: 14px;
    font-weight: 500;
    color: #333;
    display: block;
    margin-bottom: 5px;
}

.input-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    transition: 0.3s ease-in-out;
}

/* Input Focus Effect */
.input-group input:focus {
    border-color: #0071e3;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 113, 227, 0.3);
}

/* Login Button */
.btn {
    display: inline-block;
    width: 100%;
    text-decoration: none;
    font-size: 18px;
    font-weight: 500;
    color: white;
    background: #0071e3;
    padding: 12px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn:hover {
    background: #005bb5;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
}

/* Responsive Design */
@media (max-width: 600px) {
    h2 {
        font-size: 24px;
    }

    .btn {
        font-size: 16px;
        padding: 10px;
    }
}
</style>
</head>
<body>

    <div class="login-container">
        <h2>Admin Login</h2>

        <?php if (isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>

        <form method="post">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>

</body>
</html>
