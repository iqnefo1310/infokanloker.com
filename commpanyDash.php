<?php
session_start();

// Ensure the company is logged in
if (!isset($_SESSION['company_id'])) {
    header('Location: commpanyLogin.php');
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
    
    $update_query = "UPDATE jobs SET title = ?, category_id = ?, location = ?, salary = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssd", $title, $category_id, $location, $salary, $edit_id);
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
    
    $insert_query = "INSERT INTO jobs (company_id, title, category_id, location, salary, created_at) 
                     VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("isssd", $company_id, $title, $category_id, $location, $salary);
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
            <?php if (isset($_GET['add_job']) && $_GET['add_job'] == 'true'): ?>
                <section class="job-form">
                    <h2>Add Job</h2>
                    <form action="commpanyDash.php" method="POST">
                        <label for="title">Job Title:</label>
                        <input type="text" name="title" required>
                        
                        <label for="category_id">Category:</label>
                        <select name="category_id" required>
                            <?php
                            $category_query = "SELECT id, NAME FROM job_categories";
                            $category_result = $conn->query($category_query);
                            while ($category = $category_result->fetch_assoc()) {
                                echo "<option value='{$category['id']}'>{$category['NAME']}</option>";
                            }
                            ?>
                        </select>
                        
                        <label for="location">Location:</label>
                        <input type="text" name="location" required>
                        
                        <label for="salary">Salary:</label>
                        <input type="number" name="salary" required>
                        
                        <button type="submit" name="add_job">Add Job</button>
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
                        
                        <button type="submit" name="edit_job">Update Job</button>
                    </form>
                </section>
            <?php endif; ?>

            <!-- Job Listings -->
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
                                        <a href="commpanyDash.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No job listings available.</p>
                <?php endif; ?>
            </section>
        </div>
    </div>
</body>
</html>
