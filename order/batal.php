<?php
include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($conn, "UPDATE orders SET status_bayar='Batal' WHERE id='$id'");

header("location:../laporan/tampil.php?pesan=update");
?>