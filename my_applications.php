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
