<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_admin'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-body">
      <h3 class="mb-4">Import Akun User dari Excel</h3>

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

        <p><strong>Format Kolom Excel yang Diharapkan:</strong></p>

        <table class="table table-bordered">
          <thead class="table-light">
            <tr>
              <th>Nama</th>
              <th>Email</th>
              <th>Password</th>
              <th>Role</th>
              <th>Nomor Induk</th>
              <th>Prodi (TI, TMJ, TMD)</th>

            </tr>
          </thead>
        </table>

    </div>
  </div>
</div>


<?= $this->endSection(); ?>