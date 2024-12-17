<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah email sudah digunakan
    $check_email_query = $conn->prepare("SELECT id FROM detail_users WHERE email = ?");
    $check_email_query->bind_param("s", $email);
    $check_email_query->execute();
    $check_email_query->store_result();

    if ($check_email_query->num_rows > 0) {
        $error_message = "Email sudah digunakan.";
    } else {
        // Cek apakah username sudah digunakan
        $check_username_query = $conn->prepare("SELECT id FROM login_users WHERE username = ?");
        $check_username_query->bind_param("s", $username);
        $check_username_query->execute();
        $check_username_query->store_result();

        if ($check_username_query->num_rows > 0) {
            $error_message = "Username sudah digunakan.";
        } else {
            // Masukkan data ke detail_users
            $stmt = $conn->prepare("INSERT INTO detail_users (first_name, last_name, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $first_name, $last_name, $email);

            if ($stmt->execute()) {
                $detail_user_id = $conn->insert_id;

                // Masukkan data ke login_users
                $stmt2 = $conn->prepare("INSERT INTO login_users (id, username, password) VALUES (?, ?, ?)");
                $stmt2->bind_param("iss", $detail_user_id, $username, $password);

                if ($stmt2->execute()) {
                    $success_message = "Pendaftaran berhasil! Silakan login.";
                } else {
                    $error_message = "Terjadi kesalahan saat menyimpan data login: " . $stmt2->error;
                }
            } else {
                $error_message = "Terjadi kesalahan saat menyimpan detail pengguna: " . $stmt->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Register</h2>
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" >
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
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
            <br>
            <br>
            <button type="submit" class="btn btn-success">Register</button>
            <br>
            <br>
            <p>Sudah Memiliki Akun? <a href="login.php"> Login Sekarang</a></p>
            <a href="index.php">kembali</a>
        </form>
    </div>
    <script src="js/script.js"></script>
</body>

</html>