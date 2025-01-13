<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        /* Header */
        header {
            background-color:rgb(176, 179, 182);
            color: white;
            padding: 30px 0;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        header img {
            max-height: 200px;
            margin-bottom: 10px;
            transition: transform 0.3s ease;
        }

        header img:hover {
            transform: scale(1.1);
        }

        header h1 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        header a {
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            margin: 5px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1rem;
            transition: background-color 0.3s, transform 0.3s;
        }

        header a:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        header a:active {
            transform: translateY(2px);
        }

        /* Main Content */
        main {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }

        main h2 {
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 20px;
    color:rgb(10, 10, 10);
    text-align: center; /* Memusatkan teks secara horizontal */
    transition: color 0.3s ease, transform 0.3s ease; /* Menambahkan transisi untuk efek hover */
}
main p {
    font-size: 3rem;
    font-weight: 600;
    margin-bottom: 20px;
    color:rgb(243, 245, 248);
    text-align: center; /* Memusatkan teks secara horizontal */
    transition: color 0.3s ease, transform 0.3s ease; /* Menambahkan transisi untuk efek hover */
}

main h2:hover {
    color: #007bff; /* Warna teks saat hover */
    transform: scale(1.05); /* Membesarkan teks sedikit saat hover */
}
        main img {
        max-height: 900px;
        width: 70%;
        object-fit: cover;
        margin: 0 auto 20px; /* Menggunakan auto untuk margin kiri dan kanan untuk memusatkan gambar */
        display: block; /* Menjadikan gambar sebagai block element */
        transition: transform 0.3s ease;
}

        main img:hover {
            transform: scale(1.05);
        }

        main p {
            font-size: 1rem;
            line-height: 1.6;
            color: #555;
        }

        /* Footer */
        footer {
            background-color: #343a40;
            color: white;
            padding: 30px 0;
            text-align: center;
            box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.1);
        }

        footer h5 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        footer a {
            color: white;
            margin: 0 12px;
            text-decoration: none;
            font-size: 1.2rem;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #ffc107;
        }

        footer p {
            margin: 5px 0;
            font-size: 1rem;
        }

        footer .social-icons {
            margin-bottom: 20px;
        }

        footer .social-icons a {
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }

        footer .social-icons a:hover {
            transform: scale(1.1);
        }

        footer .social-icons i {
            margin-right: 8px;
        }

        footer p:last-child {
            margin-top: 20px;
            font-size: 1rem;
        }

    </style>
</head>

<body>

    <!-- Header -->
    <header>
        <div style="max-width: 1200px; margin: 0 auto;">
            <img src="assets/LOGO-removebg-preview.png" alt="Logo Infokan Loker">
            <h1>Welcome to Job Loker</h1>
            <div>
                <a href="login.php"><i class="fas fa-briefcase"></i> Cari Pekerjaan</a>
                <a href="adminLogin.php"><i class="fas fa-user-shield"></i> Kelola Admin</a>
                <a href="commpanyLogin.php"><i class="fas fa-building"></i> Kelola Perusahaan</a>
            </div>
        </div>
    </header>

    <!-- Main content -->
    <main>
        <section style="margin-bottom: 40px;">
            <h2><i class="fas fa-info-circle"></i> Informasi Pekerjaan</h2>
            <img src="assets/1.1 pamplet.jpg" alt="Informasi Pekerjaan">
            <p>Di Job Loker, kami menyediakan berbagai informasi pekerjaan dari berbagai industri dan perusahaan terkemuka. Anda dapat menemukan pekerjaan yang sesuai dengan keahlian dan pengalaman Anda, serta mendapatkan informasi terkait proses perekrutan dan syarat yang dibutuhkan.</p>
        </section>

        <section style="margin-bottom: 40px;">
            <h2><i class="fas fa-thumbs-up"></i> Keunggulan Kami</h2>
            <img src="assets/2.jpg" alt="Keunggulan Kami">
            <p>Job Loker menawarkan kemudahan dalam mencari pekerjaan, dengan fitur pencarian yang canggih, pengelompokan pekerjaan berdasarkan kategori, dan pemberitahuan terbaru tentang lowongan kerja. Kami juga memberikan tips dan panduan untuk membantu Anda dalam proses pencarian kerja dan pengembangan karir.</p>
        </section>

        <section style="margin-bottom: 40px;">
            <h2><i class="fas fa-building"></i> Informasi Perusahaan</h2>
            <img src="assets/5.jpg" alt="Informasi Perusahaan">
            <p>Job Loker bekerja sama dengan berbagai perusahaan yang mencari talenta terbaik untuk bergabung dalam tim mereka. Di sini, Anda bisa menemukan perusahaan-perusahaan dengan reputasi baik yang menawarkan kesempatan karir menarik. Kami juga menyediakan informasi lengkap tentang perusahaan yang membuka lowongan kerja.</p>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div style="max-width: 1200px; margin: 0 auto;">
            <h5>Ikuti Kami</h5>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
                <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
                <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
                <a href="#"><i class="fab fa-tiktok"></i> TikTok</a>
                <a href="#"><i class="fab fa-youtube"></i> YouTube</a>
            </div>
            <div>
                <p><i class="fas fa-envelope"></i> Email: info@infokanloker.com</p>
                <p><i class="fas fa-map-marker-alt"></i> Alamat: Jl. Contoh No.123, Jakarta</p>
            </div>
            <p>&copy; 2024 Job Loker - Semua Hak Dilindungi. Dibuat dengan ❤️ oleh Tim Kami.</p>
        </div>
    </footer>

</body>

</html>
