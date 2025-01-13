<?php
session_start();
require 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch user data from database
$user_id = $_SESSION['user_id'];
$query = $conn->prepare("SELECT first_name, last_name, email FROM detail_users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$query->bind_result($first_name, $last_name, $email);
$query->fetch();
$query->close();

// Fetch job listings
$jobs_query = $conn->prepare("SELECT id, title, company_id, location, salary FROM jobs");
$jobs_query->execute();
$jobs_result = $jobs_query->get_result();
$jobs_query->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Inline CSS for header and hover effects */
        .navbar-nav .nav-item .nav-link {
            font-size: 1.2rem;
            color: #333;
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

        .container h2,
        .container h4 {
            color: #333;
        }

        /* Footer styling */
        footer {
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        footer .social-icons a {
            color: #fff;
            margin: 0 10px;
        }

        footer .social-icons a:hover {
            color: #007bff;
        }

        footer .contact p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">InfokanLoker</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="job_listings.php"><i class="fas fa-briefcase"></i> Job Listings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="my_applications.php"><i class="fas fa-list-alt"></i> My Applications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php"><i class="fas fa-user"></i> Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Welcome, <?php echo htmlspecialchars($first_name . ' ' . $last_name); ?>!</h2>

        <!-- User Profile -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>Your Profile</h4>
            </div>
            <div class="card-body">
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></p>
            </div>
        </div>

        <!-- Job Listings -->
        <h4>Available Job Listings</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Salary</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($job = $jobs_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($job['title']); ?></td>
                    <td><?php echo htmlspecialchars($job['company_id']); ?></td>
                    <td><?php echo htmlspecialchars($job['location']); ?></td>
                    <td><?php echo htmlspecialchars($job['salary']); ?></td>
                    <td><a href="apply.php?job_id=<?php echo $job['id']; ?>" class="btn btn-primary">Apply</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <h5>Follow Us</h5>
            <div class="social-icons mt-3">
                <a href="#" class="text-white mx-2"><i class="fab fa-facebook"></i> Facebook</a>
                <a href="#" class="text-white mx-2"><i class="fab fa-instagram"></i> Instagram</a>
                <a href="#" class="text-white mx-2"><i class="fab fa-twitter"></i> Twitter</a>
                <a href="#" class="text-white mx-2"><i class="fab fa-tiktok"></i> TikTok</a>
                <a href="#" class="text-white mx-2"><i class="fab fa-youtube"></i> YouTube</a>
            </div>
            <div class="contact mt-4">
                <p><i class="fas fa-envelope"></i> Email: info@infokanloker.com</p>
                <p><i class="fas fa-map-marker-alt"></i> Address: Jl. Contoh No.123, Jakarta</p>
            </div>
            <p class="mt-3">&copy; 2024 - All Rights Reserved. Created with ❤️ by Our Team.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
