<?php
session_start();
require 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

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
