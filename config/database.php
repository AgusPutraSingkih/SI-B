<?php
// Konfigurasi database
$db_host = 'localhost'; 
$db_user = 'root';      
$db_pass = '';          
$db_name = 'bengkelsaja'; 

// Membuat koneksi
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// // cara penggunaan
// require_once 'config/database.php';
