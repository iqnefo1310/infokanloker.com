<?php
session_start();
require 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

<<<<<<< HEAD
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
=======
// Fetch user ID from session
$user_id = $_SESSION['user_id'];

// Fetch applications along with job details and applied date
$query = $conn->prepare("
    SELECT applications.job_id, jobs.title, applications.applied_on 
    FROM applications
    JOIN jobs ON applications.job_id = jobs.id
    WHERE applications.applicant_id = ?");  // Menggunakan applicant_id untuk mencocokkan ID pengguna
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

// Check if user has applied to any jobs
if ($result->num_rows > 0) {
    echo '<h2>Your Job Applications</h2>';
    echo '<table class="table table-bordered">';
    echo '<thead><tr><th>Job Title</th><th>Applied On</th></tr></thead>';
    echo '<tbody>';
    
    // Display applications
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
        echo '<td>' . htmlspecialchars($row['applied_on']) . '</td>';
        echo '</tr>';
    }
    
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p>You have not applied to any jobs yet.</p>';
}

$query->close();
?>
>>>>>>> 9c7a0875f8a5c377f7ec9c659722049ea5aec8de
