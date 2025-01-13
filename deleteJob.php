<?php
session_start();

if (!isset($_SESSION['company_id'])) {
    header('Location: commpanyDash.php');
    exit;
}

require_once 'config.php';

if (isset($_GET['id'])) {
    $job_id = $_GET['id'];
}