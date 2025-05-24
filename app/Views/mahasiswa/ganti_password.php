<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_mahasiswa'); ?>
<?= $this->section('content'); ?>

<body>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">

      <h2 class="mb-4">Ganti Password</h2>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
          <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
          <?= session()->getFlashdata('success') ?>
        </div>
      <?php endif; ?>

      <div class="card shadow-sm">
        <div class="card-body">
          <form method="POST" action="<?= site_url('mahasiswa/update-password'); ?>">

            <div class="mb-3">
              <label for="current_password" class="form-label">Password Lama</label>
              <input type="password" name="current_password" id="current_password" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="new_password" class="form-label">Password Baru</label>
              <input type="password" name="new_password" id="new_password" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
              <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Ganti Password</button>
          </form>
        </div>
      </div>

      <div class="mt-4 text-center">
        <a href="<?= site_url('mahasiswa/dashboard'); ?>" class="btn btn-secondary">Kembali ke Dashboard</a>
      </div>

    </div>
  </div>
</div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

<?= $this->endSection(); ?>