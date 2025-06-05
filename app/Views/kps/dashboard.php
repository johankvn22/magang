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
      <!-- Right Column: Info Tambahan -->
      <div class="col-lg-4">
          <!-- Pedoman / Panduan -->
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold">Buku Pedoman Dosen</h5>
                  <?php if (!empty($pedoman)): ?>
                    <p class="text-muted mb-3">
                      <i class="bi bi-file-earmark-pdf-fill me-2"></i><?= esc($pedoman['judul']) ?>
                    </p>
                    <a href="<?= base_url('uploads/pedoman/' . $pedoman['file_path']) ?>" 
                      target="_blank" 
                      class="btn btn-primary w-100">
                      <i class="bi bi-download me-1"></i>Download
                    </a>
                    <?php else: ?>
                        <p class="text-muted mb-0">Belum ada pedoman yang diunggah.</p>
                  <?php endif; ?>
            </div>
          </div>    
      
              <div class="card border-0 shadow-sm">
              <div class="card-body">
                <h5 class="fw-bold mb-3">Download Review Kinerja Mahasiswa</h5>
                <p class="text-muted mb-2">Unduh file review kinerja mahasiswa yang telah tersedia.</p>
                <?php if (!empty($reviewKinerja)): ?>
                <div class="d-flex align-items-center mb-3">
                  <i class="bi bi-file-earmark-pdf-fill me-2 fs-4 text-danger"></i>
                  <span class="fw-semibold"><?= esc($reviewKinerja['judul']) ?></span>
                </div>
                <a href="<?= base_url('uploads/review_kinerja/' . $reviewKinerja['file_path']) ?>"
                   target="_blank"
                   class="btn btn-outline-primary w-100 mb-2">
                  <i class="bi bi-download me-1"></i>Download Review
                </a>
                <?php else: ?>
                <a href="<?= site_url('kps/review-kinerja/export') ?>"
                   class="btn btn-outline-success w-100">
                  <i class="fas fa-file-export me-2"></i>Ekspor Data
                </a>
                <?php endif; ?>
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