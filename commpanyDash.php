<?php
session_start();

// Ensure the company is logged in
if (!isset($_SESSION['company_id'])) {
    header('Location: companyLogin.php');
    exit;
}

require_once 'config.php'; // Database connection

$company_id = $_SESSION['company_id'];

// Handle job deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM jobs WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: commpanyDash.php"); // Redirect after deletion
    exit;
}

// Handle job editing
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $edit_query = "SELECT * FROM jobs WHERE id = ?";
    $stmt = $conn->prepare($edit_query);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $job = $result->fetch_assoc();
}

// Handle job updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_job'])) {
    $edit_id = $_POST['edit_id'];
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $description = $_POST['description']; // Get description from form

    // Update query
    $update_query = "UPDATE jobs SET title = ?, category_id = ?, location = ?, salary = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssi", $title, $category_id, $location, $salary, $description, $edit_id);
    $stmt->execute();
    header("Location: commpanyDash.php"); // Redirect after update
    exit;
}

// Handle job addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_job'])) {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $description = $_POST['description']; // Get description from form

    // Query to insert new job
    $insert_query = "INSERT INTO jobs (company_id, title, category_id, location, salary, description, created_at) 
                     VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("isssss", $company_id, $title, $category_id, $location, $salary, $description);
    $stmt->execute();
    header("Location: commpanyDash.php"); // Redirect after adding
    exit;
}

// Fetch job listings from the database
$query = "SELECT j.id, j.title, jc.NAME as category, j.location, j.salary, j.created_at 
          FROM jobs j
          JOIN job_categories jc ON j.category_id = jc.id
          WHERE j.company_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();

// Handle manage applications
if (isset($_GET['manage_applications'])) {
    // Fetch applications
    $applications_query = "SELECT * FROM applications WHERE job_id IN (SELECT id FROM jobs WHERE company_id = ?)";
    $stmt = $conn->prepare($applications_query);
    $stmt->bind_param("i", $company_id);
    $stmt->execute();
    $applications_result = $stmt->get_result();
}

// Check which section is selected
$add_job = isset($_GET['add_job']);
$manage_applications = isset($_GET['manage_applications']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard</title>
    <link rel="stylesheet" href="css/comdash.css"> <!-- Add your CSS file -->
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Company Dashboard</h2>
            <ul>
                <li><a href="commpanyDash.php">Job Listings</a></li>
                <li><a href="commpanyDash.php?add_job=true">Add Job</a></li>
                <li><a href="commpanyDash.php?manage_applications=true">Manage Applications</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Welcome to Your Dashboard</h1>
                <div class="company-info">
                    <!-- Safely display the company name -->
                    <?php if (isset($_SESSION['company_name'])): ?>
                        <p>Company: <?php echo $_SESSION['company_name']; ?></p>
                    <?php else: ?>
                        <p>Company name not available.</p>
                    <?php endif; ?>
                    <p><a href="logout.php">Logout</a></p>
                </div>
            </header>

            <!-- Add Job Form -->
            <?php if ($add_job): ?>
                <h2 class="text-center mb-4"
                    style="font-family: Arial, sans-serif; font-size: 24px; color: #333;text-align:center">Add Job</h2>
                <section class="job-form container mt-5"
                    style="max-width: 900px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <form action="commpanyDash.php" method="POST">
                        <div class="mb-3" style="margin-bottom: 16px;">
                            <label for="title" class="form-label"
                                style="display: block; font-weight: bold; margin-bottom: 8px;">Job Title:</label>
                            <input type="text" name="title" class="form-control"
                                style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required>
                        </div>

                        <div class="mb-3" style="margin-bottom: 16px;">
                            <label for="category_id" class="form-label"
                                style="display: block; font-weight: bold; margin-bottom: 8px;">Category:</label>
                            <select name="category_id" class="form-select"
                                style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required>
                                <?php
                                $category_query = "SELECT id, NAME FROM job_categories";
                                $category_result = $conn->query($category_query);
                                while ($category = $category_result->fetch_assoc()) {
                                    echo "<option value='{$category['id']}'>{$category['NAME']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3" style="margin-bottom: 16px;">
                            <label for="location" class="form-label"
                                style="display: block; font-weight: bold; margin-bottom: 8px;">Location:</label>
                            <input type="text" name="location" class="form-control"
                                style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required>
                        </div>

                        <div class="mb-3" style="margin-bottom: 16px;">
                            <label for="salary" class="form-label"
                                style="display: block; font-weight: bold; margin-bottom: 8px;">Salary:</label>
                            <input type="number" name="salary" class="form-control"
                                style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required>
                        </div>

                        <div class="mb-3" style="margin-bottom: 16px;">
                            <label for="description" class="form-label"
                                style="display: block; font-weight: bold; margin-bottom: 8px;">Description:</label>
                            <textarea id="description" name="description" class="form-control"
                                style="width: 30vw; min-height: 10vh; padding: 10px; border: 1px solid #ccc; border-radius: 4px; resize: none; font-family: Arial, sans-serif; font-size: 14px; line-height: 1.5;"
                                rows="5" placeholder="Enter a detailed description of the job position..."
                                required></textarea>
                        </div>
                        <script>
                            // Membuat textarea bertambah besar secara otomatis saat mengetik
                            const description = document.getElementById('description');
                            description.addEventListener('input', function () {
                                // Reset tinggi agar tidak bertambah terus menerus
                                this.style.height = 'auto';
                                // Atur tinggi sesuai dengan konten
                                this.style.height = this.scrollHeight + 'px';
                            });
                        </script>
                        
                        <div class="d-grid gap-2" style="text-align: center;">
                            <button type="submit" name="add_job" class="btn btn-primary"
                                style="background-color: #007bff; border: none; color: #fff; padding: 10px 20px; font-size: 16px; border-radius: 4px; cursor: pointer;">Add
                                Job</button>
                        </div>
                    </form>
                </section>
            <?php endif; ?>
            <!-- Edit Job Form -->
            <?php if (isset($_GET['edit_id'])): ?>
                <section class="job-form">
                    <h2>Edit Job</h2>
                    <form action="commpanyDash.php" method="POST">
                        <input type="hidden" name="edit_id" value="<?php echo $job['id']; ?>">

                        <label for="title">Job Title:</label>
                        <input type="text" name="title" value="<?php echo $job['title']; ?>" required>

                        <label for="category_id">Category:</label>
                        <select name="category_id" required>
                            <?php
                            $category_query = "SELECT id, NAME FROM job_categories";
                            $category_result = $conn->query($category_query);
                            while ($category = $category_result->fetch_assoc()) {
                                $selected = ($category['id'] == $job['category_id']) ? "selected" : "";
                                echo "<option value='{$category['id']}' $selected>{$category['NAME']}</option>";
                            }
                            ?>
                        </select>

                        <label for="location">Location:</label>
                        <input type="text" name="location" value="<?php echo $job['location']; ?>" required>

                        <label for="salary">Salary:</label>
                        <input type="number" name="salary" value="<?php echo $job['salary']; ?>" required>

                        <label for="description">Description:</label>
                        <textarea name="description" required><?php echo $job['description']; ?></textarea>

                        <button type="submit" name="edit_job">Update Job</button>
                    </form>
                </section>
            <?php endif; ?>

            <!-- Job Listings (Hidden if Add Job or Manage Applications is clicked) -->
            <?php if (!$add_job && !$manage_applications): ?>
                <section class="job-listings">
                    <h2>Job Listings</h2>
                    <?php if ($result->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Salary</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['title']; ?></td>
                                        <td><?php echo $row['category']; ?></td>
                                        <td><?php echo $row['location']; ?></td>
                                        <td><?php echo $row['salary']; ?></td>
                                        <td><?php echo $row['created_at']; ?></td>
                                        <td>
                                            <a href="commpanyDash.php?edit_id=<?php echo $row['id']; ?>">Edit</a>
                                            <a href="commpanyDash.php?delete_id=<?php echo $row['id']; ?>"
                                                onclick="return confirm('Are you sure?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No job listings available.</p>
                    <?php endif; ?>
                </section>
            <?php endif; ?>

            <!-- Manage Applications Section (Hidden if Add Job or Job Listings is clicked) -->
            <?php
            // Handle job application management
            if (isset($_GET['manage_applications'])) {
                // Fetch applications
                $applications_query = "SELECT a.id, CONCAT(u.first_name, ' ', u.last_name) AS user_name, j.title AS job_title, a.STATUS, a.applied_at, a.applied_on 
                           FROM applications a
                           JOIN detail_users u ON a.applicant_id = u.id
                           JOIN jobs j ON a.job_id = j.id
                           WHERE a.job_id IN (SELECT id FROM jobs WHERE company_id = ?)";
                $stmt = $conn->prepare($applications_query);
                $stmt->bind_param("i", $company_id);
                $stmt->execute();
                $applications_result = $stmt->get_result();
            }
            ?>

            <!-- Manage Applications Section -->
            <?php if ($manage_applications): ?>
                <div class="manage-applications">
                    <h2>Manage Applications</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Job</th>
                                <th>Status</th>
                                <th>Applied On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($app = $applications_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $app['id']; ?></td>
                                    <td><?php echo $app['user_name']; ?></td>
                                    <td><?php echo $app['job_title']; ?></td>
                                    <td>
                                        <form action="commpanyDash.php" method="POST">
                                            <select name="status" class="form-control" onchange="this.form.submit()">
                                                <option value="dalam_proses" <?php echo ($app['STATUS'] == 'dalam_proses') ? 'selected' : ''; ?>>Dalam Proses</option>
                                                <option value="diterima" <?php echo ($app['STATUS'] == 'diterima') ? 'selected' : ''; ?>>Diterima</option>
                                                <option value="ditolak" <?php echo ($app['STATUS'] == 'ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                                            </select>
                                            <input type="hidden" name="application_id" value="<?php echo $app['id']; ?>">
                                        </form>
                                    </td>
                                    <td><?php echo $app['applied_on']; ?></td>
                                    <td>
                                        <a href="commpanyDash.php?view_resume=<?php echo $app['id']; ?>"
                                            class="btn btn-info btn-sm">View Resume</a>
                                        <a href="commpanyDash.php?delete_application=<?php echo $app['id']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this application?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php
            // Handle status update for applications
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'])) {
                $status = $_POST['status'];
                $application_id = $_POST['application_id'];

                // Update application status
                $update_status_query = "UPDATE applications SET STATUS = ? WHERE id = ?";
                $stmt = $conn->prepare($update_status_query);
                $stmt->bind_param("si", $status, $application_id);
                $stmt->execute();

                // Redirect to the same page after status update
                header("Location: commpanyDash.php?manage_applications=true");
                exit;
            }

            // Handle delete application
            if (isset($_GET['delete_application'])) {
                $delete_id = $_GET['delete_application'];
                $delete_query = "DELETE FROM applications WHERE id = ?";
                $stmt = $conn->prepare($delete_query);
                $stmt->bind_param("i", $delete_id);
                $stmt->execute();

                // Redirect after deletion
                header("Location: commpanyDash.php?manage_applications=true");
                exit;
            }
            ?>

        </div>
    </div>
</body>

</html>