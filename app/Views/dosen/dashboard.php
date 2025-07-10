<?php

/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_dosen'); ?>
<?= $this->section('content'); ?>

<body>
    <main class="container-fluid">
        <!-- Alert Lengkapi Profil -->
        <?php if (!$profilLengkap): ?>
            <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                <strong>Lengkapi profil Anda!</strong> Beberapa data penting masih kosong.
                <a href="<?= base_url('dosen/editProfile') ?>" class="alert-link">Klik di sini untuk melengkapi profil.</a>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($broadcasts)) : ?>
            <div class="alert alert-info">
                <h5>Pesan dari Admin:</h5>
                <ul class="mb-0">
                    <?php foreach ($broadcasts as $pesan): ?>
                        <li><strong><?= esc($pesan['judul']) ?></strong>: <?= esc($pesan['isi']) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <div class="row g-4 mt-3">
            <!-- Alur Section (Left Column) -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-2">Alur Monitoring dan Evaluasi Mahasiswa</h5>
                        <p class="text-muted mb-3">Panduan proses monitoring dan evaluasi magang</p>
                        <img src="<?= base_url('assets/img/alur_admin.png') ?>" class="img-fluid rounded" alt="Alur Mahasiswa">
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

                <!-- Jumlah Mahasiswa Bimbingan -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="fw-bold mb-0">Jumlah Mahasiswa Bimbingan</h5>
                    </div>
                    <div class="card-body text-center">
                        <h1 class="display-4 fw-bold mb-2"><?= $jumlahMahasiswaBimbingan ?></h1>
                        <p class="text-muted mb-0">Mahasiswa yang sedang Anda bimbing</p>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="card border-0 shadow-sm mb-2">
                            <div class="card-body text-center">
                                <h5 class="card-title mb-1">Sudah Dinilai</h5>
                                <p class="card-text text-warning fs-4 fw-bold mb-0"><?= $jumlahSudahDinilai ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 shadow-sm mb-2">
                            <div class="card-body text-center">
                                <h5 class="card-title mb-1">Belum Dinilai</h5>
                                <p class="card-text text-success fs-4 fw-bold mb-0"><?= $jumlahBelumDinilai ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Bimbingan -->
        <div class="row mt-4">
            <div class="col">
                <h4 class="fw-bold">Statistik Logbook Bimbingan</h4>
            </div>
        </div>

        <div class="row justify-content-center g-4 mb-5 mt-">
            <div class="col-sm-6 col-md-4">
                <div class="card text-center border-0 shadow-sm p-4">
                    <div class="card-body">
                        <i class="bi bi-file-earmark-text-fill text-primary fs-2 mb-2"></i>
                        <h5 class="card-text"><?= $jumlahBimbinganMasuk ?></h5>
                        <p class="text-muted mb-0">Total Logbook</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card text-center border-0 shadow-sm p-4">
                    <div class="card-body">
                        <i class="bi bi-check-circle-fill text-success fs-2 mb-2"></i>
                        <h5 class="card-text"><?= $jumlahLaporanDiterima ?></h5>
                        <p class="text-muted mb-0">Logbook Disetujui</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card text-center border-0 shadow-sm p-4">
                    <div class="card-body">
                        <i class="bi bi-clock-fill text-warning fs-2 mb-2"></i>
                        <h5 class="card-text"><?= $jumlahLaporanMenunggu ?></h5>
                        <p class="text-muted mb-0">Menunggu Persetujuan</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

<?= $this->endSection(); ?>