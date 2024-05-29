-- Membuat database (jika belum ada)
CREATE DATABASE IFNOT EXISTS bengkel_motor;

-- Menggunakan database
USE bengkel_motor;

-- Tabel users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'kasir', 'gudang') NOT NULL
);

-- Tabel spareparts
CREATE TABLE spareparts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    harga_beli DECIMAL(10,2) NOT NULL,
    harga_jual DECIMAL(10,2) NOT NULL,
    stok INT NOT NULL
);

-- Tabel jasa
CREATE TABLE jasa (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    harga DECIMAL(10,2) NOT NULL
);

-- ... (kode untuk membuat tabel users, spareparts, dan jasa tetap sama)

-- Tabel pelanggan
CREATE TABLE pelanggan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    alamat VARCHAR(255),
    no_telepon VARCHAR(20)
);

-- Tabel kendaraan
CREATE TABLE kendaraan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_pelanggan INT NOT NULL,
    no_polisi VARCHAR(20) NOT NULL,
    jenis VARCHAR(50),
    merk VARCHAR(50),
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id)
);

-- Tabel transaksi (diubah)
CREATE TABLE transaksi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tanggal DATE NOT NULL,
    jenis ENUM('pembelian', 'penjualan') NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    id_user INT NOT NULL,
    id_pelanggan INT,
    id_kendaraan INT,
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id),
    FOREIGN KEY (id_kendaraan) REFERENCES kendaraan(id)
);

-- Tabel detail_transaksi (diubah)
CREATE TABLE detail_transaksi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_transaksi INT NOT NULL,
    id_sparepart INT,
    id_jasa INT,
    jumlah INT NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_transaksi) REFERENCES transaksi(id),
    FOREIGN KEY (id_sparepart) REFERENCES spareparts(id),
    FOREIGN KEY (id_jasa) REFERENCES jasa(id)
);


--Insert data ke tabel users
INSERT INTO users (username, password, role) VALUES
('admin', '$2y$10$f.d1h3423423423423423423423423423423', 'admin'),
('kasir1', '$2y$10$f.d1h3423423423423423423423423423423', 'kasir'),
('gudang1', '$2y$10$f.d1h3423423423423423423423423423423', 'gudang'),
('mekanik1', '$2y$10$f.d1h3423423423423423423423423423423', 'kasir'),
('mekanik2', '$2y$10$f.d1h3423423423423423423423423423423', 'kasir'),
('supervisor', '$2y$10$f.d1h3423423423423423423423423423423', 'admin'),
('kasir2', '$2y$10$f.d1h3423423423423423423423423423423', 'kasir'),
('gudang2', '$2y$10$f.d1h3423423423423423423423423423423', 'gudang'),
('mekanik3', '$2y$10$f.d1h3423423423423423423423423423423', 'kasir'),
('kepala_mekanik', '$2y$10$f.d1h3423423423423423423423423423423', 'admin');

-- Insert data ke tabel spareparts
INSERT INTO spareparts (nama, harga_beli, harga_jual, stok) VALUES
('Oli Mesin 1L', 45000, 55000, 50),
('Kampas Rem Depan', 80000, 100000, 30),
('Busi Standar', 15000, 20000, 100),
('Ban Dalam 14"', 60000, 75000, 25),
('Rantai Motor', 120000, 150000, 20),
('Aki Kering', 250000, 300000, 15),
('Filter Udara', 30000, 40000, 40),
('Bohlam Lampu', 10000, 15000, 80),
('V-Belt', 70000, 90000, 18),
('Kabel Gas', 25000, 35000, 35);

-- Insert data ke tabel jasa
INSERT INTO jasa (nama, harga) VALUES
('Ganti Oli', 20000),
('Ganti Kampas Rem', 35000),
('Servis Ringan', 80000),
('Servis Besar', 150000),
('Tune Up', 50000),
('Ganti Ban Dalam', 25000),
('Ganti Rantai', 40000),
('Ganti Aki', 30000),
('Perbaikan Kelistrikan', 75000),
('Cuci Motor', 15000);

-- Insert data ke tabel pelanggan
INSERT INTO pelanggan (nama, alamat, no_telepon) VALUES
('Budi Santoso', 'Jl. Mawar No. 10', '081234567890'),
('Ani Rahmawati', 'Jl. Melati No. 15', '082123456789'),
('Candra Gunawan', 'Jl. Anggrek No. 20', '085212345678'),
('Dewi Lestari', 'Jl. Kenanga No. 25', '089876543210'),
('Eko Prasetyo', 'Jl. Teratai No. 30', '087654321098'),
('Fitri Handayani', 'Jl. Dahlia No. 35', '085678901234'),
('Galih Mahendra', 'Jl. Kamboja No. 40', '081345678901'),
('Hani Wijaya', 'Jl. Kemuning No. 45', '082234567890'),
('Indra Kusuma', 'Jl. Cempaka No. 50', '089987654321'),
('Jaka Pratama', 'Jl. Flamboyan No. 55', '088765432109');

-- Insert data ke tabel kendaraan
INSERT INTO kendaraan (id_pelanggan, no_polisi, jenis, merk) VALUES
(1, 'L 1234 AB', 'Motor', 'Honda'),
(2, 'N 5678 CD', 'Motor', 'Yamaha'),
(3, 'B 9012 EF', 'Motor', 'Suzuki'),
(4, 'DK 3456 GH', 'Mobil', 'Toyota'),
(5, 'AD 7890 IJ', 'Mobil', 'Daihatsu'),
(1, 'AG 1122 KL', 'Motor', 'Kawasaki'), 
(2, 'AB 4321 MN', 'Motor', 'Honda'),
(3, 'AE 8765 OP', 'Mobil', 'Mitsubishi'),
(4, 'D 2233 QR', 'Mobil', 'Nissan'),
(5, 'B 5566 ST', 'Motor', 'Yamaha');

-- Insert data ke tabel transaksi (dengan id_pelanggan dan id_kendaraan)
INSERT INTO transaksi (tanggal, jenis, total, id_user, id_pelanggan, id_kendaraan) VALUES
('2024-05-20', 'penjualan', 350000, 2, 1, 1),
('2024-05-21', 'pembelian', 850000, 3, NULL, NULL),
('2024-05-22', 'penjualan', 120000, 4, 2, 2),
('2024-05-23', 'penjualan', 535000, 7, 3, 3),
('2024-05-24', 'pembelian', 210000, 8, NULL, NULL),
('2024-05-19', 'penjualan', 90000, 2, 1, 6), 
('2024-05-18', 'pembelian', 500000, 3, NULL, NULL),
('2024-05-17', 'penjualan', 280000, 4, 2, 7), 
('2024-05-16', 'penjualan', 150000, 7, 3, 8),
('2024-05-15', 'pembelian', 380000, 8, NULL, NULL);

-- Insert data ke tabel detail_transaksi (tanpa jenis_item, dengan id_sparepart dan id_jasa)
INSERT INTO detail_transaksi (id_transaksi, id_sparepart, id_jasa, jumlah, harga) VALUES
(1, 1, 3, 2, 55000), -- Transaksi 1: 2 Oli Mesin + Servis Ringan
(1, NULL, 1, 1, 20000), -- Transaksi 1: Ganti Oli
(2, 5, NULL, 5, 120000), -- Transaksi 2: 5 Rantai Motor 
(2, 6, NULL, 2, 250000), -- Transaksi 2: 2 Aki Kering
(3, NULL, 2, 1, 35000), -- Transaksi 3: Ganti Kampas Rem
(3, 8, NULL, 2, 10000), -- Transaksi 3: 2 Bohlam Lampu
(4, 1, 4, 3, 55000), -- Transaksi 4: 3 Oli Mesin + Servis Besar
(5, 9, NULL, 2, 70000), -- Transaksi 5: 2 V-Belt
(5, 7, NULL, 3, 30000); -- Transaksi 5: 3 Filter Udara
