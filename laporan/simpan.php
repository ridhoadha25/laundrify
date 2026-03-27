<?php
include '../config/koneksi.php';

mysqli_query($conn, "INSERT INTO pengeluaran VALUES(
    '',
    '$_POST[keterangan]',
    '$_POST[jumlah]',
    '$_POST[tanggal]'
)");

header("Location: tampil.php?pesan=tambah");
?>