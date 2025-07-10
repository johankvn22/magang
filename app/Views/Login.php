<!-- app/Views/login.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - MAGANG PNJ</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/login.css'); ?>">
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100">
  <div class="login-card">
    <h1 class="login-title">Login Sistem Magang</h1>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="<?= site_url('login'); ?>">
      <?= csrf_field() ?>

      <div class="mb-3">
        <label for="nomor_induk" class="form-label">Nomor Induk (NIM/NIP)</label>
        <input type="text" class="form-control" name="nomor_induk" id="nomor_induk" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password" required>
      </div>

      <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" id="showPassword">
        <label class="form-check-label" for="showPassword">Show Password</label>
      </div>

      <button type="submit" class="btn btn-success btn-login">Login</button>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('assets/js/login.js'); ?>"></script>
</body>

</html>
