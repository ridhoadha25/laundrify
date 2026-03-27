<!DOCTYPE html>
<html>
<head>
    <title>Login - Laundry App</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            height: 100vh;
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-header i {
            font-size: 40px;
            color: #0d6efd;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-primary {
            border-radius: 10px;
        }
    </style>
</head>

<body>

<div class="card login-card shadow p-4">

    <div class="login-header">
        <i class="fa fa-shirt"></i>
        <h4 class="mt-2">Laundry App</h4>
        <small class="text-muted">Silakan login</small>
    </div>

    <?php if(isset($_GET['error'])){ ?>
    <div class="alert alert-danger text-center">
        <i class="fa fa-times-circle"></i> Username atau password salah!
    </div>
    <?php } ?>

    <form action="proses_login.php" method="POST">

        <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
        </div>

        <button class="btn btn-primary w-100">
            <i class="fa fa-sign-in-alt"></i> Login
        </button>

    </form>

</div>

</body>
</html>