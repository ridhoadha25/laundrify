<?php
include '../config/koneksi.php';

$id = $_POST['id'];
$status = $_POST['status'];
$status_bayar = $_POST['status_bayar'];

mysqli_query($conn, "UPDATE orders SET 
    status='$status',
    status_bayar='$status_bayar'
WHERE id='$id'");

header("Location: tampil.php?pesan=update");
?>