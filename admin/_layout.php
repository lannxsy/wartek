<?php
// _layout.php — include SEBELUM output HTML apapun
// Output buffering aktif sejak baris ini, header() tetap bisa dipanggil setelahnya
ob_start();
require_once dirname(__DIR__) . '/db.php';
$unread = countUnread($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title><?= htmlspecialchars($pageTitle ?? '') ?> — Warteg Sabili</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Nunito',sans-serif;background:#f4f6fb;color:#333;display:flex;min-height:100vh}
.sidebar{width:240px;min-height:100vh;background:#0f172a;display:flex;flex-direction:column;flex-shrink:0;position:fixed;top:0;left:0;bottom:0;z-index:100}
.sidebar-brand{padding:24px 20px 16px;border-bottom:1px solid rgba(255,255,255,0.07)}
.sidebar-brand span{color:#FEA116;font-size:1.1rem;font-weight:800}
.sidebar-brand small{display:block;color:#64748b;font-size:.75rem;margin-top:2px}
.sidebar nav{flex:1;padding:16px 0}
.nav-section{padding:8px 20px 4px;font-size:.7rem;color:#475569;text-transform:uppercase;letter-spacing:.08em;font-weight:700}
.nav-item{display:flex;align-items:center;gap:10px;padding:10px 20px;color:#94a3b8;text-decoration:none;font-size:.9rem;font-weight:600;transition:background .15s,color .15s}
.nav-item:hover{background:rgba(255,255,255,.05);color:#fff}
.nav-item.active{background:rgba(254,161,22,.12);color:#FEA116;border-right:3px solid #FEA116}
.nav-item i{width:18px;text-align:center}
.badge-unread{margin-left:auto;background:#ef4444;color:#fff;font-size:.7rem;font-weight:700;border-radius:10px;padding:1px 7px}
.sidebar-footer{padding:16px 20px;border-top:1px solid rgba(255,255,255,.07)}
.sidebar-footer a{display:flex;align-items:center;gap:8px;color:#64748b;text-decoration:none;font-size:.85rem}
.sidebar-footer a:hover{color:#ef4444}
.main-wrapper{margin-left:240px;flex:1;display:flex;flex-direction:column;min-height:100vh}
.topbar{background:#fff;padding:14px 28px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
.topbar h2{font-size:1.05rem;font-weight:700;color:#1e293b}
.topbar-user{display:flex;align-items:center;gap:8px;font-size:.85rem;color:#64748b}
.topbar-user strong{color:#1e293b}
.main-content{padding:28px;flex:1}
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:18px;margin-bottom:28px}
.stat-card{background:#fff;border-radius:12px;padding:20px 22px;display:flex;align-items:center;gap:16px;box-shadow:0 1px 4px rgba(0,0,0,.06)}
.stat-icon{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:#fff;flex-shrink:0}
.stat-icon.orange{background:#FEA116}.stat-icon.blue{background:#3b82f6}.stat-icon.green{background:#10b981}
.stat-info p{font-size:.8rem;color:#94a3b8;margin-bottom:2px}
.stat-info h3{font-size:1.5rem;font-weight:800;color:#1e293b}
.card{background:#fff;border-radius:12px;box-shadow:0 1px 4px rgba(0,0,0,.06);overflow:hidden}
.card-header{padding:16px 22px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between}
.card-header h3{font-size:.95rem;font-weight:700;color:#1e293b}
table{width:100%;border-collapse:collapse;font-size:.875rem}
th{padding:11px 16px;background:#f8fafc;text-align:left;font-weight:700;color:#64748b;font-size:.78rem;text-transform:uppercase;letter-spacing:.04em;border-bottom:1px solid #f1f5f9}
td{padding:13px 16px;border-bottom:1px solid #f8fafc;vertical-align:middle;color:#374151}
tr:last-child td{border-bottom:none}
tr:hover td{background:#fafbfc}
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:.85rem;font-weight:700;font-family:'Nunito',sans-serif;cursor:pointer;border:none;text-decoration:none;transition:opacity .15s}
.btn:hover{opacity:.88}
.btn-primary{background:#FEA116;color:#fff}.btn-secondary{background:#f1f5f9;color:#475569}
.btn-danger{background:#fee2e2;color:#dc2626}.btn-success{background:#d1fae5;color:#065f46}
.btn-sm{padding:5px 10px;font-size:.78rem}
.form-card{background:#fff;border-radius:12px;padding:28px;box-shadow:0 1px 4px rgba(0,0,0,.06);max-width:640px}
.form-group{margin-bottom:18px}
.form-group label{display:block;font-size:.85rem;font-weight:700;color:#374151;margin-bottom:6px}
.form-group input,.form-group textarea,.form-group select{width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:.9rem;font-family:'Nunito',sans-serif;color:#374151;transition:border-color .2s;background:#fff}
.form-group input:focus,.form-group textarea:focus{outline:none;border-color:#FEA116}
.form-group textarea{resize:vertical;min-height:100px}
.form-hint{font-size:.78rem;color:#94a3b8;margin-top:4px}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.alert{padding:12px 16px;border-radius:8px;font-size:.875rem;margin-bottom:20px;display:flex;align-items:center;gap:8px}
.alert-success{background:#d1fae5;color:#065f46;border-left:3px solid #10b981}
.alert-error{background:#fee2e2;color:#dc2626;border-left:3px solid #ef4444}
.badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:700}
.badge-read{background:#f1f5f9;color:#64748b}.badge-unread-item{background:#fef3c7;color:#92400e}
.foto-preview{width:44px;height:44px;border-radius:8px;object-fit:cover}
.foto-placeholder{width:44px;height:44px;border-radius:8px;background:#f1f5f9;display:inline-flex;align-items:center;justify-content:center;color:#cbd5e1}
</style>
</head>
<body>
<aside class="sidebar">
  <div class="sidebar-brand">
    <span><i class="fa fa-utensils"></i> Warteg Sabili</span>
    <small>Panel Admin</small>
  </div>
  <nav>
    <div class="nav-section">Utama</div>
    <a href="/wartek/admin/dashboard.php" class="nav-item <?= isActive('dashboard') ?>"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
    <div class="nav-section">Kelola</div>
    <a href="/wartek/admin/menu/index.php" class="nav-item <?= isActive('/menu/') ?>"><i class="fa fa-utensils"></i> Menu Masakan</a>
    <a href="/wartek/admin/pesan/index.php" class="nav-item <?= isActive('/pesan/') ?>">
      <i class="fa fa-envelope"></i> Pesan Kontak
      <?php if ($unread > 0): ?><span class="badge-unread"><?= $unread ?></span><?php endif; ?>
    </a>
    <a href="/wartek/admin/warung/edit.php" class="nav-item <?= isActive('/warung/') ?>"><i class="fa fa-store"></i> Info Warung</a>
    <div class="nav-section">Akun</div>
    <a href="/wartek/admin/ganti_password.php" class="nav-item <?= isActive('ganti_password') ?>"><i class="fa fa-key"></i> Ganti Password</a>
  </nav>
  <div class="sidebar-footer">
    <a href="/wartek/admin/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
  </div>
</aside>
<div class="main-wrapper">
  <div class="topbar">
    <h2><?= htmlspecialchars($pageTitle ?? '') ?></h2>
    <div class="topbar-user"><i class="fa fa-user-circle"></i> Halo, <strong><?= htmlspecialchars($_SESSION['admin_username'] ?? '') ?></strong></div>
  </div>
  <div class="main-content">
