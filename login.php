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
        echo "<div class='alert alert-danger'>Username atau password salah!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Include Header -->
    <?php include('includes/header.php'); ?>

    <div class="container mt-5" width="100px">
        <h2>Login</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <label>
                <input type="checkbox" name="cekpas" id="cekPass"> Tampilkan Kata Sandi
            </label>
            <br><br>
            <button type="submit" class="btn btn-primary">Login</button>
            <br>
            <p>Belum Punya Akun? <a href="register.php">Daftar Sekarang</a></p>
            <a href="index.php">Kembali</a>
        </form>
    </div>

    <!-- Include Footer -->
    <?php include('includes/footer.php'); ?>

    <script src="js/script.js"></script>
    <script>
        // Toggle password visibility
        const cekPass = document.getElementById('cekPass');
        const passwordField = document.getElementById('password');
        cekPass.addEventListener('change', () => {
            if (cekPass.checked) {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
        });
    </script>
</body>

</html>
