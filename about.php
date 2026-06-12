<?php require_once 'db.php';
$warung = getWarung($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tentang Kami - <?= htmlspecialchars($warung['nama'] ?? 'Warteg Sabili') ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid bg-white p-0">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3 py-lg-0">
        <a href="index.php" class="navbar-brand p-0"><h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i><?= htmlspecialchars($warung['nama'] ?? 'Warteg Sabili') ?></h1></a>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0 pe-4">
                <a href="index.php" class="nav-item nav-link">Home</a>
                <a href="about.php" class="nav-item nav-link active">Tentang Kami</a>
                <a href="menu.php" class="nav-item nav-link">Menu Masakan</a>
                <a href="contact.php" class="nav-item nav-link">Kontak</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3">Tentang Kami</h1>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-12 text-center">
                    <h5 class="section-title ff-secondary text-primary fw-normal">Cerita Kami</h5>
                    <h1 class="mb-4">Dedikasi Rasa Kuliner Rumahan</h1>
                    <p class="mb-4">Warteg Sabili berkomitmen menyajikan makanan yang bersih, bergizi, hangat, dan ramah di kantong mahasiswa maupun pekerja. Semua bumbu diolah secara tradisional untuk menjaga rasa asli masakan ibu di rumah.</p>
                </div>
            </div>

            <!-- Info Warung dari Database -->
            <div class="row g-4 justify-content-center mt-2">
                <div class="col-md-4 text-center">
                    <div class="border rounded p-4 h-100">
                        <i class="fa fa-map-marker-alt fa-2x text-primary mb-3"></i>
                        <h6 class="fw-bold">Alamat</h6>
                        <p class="text-muted mb-0"><?= nl2br(htmlspecialchars($warung['alamat'] ?? '-')) ?></p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="border rounded p-4 h-100">
                        <i class="fa fa-phone-alt fa-2x text-primary mb-3"></i>
                        <h6 class="fw-bold">Telepon</h6>
                        <p class="text-muted mb-0"><?= htmlspecialchars($warung['no_telepon'] ?? '-') ?></p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="border rounded p-4 h-100">
                        <i class="fa fa-clock fa-2x text-primary mb-3"></i>
                        <h6 class="fw-bold">Jam Buka</h6>
                        <p class="text-muted mb-0">
                            Setiap Hari<br>
                            <?= date('H:i', strtotime($warung['jam_buka'] ?? '06:00')) ?> –
                            <?= date('H:i', strtotime($warung['jam_tutup'] ?? '22:00')) ?> WIB
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Maps -->
    <div class="container-fluid py-5 bg-light border-top">
        <div class="container">
            <div class="text-center mb-4">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Lokasi</h5>
                <h1 class="mb-3">Kunjungi Warung Kami</h1>
                <p><?= htmlspecialchars($warung['alamat'] ?? '') ?></p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="rounded overflow-hidden shadow" style="height:400px;">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.5!2d107.6780!3d-6.9350!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68c2af91e3c397%3A0xd2479f74f74df852!2sWaroeng%20Lotek%20Ceu%20Dedah!5e0!3m2!1sid!2sid!4v1710000000000!5m2!1sid!2sid"
                            width="100%" height="100%" style="border:0;"
                            allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-dark text-light footer pt-5">
        <div class="container text-center py-3">
            <p>&copy; <?= htmlspecialchars($warung['nama'] ?? 'Warteg Sabili') ?>, All Right Reserved.</p>
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
