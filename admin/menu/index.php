<?php
require_once '../_auth.php';
$pageTitle = 'Menu Masakan';
require_once '../_layout.php';

$msg = $_GET['msg'] ?? '';
$menuList = $conn->query("SELECT * FROM menu WHERE warung_id = 1 ORDER BY id ASC");
?>

<?php if ($msg === 'added'): ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> Menu berhasil ditambahkan.</div>
<?php elseif ($msg === 'updated'): ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> Menu berhasil diperbarui.</div>
<?php elseif ($msg === 'deleted'): ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> Menu berhasil dihapus.</div>
<?php endif; ?>

<div style="margin-bottom:18px">
    <a href="add.php" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Menu</a>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fa fa-utensils" style="color:#FEA116;margin-right:6px"></i> Daftar Menu (<?= $menuList->num_rows ?> item)</h3>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nama Menu</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($menuList->num_rows === 0): ?>
                    <tr><td colspan="6" style="text-align:center;color:#94a3b8;padding:24px">Belum ada menu. <a href="add.php">Tambah sekarang</a></td></tr>
                <?php else: ?>
                    <?php $no = 1; while ($m = $menuList->fetch_assoc()): ?>
                    <tr>
                        <td style="color:#94a3b8"><?= $no++ ?></td>
                        <td>
                            <?php if ($m['foto']): ?>
                                <img src="/wartek/img/<?= htmlspecialchars($m['foto']) ?>" class="foto-preview" alt="">
                            <?php else: ?>
                                <div class="foto-placeholder"><i class="fa fa-image"></i></div>
                            <?php endif; ?>
                        </td>
                        <td><strong><?= htmlspecialchars($m['nama']) ?></strong></td>
                        <td style="color:#64748b;max-width:260px">
                            <?= htmlspecialchars(substr($m['deskripsi'] ?? '', 0, 70)) ?>
                            <?= strlen($m['deskripsi'] ?? '') > 70 ? '...' : '' ?>
                        </td>
                        <td><strong style="color:#FEA116"><?= rupiah($m['harga']) ?></strong></td>
                        <td>
                            <a href="edit.php?id=<?= $m['id'] ?>" class="btn btn-secondary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                            <a href="delete.php?id=<?= $m['id'] ?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin hapus menu <?= htmlspecialchars($m['nama']) ?>?')">
                               <i class="fa fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../_layout_end.php'; ?>
