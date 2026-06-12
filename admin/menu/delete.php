<?php
require_once '../_auth.php';
require_once dirname(__DIR__) . '/../db.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) { header('Location: index.php'); exit; }

$menu = $conn->query("SELECT * FROM menu WHERE id = $id AND warung_id = 1 LIMIT 1")->fetch_assoc();
if ($menu) {
    // Hapus foto jika ada
    if ($menu['foto']) {
        $path = dirname(__DIR__, 2) . '/img/' . $menu['foto'];
        if (file_exists($path)) @unlink($path);
    }
    $conn->query("DELETE FROM menu WHERE id = $id");
}

header('Location: index.php?msg=deleted');
exit;
