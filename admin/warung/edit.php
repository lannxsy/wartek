<?php
require_once '../_auth.php';
require_once dirname(__DIR__) . '/../db.php';

$warung = $conn->query("SELECT * FROM warung WHERE id = 1 LIMIT 1")->fetch_assoc();
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama'] ?? '');
    $alamat   = trim($_POST['alamat'] ?? '');
    $telp     = trim($_POST['no_telepon'] ?? '');
    $jamBuka  = $_POST['jam_buka'] ?? '';
    $jamTutup = $_POST['jam_tutup'] ?? '';

    if (!$nama) $errors[] = 'Nama warung wajib diisi.';

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE warung SET nama=?, alamat=?, no_telepon=?, jam_buka=?, jam_tutup=? WHERE id=1");
        $stmt->bind_param('sssss', $nama, $alamat, $telp, $jamBuka, $jamTutup);
        $stmt->execute();
        $warung = $conn->query("SELECT * FROM warung WHERE id = 1 LIMIT 1")->fetch_assoc();
        $success = true;
    }
}

$pageTitle = 'Info Warung';
require_once '../_layout.php';
?>

<?php if ($success): ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> Info warung berhasil diperbarui.</div>
<?php endif; ?>
<?php if (!empty($errors)): ?>
    <div class="alert alert-error"><i class="fa fa-exclamation-circle"></i> <?= implode(' &bull; ', array_map('htmlspecialchars', $errors)) ?></div>
<?php endif; ?>

<div class="form-card">
    <form method="POST">
        <div class="form-group">
            <label>Nama Warung <span style="color:#ef4444">*</span></label>
            <input type="text" name="nama" value="<?= htmlspecialchars($warung['nama'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat"><?= htmlspecialchars($warung['alamat'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <label>Nomor Telepon</label>
            <input type="text" name="no_telepon" value="<?= htmlspecialchars($warung['no_telepon'] ?? '') ?>" placeholder="cth: 081234567890">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Jam Buka</label>
                <input type="time" name="jam_buka" value="<?= htmlspecialchars($warung['jam_buka'] ?? '06:00') ?>">
            </div>
            <div class="form-group">
                <label>Jam Tutup</label>
                <input type="time" name="jam_tutup" value="<?= htmlspecialchars($warung['jam_tutup'] ?? '22:00') ?>">
            </div>
        </div>
        <div style="margin-top:8px">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>

<?php require_once '../_layout_end.php'; ?>
