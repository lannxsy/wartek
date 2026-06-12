<?php
// kirim_pesan.php — handler form kontak dari contact.html
require_once 'db.php';

header('Content-Type: application/json');

$nama  = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$pesan = trim($_POST['pesan'] ?? '');

if (!$nama || !$email || !$pesan) {
    echo json_encode(['ok' => false, 'msg' => 'Semua field wajib diisi.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['ok' => false, 'msg' => 'Format email tidak valid.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO pesan_kontak (warung_id, nama_pengirim, email_pengirim, isi_pesan) VALUES (1, ?, ?, ?)");
$stmt->bind_param('sss', $nama, $email, $pesan);

if ($stmt->execute()) {
    echo json_encode(['ok' => true, 'msg' => 'Pesan berhasil dikirim! Kami akan segera menghubungi Anda.']);
} else {
    echo json_encode(['ok' => false, 'msg' => 'Terjadi kesalahan, coba lagi.']);
}
