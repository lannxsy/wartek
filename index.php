<?php require_once 'db.php';
$warung = getWarung($conn);
$menuPopuler = $conn->query("SELECT * FROM menu WHERE warung_id = 1 ORDER BY id ASC LIMIT 3");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($warung['nama'] ?? 'Warteg Sabili') ?> - Simpel & Nikmat</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid bg-white p-0">

    <!-- Navbar -->
    <div class="container-fluid p-0">
        <div class="container position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3 py-lg-0">
                <a href="index.php" class="navbar-brand p-0">
                    <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i><?= htmlspecialchars($warung['nama'] ?? 'Warteg Sabili') ?></h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0 pe-4">
                        <a href="index.php" class="nav-item nav-link active">Home</a>
                        <a href="about.php" class="nav-item nav-link">Tentang Kami</a>
                        <a href="menu.php" class="nav-item nav-link">Menu Masakan</a>
                        <a href="contact.php" class="nav-item nav-link">Kontak</a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Hero Banner -->
        <div class="container-fluid py-5 bg-dark hero-header mb-5">
            <div class="container my-5 py-5">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class="display-3 text-white animated slideInLeft">Sajian Rumahan<br>Nikmat & Hemat</h1>
                        <p class="text-white animated slideInLeft mb-4 pb-2">Nikmati berbagai pilihan masakan khas rumahan yang hangat, segar, dan ramah di kantong setiap hari.</p>
                        <a href="menu.php" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">Lihat Menu</a>
                    </div>
                    <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                        <img class="img-fluid rounded-circle border border-3 border-primary shadow"
                             src="img/lotek.webp" alt="<?= htmlspecialchars($warung['nama'] ?? '') ?>"
                             style="width:500px;height:500px;object-fit:cover;object-position:center;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tentang Kami -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <h5 class="section-title ff-secondary text-start text-primary fw-normal">Tentang Kami</h5>
                    <h1 class="mb-4">Selamat Datang di <i class="fa fa-utensils text-primary me-2"></i><?= htmlspecialchars($warung['nama'] ?? 'Warteg Sabili') ?></h1>
                    <p class="mb-4">Kami menyediakan kelimpahan rasa masakan nusantara dengan konsep bersih, cepat, dan terjangkau untuk semua kalangan.</p>
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                                <h1 class="flex-shrink-0 display-5 text-primary mb-0">10</h1>
                                <div class="ps-4"><p class="mb-0">Tahun</p><h6 class="text-uppercase mb-0">Melayani</h6></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                                <h1 class="flex-shrink-0 display-5 text-primary mb-0"><?= $conn->query("SELECT COUNT(*) as c FROM menu WHERE warung_id=1")->fetch_assoc()['c'] ?></h1>
                                <div class="ps-4"><p class="mb-0">Pilihan</p><h6 class="text-uppercase mb-0">Menu Harian</h6></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-6 text-start"><img class="img-fluid rounded w-100" src="img/lotek.webp" style="object-fit:cover;height:250px;" alt=""></div>
                        <div class="col-6 text-start"><img class="img-fluid rounded w-75" src="img/lotek.webp" style="object-fit:cover;height:180px;margin-top:25%;" alt=""></div>
                        <div class="col-6 text-end"><img class="img-fluid rounded w-75" src="img/lotek.webp" style="object-fit:cover;height:180px;" alt=""></div>
                        <div class="col-6 text-end"><img class="img-fluid rounded w-100" src="img/lotek.webp" style="object-fit:cover;height:250px;" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Populer -->
    <div class="container-fluid py-5 bg-light">
        <div class="container text-center">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Menu Populer</h5>
            <h1 class="mb-5">Menu Unggulan Paling Dicari</h1>
            <div class="row g-4 justify-content-center">
                <?php while ($m = $menuPopuler->fetch_assoc()): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="bg-white p-4 rounded shadow-sm text-center border">
                        <?php if ($m['foto']): ?>
                            <img class="img-fluid rounded-circle border border-2 border-primary mb-3 mx-auto"
                                 src="img/<?= htmlspecialchars($m['foto']) ?>"
                                 style="width:140px;height:140px;object-fit:cover;" alt="<?= htmlspecialchars($m['nama']) ?>">
                        <?php else: ?>
                            <div class="rounded-circle border border-2 border-primary mb-3 mx-auto d-flex align-items-center justify-content-center bg-light"
                                 style="width:140px;height:140px;">
                                <i class="fa fa-utensils fa-2x text-primary"></i>
                            </div>
                        <?php endif; ?>
                        <h5 class="mb-1"><?= htmlspecialchars($m['nama']) ?></h5>
                        <div class="text-primary mb-2">
                            <small class="fa fa-star"></small><small class="fa fa-star"></small>
                            <small class="fa fa-star"></small><small class="fa fa-star"></small>
                            <small class="fa fa-star"></small>
                        </div>
                        <p class="text-muted small"><?= htmlspecialchars($m['deskripsi'] ?? '') ?></p>
                        <h5 class="text-primary m-0"><?= rupiah($m['harga']) ?></h5>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <div class="mt-5">
                <a href="menu.php" class="btn btn-primary py-3 px-5 rounded-pill">Lihat Semua Menu Masakan</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Navigasi</h4>
                    <a class="btn btn-link" href="about.php">Tentang Kami</a>
                    <a class="btn btn-link" href="contact.php">Hubungi Kami</a>
                    <a class="btn btn-link" href="menu.php">Menu Makanan</a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Kontak</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i><?= htmlspecialchars($warung['alamat'] ?? '') ?></p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i><?= htmlspecialchars($warung['no_telepon'] ?? '') ?></p>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Jam Buka</h4>
                    <h5 class="text-light fw-normal">Setiap Hari</h5>
                    <p><?= date('H:i', strtotime($warung['jam_buka'] ?? '06:00')) ?> - <?= date('H:i', strtotime($warung['jam_tutup'] ?? '22:00')) ?></p>
                </div>
            </div>
        </div>
        <div class="container text-center py-3 border-top border-secondary">
            <p>&copy; <?= htmlspecialchars($warung['nama'] ?? 'Warteg Sabili') ?>, All Right Reserved.</p>
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
