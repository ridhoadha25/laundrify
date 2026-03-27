<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pelanggan</title>

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

        .card {
            border-radius: 15px;
        }

        .card-header {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .form-control, textarea {
            border-radius: 10px;
        }

        .btn {
            border-radius: 10px;
        }

        body {
            background: #f4f6f9;
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
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <span class="navbar-brand mb-0 h5">
            <i class="fa fa-user-plus text-primary"></i> Tambah Pelanggan
        </span>

        <span class="text-muted small">
            <i class="fa fa-calendar"></i> <?= date('d M Y') ?>
        </span>

    </div>
</nav>

    <div class="container mt-4">

        <div class="card shadow border-0 col-md-6 mx-auto">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fa fa-user-plus"></i> Tambah Pelanggan
                </h5>
            </div>

            <div class="card-body">

                <form action="simpan.php" method="POST">

                    <!-- NAMA -->
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama pelanggan" required>
                    </div>

                    <!-- NO HP -->
                    <div class="mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control" placeholder="Masukkan nomor HP">
                    </div>

                    <!-- ALAMAT -->
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat"></textarea>
                    </div>

                    <!-- TOMBOL -->
                    <div class="d-flex justify-content-between">
                        <a href="tampil.php" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <button class="btn btn-primary">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

</div>

</body>
</html>