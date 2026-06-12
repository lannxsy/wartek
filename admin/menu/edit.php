<?php
require_once '../_auth.php';
require_once dirname(__DIR__) . '/../db.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) { header('Location: index.php'); exit; }

$menu = $conn->query("SELECT * FROM menu WHERE id = $id AND warung_id = 1 LIMIT 1")->fetch_assoc();
if (!$menu) { header('Location: index.php'); exit; }

$errors = [];
$data = $menu;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['nama']      = trim($_POST['nama'] ?? '');
    $data['deskripsi'] = trim($_POST['deskripsi'] ?? '');
    $data['harga']     = trim($_POST['harga'] ?? '');

    if (!$data['nama']) $errors[] = 'Nama menu wajib diisi.';
    if (!$data['harga'] || !is_numeric($data['harga'])) $errors[] = 'Harga wajib diisi dengan angka.';

    $fotoName = $menu['foto'];
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg','jpeg','png','webp'])) {
            $errors[] = 'Format foto harus JPG, PNG, atau WebP.';
        } else {
            $newName = 'menu_' . time() . '_' . rand(100,999) . '.' . $ext;
            $uploadDir = dirname(__DIR__, 2) . '/img/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $newName)) {
                if ($fotoName && file_exists($uploadDir . $fotoName)) @unlink($uploadDir . $fotoName);
                $fotoName = $newName;
            } else {
                $errors[] = 'Gagal upload foto.';
            }
        }
    }

    if (isset($_POST['hapus_foto']) && $_POST['hapus_foto'] === '1') {
        $uploadDir = dirname(__DIR__, 2) . '/img/';
        if ($fotoName && file_exists($uploadDir . $fotoName)) @unlink($uploadDir . $fotoName);
        $fotoName = null;
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE menu SET nama=?, deskripsi=?, harga=?, foto=? WHERE id=? AND warung_id=1");
        $stmt->bind_param('ssdsi', $data['nama'], $data['deskripsi'], $data['harga'], $fotoName, $id);
        $stmt->execute();
        ob_end_clean();
        header('Location: index.php?msg=updated');
        exit;
    }
}

$pageTitle = 'Edit Menu';
require_once '../_layout.php';
?>
<?php if (!empty($errors)): ?>
<div class="alert alert-error"><i class="fa fa-exclamation-circle"></i> <?= implode(' &bull; ', array_map('htmlspecialchars', $errors)) ?></div>
<?php endif; ?>
<div class="form-card">
  <form method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label>Nama Menu <span style="color:#ef4444">*</span></label>
      <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" autofocus>
    </div>
    <div class="form-group">
      <label>Deskripsi</label>
      <textarea name="deskripsi"><?= htmlspecialchars($data['deskripsi'] ?? '') ?></textarea>
    </div>
    <div class="form-group">
      <label>Harga (Rp) <span style="color:#ef4444">*</span></label>
      <input type="number" name="harga" value="<?= htmlspecialchars($data['harga']) ?>" min="0">
    </div>
    <div class="form-group">
      <label>Foto Menu</label>
      <?php if ($data['foto']): ?>
      <div style="margin-bottom:10px;display:flex;align-items:center;gap:12px">
        <img src="/wartek/img/<?= htmlspecialchars($data['foto']) ?>" style="width:80px;height:80px;border-radius:8px;object-fit:cover">
        <label style="display:flex;align-items:center;gap:6px;font-weight:400;font-size:.85rem;color:#ef4444;cursor:pointer">
          <input type="checkbox" name="hapus_foto" value="1"> Hapus foto ini
        </label>
      </div>
      <?php endif; ?>
      <input type="file" name="foto" accept="image/*">
      <p class="form-hint">Biarkan kosong jika tidak ingin mengganti foto.</p>
    </div>
    <div style="display:flex;gap:10px;margin-top:8px">
      <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Perbarui</button>
      <a href="index.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Batal</a>
    </div>
  </form>
</div>
<?php require_once '../_layout_end.php'; ?>
