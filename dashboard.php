<?php 
session_start();
include 'config/koneksi.php';

$status_diproses = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE status='Diproses'"));
$status_dicuci = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE status='Dicuci'"));
$status_setrika = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE status='Disetrika'"));
$status_selesai = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE status='Selesai'"));

// ORDER TERBARU (limit 5)
$order_terbaru = mysqli_query($conn, "
    SELECT o.*, p.nama 
    FROM orders o
    JOIN pelanggan p ON o.pelanggan_id = p.id
    ORDER BY o.tanggal DESC
    LIMIT 5
");

// hitung data
$total_pelanggan = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pelanggan"));
$total_order = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders"));
$total_selesai = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE status='Selesai'"));
$total_pendapatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as total FROM orders WHERE status_bayar='Lunas'"))['total'];


$status_diproses = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE status='Diproses'"));
$status_dicuci = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE status='Dicuci'"));
$status_setrika = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE status='Disetrika'"));
$status_selesai_chart = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE status='Selesai'"));
$status_diambil = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE status='Diambil'"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
    body {
        overflow-x: hidden;
        background: #f4f6f9;
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

    .card {
        border-radius: 15px;
    }

    .card h3 {
        font-weight: bold;
    }

    .card-icon {
        font-size: 30px;
        opacity: 0.7;
    }

    .navbar {
        border-radius: 0 0 15px 15px;
    }

    .card-hover {
    border-radius: 15px;
    transition: 0.3s;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4 class="text-center py-3">
    <i class="fa fa-shirt text-info me-1"></i> Laundrify
    </h4>

    <a href="dashboard.php" class="active"><i class="fa fa-home"></i> Dashboard</a>
    <a href="pelanggan/tampil.php"><i class="fa fa-users"></i> Pelanggan</a>
    <a href="order/tampil.php"><i class="fa fa-box"></i> Order</a>
    <a href="order/tambah.php"><i class="fa fa-plus"></i> Tambah Order</a>
    <a href="laporan/tampil.php"><i class="fa fa-chart-line"></i> Laporan</a>

    <hr class="bg-light">

    <a href="auth/logout.php" class="text-danger">
        <i class="fa fa-sign-out"></i> Logout
    </a>
</div>

<div class="text-end">
    <div id="jam" style="font-size:18px; font-weight:bold;"></div>
    <small id="tanggal" class="text-muted"></small>
</div>

<!-- CONTENT -->
<div class="content">

    <nav class="navbar navbar-light bg-white shadow-sm">
    <div class="container-fluid d-flex justify-content-between">

        <span class="navbar-brand mb-0 h4">
            <i class="fa fa-chart-line text-primary"></i> Dashboard
        </span>

        <div>
            <span class="me-3 text-muted">
                <i class="fa fa-calendar"></i> <?= date('d M Y') ?>
            </span>
        </div>
    </div>
</nav>

    <div class="container mt-4">

        <!-- CARDS -->
        <div class="row g-4">

            <!-- Pelanggan -->
            <div class="col-md-3">
                <div class="card shadow border-0 bg-primary text-white card-hover">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Total Pelanggan</h6>
                            <h3 class="fw-bold"><?= $total_pelanggan ?></h3>
                        </div>
                        <i class="fa fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            
            <!-- Order -->
            <div class="col-md-3">
                <div class="card shadow border-0 bg-success text-white card-hover">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Total Order</h6>
                            <h3 class="fw-bold"><?= $total_order ?></h3>
                        </div>
                        <i class="fa fa-box fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>

            <!-- Selesai -->
            <div class="col-md-3">
                <div class="card shadow border-0 bg-warning text-dark card-hover">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Order Selesai</h6>
                            <h3 class="fw-bold"><?= $total_selesai ?></h3>
                        </div>
                        <i class="fa fa-check fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>

            <!-- Pendapatan -->
            <div class="col-md-3">
                <div class="card shadow border-0 bg-dark text-white card-hover">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Total Pendapatan</h6>
                            <h3 class="fw-bold">Rp <?= number_format($total_pendapatan ?? 0) ?></h3>
                        </div>
                        <i class="fa fa-money-bill fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>

        </div>

        <!-- ORDER TERBARU -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow border-0">
                    <div class="card-body">

                        <h5 class="mb-3">
                            <i class="fa fa-clock text-primary"></i> Order Terbaru
                        </h5>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered mb-0 align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php if(mysqli_num_rows($order_terbaru) > 0){ ?>
                                    <?php while($row = mysqli_fetch_assoc($order_terbaru)){ ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['nama']) ?></td>
                                            <td>Rp <?= number_format($row['total']) ?></td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= $row['status'] ?>
                                                </span>
                                            </td>
                                            <td><?= $row['tanggal'] ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            Belum ada order
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- STATUS ORDER -->
<div class="mt-4">

    <h5 class="mb-3">
        <i class="fa fa-list text-primary"></i> Status Order
    </h5>

    <div class="row">

        <!-- Diproses -->
        <div class="col-md-3 col-6 mb-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa fa-cogs text-warning mb-2" style="font-size: 20px;"></i>
                    <h6 class="mb-1">Diproses</h6>
                    <h4 class="fw-bold"><?= $status_diproses ?></h4>
                </div>
            </div>
        </div>

        <!-- Dicuci -->
        <div class="col-md-3 col-6 mb-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa fa-soap text-info mb-2" style="font-size: 20px;"></i>
                    <h6 class="mb-1">Dicuci</h6>
                    <h4 class="fw-bold"><?= $status_dicuci ?></h4>
                </div>
            </div>
        </div>

        <!-- Disetrika -->
        <div class="col-md-3 col-6 mb-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa fa-fire text-secondary mb-2" style="font-size: 20px;"></i>
                    <h6 class="mb-1">Disetrika</h6>
                    <h4 class="fw-bold"><?= $status_setrika ?></h4>
                </div>
            </div>
        </div>

        <!-- Selesai -->
        <div class="col-md-3 col-6 mb-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa fa-check-circle text-success mb-2" style="font-size: 20px;"></i>
                    <h6 class="mb-1">Selesai</h6>
                    <h4 class="fw-bold"><?= $status_selesai ?></h4>
                </div>
            </div>
        </div>

    </div>

</div>
    </div>

</div>

</body>
</html>