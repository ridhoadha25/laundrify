<?php include '../config/koneksi.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Order</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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

    .card-header {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .form-control, .form-select {
        border-radius: 10px;
    }

    .btn {
        border-radius: 10px;
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
    <a href="tampil.php"><i class="fa fa-box"></i> Order</a>
    <a href="tambah.php" class="active"><i class="fa fa-plus"></i> Tambah Order</a>
    <a href="../laporan/tampil.php"><i class="fa fa-chart-line"></i> Laporan</a>

    <hr class="bg-light">

    <a href="../auth/logout.php" class="text-danger">
        <i class="fa fa-sign-out"></i> Logout
    </a>
</div>

<!-- CONTENT -->
<div class="content">

    <!-- NAVBAR -->
    <nav class="navbar navbar-light bg-white shadow-sm">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <span class="navbar-brand mb-0 h5">
            <i class="fa fa-plus-circle text-success"></i> Tambah Order
        </span>

        <span class="text-muted small">
            <i class="fa fa-calendar"></i> <?= date('d M Y') ?>
        </span>

    </div>
</nav>

    <div class="container mt-4">

        <div class="card shadow border-0 col-md-6 mx-auto">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fa fa-plus"></i> Tambah Order Laundry</h5>
            </div>

            <div class="card-body">

                <form action="simpan.php" method="POST">

                    <!-- PELANGGAN -->
                    <div class="mb-3">
                        <label class="form-label">Pelanggan</label>
                        <select name="pelanggan_id" class="form-control" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php
                            $pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan");
                            while ($p = mysqli_fetch_assoc($pelanggan)) {
                                echo "<option value='{$p['id']}'>{$p['nama']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- BERAT -->
                    <div class="mb-3">
                        <label class="form-label">Berat (kg)</label>
                        <input type="number" name="berat" class="form-control" required>
                    </div>

                    <!-- HARGA -->
                    <div class="mb-3">
                        <label class="form-label">Harga per Kg</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>

                    <!-- TOTAL (AUTO) -->
                    <div class="mb-3">
                        <label class="form-label">Total</label>
                        <input type="text" id="total" class="form-control" readonly>
                    </div>

                    <!-- STATUS -->
                    <div class="mb-3">
                        <label class="form-label">Status Laundry</label>
                        <select name="status" class="form-control">
                            <option>Diproses</option>
                            <option>Dicuci</option>
                            <option>Disetrika</option>
                            <option>Selesai</option>
                            <option>Diambil</option>
                        </select>
                    </div>

                    <!-- STATUS BAYAR -->
                    <div class="mb-3">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="status_bayar" class="form-control">
                            <option>Lunas</option>
                            <option>Belum</option>
                        </select>
                    </div>

                    <!-- TOMBOL -->
                    <div class="d-flex justify-content-between">
                        <a href="tampil.php" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <button class="btn btn-success">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

</div>

<script>
const berat = document.querySelector('[name="berat"]');
const harga = document.querySelector('[name="harga"]');
const total = document.getElementById('total');

function hitungTotal() {
    let b = berat.value || 0;
    let h = harga.value || 0;
    total.value = "Rp " + (b * h);
}

berat.addEventListener('input', hitungTotal);
harga.addEventListener('input', hitungTotal);
</script>

</body>
</html>