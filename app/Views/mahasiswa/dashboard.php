<?php

/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_mahasiswa'); ?>
<?= $this->section('content'); ?>

<body>
    <!-- Main Content -->
    <main class="container-fluid">

        <?php if (!$profilLengkap): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Lengkapi profil Anda!</strong> Beberapa data penting masih kosong.
                <a href="<?= base_url('mahasiswa/edit') ?>" class="alert-link">Klik di sini untuk melengkapi profil.</a>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($broadcasts)): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <h5>Pesan dari Admin:</h5>
                <ul class="mb-0">
                    <?php foreach ($broadcasts as $pesan): ?>
                        <li><strong><?= esc($pesan['judul']) ?></strong>: <?= esc($pesan['isi']) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">
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

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Dosen Profile Card -->
                <?php if (!empty($dosenPembimbing)): ?>
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="fw-bold mb-0">Dosen Pembimbing</h5>
                        </div>
                        <div class="card-body">
                            <?php foreach ($dosenPembimbing as $dosen): ?>
                                <div class="d-flex align-items-center mb-3">

                                    <div>
                                        <h6 class="fw-bold mb-1"><?= esc($dosen['nama_lengkap']) ?></h6>
                                        <p class="text-muted small mb-1">NIP: <?= esc($dosen['nip']) ?></p>
                                        <p class="text-muted small mb-1">Email: <?= esc($dosen['email']) ?></p>
                                        <p class="text-muted small mb-1">No. HP: <?= esc($dosen['no_telepon']) ?></p>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="me-2">
                                        <span class="fw-semibold">Grup WhatsApp:</span>
                                    </div>
                                    <a href="<?= esc($dosen['link_whatsapp']) ?>"
                                        class="btn btn-sm btn-success"
                                        target="_blank">
                                        <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                    </a>
                                </div>
                                <hr>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        Anda belum memiliki dosen pembimbing. Silakan hubungi administrator.
                    </div>
                <?php endif; ?>

                <!-- Buku Pedoman Card -->
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
            </div>
        </div>

        <!-- Logbook Bimbingan Section -->
        <div class="row mt-5 ">
            <div class="col">
                <h4 class="fw-bold">Logbook Bimbingan</h4>
            </div>
        </div>

        <div class="row justify-content-center g-4 mb-5 mt-4">
            <div class="col-sm-6 col-md-4">
                <div class="card text-center border-0 shadow-sm p-4">
                    <div class="card-body">
                        <i class="bi bi-file-earmark-text-fill text-primary fs-2 mb-2"></i>
                        <h3 class="fw-bold text-primary"><?= $jumlahLaporan ?></h3>
                        <p class="text-muted mb-0">Laporan Terkirim</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card text-center border-0 shadow-sm p-4">
                    <div class="card-body">
                        <i class="bi bi-check-circle-fill text-success fs-2 mb-2"></i>
                        <h3 class="fw-bold text-success"><?= $jumlahDisetujui ?></h3>
                        <p class="text-muted mb-0">Laporan Disetujui</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card text-center border-0 shadow-sm p-4">
                    <div class="card-body">
                        <i class="bi bi-clock-fill text-warning fs-2 mb-2"></i>
                        <h3 class="fw-bold text-warning"><?= $jumlahMenunggu ?></h3>
                        <p class="text-muted mb-0">Laporan Menunggu</p>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
</body>

<?= $this->endSection(); ?>