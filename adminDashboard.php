<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            overflow-x: hidden;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #343a40;
            color: #fff;
            padding: 15px;
            width: 250px;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2 class="text-center">Admin Panel</h2>
    <hr>
    <a href="dashboard.php">Dashboard</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="manage_jobs.php">Manage Jobs</a>
    <a href="manage_applications.php">Manage Applications</a>
    <a href="logout.php" class="text-danger">Logout</a>
</div>

<div class="content">
    <h1>Welcome, Admin!</h1>
    <p>Use the sidebar to navigate through the admin panel features.</p>

    <!-- Example: Display User Count -->
    <?php
    // Koneksi ke database
    require 'config.php';

    // Query jumlah pengguna
    $user_query = "SELECT COUNT(*) AS total_users FROM users";
    $user_result = $conn->query($user_query);
    $user_data = $user_result->fetch_assoc();
    $total_users = $user_data['total_users'];

    // Query jumlah pekerjaan
    $job_query = "SELECT COUNT(*) AS total_jobs FROM jobs";
    $job_result = $conn->query($job_query);
    $job_data = $job_result->fetch_assoc();
    $total_jobs = $job_data['total_jobs'];
    ?>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text"><?php echo $total_users; ?> Registered Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Jobs</h5>
                    <p class="card-text"><?php echo $total_jobs; ?> Job Listings</p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
