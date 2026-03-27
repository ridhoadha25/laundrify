<?php
include '../config/koneksi.php';

$id = intval($_GET['id']); // biar aman

$hapus = mysqli_query($conn, "DELETE FROM pelanggan WHERE id='$id'");

if($hapus){
    header("Location: tampil.php?pesan=hapus");
} else {
    echo "Gagal menghapus data!";
}

exit;
?>