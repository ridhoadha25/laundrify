<?php
include '../config/koneksi.php';

mysqli_query($conn, "UPDATE pengeluaran SET
    keterangan='$_POST[keterangan]',
    jumlah='$_POST[jumlah]',
    tanggal='$_POST[tanggal]'
WHERE id='$_POST[id]'");

header("Location: tampil.php?pesan=update");
?>