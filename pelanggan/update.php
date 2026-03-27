<?php
include '../config/koneksi.php';

$id = intval($_POST['id']);
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
$alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

$update = mysqli_query($conn, "UPDATE pelanggan SET 
    nama='$nama',
    no_hp='$no_hp',
    alamat='$alamat'
WHERE id='$id'");

if($update){
    header("Location: tampil.php?pesan=update");
} else {
    echo "Gagal update data!";
}

exit;
?>