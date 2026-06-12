<?php
require_once '../_auth.php';
$pageTitle = 'Pesan Kontak';
require_once '../_layout.php';

// Tandai semua sebagai dibaca kalau buka halaman ini
$conn->query("UPDATE pesan_kontak SET sudah_dibaca = 1 WHERE sudah_dibaca = 0");

// Hapus pesan
if (isset($_GET['hapus'])) {
    $hid = (int)$_GET['hapus'];
    $conn->query("DELETE FROM pesan_kontak WHERE id = $hid AND warung_id = 1");
    header('Location: index.php?msg=deleted');
    exit;
}

$msg = $_GET['msg'] ?? '';
$pesanList = $conn->query("SELECT * FROM pesan_kontak WHERE warung_id = 1 ORDER BY dikirim_at DESC");

// Detail pesan (modal)
$detail = null;
if (isset($_GET['lihat'])) {
    $lid = (int)$_GET['lihat'];
    $detail = $conn->query("SELECT * FROM pesan_kontak WHERE id = $lid AND warung_id = 1 LIMIT 1")->fetch_assoc();
}
?>

<?php if ($msg === 'deleted'): ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> Pesan berhasil dihapus.</div>
<?php endif; ?>

<?php if ($detail): ?>
<div style="background:#fff;border-radius:12px;padding:24px;margin-bottom:24px;box-shadow:0 1px 4px rgba(0,0,0,0.08);max-width:600px;border-left:4px solid #FEA116">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <h3 style="font-size:1rem;color:#1e293b">Detail Pesan</h3>
        <a href="index.php" class="btn btn-secondary btn-sm"><i class="fa fa-times"></i> Tutup</a>
    </div>
    <p style="margin-bottom:6px"><strong>Dari:</strong> <?= htmlspecialchars($detail['nama_pengirim']) ?></p>
    <p style="margin-bottom:6px"><strong>Email:</strong> <?= htmlspecialchars($detail['email_pengirim']) ?></p>
    <p style="margin-bottom:12px"><strong>Waktu:</strong> <?= date('d M Y, H:i', strtotime($detail['dikirim_at'])) ?> WIB</p>
    <div style="background:#f8fafc;border-radius:8px;padding:14px;font-size:0.9rem;line-height:1.6;color:#374151">
        <?= nl2br(htmlspecialchars($detail['isi_pesan'])) ?>
    </div>
    <div style="margin-top:14px">
        <a href="mailto:<?= htmlspecialchars($detail['email_pengirim']) ?>" class="btn btn-success btn-sm">
            <i class="fa fa-reply"></i> Balas via Email
        </a>
        <a href="index.php?hapus=<?= $detail['id'] ?>" class="btn btn-danger btn-sm"
           onclick="return confirm('Yakin hapus pesan ini?')">
           <i class="fa fa-trash"></i> Hapus
        </a>
    </div>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3><i class="fa fa-envelope" style="color:#FEA116;margin-right:6px"></i> Semua Pesan (<?= $pesanList->num_rows ?>)</h3>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Pesan</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($pesanList->num_rows === 0): ?>
                    <tr><td colspan="6" style="text-align:center;color:#94a3b8;padding:28px">Belum ada pesan masuk.</td></tr>
                <?php else: ?>
                    <?php $no = 1; while ($p = $pesanList->fetch_assoc()): ?>
                    <tr>
                        <td style="color:#94a3b8"><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($p['nama_pengirim']) ?></strong></td>
                        <td style="color:#64748b"><?= htmlspecialchars($p['email_pengirim']) ?></td>
                        <td style="max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#64748b">
                            <?= htmlspecialchars(substr($p['isi_pesan'], 0, 70)) ?>
                        </td>
                        <td style="color:#94a3b8;white-space:nowrap;font-size:0.82rem">
                            <?= date('d M Y, H:i', strtotime($p['dikirim_at'])) ?>
                        </td>
                        <td>
                            <a href="index.php?lihat=<?= $p['id'] ?>" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i> Lihat</a>
                            <a href="index.php?hapus=<?= $p['id'] ?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin hapus?')"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../_layout_end.php'; ?>
