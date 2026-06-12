<?php require_once 'db.php';
$warung = getWarung($conn);
$menuList = $conn->query("SELECT * FROM menu WHERE warung_id = 1 ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Menu Masakan - <?= htmlspecialchars($warung['nama'] ?? 'Warteg Sabili') ?></title>
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
                <a href="about.php" class="nav-item nav-link">Tentang Kami</a>
                <a href="menu.php" class="nav-item nav-link active">Menu Masakan</a>
                <a href="contact.php" class="nav-item nav-link">Kontak</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3">Menu Masakan</h1>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-4">
                <?php if ($menuList->num_rows === 0): ?>
                    <div class="col-12 text-center text-muted py-5">
                        <i class="fa fa-utensils fa-3x mb-3 d-block"></i>
                        Menu sedang dipersiapkan.
                    </div>
                <?php else: ?>
                    <?php while ($m = $menuList->fetch_assoc()): ?>
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center border p-3 rounded">
                            <?php if ($m['foto']): ?>
                                <img src="img/<?= htmlspecialchars($m['foto']) ?>"
                                     style="width:64px;height:64px;object-fit:cover;border-radius:8px;flex-shrink:0;" alt="">
                            <?php else: ?>
                                <div style="width:64px;height:64px;background:#f1f5f9;border-radius:8px;flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                                    <i class="fa fa-utensils text-primary"></i>
                                </div>
                            <?php endif; ?>
                            <div class="w-100 d-flex flex-column text-start ps-3">
                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                    <span><?= htmlspecialchars($m['nama']) ?></span>
                                    <span class="text-primary"><?= rupiah($m['harga']) ?></span>
                                </h5>
                                <small class="text-muted"><?= htmlspecialchars($m['deskripsi'] ?? '') ?></small>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php endif; ?>
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
