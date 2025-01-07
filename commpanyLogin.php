<?php
session_start();
require 'config.php';

// Check if the company is already logged in
if (isset($_SESSION['company_id'])) {
    header('Location: commpanyDash.php');
    exit;
}

// Process login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input to prevent SQL Injection
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['passwords'];

    // Query to check company credentials
    $query = $conn->prepare("SELECT id, passwords FROM companies WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $query->store_result();
    $query->bind_result($company_id, $hashed_password);
    $query->fetch();

    if ($query->num_rows > 0 && password_verify($password, $hashed_password)) {
        // Successful login
        $_SESSION['company_id'] = $company_id;
        $_SESSION['company_name'] = $username; // Store company name in session
        header('Location: commpanyDash.php');
        exit;
    } else {
        $error = "Invalid credentials!";
    }
    $query->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <h2 class="text-center">Company Login</h2>
                <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
                <form method="POST" action="commpanyLogin.php">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="passwords" class="form-label">Password</label>
                        <input type="password" class="form-control" id="passwords" name="passwords" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="commpanyRegst.php">Don't have an account? Register here</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
