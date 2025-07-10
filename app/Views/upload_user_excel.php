<?php

/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_admin'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
  <div class="card shadow">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Import Akun User dari Excel</h3>
        <a href="<?= base_url('template/format_user.xlsx') ?>" class="btn btn-success" download>
          📥 Download Template Excel
        </a>
      </div>

      <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-info">
          <?= session()->getFlashdata('message') ?>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('/upload-user-excel') ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="excel_file" class="form-label">Pilih File Excel (.xlsx)</label>
          <input type="file" name="excel_file" id="excel_file" class="form-control" accept=".xlsx,.xls" required>
        </div>
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-upload me-1"></i> Upload & Import
        </button>
      </form>

      <hr class="my-4">

      <p class="fw-bold">Format Kolom Excel yang Diharapkan:</p>

      <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
          <thead class="table-light">
            <tr>
              <th>Nama</th>
              <th>Email</th>
              <th>Password</th>
              <th>Role</th>
              <th>Nomor Induk</th>
              <th>Prodi<br><small class="text-muted">(TI, TMJ, TMD)</small></th>
            </tr>
          </thead>
        </table>
      </div>

    </div>
  </div>
</div>

<?= $this->endSection(); ?>