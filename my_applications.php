<?php
session_start();
require 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch user applications
$user_id = $_SESSION['user_id'];
$query = $conn->prepare("
    SELECT jobs.title, companies.company_name, applications.status, applications.applied_at
    FROM applications
    JOIN jobs ON applications.job_id = jobs.id
    JOIN companies ON jobs.company_id = companies.id
    WHERE applications.applicant_id = ?
");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$query->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications</title>
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
        <h2>My Applications</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Status</th>
                    <th>Applied At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($application = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($application['title']); ?></td>
                        <td><?php echo htmlspecialchars($application['company_name']); ?></td>
                        <td><?php echo htmlspecialchars($application['status']); ?></td>
                        <td><?php echo htmlspecialchars($application['applied_at']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>