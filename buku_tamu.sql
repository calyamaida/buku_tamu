-- Membuat database buku_tamu (sudah ada di koneksidb.php)
CREATE DATABASE IF NOT EXISTS buku_tamu;

-- Menggunakan database buku_tamu
USE buku_tamu;

-- Membuat tabel users untuk autentikasi
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Membuat tabel guest_book untuk menyimpan data buku tamu
CREATE TABLE IF NOT EXISTS guest_book (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);