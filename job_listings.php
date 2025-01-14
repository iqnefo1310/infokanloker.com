<?php
session_start();
require 'config.php';

<<<<<<< HEAD
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch all job listings
$query = $conn->prepare("
    SELECT jobs.id, jobs.title, companies.company_name, jobs.location, jobs.salary, jobs.description
    FROM jobs
    JOIN companies ON jobs.company_id = companies.id
");
$query->execute();
$result = $query->get_result();
$query->close();
=======
// Fetch job listings with company name
$jobs_query = $conn->prepare("
    SELECT jobs.id, jobs.title, companies.company_name, jobs.location, jobs.salary 
    FROM jobs 
    JOIN companies ON jobs.company_id = companies.id
");
$jobs_query->execute();
$jobs_result = $jobs_query->get_result();
$jobs_query->close();
>>>>>>> 9c7a0875f8a5c377f7ec9c659722049ea5aec8de
?>

<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD
=======

>>>>>>> 9c7a0875f8a5c377f7ec9c659722049ea5aec8de
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<<<<<<< HEAD
</head>
<body>
    <div class="container mt-5">
        <h2>Job Listings</h2>
=======
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Inline CSS for hover effects */
        .table td, .table th {
            text-align: center;
        }

        .table th {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg" style="background: linear-gradient(90deg,rgb(30, 50, 139),rgb(234, 238, 239)); color: white;">
    <div class="container-fluid">
        <!-- Tambahkan gambar logo di sini -->
        <a class="navbar-brand d-flex align-items-center" href="dashboard.php" style="color: white;">
            <img src="assets/2-removebg-preview.png" alt="InfokanLoker Logo" style="height: 200px; margin-right: 10px;">
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
        <h2>Available Job Listings</h2>
>>>>>>> 9c7a0875f8a5c377f7ec9c659722049ea5aec8de
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Salary</th>
<<<<<<< HEAD
                    <th>Description</th>
=======
>>>>>>> 9c7a0875f8a5c377f7ec9c659722049ea5aec8de
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<<<<<<< HEAD
                <?php while ($job = $result->fetch_assoc()): ?>
=======
                <?php while ($job = $jobs_result->fetch_assoc()): ?>
>>>>>>> 9c7a0875f8a5c377f7ec9c659722049ea5aec8de
                    <tr>
                        <td><?php echo htmlspecialchars($job['title']); ?></td>
                        <td><?php echo htmlspecialchars($job['company_name']); ?></td>
                        <td><?php echo htmlspecialchars($job['location']); ?></td>
                        <td><?php echo htmlspecialchars($job['salary']); ?></td>
<<<<<<< HEAD
                        <td><?php echo htmlspecialchars(substr($job['description'], 0, 200)); ?>...</td>
=======
>>>>>>> 9c7a0875f8a5c377f7ec9c659722049ea5aec8de
                        <td><a href="apply.php?job_id=<?php echo $job['id']; ?>" class="btn btn-primary">Apply</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<<<<<<< HEAD
</body>
=======

    <!-- Include Footer -->
    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

>>>>>>> 9c7a0875f8a5c377f7ec9c659722049ea5aec8de
</html>
