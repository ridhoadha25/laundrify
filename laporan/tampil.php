<?php
include '../config/koneksi.php';

// Total Pendapatan
$total_pendapatan = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT SUM(total) as total FROM orders WHERE status_bayar='Lunas'")
)['total'] ?? 0;

// Total Pengeluaran
$total_pengeluaran = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT SUM(jumlah) as total FROM pengeluaran")
)['total'] ?? 0;

// Pendapatan Bersih
$total_bersih = $total_pendapatan - $total_pengeluaran;

// Data
$data_pendapatan = mysqli_query($conn, "SELECT * FROM orders WHERE status_bayar='Lunas' ORDER BY tanggal DESC");
$data_pengeluaran = mysqli_query($conn, "SELECT * FROM pengeluaran ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
body { background: #f4f6f9; }

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
    border-radius: 12px;
}

.container-custom {
    max-width: 1200px;
    margin: auto;
}

.btn {
    border-radius: 8px;
}
</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar text-white">
    <h4 class="text-center py-3">
    <i class="fa fa-shirt text-info me-1"></i> Laundrify
    </h4>

    <a href="../dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
    <a href="../pelanggan/tampil.php"><i class="fa fa-users"></i> Pelanggan</a>
    <a href="../order/tampil.php"><i class="fa fa-box"></i> Order</a>
    <a href="../order/tambah.php"><i class="fa fa-plus"></i> Tambah Order</a>
    <a href="tampil.php" class="active"><i class="fa fa-chart-line"></i> Laporan</a>

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
        <span class="navbar-brand">
            <i class="fa fa-chart-line text-primary"></i> Laporan
        </span>
        <span class="text-muted">
            <i class="fa fa-calendar"></i> <?= date('d M Y') ?>
        </span>
    </div>
</nav>

<div class="container mt-4 container-custom">

<!-- BUTTON -->
<div class="mb-3">
    <a href="tambah.php" class="btn btn-primary">
        <i class="fa fa-plus"></i> Tambah Pengeluaran
    </a>
</div>

<!-- CARDS -->
<div class="row text-center mb-3">
    <div class="col-md-4 mb-3">
        <div class="card shadow p-3">
            <h6>Total Pendapatan</h6>
            <h5 class="text-success">Rp <?= number_format($total_pendapatan) ?></h5>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card shadow p-3">
            <h6>Total Pengeluaran</h6>
            <h5 class="text-danger">Rp <?= number_format($total_pengeluaran) ?></h5>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card shadow p-3">
            <h6>Pendapatan Bersih</h6>
            <h5 class="<?= $total_bersih >= 0 ? 'text-success' : 'text-danger' ?>">
                Rp <?= number_format($total_bersih) ?>
            </h5>
        </div>
    </div>
</div>

<!-- TABEL PENDAPATAN -->
<div class="card shadow mb-4">
    <div class="card-header bg-success text-white">
        Data Pendapatan
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($data_pendapatan)) { ?>
                    <tr>
                        <td><?= $row['pelanggan_id'] ?></td>
                        <td>Rp <?= number_format($row['total']) ?></td>
                        <td><?= $row['tanggal'] ?></td>
                        <td>
                            <a href="../order/batal.php?id=<?= $row['id'] ?>" 
                            class="btn btn-warning btn-sm"
                            onclick="return confirm('Batalkan pembayaran ini?')">
                            <i class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- TABEL PENGELUARAN -->
<div class="card shadow">
    <div class="card-header bg-danger text-white">
        Data Pengeluaran
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($data_pengeluaran) > 0) { ?>
                        <?php while($row = mysqli_fetch_assoc($data_pengeluaran)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['keterangan']) ?></td>
                            <td>Rp <?= number_format($row['jumlah']) ?></td>
                            <td><?= $row['tanggal'] ?></td>
                            <td class="d-flex gap-1">
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin hapus?')">
                                   <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Belum ada data
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>