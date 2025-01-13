<?php
require 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM detail_users WHERE id = $id");
}

header("Location: adminDashboard.php");
?>
