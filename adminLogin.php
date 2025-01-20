<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $passwords = trim($_POST['passwords']);

    // Ambil user berdasarkan username
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    try {
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
        $error_message = "Terjadi kesalahan pada sistem. " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Include Font Awesome -->
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
            margin-top: 15px;
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
            background-color: rgb(237, 242, 247);
            color: #ffffff;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
        }
        .form-container .back-button:hover {
            background-color: rgb(160, 207, 243);
        }
    </style>
</head>
<body>
    <!-- Include Header -->
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="login-wrapper">
            <!-- Image Container -->
            <div class="image-container">
                <img src="assets/loginpage.png" alt="Admin Login">
            </div>
            <!-- Form Container -->
            <div class="form-container">
                <h2>Admin Login</h2>
                <?php if (!empty($error_message)): ?>
                    <div class="alert"><?php echo htmlspecialchars($error_message); ?></div>
                <?php endif; ?>
                <form method="POST" action="adminLogin.php">
                    <div>
                        <label for="username">Username</label>
                        <div class="input-group">
                            <i class="fas fa-user"></i>
                            <input type="text" id="username" name="username" required>
                        </div>
                    </div>
                    <div>
                        <label for="passwords">Passwords</label>
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="passwords" name="passwords" required>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="cekPass">
                        <label class="form-check-label" for="cekPass">Tampilkan Kata Sandi</label>
                    </div>
                    <br>
                    <button type="submit">Login</button>
                </form>
                <div class="text-center">
                    <!-- <a href="adminRegst.php">Belum Punya Akun? Daftar Sekarang</a>
                    <br><br> -->
                    <a href="index.php" class="back-button">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include 'includes/footer.php'; ?>
    
    <script>
        document.getElementById('cekPass').addEventListener('change', function () {
            const passwordsField = document.getElementById('passwords');
            passwordsField.type = this.checked ? 'text' : 'password';
        });
    </script>
</body>
</html>
