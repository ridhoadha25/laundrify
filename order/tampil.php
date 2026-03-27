<?php 
include '../config/koneksi.php';

$cari = $_GET['cari'] ?? '';

$query = mysqli_query($conn, "
    SELECT orders.*, pelanggan.nama 
    FROM orders 
    JOIN pelanggan ON orders.pelanggan_id = pelanggan.id
    WHERE pelanggan.nama LIKE '%$cari%'
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Order</title>

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

    .table th, .table td {
        vertical-align: middle;
    }

    .btn {
        border-radius: 8px;
    }

    .badge {
        font-size: 13px;
        padding: 6px 10px;
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
    <a href="tampil.php" class="active"><i class="fa fa-box"></i> Order</a>
    <a href="tambah.php"><i class="fa fa-plus"></i> Tambah Order</a>
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
        <div class="container-fluid d-flex justify-content-between">
            <span class="navbar-brand mb-0 h5">
                <i class="fa fa-box text-success"></i> Data Order Laundry
            </span>

            <span class="me-3 text-muted">
                <i class="fa fa-calendar"></i> <?= date('d M Y') ?>
            </span>
        </div>
    </nav>

    <div class="container mt-4">

        <!-- ALERT -->
       <?php if(isset($_GET['pesan'])){ ?>
            <?php if($_GET['pesan']=='tambah'){ ?>
                <div class="alert alert-success">Order berhasil ditambahkan!</div>
            <?php } elseif($_GET['pesan']=='update'){ ?>
                <div class="alert alert-warning">Order berhasil diupdate!</div>
            <?php } elseif($_GET['pesan']=='hapus'){ ?>
                <div class="alert alert-danger">Order berhasil dihapus!</div>
            <?php } ?>
        <?php } ?>

        <!-- TOMBOL & SEARCH -->
        <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
    
            <a href="tambah.php" class="btn btn-success">
                <i class="fa fa-plus"></i> Tambah Order
            </a>

            <form method="GET" class="d-flex">
                <input type="text" name="cari" class="form-control me-2" 
                    placeholder="Cari pelanggan..." 
                    value="<?= $cari ?>">
                <button class="btn btn-primary">
                    <i class="fa fa-search"></i>
                </button>
            </form>

        </div>

        <!-- TABEL -->
        <div class="card shadow">
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped table-hover table-bordered mb-0 align-middle">
                        <thead class="table-dark text-white">
                            <tr>
                                <th>Nama</th>
                                <th>Berat</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Pembayaran</th>
                                <th width="170">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(mysqli_num_rows($query) > 0){ ?>
                                <?php while ($row = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['nama']); ?></td>
                                        <td><?= $row['berat']; ?> kg</td>
                                        <td>Rp <?= number_format($row['total']); ?></td>

                                        <!-- STATUS -->
                                        <td>
                                            <?php 
                                            $warna = 'bg-secondary';

                                            if($row['status']=='Dicuci') $warna='bg-info';
                                            elseif($row['status']=='Disetrika') $warna='bg-primary';
                                            elseif($row['status']=='Selesai') $warna='bg-success';
                                            elseif($row['status']=='Diambil') $warna='bg-dark';
                                            ?>

                                            <span class="badge <?= $warna ?>">
                                                <?= $row['status']; ?>
                                            </span>
                                        </td>

                                        <!-- PEMBAYARAN -->
                                        <td>
                                            <span class="badge 
                                                <?= $row['status_bayar']=='Lunas' ? 'bg-success' : 'bg-danger' ?>">
                                                <?= $row['status_bayar']; ?>
                                            </span>
                                        </td>

                                        <!-- AKSI -->
                                        <td class="d-flex gap-1">
                                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a href="hapus.php?id=<?= $row['id'] ?>" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus?')">
                                            <i class="fa fa-trash"></i>
                                            </a>

                                            <a href="struk_pdf.php?id=<?= $row['id'] ?>" 
                                            class="btn btn-info btn-sm" target="_blank">
                                            <i class="fa fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Data tidak ditemukan
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

</body>
</html>