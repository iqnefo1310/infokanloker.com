<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM user_logins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['passwords'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(193, 210, 226);
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-wrapper {
            display: flex;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 800px;
            width: 100%;
        }

        .image-container {
            background-color: rgb(150, 196, 245);
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .form-container {
            padding: 30px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-container h2 {
            text-align: center;
            color: #333333;
            margin-bottom: 20px;
        }

        .alert {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            font-size: 14px;
            color: #495057;
            margin-bottom: 5px;
        }

        .input-group {
            display: flex;
            align-items: center;
            border: 1px solid #ced4da;
            border-radius: 4px;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .input-group i {
            padding: 10px;
            background-color: #e9ecef;
            color: #495057;
        }

        .input-group input {
            border: none;
            outline: none;
            padding: 10px;
            flex: 1;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .text-center {
            text-align: center;
            margin-top: 15px;
        }

        .text-center a {
            color: #007bff;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
        <!-- Include Header -->
        <?php include('includes/header.php'); ?>

    <div class="container">
        <div class="login-wrapper">
            <!-- Image Container -->
            <div class="image-container">
                <img src="assets/loginpage.png" alt="Login Illustration">
            </div>
            <!-- Form Container -->
            <div class="form-container">
                <h2>Login</h2>
                <?php if (isset($error)) { echo "<div class='alert'>$error</div>"; } ?>
                <form method="POST">
                    <div>
                        <label for="username">Username</label>
                        <div class="input-group">
                            <i class="fas fa-user"></i>
                            <input type="text" id="username" name="username" required>
                        </div>
                    </div>
                    <div>
                        <label for="password">Password</label>
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" name="password" required>
                        </div>
                    </div>
                    <button type="submit">Login</button>
                </form>
                <div class="text-center">
                    <a href="register.php">Don't have an account? Register here</a>
                </div>
            </div>
        </div>
    </div>
        <!-- Include Footer -->
        <?php include('includes/footer.php'); ?>

</body>

</html>
