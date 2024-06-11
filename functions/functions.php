<?php
session_start(); // Mulai session di awal file

// Sertakan file koneksi database (database.php)
require_once '../../config/database.php';

#Security Functions

// Fungsi validasi input (contoh sederhana)
function validateInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

#Security Functions


#Auth Functions

// Fungsi login (menggunakan POST jika didukung)
function login() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = validateInput($_POST['username']);
        $password = validateInput($_POST['password']); // Tidak ada enkripsi

        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];

            // Redirect ke dashboard.php jika berhasil
            header("Location: ../dashboard/index.php");
            exit(); // Hentikan eksekusi lebih lanjut
        } else {
            // Set error message
            $_SESSION['login_error'] = "Username atau password salah.";
        }
    }
    return false; 
}

// Fungsi registrasi (menggunakan POST jika didukung)
function register() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = validateInput($_POST['username']);
        $password = validateInput($_POST['password']); // Tidak ada enkripsi
        $role = validateInput($_POST['role']);

        // Validasi role (pastikan hanya nilai yang diizinkan)
        $validRoles = ['admin', 'kasir', 'gudang'];
        if (!in_array($role, $validRoles)) {
            return false; // Atau berikan pesan kesalahan yang sesuai
        }

        $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
        return mysqli_query($conn, $query);
    }
    return false;
}

// Fungsi pengecekan pengguna login
function isLoggedIn() {
    return isset($_SESSION['id']);
    return isset($_SESSION['username']);
    return isset($_SESSION['role']);
}

// Fungsi untuk mendapatkan informasi pengguna yang sedang login (opsional)
function getCurrentUser() {
    if (isLoggedIn()) {
        global $conn;
        $id = $_SESSION['id'];
        $username = $_SESSION['username'];
        $role = $_SESSION['role'];
        $query = "SELECT * FROM users WHERE id = $id AND username = '$username' AND role = '$role'";
        $result = mysqli_query($conn, $query);
        return mysqli_fetch_assoc($result);
    } else {
        return null;
    }
}
// Fungsi untuk memeriksa apakah pengguna sudah login dan memiliki peran yang diizinkan
function checkRole($allowedRoles) {
    if (!isLoggedIn()) {
        header('Location: ../../pages/form/form.php'); // Redirect ke halaman login jika belum login
        exit();
    }

    if (!in_array($_SESSION['role'], $allowedRoles)) {
        // Jika pengguna tidak memiliki akses, arahkan ke halaman lain (misalnya, 403.php)
        header('Location: ../../pages/form/form.php'); // Redirect ke halaman error jika tidak memiliki akses
        exit();
    }
}
function checkRole_tempaltes($allowedRoles) {
    if (!isLoggedIn()) {
        header('Location: ../../../pages/form/form.php'); // Redirect ke halaman login jika belum login
        exit();
    }

    if (!in_array($_SESSION['role'], $allowedRoles)) {
        // Jika pengguna tidak memiliki akses, arahkan ke halaman lain (misalnya, 403.php)
        header('Location: ../../../pages/form/form.php'); // Redirect ke halaman error jika tidak memiliki akses
        exit();
    }
}

function logout() {
    session_unset();
    session_destroy();
    header('Location: ../../pages/form/form.php'); // Arahkan ke halaman login setelah logout
    exit();
}
function logout_templates() {
    session_unset();
    session_destroy();
    header('Location: ../../../pages/form/form.php'); // Arahkan ke halaman login setelah logout
    exit();
}


#Auth Functions


#CRUD Functions


// Fungsi untuk mendapatkan daftar sparepart (contoh)
function getSpareparts() {
    global $conn;
    checkRole(['admin', 'gudang', 'kasir']); 
    $query = "SELECT * FROM spareparts";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fungsi untuk mendapatkan daftar jasa (contoh)
function getJasa() {
    global $conn;
    checkRole(['admin', 'gudang', 'kasir']); 
    $query = "SELECT * FROM jasa";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fungsi untuk mendapatkan daftar pelanggan (contoh)
function getPelanggan() {
    global $conn;
    checkRole(['admin', 'gudang', 'kasir']); 
    $query = "SELECT * FROM pelanggan";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fungsi untuk mendapatkan daftar kendaraan (contoh)
function getKendaraan() {
    global $conn;
    checkRole(['admin', 'gudang', 'kasir']); 
    $query = "SELECT * FROM kendaraan";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fungsi untuk mendapatkan daftar transaksi (contoh)
function getTransaksi() {
    global $conn;
    checkRole(['admin', 'gudang', 'kasir']); 
    $query = "SELECT * FROM transaksi";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fungsi untuk mendapatkan detail transaksi berdasarkan ID transaksi (contoh)
function getDetailTransaksi($id_transaksi) {
    global $conn;
    checkRole(['admin', 'gudang', 'kasir']); 
    $query = "SELECT * FROM detail_transaksi WHERE id_transaksi = $id_transaksi";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC); }

function getJumlahTransaksi() {
    global $conn;
    checkRole(['admin', 'gudang', 'kasir']); 
    $query = "SELECT COUNT(id) AS jumlah_transaksi FROM transaksi";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['jumlah_transaksi'];
    }
function getJumlahKaryawan() {
    global $conn;
    checkRole(['admin', 'gudang', 'kasir']);
    $query = "SELECT COUNT(id) AS jumlah_karyawan FROM users";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['jumlah_karyawan'];
    }
function getJumlahPelanggan() {
    global $conn;
    checkRole(['admin', 'gudang', 'kasir']);
    $query = "SELECT COUNT(id) AS jumlah_pelanggan FROM pelanggan";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['jumlah_pelanggan'];
    }
function getJumlahKendaraan() {
    global $conn;
    checkRole(['admin', 'gudang', 'kasir']);
    $query = "SELECT COUNT(id) AS jumlah_kendaraan FROM kendaraan";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['jumlah_kendaraan'];
    }
function getPelangganHarian() {
    global $conn;
    checkRole(['admin', 'gudang', 'kasir']);
    $query = "SELECT COUNT(pelanggan.id) AS jumlah_pelanggan FROM pelanggan JOIN transaksi ON pelanggan.id = transaksi.id_pelanggan WHERE tanggal = CURDATE()";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['jumlah_pelanggan'];
    }
function getTransaksiHarian() {
    global $conn;
    checkRole(['admin', 'gudang', 'kasir']);
    $query = "SELECT COUNT(id) AS jumlah_transaksi FROM transaksi WHERE tanggal = CURDATE()";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['jumlah_transaksi'];
    }
function getKendaraanHarian() {
    global $conn;
    checkRole(['admin', 'gudang', 'kasir']);
    $query = "SELECT COUNT(kendaraan.id) AS jumlah_kendaraan FROM kendaraan JOIN transaksi ON kendaraan.id = transaksi.id_kendaraan WHERE tanggal = CURDATE()";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['jumlah_kendaraan'];
    }
function getTableTransaksiTerbaru() { 
    global $conn;
    checkRole(['admin', 'gudang', 'kasir']);
    $query = "SELECT pelanggan.nama, transaksi.jenis, kendaraan.no_polisi, transaksi.total FROM pelanggan JOIN transaksi ON pelanggan.id = transaksi.id_pelanggan JOIN kendaraan ON transaksi.id_kendaraan = kendaraan.id ORDER BY transaksi.id DESC LIMIT 5";
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return []; // Return an empty array if there's an error
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
function getTablePelangganTerbaru() {
    global $conn;
    checkRole(['admin', 'gudang', 'kasir']);
    $query = "SELECT nama FROM pelanggan ORDER BY id DESC LIMIT 5";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return []; // Return an empty array if there's an error
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }












    #CRUD Functions