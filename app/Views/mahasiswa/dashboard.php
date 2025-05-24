<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_mahasiswa'); ?>
<?= $this->section('content'); ?>


    <div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <h2 class="mb-4">Dashboard Mahasiswa</h2>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
          <?= session()->getFlashdata('success') ?>
        </div>
      <?php endif; ?>

      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title">Informasi Mahasiswa</h5>
          <p class="card-text">
            <strong>Nama:</strong> <?= esc($mahasiswa['nama_lengkap']) ?> <br>
            <strong>NIM:</strong> <?= esc($mahasiswa['nim']) ?> <br>
            <strong>Email:</strong> <?= esc($mahasiswa['email']) ?> <br>
          </p>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title">Upload Laporan Magang</h5>
          <form method="post" action="<?= site_url('mahasiswa/upload'); ?>" enctype="multipart/form-data">
            <div class="form-group mt-3">
              <label for="file">Pilih File:</label>
              <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Upload</button>
          </form>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title">Petunjuk Pengisian Logbook</h5>
          <p>
            1. Login untuk mengisi logbook.<br>
            2. Pastikan semua data diisi dengan lengkap.<br>
            3. Lengkapi semua kolom yang diperlukan dan upload laporan sesuai waktu yang ditentukan.
          </p>
        </div>
      </div>
    </div>
  </div>  
</div>





<?= $this->endSection(); ?>

