<?php
session_start();
require 'config.php';  // Pastikan file config.php berisi koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $passwords = $_POST['passwords'];
    $company_name = $_POST['company_name'];
    $email = $_POST['email'];

    // Validasi input
    if (empty($username) || empty($passwords) || empty($company_name) || empty($email)) {
        $error = "Semua field harus diisi!";
    } else {
        // Cek apakah username atau email sudah ada di database
        $query = $conn->prepare("SELECT id FROM companies WHERE username = ? OR email = ?");
        $query->bind_param("ss", $username, $email);
        $query->execute();
        $query->store_result();

        if ($query->num_rows > 0) {
            $error = "Username atau email sudah terdaftar!";
        } else {
            // Hash passwords sebelum disimpan
            $hashed_passwords = password_hash($passwords, PASSWORD_DEFAULT);

            // Simpan data perusahaan baru ke database
            $insert = $conn->prepare("INSERT INTO companies (username, passwords, company_name, email) VALUES (?, ?, ?, ?)");
            $insert->bind_param("ssss", $username, $hashed_passwords, $company_name, $email);

            if ($insert->execute()) {
                $_SESSION['company_id'] = $conn->insert_id; // Menyimpan id perusahaan ke session
                header('Location: commpanyDash.php'); // Redirect ke halaman dashboard perusahaan
                exit;
            } else {
                $error = "Terjadi kesalahan, silakan coba lagi!";
            }

            $insert->close();
        }
        $query->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Perusahaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <h2 class="text-center">Registrasi Perusahaan</h2>
                <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
                <form method="POST" action="commpanyRegst.php">
                    <div class="mb-3">
                        <label for="company_name" class="form-label">Nama Perusahaan</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="passwords" class="form-label">Passwords</label>
                        <input type="passwords" class="form-control" id="passwords" name="passwords" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Daftar</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="commpanyLogin.php">Sudah punya akun? Login disini</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
