<?php 
include '../config/koneksi.php';

$cari = $_GET['cari'] ?? '';

$data = mysqli_query($conn, "
    SELECT * FROM pelanggan 
    WHERE nama LIKE '%$cari%' 
    OR no_hp LIKE '%$cari%'
");
?>  

<!DOCTYPE html>  
<html>  
<head>  
    <title>Data Pelanggan</title>  

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
</style>
</head>  
<body class="bg-light">

<!-- SIDEBAR -->
<div class="sidebar">
    <h4 class="text-center py-3">
    <i class="fa fa-shirt text-info me-1"></i> Laundrify
    </h4>

    <a href="../dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
    <a href="tampil.php" class="active"><i class="fa fa-users"></i> Pelanggan</a>
    <a href="../order/tampil.php"><i class="fa fa-box"></i> Order</a>
    <a href="../order/tambah.php"><i class="fa fa-plus"></i> Tambah Order</a>
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
            <i class="fa fa-users text-primary"></i> Data Pelanggan
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
                <div class="alert alert-success">Data berhasil ditambahkan!</div>
            <?php } elseif($_GET['pesan']=='update'){ ?>
                <div class="alert alert-warning">Data berhasil diupdate!</div>
            <?php } elseif($_GET['pesan']=='hapus'){ ?>
                <div class="alert alert-danger">Data berhasil dihapus!</div>
            <?php } ?>
        <?php } ?>

        <!-- TOMBOL + SEARCH -->
        <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
    
        <a href="tambah.php" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah
        </a>

            <form method="GET" class="d-flex">
                <input type="text" name="cari" class="form-control me-2" 
                    placeholder="Cari nama / no HP..." 
                    value="<?= $cari ?>">
                <button class="btn btn-success">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>

        <!-- TABEL -->
        <div class="card shadow">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered mb-0 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php if(mysqli_num_rows($data) > 0){ ?>
                            <?php while ($row = mysqli_fetch_assoc($data)) { ?>  
                                <tr>  
                                    <td><?= htmlspecialchars($row['nama']); ?></td>  
                                    <td><?= htmlspecialchars($row['no_hp']); ?></td>  
                                    <td><?= htmlspecialchars($row['alamat']); ?></td>  
                                    
                                    <!--Tombol aksi-->
                                    <td class="d-flex gap-1">
                                        <a href="edit.php?id=<?= $row['id'] ?>" 
                                        class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                        </a>

                                        <a href="hapus.php?id=<?= $row['id'] ?>" 
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin mau hapus data ini?')">
                                        <i class="fa fa-trash"></i>
                                        </a>
                                    </td>  
                                </tr>  
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">
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