<?php
include '../config/koneksi.php';

$pelanggan_id = $_POST['pelanggan_id'];
$berat = $_POST['berat'];
$harga = $_POST['harga'];
$status = $_POST['status'];
$status_bayar = $_POST['status_bayar'];

$total = $berat * $harga;

mysqli_query($conn, "INSERT INTO orders 
(pelanggan_id, berat, total, status, status_bayar) 
VALUES 
('$pelanggan_id','$berat','$total','$status','$status_bayar')");

header("Location: tampil.php?pesan=tambah");
exit;
?>