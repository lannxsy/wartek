<?php
// =============================================
// db.php — Koneksi ke database MySQL
// Letakkan file ini di root folder wartek/
// =============================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // ganti sesuai user MySQL kamu
define('DB_PASS', '');           // ganti sesuai password MySQL kamu
define('DB_NAME', 'wartek');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('<div style="font-family:sans-serif;padding:20px;color:red;">
        <strong>Koneksi database gagal:</strong> ' . $conn->connect_error . '
        <br><small>Pastikan XAMPP/MySQL sudah berjalan dan database <b>wartek</b> sudah dibuat.</small>
    </div>');
}

$conn->set_charset('utf8mb4');

// Helper: ambil data warung (selalu id=1)
function getWarung($conn) {
    $r = $conn->query("SELECT * FROM warung WHERE id = 1 LIMIT 1");
    return $r ? $r->fetch_assoc() : [];
}

// Helper: format rupiah
function rupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// Helper: aktif nav (untuk admin)
function isActive($page) {
    return strpos($_SERVER['PHP_SELF'], $page) !== false ? 'active' : '';
}