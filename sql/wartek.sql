-- =============================================
-- DATABASE: wartek
-- Warteg Sabili - Company Profile
-- =============================================

CREATE DATABASE IF NOT EXISTS wartek CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE wartek;

-- Tabel warung (data profil warung)
CREATE TABLE warung (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT,
    no_telepon VARCHAR(20),
    jam_buka TIME,
    jam_tutup TIME
);

-- Tabel menu
CREATE TABLE menu (
    id INT PRIMARY KEY AUTO_INCREMENT,
    warung_id INT NOT NULL,
    nama VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    harga DECIMAL(10,0) NOT NULL,
    foto VARCHAR(255),
    FOREIGN KEY (warung_id) REFERENCES warung(id) ON DELETE CASCADE
);

-- Tabel pesan_kontak
CREATE TABLE pesan_kontak (
    id INT PRIMARY KEY AUTO_INCREMENT,
    warung_id INT NOT NULL,
    nama_pengirim VARCHAR(100) NOT NULL,
    email_pengirim VARCHAR(100) NOT NULL,
    isi_pesan TEXT NOT NULL,
    dikirim_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sudah_dibaca TINYINT(1) DEFAULT 0,
    FOREIGN KEY (warung_id) REFERENCES warung(id) ON DELETE CASCADE
);

-- Tabel admin (login)
CREATE TABLE admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- =============================================
-- DATA AWAL
-- =============================================

-- Data warung
INSERT INTO warung (nama, alamat, no_telepon, jam_buka, jam_tutup) VALUES
('Warteg Sabili', 'Jl. Cikutra No. 227, Neglasari, Kec. Cibeunying Kaler, Kota Bandung', '081234567890', '06:00:00', '22:00:00');

-- Data menu awal
INSERT INTO menu (warung_id, nama, deskripsi, harga, foto) VALUES
(1, 'Lotek', 'Sayuran segar dengan siraman bumbu kacang khas.', 15000, 'lotek.webp'),
(1, 'Pepes Ayam', 'Daging ayam empuk dengan bumbu rempah melimpah dibungkus daun pisang.', 12000, NULL),
(1, 'Pepes Ikan', 'Ikan segar bumbu kuning kukus gurih beraroma daun kemangi.', 13000, NULL),
(1, 'Pepes Tahu', 'Tahu lembut dengan campuran bumbu halus tradisional.', 5000, NULL),
(1, 'Tahu Goreng', 'Tahu goreng hangat pilihan, gurih luar dalam.', 1500, NULL),
(1, 'Bala-Bala (Bakwan)', 'Gorengan sayur renyah favorit sejuta umat.', 1500, NULL),
(1, 'Tempe Goreng', 'Tempe goreng standar warteg yang gak pernah salah.', 1500, NULL),
(1, 'Risol', 'Kulit risol lembut dengan isian gurih padat.', 2000, NULL),
(1, 'Lontong', 'Cocok buat penambah karbohidrat pelengkap lotek/gorengan.', 2500, NULL),
(1, 'Peyek', 'Garing, renyah, dan cocok jadi teman makan nasi.', 8000, NULL);

-- Admin default: username=admin, password=admin123
INSERT INTO admin (username, password) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
-- password di atas = "password" (bcrypt), ganti setelah login pertama
-- untuk password "admin123" jalankan: php -r "echo password_hash('admin123', PASSWORD_BCRYPT);"
