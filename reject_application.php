<?php
// Ambil ID aplikasi dari URL
$id = $_GET['id']; 

// Perbarui status aplikasi menjadi "Rejected"
$conn->query("UPDATE applications SET status = 'ditolak' WHERE id = $id");

// Redirect kembali ke halaman manage applications
header("Location: manage_applications.php");
exit();
?>
