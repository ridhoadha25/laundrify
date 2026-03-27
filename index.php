<?php
session_start();

if(isset($_SESSION['login'])){
    header("Location: dashboard.php");
} else {
    header("Location: auth/login.php");
}
exit;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laundry App</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="#">LaundryApp</a>
    <div>
      <a href="pelanggan/tampil.php" class="btn btn-light btn-sm">Pelanggan</a>
      <a href="order/tampil.php" class="btn btn-light btn-sm">Order</a>
    </div>
  </div>
</nav>

<!-- Hero -->
<div class="container mt-5 text-center">
    <h1 class="fw-bold">Sistem Laundry</h1>
    <p class="text-muted">Kelola laundry jadi lebih mudah 🚀</p>

    <a href="pelanggan/tambah.php" class="btn btn-primary">Tambah Pelanggan</a>
    <a href="order/tambah.php" class="btn btn-success">Tambah Order</a>
</div>

</body>
</html>