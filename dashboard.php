<?php
session_start();
require 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch user data from database
$user_id = $_SESSION['user_id'];
$query = $conn->prepare("SELECT first_name, last_name, email FROM detail_users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$query->bind_result($first_name, $last_name, $email);
$query->fetch();
$query->close();

// Fetch job listings with company name
$jobs_query = $conn->prepare("SELECT jobs.id, jobs.title, companies.company_name, jobs.location, jobs.salary, jobs.description FROM jobs JOIN companies ON jobs.company_id = companies.id");
$jobs_query->execute();
$jobs_result = $jobs_query->get_result();
$jobs_query->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .job-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .job-card h5 {
            color: #007bff;
            margin-bottom: 10px;
        }

        .job-card p {
            margin: 5px 0;
        }

        .job-card .btn {
            margin-top: 10px;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg" style="background: linear-gradient(90deg,rgb(40, 62, 163),rgb(237, 239, 240)); color: white;">
    <div class="container-fluid">
        <!-- Tambahkan gambar logo di sini -->
        <a class="navbar-brand d-flex align-items-center" href="dashboard.php" style="color: white;">
            <img src="assets/2-removebg-preview.png" alt="InfokanLoker Logo" style="height: 200px; margin-right: 10px;">
            JOBLoker
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php" style="color: white;">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="job_listings.php" style="color: white;">
                        <i class="fas fa-briefcase"></i> Job Listings
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="my_applications.php" style="color: white;">
                        <i class="fas fa-list-alt"></i> My Applications
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php" style="color: white;">
                        <i class="fas fa-user"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" style="color: white;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container mt-5">
        <h2>Welcome, <?php echo htmlspecialchars($first_name . ' ' . $last_name); ?>!</h2>

        <!-- User Profile -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>Your Profile</h4>
            </div>
            <div class="card-body">
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></p>
            </div>
        </div>

        <h4>Image Gallery</h4>
<div class="image-section" style="display: flex; flex-wrap: wrap; gap: 15px;">
    <div class="image-item" style="flex: 1 1 calc(50% - 15px); text-align: center;">
        <img src="assets/6.jpg" alt="Image 1" class="hover-image" style="width: 100%; height: auto; border-radius: 8px;">
        <p style="margin-top: 10px; font-size: 1.1rem;">Temukan berbagai peluang kerja terbaru dengan mudah diJOBLoker. Aplikasi ini menyediakan daftar pekerjaan terkini dari berbagai industri, membantu Anda menemukan pekerjaan yang sesuai dengan keahlian dan minat Anda. Mulai langkah karier Anda hari ini!</p>
    </div>
    <div class="image-item" style="flex: 1 1 calc(50% - 15px); text-align: center;">
        <img src="assets/7.jpg" alt="Image 2" class="hover-image" style="width: 100%; height: auto; border-radius: 8px;">
        <p style="margin-top: 10px; font-size: 1.1rem;">Aplikasi Pencarian Kerja yang Mudah dan CepatJOBLoker memungkinkan Anda mencari pekerjaan dengan cepat dan efisien. Dengan fitur pencarian yang canggih dan kategori pekerjaan yang terorganisir, Anda dapat menemukan pekerjaan yang tepat hanya dengan beberapa klik.</p>
    </div>
    <div class="image-item" style="flex: 1 1 calc(50% - 15px); text-align: center;">
        <img src="assets/8.jpg" alt="Image 3" class="hover-image" style="width: 100%; height: auto; border-radius: 8px;">
        <p style="margin-top: 10px; font-size: 1.1rem;">Aplikasi yang Memberikan Kemudahan Melamar Pekerjaan Tidak hanya menemukan pekerjaan,JOBLoker juga memudahkan Anda untuk mengajukan lamaran. Dapatkan akses langsung ke pekerjaan impian Anda dan kirimkan aplikasi dengan mudah. Semuanya hanya dalam satu aplikasi yang user-friendly.</p>
    </div>
    <div class="image-item" style="flex: 1 1 calc(50% - 15px); text-align: center;">
        <img src="assets/9.jpg" alt="Image 4" class="hover-image" style="width: 100%; height: auto; border-radius: 8px;">
        <p style="margin-top: 10px; font-size: 1.1rem;">Jelajahi Berbagai Perusahaan TerkenalJOBLoker menghubungkan Anda dengan berbagai perusahaan ternama yang membuka lowongan pekerjaan. Lihat informasi tentang perusahaan-perusahaan tersebut, termasuk gaji, lokasi, dan deskripsi pekerjaan yang lebih detail untuk membantu Anda membuat keputusan yang tepat.</p>
    </div>
    <div class="image-item" style="flex: 1 1 calc(50% - 15px); text-align: center;">
        <img src="assets/10.jpg" alt="Image 5" class="hover-image" style="width: 100%; height: auto; border-radius: 8px;">
        <p style="margin-top: 10px; font-size: 1.1rem;">Rata-rata 10.000 Lamaran Diterima Setiap Bulan
        Setiap bulan, ribuan pengguna kami berhasil mendapatkan pekerjaan baru, membuktikan keefektifan aplikasi ini dalam menjembatani pencari kerja dan perusahaan.</p>
    </div>
    <div class="image-item" style="flex: 1 1 calc(50% - 15px); text-align: center;">
        <img src="assets/11.jpg" alt="Image 5" class="hover-image" style="width: 100%; height: auto; border-radius: 8px;">
        <p style="margin-top: 10px; font-size: 1.1rem;">Lebih dari 1 Juta Lowongan Tersedia
        Aplikasi kami menyediakan akses ke lebih dari 1 juta lowongan kerja dari berbagai industri dan lokasi di seluruh Indonesia, memastikan Anda selalu memiliki peluang untuk menemukan pekerjaan impian.</p>
    </div>

</div>

<style>
    .hover-image {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-image:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(126, 167, 243, 0.2);
    }
</style>

    <!-- Include Footer -->
    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
