<?php
session_start();
require 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch user profile data
$user_id = $_SESSION['user_id'];
$query = $conn->prepare("SELECT first_name, last_name, email FROM detail_users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$query->bind_result($first_name, $last_name, $email);
$query->fetch();
$query->close();

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_first_name = htmlspecialchars($_POST['first_name']);
    $new_last_name = htmlspecialchars($_POST['last_name']);
    $new_email = htmlspecialchars($_POST['email']);

    // Update user profile in the database
    $update_query = $conn->prepare("UPDATE detail_users SET first_name = ?, last_name = ?, email = ? WHERE id = ?");
    $update_query->bind_param("sssi", $new_first_name, $new_last_name, $new_email, $user_id);
    $update_query->execute();
    $update_query->close();

    // Refresh the profile data after update
    $first_name = $new_first_name;
    $last_name = $new_last_name;
    $email = $new_email;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg"
        style="background: linear-gradient(90deg,rgb(4, 23, 110),rgb(193, 231, 250)); color: white;">
        <div class="container-fluid">
            <!-- Tambahkan gambar logo di sini -->
            <a class="navbar-brand d-flex align-items-center" href="dashboard.php" style="color: white;">
                <img src="assets/2-removebg-preview.png" alt="InfokanLoker Logo"
                    style="height: 200px; margin-right: 10px;">
                JOBLoker
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
        <div class="card">
            <div class="card-header">Profile Details</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            value="<?php echo htmlspecialchars($first_name); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            value="<?php echo htmlspecialchars($last_name); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>