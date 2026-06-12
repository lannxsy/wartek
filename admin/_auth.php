<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/') - 2) . 'admin/login.php');
    exit;
}

function countUnread($conn) {
    $r = $conn->query("SELECT COUNT(*) as total FROM pesan_kontak WHERE sudah_dibaca = 0");
    return $r ? $r->fetch_assoc()['total'] : 0;
}