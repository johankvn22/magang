  <?php
  /** @var \CodeIgniter\View\View $this */
  ?>
  <?= $this->extend('layouts/template_admin'); ?>
  <?= $this->section('content'); ?>

  <main class="container-fluid "> <!-- ganti py-3 jadi pt-2, hilangkan padding bawah -->
    
  <div class="position-relative w-100 overflow-hidden" style="height: 380px;">
    <img src="<?= base_url('assets/img/pnj.jpg') ?>" alt="Banner PNJ" class="w-100 h-100 object-fit-cover">

    <!-- Overlay tanpa padding kiri -->
    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center ps-0"
        style="background: rgba(0, 0, 0, 0.5);">
      <!-- Card menempel kiri dengan sedikit margin -->
      <div class="bg-success bg-opacity-75 p-4 rounded-4 shadow text-white ms-3" style="max-width: 550px;">
        <h1 class="fw-bold display-5 mb-2">Dashboard Admin</h1>
        <p class="fs-5 mb-0">Kelola layanan magang Politeknik Negeri Jakarta</p>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <main class="container-fluid px-4 py-5">

    <!-- Statistik Section -->
    <div class="row justify-content-center g-4 mb-5">
      <div class="col-sm-6 col-md-4">
        <div class="card text-center border-0 shadow-sm p-4">
          <div class="card-body">
            <i class="bi bi-people-fill text-primary fs-2 mb-2"></i>
            <h3 class="fw-bold text-primary">200</h3>
            <p class="text-muted mb-0">Mahasiswa Terdaftar</p>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="card text-center border-0 shadow-sm p-4">
          <div class="card-body">
            <i class="bi bi-person-check-fill text-success fs-2 mb-2"></i>
            <h3 class="fw-bold text-success">200</h3>
            <p class="text-muted mb-0">Dosen Pembimbing Terdaftar</p>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="card text-center border-0 shadow-sm p-4">
          <div class="card-body">
            <i class="bi bi-person-vcard-fill text-danger fs-2 mb-2"></i>
            <h3 class="fw-bold text-danger">200</h3>
            <p class="text-muted mb-0">Mentor Industri Terdaftar</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Alur & Buku Pedoman -->
    <div class="row g-4">
      <!-- Alur -->
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <h5 class="fw-bold mb-2">Alur Monitoring dan Evaluasi Admin</h5>
            <p class="text-muted mb-3">Panduan proses pengelolaan monitoring dan evaluasi magang</p>
            <img src="<?= base_url('assets/img/alur_admin.png') ?>" class="img-fluid rounded" alt="Alur Admin">
          </div>
        </div>
      </div>

    <!-- Buku Pedoman -->
    <div class="col-lg-4">
      <!-- HAPUS class 'h-100' di sini -->
      <div class="card border-0 shadow-sm">
        <div class="card-body d-flex flex-column justify-content-between">
          <div>
            <h5 class="fw-bold">Buku Pedoman Magang</h5>
            <p class="text-muted mb-3"><i class="bi bi-file-earmark-pdf-fill me-2"></i>Judul File PDF</p>
          </div>
          <div class="d-flex gap-2">
            <button class="btn btn-success w-50">Upload </button>
            <button class="btn btn-outline-danger w-50">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </main>






  <?= $this->endSection(); ?>

