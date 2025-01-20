<?php
// Ambil ID aplikasi dari URL
$id = $_GET['id']; 

// Ambil detail aplikasi dari database
$app_query = $conn->query("SELECT * FROM applications WHERE id = $id");
$app = $app_query->fetch_assoc();

// Tampilkan detail aplikasi
echo "<h2>Application Details</h2>";
echo "<p>User: " . $app['user_id'] . "</p>";
echo "<p>Job: " . $app['job_id'] . "</p>";
echo "<p>Status: " . $app['status'] . "</p>";
?>
