-- Import lewat phpMyAdmin (tab Import) atau: mysql -u root < database.sql
CREATE DATABASE IF NOT EXISTS db_tokoonline CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_tokoonline;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS detail_pesanan, pesanan, produk, kategori, users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','pelanggan') NOT NULL DEFAULT 'pelanggan',
  dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE kategori (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(60) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE produk (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  kategori_id INT UNSIGNED NOT NULL,
  nama VARCHAR(150) NOT NULL,
  deskripsi TEXT NULL,
  harga INT UNSIGNED NOT NULL,
  stok INT UNSIGNED NOT NULL DEFAULT 0,
  gambar VARCHAR(255) NULL,
  dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (kategori_id) REFERENCES kategori(id)
) ENGINE=InnoDB;

CREATE TABLE pesanan (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  kode VARCHAR(24) NOT NULL UNIQUE,
  user_id INT UNSIGNED NOT NULL,
  nama_penerima VARCHAR(100) NOT NULL,
  telepon VARCHAR(20) NOT NULL,
  alamat TEXT NOT NULL,
  total INT UNSIGNED NOT NULL,
  status ENUM('menunggu_pembayaran','menunggu_verifikasi','dibayar','dikirim','selesai','batal') NOT NULL DEFAULT 'menunggu_pembayaran',
  bukti_bayar VARCHAR(255) NULL,
  dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;

-- nama dan harga disalin ke sini agar riwayat tetap akurat walau produk diubah/dihapus
CREATE TABLE detail_pesanan (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  pesanan_id INT UNSIGNED NOT NULL,
  produk_id INT UNSIGNED NULL,
  nama_produk VARCHAR(150) NOT NULL,
  harga INT UNSIGNED NOT NULL,
  qty INT UNSIGNED NOT NULL,
  FOREIGN KEY (pesanan_id) REFERENCES pesanan(id) ON DELETE CASCADE,
  FOREIGN KEY (produk_id) REFERENCES produk(id) ON DELETE SET NULL
) ENGINE=InnoDB;
