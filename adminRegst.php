<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $passwords = $_POST['passwords'];
    $confirm_passwords = $_POST['confirm_passwords'];

    // Validasi input
    if (empty($username) || empty($passwords) || empty($confirm_passwords)) {
        $error_message = "Semua field harus diisi!";
    } elseif ($passwords !== $confirm_passwords) {
        $error_message = "Passwords dan Konfirmasi Passwords tidak cocok!";
    } else {
        // Hash passwords
        $hashed_passwords = password_hash($passwords, PASSWORD_DEFAULT);

        // Simpan ke database
        $stmt = $conn->prepare("INSERT INTO admins (username, passwords) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_passwords);

        if ($stmt->execute()) {
            $success_message = "Registrasi berhasil! Silakan login.";
        } else {
            $error_message = "Terjadi kesalahan saat menyimpan data.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <div class="container mt-5">
        <h2>Admin Registration</h2>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="passwords" class="form-label">Passwords</label>
                <input type="password" name="passwords" id="passwords" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="confirm_passwords" class="form-label">Confirm Passwords</label>
                <input type="password" name="confirm_passwords" id="confirm_passwords" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
            <br><br>
            <p>Sudah punya akun? <a href="adminLogin.php">Login</a></p>
            <a href="index.php">Kembali</a>
        </form>
    </div>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>

</html>
