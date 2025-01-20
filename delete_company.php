<?php
require 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM companies WHERE id = $id");
}

header("Location: adminDashboard.php");
?>
