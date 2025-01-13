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
            background-color:rgb(23, 93, 163);
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

        .sidebar h2 {
            font-size: 1.5rem;
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
        }

        .sidebar button {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #495057;
            color: #fff;
            text-align: left;
            cursor: pointer;
        }

        .sidebar button:hover {
            background-color: #6c757d;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .hidden {
            display: none;
        }

        .alert {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>Admin Panel</h2>
        <hr>
        <button id="btnHome">Dashboard</button>
        <button id="btnManageUsers">Manage Users</button>
        <button id="btnManageJobs">Manage Jobs</button>
        <button id="btnManageApplications">Manage Applications</button>
        <a href="logout.php" class="btn btn-danger w-100 mt-3">Logout</a>
    </div>

    <div class="content">
        <!-- Dashboard Section -->
        <div id="dashboardSection">
            <h1>Welcome, Admin!</h1>
            <p>Use the buttons in the sidebar to navigate through the admin panel features.</p>

            <?php
            // Include database connection
            require 'config.php';

            // Query for statistics
            $user_query = "SELECT COUNT(*) AS total_users FROM detail_users";
            $user_result = $conn->query($user_query);
            $user_data = $user_result->fetch_assoc();
            $total_users = $user_data['total_users'];

            $job_query = "SELECT COUNT(*) AS total_jobs FROM jobs";
            $job_result = $conn->query($job_query);
            $job_data = $job_result->fetch_assoc();
            $total_jobs = $job_data['total_jobs'];

            $application_query = "SELECT COUNT(*) AS total_applications FROM applications";
            $application_result = $conn->query($application_query);
            $application_data = $application_result->fetch_assoc();
            $total_applications = $application_data['total_applications'];
            ?>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <p class="card-text"><?php echo $total_users; ?> Registered Users</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Jobs</h5>
                            <p class="card-text"><?php echo $total_jobs; ?> Job Listings</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Applications</h5>
                            <p class="card-text"><?php echo $total_applications; ?> Applications Submitted</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Manage Users Section -->
        <div id="manageUsersSection" class="hidden">
            <h2>Manage Users</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $users = $conn->query("SELECT * FROM detail_users");
                    while ($user = $users->fetch_assoc()) {
                        $full_name = $user['first_name'];
                        if (!empty($user['last_name'])) {
                            $full_name .= " " . $user['last_name'];
                        }
                        echo "<tr>
                            <td>{$user['id']}</td>
                            <td>{$full_name}</td>
                            <td>{$user['email']}</td>
                            <td>
                                <a href='edit_user.php?id={$user['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='delete_user.php?id={$user['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Manage Jobs Section -->
        <div id="manageJobsSection" class="hidden">
            <h2>Manage Jobs</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Company</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
$jobs = $conn->query("SELECT jobs.id, jobs.title, companies.company_name 
                      FROM jobs 
                      JOIN companies ON jobs.company_id = companies.id");

while ($job = $jobs->fetch_assoc()) {
    echo "<tr>
        <td>{$job['id']}</td>
        <td>{$job['title']}</td>
        <td>{$job['company_name']}</td>
        <td>
            <a href='editJob.php?id={$job['id']}' class='btn btn-warning btn-sm'>Edit</a>
            <a href='deleteJob.php?id={$job['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this job?');\">Delete</a>
        </td>
    </tr>";
}
?>

                </tbody>
            </table>
        </div>

        <!-- Manage Applications Section -->
        <div id="manageApplicationsSection" class="hidden">
            <h2>Manage Applications</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Job</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $applications = $conn->query("SELECT * FROM applications");
                    while ($app = $applications->fetch_assoc()) {
                        echo "<tr>
                            <td>{$app['id']}</td>
                            <td>{$app['user_id']}</td>
                            <td>{$app['job_id']}</td>
                            <td>{$app['status']}</td>
                            <td>
                                <button class='btn btn-success btn-sm'>Approve</button>
                                <button class='btn btn-danger btn-sm'>Reject</button>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const dashboardSection = document.getElementById('dashboardSection');
        const manageUsersSection = document.getElementById('manageUsersSection');
        const manageJobsSection = document.getElementById('manageJobsSection');
        const manageApplicationsSection = document.getElementById('manageApplicationsSection');

        document.getElementById('btnHome').onclick = () => {
            hideAllSections();
            dashboardSection.classList.remove('hidden');
        };
        document.getElementById('btnManageUsers').onclick = () => {
            hideAllSections();
            manageUsersSection.classList.remove('hidden');
        };
        document.getElementById('btnManageJobs').onclick = () => {
            hideAllSections();
            manageJobsSection.classList.remove('hidden');
        };
        document.getElementById('btnManageApplications').onclick = () => {
            hideAllSections();
            manageApplicationsSection.classList.remove('hidden');
        };

        function hideAllSections() {
            dashboardSection.classList.add('hidden');
            manageUsersSection.classList.add('hidden');
            manageJobsSection.classList.add('hidden');
            manageApplicationsSection.classList.add('hidden');
        }
    </script>
</body>

</html>
