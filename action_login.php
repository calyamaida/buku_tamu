<?php
session_start();
require_once 'koneksidb.php'; // Include koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["register"])) {
        $username = trim($_POST["username"]);
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        if (!empty($username) && !empty($_POST["password"])) {
            // Cek apakah username sudah ada
            $check_query = "SELECT username FROM users WHERE username = ?";
            $check_stmt = $conn->prepare($check_query);
            $check_stmt->bind_param("s", $username);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            
            if ($check_result->num_rows == 0) {
                // Username belum digunakan, lakukan pendaftaran
                $insert_query = "INSERT INTO users (username, password) VALUES (?, ?)";
                $insert_stmt = $conn->prepare($insert_query);
                $insert_stmt->bind_param("ss", $username, $password);
                
                if ($insert_stmt->execute()) {
                    $_SESSION['register_success'] = "Registrasi berhasil! Silakan login.";
                } else {
                    $_SESSION['register_error'] = "Terjadi kesalahan saat mendaftar: " . $conn->error;
                }
                $insert_stmt->close();
            } else {
                $_SESSION['register_error'] = "Username sudah digunakan!";
            }
            $check_stmt->close();
        } else {
            $_SESSION['register_error'] = "Username dan password tidak boleh kosong!";
        }
        header("Location: login.php");
        exit;
    } 
    elseif (isset($_POST["login"])) {
        $username = trim($_POST["username"]);
        $password = $_POST["password"];

        // Query untuk mendapatkan user dengan username yang diberikan
        $login_query = "SELECT id, username, password FROM users WHERE username = ?";
        $login_stmt = $conn->prepare($login_query);
        $login_stmt->bind_param("s", $username);
        $login_stmt->execute();
        $login_result = $login_stmt->get_result();
        
        if ($login_result->num_rows === 1) {
            $user = $login_result->fetch_assoc();
            
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                $_SESSION["user_id"] = $user['id'];
                $_SESSION["username"] = $user['username'];
                $_SESSION["login"] = true;
                
                header("Location: dashboard.php");
                exit;
            } else {
                $_SESSION['login_error'] = "Username atau password salah!";
            }
        } else {
            $_SESSION['login_error'] = "Username atau password salah!";
        }
        $login_stmt->close();
        
        header("Location: login.php");
        exit;
    }
}

// Tutup koneksi database
$conn->close();
?>