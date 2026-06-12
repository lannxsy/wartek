<?php
require_once '_auth.php';
require_once dirname(__DIR__) . '/db.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passLama = $_POST['pass_lama'] ?? '';
    $passBaru = $_POST['pass_baru'] ?? '';
    $passConf = $_POST['pass_konfirmasi'] ?? '';

    $admin = $conn->query("SELECT password FROM admin WHERE id = {$_SESSION['admin_id']} LIMIT 1")->fetch_assoc();

    if (!password_verify($passLama, $admin['password'])) {
        $errors[] = 'Password lama tidak sesuai.';
    }
    if (strlen($passBaru) < 6) {
        $errors[] = 'Password baru minimal 6 karakter.';
    }
    if ($passBaru !== $passConf) {
        $errors[] = 'Konfirmasi password tidak cocok.';
    }

    if (empty($errors)) {
        $hash = password_hash($passBaru, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE admin SET password=? WHERE id=?");
        $stmt->bind_param('si', $hash, $_SESSION['admin_id']);
        $stmt->execute();
        $success = true;
    }
}

$pageTitle = 'Ganti Password';
require_once '_layout.php';
?>

<?php if ($success): ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> Password berhasil diubah.</div>
<?php endif; ?>
<?php if (!empty($errors)): ?>
    <div class="alert alert-error"><i class="fa fa-exclamation-circle"></i> <?= implode(' &bull; ', array_map('htmlspecialchars', $errors)) ?></div>
<?php endif; ?>

<div class="form-card">
    <form method="POST">
        <div class="form-group">
            <label>Password Lama <span style="color:#ef4444">*</span></label>
            <input type="password" name="pass_lama" placeholder="Masukkan password saat ini">
        </div>
        <div class="form-group">
            <label>Password Baru <span style="color:#ef4444">*</span></label>
            <input type="password" name="pass_baru" placeholder="Minimal 6 karakter">
        </div>
        <div class="form-group">
            <label>Konfirmasi Password Baru <span style="color:#ef4444">*</span></label>
            <input type="password" name="pass_konfirmasi" placeholder="Ulangi password baru">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fa fa-key"></i> Ganti Password</button>
    </form>
</div>

<?php require_once '_layout_end.php'; ?>
