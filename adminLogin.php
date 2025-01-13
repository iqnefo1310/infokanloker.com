<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $passwords = trim($_POST['passwords']);

    // Ambil user berdasarkan username
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    try{
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($passwords, $user['passwords'])) {
            // Jika passwords cocok
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: adminDashboard.php");
            exit;
        } else {
            $error_message = "Username atau passwords salah!";
        }
    } else {
        $error_message = "Terjadi kesalahan pada sistem. Silakan coba lagi nanti.";
    }
    } catch (Exception $e) {
        $error_message = "Terjadi kesalahan pada sistem." + $e->getMessage();
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
    <div class="container mt-5">
        <h2>Admin Login</h2>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="passwords" class="form-label">Passwords</label>
                <input type="passwords" name="passwords" id="passwords" class="form-control" required>
            </div>
            <label>
                <input type="checkbox" id="cekPass"> Tampilkan Kata Sandi
            </label>
            <br><br>
            <button type="submit" class="btn btn-primary">Login</button>
            <br><br>
            <p>Belum Punya Akun? <a href="adminRegst.php">Daftar Sekarang</a><p>
            <a href="index.php">kembali</a>
        </form>
    </div>
    <script>
        document.getElementById('cekPass').addEventListener('change', function () {
            const passwordsField = document.getElementById('passwords');
            passwordsField.type = this.checked ? 'text' : 'passwords';
        });
    </script>
</body>

</html>
