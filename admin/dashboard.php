<?php
require_once '_auth.php';
$pageTitle = 'Dashboard';
require_once '_layout.php';

// Statistik
$totalMenu   = $conn->query("SELECT COUNT(*) as c FROM menu")->fetch_assoc()['c'];
$totalPesan  = $conn->query("SELECT COUNT(*) as c FROM pesan_kontak")->fetch_assoc()['c'];
$pesanBaru   = $conn->query("SELECT COUNT(*) as c FROM pesan_kontak WHERE sudah_dibaca = 0")->fetch_assoc()['c'];

// 5 pesan terbaru
$pesanTerbaru = $conn->query("SELECT * FROM pesan_kontak ORDER BY dikirim_at DESC LIMIT 5");
?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fa fa-utensils"></i></div>
        <div class="stat-info">
            <p>Total Menu</p>
            <h3><?= $totalMenu ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fa fa-envelope"></i></div>
        <div class="stat-info">
            <p>Total Pesan</p>
            <h3><?= $totalPesan ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fa fa-bell"></i></div>
        <div class="stat-info">
            <p>Pesan Belum Dibaca</p>
            <h3><?= $pesanBaru ?></h3>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fa fa-envelope" style="color:#FEA116;margin-right:6px"></i> Pesan Terbaru</h3>
        <a href="pesan/index.php" class="btn btn-secondary btn-sm">Lihat Semua</a>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Pesan</th>
                    <th>Waktu</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($pesanTerbaru->num_rows === 0): ?>
                    <tr><td colspan="5" style="text-align:center;color:#94a3b8;padding:24px">Belum ada pesan masuk.</td></tr>
                <?php else: ?>
                    <?php while ($p = $pesanTerbaru->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($p['nama_pengirim']) ?></strong></td>
                        <td style="color:#64748b"><?= htmlspecialchars($p['email_pengirim']) ?></td>
                        <td style="max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                            <?= htmlspecialchars(substr($p['isi_pesan'], 0, 80)) ?>...
                        </td>
                        <td style="color:#94a3b8;white-space:nowrap"><?= date('d M Y H:i', strtotime($p['dikirim_at'])) ?></td>
                        <td>
                            <?php if (!$p['sudah_dibaca']): ?>
                                <span class="badge badge-unread-item">Baru</span>
                            <?php else: ?>
                                <span class="badge badge-read">Dibaca</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '_layout_end.php'; ?>
