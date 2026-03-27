<?php
include '../config/koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM orders WHERE id='$id'");
$row = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Order</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
        height: 100vh;
        background: linear-gradient(180deg, #212529, #343a40);
        color: white;
        position: fixed;
        width: 220px;
        }

        .sidebar h4 {
            font-weight: bold;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            padding: 12px;
            border-radius: 8px;
            margin: 5px;
            transition: 0.2s;
        }


        .sidebar a:hover {
            background: #495057;
            color: white;
            transform: translateX(5px);
        }

        .sidebar .active {
            background: #0d6efd;
            color: white;
        }

        .content {
            margin-left: 220px;
        }
    </style>
</head>
<body class="bg-light">

<!-- SIDEBAR -->
<div class="sidebar">
    <h4 class="text-center py-3">
    <i class="fa fa-shirt text-info me-1"></i> Laundrify
    </h4>

    <a href="../dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
    <a href="../pelanggan/tampil.php"><i class="fa fa-users"></i> Pelanggan</a>
    <a href="tampil.php" class="active"><i class="fa fa-box"></i> Order</a>
    <a href="tambah.php"><i class="fa fa-plus"></i> Tambah Order</a>
    <a href="laporan/tampil.php"><i class="fa fa-chart-line"></i> Laporan</a>

    <hr class="bg-light">

    <a href="../auth/logout.php" class="text-danger">
        <i class="fa fa-sign-out"></i> Logout
    </a>
</div>

<!-- CONTENT -->
<div class="content">

    <!-- NAVBAR -->
    <nav class="navbar navbar-light bg-white shadow-sm">
    <div class="container-fluid d-flex justify-content-between">
        <span class="navbar-brand mb-0 h5">
            <i class="fa fa-edit"></i> Edit Order
        </span>

        <span class="me-3 text-muted">
            <i class="fa fa-calendar"></i> <?= date('d M Y') ?>
        </span>
    </div>
</nav>

    <div class="container mt-4">

        <div class="card shadow col-md-6 mx-auto">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="fa fa-edit"></i> Edit Order Laundry
                </h5>
            </div>

            <div class="card-body">

                <form action="update.php" method="POST">

                    <input type="hidden" name="id" value="<?= $row['id']; ?>">

                    <!-- STATUS LAUNDRY -->
                    <div class="mb-3">
                        <label class="form-label">Status Laundry</label>
                        <select name="status" class="form-control">
                            <option <?= $row['status']=='Diproses' ? 'selected' : '' ?>>Diproses</option>
                            <option <?= $row['status']=='Dicuci' ? 'selected' : '' ?>>Dicuci</option>
                            <option <?= $row['status']=='Disetrika' ? 'selected' : '' ?>>Disetrika</option>
                            <option <?= $row['status']=='Selesai' ? 'selected' : '' ?>>Selesai</option>
                            <option <?= $row['status']=='Diambil' ? 'selected' : '' ?>>Diambil</option>
                        </select>
                    </div>

                    <!-- STATUS PEMBAYARAN -->
                    <div class="mb-3">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="status_bayar" class="form-control">
                            <option <?= $row['status_bayar']=='Lunas' ? 'selected' : '' ?>>Lunas</option>
                            <option <?= $row['status_bayar']=='Belum' ? 'selected' : '' ?>>Belum</option>
                        </select>
                    </div>

                    <!-- TOMBOL -->
                    <div class="d-flex justify-content-between">
                        <a href="tampil.php" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <button class="btn btn-warning">
                            <i class="fa fa-save"></i> Update
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

</div>

</body>
</html>