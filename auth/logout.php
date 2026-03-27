<?php
session_start(); // HARUS di paling atas, sebelum HTML atau spasi
session_destroy(); // hapus semua session
header("Location: ../auth/login.php"); // redirect ke halaman login
exit; // hentikan eksekusi script
?>