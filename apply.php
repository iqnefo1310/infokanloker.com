<?php
session_start();
require 'config.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id']; // ID pengguna dari sesi
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input dan upload file
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['resume']['tmp_name'];
        $fileName = $_FILES['resume']['name'];
        $fileSize = $_FILES['resume']['size'];
        $fileType = $_FILES['resume']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedfileExtensions = ['pdf', 'doc', 'docx'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = 'uploads/';
            $dest_path = $uploadFileDir . $user_id . '_' . time() . '_' . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Simpan data ke database
                $stmt = $conn->prepare("INSERT INTO applications (job_id, applicant_id, RESUME) VALUES (?, ?, ?)");
                $stmt->bind_param("iis", $job_id, $user_id, $dest_path);
                if ($stmt->execute()) {
                    $success_message = "Lamaran berhasil dikirim!";
                } else {
                    $error_message = "Terjadi kesalahan saat menyimpan lamaran.";
                }
                $stmt->close();
            } else {
                $error_message = "Gagal mengunggah file. Silakan coba lagi.";
            }
        } else {
            $error_message = "Format file tidak didukung. Harap unggah file PDF, DOC, atau DOCX.";
        }
    } else {
        $error_message = "Harap unggah resume Anda.";
    }
}

// Ambil detail pekerjaan untuk ditampilkan
$stmt = $conn->prepare("SELECT title FROM jobs WHERE id = ?");
$stmt->bind_param("i", $job_id);
$stmt->execute();
$stmt->bind_result($job_title);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lamaran Pekerjaan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Apply for: <?php echo htmlspecialchars($job_title); ?></h3>
    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>
    <?php if ($success_message): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="resume" class="form-label">Unggah Resume (PDF, DOC, DOCX):</label>
            <input type="file" name="resume" id="resume" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Lamaran</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali ke Daftar Pekerjaan</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
