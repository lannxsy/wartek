<?php require_once 'db.php';
$warung = getWarung($conn);
$msgStatus = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pesan = trim($_POST['pesan'] ?? '');

    if (!$nama || !$email || !$pesan) {
        $msgStatus = 'error:Semua field wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msgStatus = 'error:Format email tidak valid.';
    } else {
        $stmt = $conn->prepare("INSERT INTO pesan_kontak (warung_id, nama_pengirim, email_pengirim, isi_pesan) VALUES (1, ?, ?, ?)");
        $stmt->bind_param('sss', $nama, $email, $pesan);
        $msgStatus = $stmt->execute() ? 'success:Pesan berhasil dikirim! Kami akan segera menghubungi Anda.' : 'error:Gagal mengirim pesan, coba lagi.';
    }
}
[$msgType, $msgText] = $msgStatus ? explode(':', $msgStatus, 2) : ['', ''];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Kontak Kami - <?= htmlspecialchars($warung['nama'] ?? 'Warteg Sabili') ?></title>
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
                <a href="menu.php" class="nav-item nav-link">Menu Masakan</a>
                <a href="contact.php" class="nav-item nav-link active">Kontak</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3">Hubungi Kami</h1>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <h5 class="section-title ff-secondary text-start text-primary fw-normal">Kontak</h5>
                    <h1 class="mb-4">Ada Pertanyaan / Pesanan Besar?</h1>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary me-3"></i><?= htmlspecialchars($warung['alamat'] ?? '-') ?></p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-primary me-3"></i><?= htmlspecialchars($warung['no_telepon'] ?? '-') ?></p>
                    <p class="mb-2"><i class="fa fa-clock text-primary me-3"></i>
                        <?= date('H:i', strtotime($warung['jam_buka'] ?? '06:00')) ?> –
                        <?= date('H:i', strtotime($warung['jam_tutup'] ?? '22:00')) ?> WIB
                    </p>
                </div>
                <div class="col-md-6">
                    <?php if ($msgType === 'success'): ?>
                        <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
                            <i class="fa fa-check-circle"></i> <?= htmlspecialchars($msgText) ?>
                        </div>
                    <?php elseif ($msgType === 'error'): ?>
                        <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
                            <i class="fa fa-exclamation-circle"></i> <?= htmlspecialchars($msgText) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="nama" class="form-control"
                                       placeholder="Nama Anda"
                                       value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control"
                                       placeholder="Email Anda"
                                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                            </div>
                            <div class="col-12">
                                <textarea name="pesan" class="form-control"
                                          placeholder="Pesan atau Detail Pesanan Catering"
                                          style="height:150px"><?= htmlspecialchars($_POST['pesan'] ?? '') ?></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Kirim Pesan</button>
                            </div>
                        </div>
                    </form>
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
