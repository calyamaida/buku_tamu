<?php
$servername = "localhost";
$username = "root";
$password = "rahasia20";
$dbname = "buku_tamu"; // nama database yang akan digunakan

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Pesan koneksi berhasil dikomentari agar tidak mengganggu output halaman
// echo "Connected successfully";
?>