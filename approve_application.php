<?php
// Ambil ID aplikasi dari URL
$id = $_GET['id']; 

// Perbarui status aplikasi menjadi "Approved"
$conn->query("UPDATE applications SET status = 'diterima' WHERE id = $id");

// Redirect kembali ke halaman manage applications
header("Location: manage_applications.php");
exit();
?>
