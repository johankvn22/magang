<?php

/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_kps'); ?>
<?= $this->section('content'); ?>

<body>

  <!-- Main Content -->
  <main class="container-fluid">

    <!-- Alur & Buku Pedoman -->
    <div class="row g-4">
      <!-- Alur -->
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <h5 class="fw-bold mb-2">Alur Monitoring dan Evaluasi KPS</h5>
            <p class="text-muted mb-3">Panduan proses pengelolaan monitoring dan evaluasi magang</p>
            <img src="<?= base_url('assets/img/1.png') ?>" class="img-fluid rounded" alt="Alur Admin">
          </div>
        </div>
      </div>
      
 <div class="row g-4">
      <!-- Alur -->
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <h5 class="fw-bold mb-2">Alur Monitoring dan Evaluasi KPS</h5>
            <p class="text-muted mb-3">Panduan proses pengelolaan monitoring dan evaluasi magang</p>
            <img src="<?= base_url('assets/img/2.png') ?>" class="img-fluid rounded" alt="Alur Admin">
          </div>
        </div>
      </div>

     

        <!-- Buku Pedoman -->
        <div class="card border-0 shadow-sm">
          <div class="card-body d-flex flex-column justify-content-between">
            <div>
              <h5 class="fw-bold">Buku Pedoman Magang</h5>

              <?php if (!empty($pedoman)) : ?>
                <p class="text-muted mb-3">
                  <i class="bi bi-file-earmark-pdf-fill me-2"></i><?= esc($pedoman['judul']) ?>
                </p>
              <?php else : ?>
                <p class="text-muted mb-3">Belum ada file pedoman yang diupload.</p>
              <?php endif; ?>
            </div>

            <div class="d-flex flex-column gap-2">
              <?php if (!empty($pedoman)) : ?>
                <a href="<?= base_url('pedoman/untuk-pedoman/' . $pedoman['id']) ?>" target="_blank" class="btn btn-primary w-100">
                  <i class="bi bi-download me-1"></i>Download
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Statistik Section -->
    <div class="row justify-content-center g-4 mb-5 mt-4">
      <div class="col-sm-6 col-md-4">
        <div class="card text-center border-0 shadow-sm p-4">
          <div class="card-body">
            <i class="bi bi-people-fill text-primary fs-2 mb-2"></i>
            <h3 class="fw-bold text-primary"><?= $jumlahMahasiswa ?></h3>
            <p class="text-muted mb-0">Mahasiswa Terdaftar</p>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="card text-center border-0 shadow-sm p-4">
          <div class="card-body">
            <i class="bi bi-person-check-fill text-success fs-2 mb-2"></i>
            <h3 class="fw-bold text-success"><?= $jumlahDosen ?></h3>
            <p class="text-muted mb-0">Dosen Pembimbing Terdaftar</p>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="card text-center border-0 shadow-sm p-4">
          <div class="card-body">
            <i class="bi bi-person-vcard-fill text-danger fs-2 mb-2"></i>
            <h3 class="fw-bold text-danger"><?= $jumlahIndustri ?></h3>
            <p class="text-muted mb-0">Mentor Industri Terdaftar</p>
          </div>
        </div>
      </div>
    </div>

  </main>

</body>

<?= $this->endSection(); ?>