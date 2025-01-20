<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            overflow-x: hidden;
            background-color: rgb(135, 171, 207);
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
            z-index: 1000;
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
            transition: background-color 0.3s ease;
        }

        .sidebar button:hover {
            background-color: #007bff;
            transform: scale(1.05);
        }

        .sidebar button i {
            margin-right: 10px;
            transition: transform 0.3s ease;
        }

        .sidebar button:hover i {
            transform: rotate(15deg);
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
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

        .row {
            margin-top: 20px;
        }

        .card-title {
            font-weight: bold;
        }

        .card-text {
            font-size: 1.1rem;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>Admin Panel</h2>
        <hr>
        <button id="btnHome">
            <i class="bi bi-house-door"></i> Dashboard
        </button>
        <button id="btnManageUsers">
            <i class="bi bi-person"></i> Manage Users
        </button>
        <button id="btnManageCompanies">
            <i class="bi bi-person"></i> Manage Companies
        </button>
        <button id="btnManageJobs">
            <i class="bi bi-briefcase"></i> Manage Jobs
        </button>
        <a href="logout.php" class="btn btn-danger w-100 mt-3">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>

    <div class="content">
        <!-- Dashboard Section -->
        <div id="dashboardSection" style="text-align: center;">
            <p>Gunakan tombol di sidebar untuk menavigasi melalui fitur panel admin.</p>
            <img src="assets/hai admin.png" alt="Pamflet" style="max-width: 100%; height: auto; border-radius: 1px;">

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

            <div class="row">
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
                                <a href='edit_user.php?id={$user['id']}' class='btn btn-warning btn-sm'>
                                    <i class='bi bi-pencil-square'></i> Edit
                                </a>
                                <a href='delete_user.php?id={$user['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this user?');\">
                                    <i class='bi bi-trash'></i> Delete
                                </a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Manage Company Section -->
        <div id="manageCompaniesSection" class="hidden">
            <h2>Manage Users</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Company Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $users = $conn->query("SELECT * FROM companies");
                    while ($user = $users->fetch_assoc()) {
                        
                        echo "<tr>
                            <td>{$user['id']}</td>
                            <td>{$user['company_name']}</td>
                            <td>{$user['email']}</td>
                            <td>
                                <a href='delete_company.php?id={$user['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this Companies?');\">
                                    <i class='bi bi-trash'></i> Delete
                                </a>
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
                    echo 
                    "<tr>
                        <td>{$job['id']}</td>
                        <td>{$job['title']}</td>
                        <td>{$job['company_name']}</td>
                        <td>
                            <a href='commpanyLogin.php?id={$job['id']}' class='btn btn-warning btn-sm' onclick=\"return confirm('Jika Ingin Mengedit Pekerjaan Silahkan Login Ke Perusahaan, Apakah Anda Mau Beralih Sekarang?');\">
                                <i class='bi bi-pencil-square'></i> Edit
                            </a>
                            <a href='commpanyLogin.php?id={$job['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Jika Ingin Mengedit Pekerjaan Silahkan Login Ke Perusahaan, Apakah Anda Mau Beralih Sekarang?');\">
                                <i class='bi bi-trash'></i> Delete
                            </a>
                        </td>
                    </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('btnHome').addEventListener('click', function () {
            toggleSections('dashboardSection');
        });

        document.getElementById('btnManageUsers').addEventListener('click', function () {
            toggleSections('manageUsersSection');
        });

        document.getElementById('btnManageJobs').addEventListener('click', function () {
            toggleSections('manageJobsSection');
        });

        document.getElementById('btnManageCompanies').addEventListener('click', function () {
            toggleSections('manageCompaniesSection');
        });

        function toggleSections(sectionId) {
            const sections = document.querySelectorAll('.content > div');
            sections.forEach(section => {
                if (section.id === sectionId) {
                    section.classList.remove('hidden');
                } else {
                    section.classList.add('hidden');
                }
            });
        }
    </script>

</body>

</html>