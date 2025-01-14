<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer dengan Gradasi dan Efek Hover</title>
    <!-- Tambahkan Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Footer -->
    <footer style="background: linear-gradient(135deg, #000000, #0d47a1); color: white; padding: 20px 0; text-align: center;">
        <h5 style="font-size: 1.5rem; margin-bottom: 20px;">Ikuti Kami</h5>
        <div style="margin-bottom: 20px;">
            <a href="#" class="social-link facebook" style="color: white; margin: 0 10px; text-decoration: none; font-size: 1.5rem;">
                <i class="fab fa-facebook"></i> Facebook
            </a>
            <a href="#" class="social-link instagram" style="color: white; margin: 0 10px; text-decoration: none; font-size: 1.5rem;">
                <i class="fab fa-instagram"></i> Instagram
            </a>
            <a href="#" class="social-link twitter" style="color: white; margin: 0 10px; text-decoration: none; font-size: 1.5rem;">
                <i class="fab fa-twitter"></i> Twitter
            </a>
            <a href="#" class="social-link tiktok" style="color: white; margin: 0 10px; text-decoration: none; font-size: 1.5rem;">
                <i class="fab fa-tiktok"></i> TikTok
            </a>
            <a href="#" class="social-link youtube" style="color: white; margin: 0 10px; text-decoration: none; font-size: 1.5rem;">
                <i class="fab fa-youtube"></i> YouTube
            </a>
        </div>
        <div style="margin-bottom: 20px;">
            <p style="margin: 5px 0;">
                <i class="fas fa-envelope" style="margin-right: 10px;"></i> Email: info@JOBloker.com
            </p>
            <p style="margin: 5px 0;">
                <i class="fas fa-map-marker-alt" style="margin-right: 10px;"></i> Alamat: Jl. Cianjur No.123, Jawa Barat
            </p>
        </div>
        <p style="font-size: 1rem; margin-top: 20px;">&copy; 2025 Job Loker - Semua Hak Dilindungi. Dibuat oleh Tim Kami.</p>
    </footer>

    <!-- CSS untuk Efek Hover dan Animasi -->
    <style>
        /* Efek Hover untuk masing-masing link */
        .social-link {
            position: relative;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            color: #ffc107; /* Warna hover kuning */
            transform: scale(1.1); /* Efek pembesaran sedikit */
        }

        .social-link:before {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 100%;
            height: 2px;
            background-color: #ffc107; /* Garis bawah kuning */
            transform: translateX(-50%);
            visibility: hidden;
            transition: visibility 0s, opacity 0.3s linear;
        }

        .social-link:hover:before {
            visibility: visible;
            opacity: 1;
        }

        /* Warna spesifik untuk masing-masing platform */
        .facebook:hover {
            color: #3b5998; /* Warna Facebook */
        }

        .instagram:hover {
            color: #e4405f; /* Warna Instagram */
        }

        .twitter:hover {
            color: #1da1f2; /* Warna Twitter */
        }

        .tiktok:hover {
            color: #69c9d0; /* Warna TikTok */
        }

        .youtube:hover {
            color: #ff0000; /* Warna YouTube */
        }
    </style>
</body>
</html>
