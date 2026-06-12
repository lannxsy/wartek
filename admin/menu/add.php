<?php
require_once '../_auth.php';
require_once dirname(__DIR__) . '/../db.php';

$errors = [];
$data = ['nama' => '', 'deskripsi' => '', 'harga' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['nama']      = trim($_POST['nama'] ?? '');
    $data['deskripsi'] = trim($_POST['deskripsi'] ?? '');
    $data['harga']     = trim($_POST['harga'] ?? '');

    if (!$data['nama']) $errors[] = 'Nama menu wajib diisi.';
    if (!$data['harga'] || !is_numeric($data['harga'])) $errors[] = 'Harga wajib diisi dengan angka.';

    $fotoName = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg','jpeg','png','webp'])) {
            $errors[] = 'Format foto harus JPG, PNG, atau WebP.';
        } else {
            $fotoName = 'menu_' . time() . '_' . rand(100,999) . '.' . $ext;
            $uploadDir = dirname(__DIR__, 2) . '/img/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $fotoName)) {
                $errors[] = 'Gagal upload foto.';
                $fotoName = null;
            }
        }
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO menu (warung_id, nama, deskripsi, harga, foto) VALUES (1, ?, ?, ?, ?)");
        $stmt->bind_param('ssds', $data['nama'], $data['deskripsi'], $data['harga'], $fotoName);
        $stmt->execute();
        ob_end_clean();
        header('Location: index.php?msg=added');
        exit;
    }
}

$pageTitle = 'Tambah Menu';
require_once '../_layout.php';
?>
<?php if (!empty($errors)): ?>
<div class="alert alert-error"><i class="fa fa-exclamation-circle"></i> <?= implode(' &bull; ', array_map('htmlspecialchars', $errors)) ?></div>
<?php endif; ?>
<div class="form-card">
  <form method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label>Nama Menu <span style="color:#ef4444">*</span></label>
      <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" placeholder="cth: Lotek, Pepes Ayam" autofocus>
    </div>
    <div class="form-group">
      <label>Deskripsi</label>
      <textarea name="deskripsi" placeholder="Deskripsi singkat menu..."><?= htmlspecialchars($data['deskripsi']) ?></textarea>
    </div>
    <div class="form-group">
      <label>Harga (Rp) <span style="color:#ef4444">*</span></label>
      <input type="number" name="harga" value="<?= htmlspecialchars($data['harga']) ?>" placeholder="cth: 15000" min="0">
    </div>
    <div class="form-group">
      <label>Foto Menu</label>
      <input type="file" name="foto" accept="image/*">
      <p class="form-hint">Format: JPG, PNG, WebP. Opsional.</p>
    </div>
    <div style="display:flex;gap:10px;margin-top:8px">
      <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
      <a href="index.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Batal</a>
    </div>
  </form>
</div>
<?php require_once '../_layout_end.php'; ?>
