<?php
session_start();
require 'config.php';

// Ambil ID pengguna dari session
$user_id = $_SESSION['user_id'];

// Ambil data pengguna dari tabel detail_users
$query = $conn->prepare("SELECT first_name, last_name, email FROM detail_users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$query->bind_result($first_name, $last_name, $email);
$query->fetch();
$query->close();

// Ambil data login pengguna dari tabel user_logins (jika diperlukan)
$query_login = $conn->prepare("SELECT username FROM user_logins WHERE id = ?");
$query_login->bind_param("i", $user_id);
$query_login->execute();
$query_login->bind_result($username);
$query_login->fetch();
$query_login->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        <style>
        /* Inline CSS for header and hover effects */
        .navbar-nav .nav-item .nav-link {
            font-size: 1.2rem;
            color: #007bff;
            padding: 10px 15px;
        }

        .navbar-nav .nav-item .nav-link:hover {
            color: #007bff;
            background-color: #f1f1f1;
            border-radius: 5px;
        }

        .navbar-brand {
            font-size: 1.5rem;
            color: #333;
        }

        .navbar-toggler {
            border-color: #333;
        }

        .navbar-toggler-icon {
            background-color: #333;
        }
        footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
        }

        footer .social-icons a {
            text-decoration: none;
            margin: 0 10px;
            color: #000;
            transition: color 0.3s ease;
        }

        footer .social-icons a:hover {
            color: #007bff;
        }

        footer .contact p {
            margin: 0;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg" style="background: linear-gradient(90deg,rgb(19, 37, 120),rgb(241, 245, 247)); color: white;">
    <div class="container-fluid">
        <!-- Tambahkan gambar logo di sini -->
        <a class="navbar-brand d-flex align-items-center" href="dashboard.php" style="color: white;">
            <img src="assets/2-removebg-preview.png" alt="InfokanLoker Logo" style="height: 200px; margin-right: 10px;">
            
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php" style="color: white;">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="job_listings.php" style="color: white;">
                        <i class="fas fa-briefcase"></i> Job Listings
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="my_applications.php" style="color: white;">
                        <i class="fas fa-list-alt"></i> My Applications
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php" style="color: white;">
                        <i class="fas fa-user"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" style="color: white;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container mt-5">
        <h2>Your Profile</h2>
        <form action="update_profile.php" method="POST">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" disabled>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>

    <!-- Include Footer -->
    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
