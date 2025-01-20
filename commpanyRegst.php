<?php
session_start();
require 'config.php'; // Pastikan file config.php berisi koneksi database

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
    <!-- Tambahkan CDN untuk Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(210, 228, 245);
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
        .form-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            position: relative;
        }
        .form-container h2 {
            text-align: center;
            color: #333333;
            margin-bottom: 20px;
        }
        .form-container .alert {
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
        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
        .form-container .text-center {
            text-align: center;
        }
        .form-container .text-center a {
            color: #007bff;
            text-decoration: none;
        }
        .form-container .text-center a:hover {
            text-decoration: underline;
        }
        .form-container .back-button {
            margin-top: 10px;
            display: inline-block;
            text-align: center;
            background-color:rgb(223, 236, 247);
            color: #ffffff;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
        }
        .form-container .back-button:hover {
            background-color:rgb(134, 200, 250);
        }
        .form-image {
            max-width: 900px;
            margin-left: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <!-- Include Header -->
    <?php include('includes/header.php'); ?>

    <div class="container">
        <div class="form-container">
            <h2>Registrasi Perusahaan</h2>
            <?php if (isset($error)) { echo "<div class='alert'>$error</div>"; } ?>
            <form method="POST" action="commpanyRegst.php">
                <div>
                    <label for="company_name">Nama Perusahaan</label>
                    <div class="input-group">
                        <i class="fas fa-building"></i>
                        <input type="text" id="company_name" name="company_name" required>
                    </div>
                </div>
                <div>
                    <label for="username">Username</label>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" id="username" name="username" required>
                    </div>
                </div>
                <div>
                    <label for="email">Email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>
                <div>
                    <label for="passwords">Passwords</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="passwords" name="passwords" required>
                    </div>
                </div>
                <button type="submit">Daftar</button>
            </form>
            <div class="text-center">
                <a href="commpanyLogin.php">Sudah punya akun? Login disini</a>
            </div>
        </div>
        <div class="form-image">
            <img src="assets/REGISTRASI.png" alt="Company Image">
        </div>
    </div>

    <!-- Include Footer -->
    <?php include('includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
