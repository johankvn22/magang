<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h3 class="mb-0">Dashboard Pembimbing Industri</h3>
        </div>
        <div class="card-body">
            <?php if (!$profilLengkap) : ?>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Lengkapi profil Anda untuk mengakses semua fitur.
                </div>
            <?php endif; ?>

            <p class="text-muted">Halaman utama untuk memantau kegiatan bimbingan industri.</p>

            <!-- Statistik -->
            <div class="row mt-4">
                <div class="col-md-3 mb-3">
                    <div class="card border-start border-primary border-3 shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="card-subtitle text-muted mb-2">Total Mahasiswa</h6>
                            <p class="card-text fs-4 fw-bold text-dark"><?= $totalMahasiswa ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card border-start border-success border-3 shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="card-subtitle text-muted mb-2">Bimbingan Masuk</h6>
                            <p class="card-text fs-4 fw-bold text-dark"><?= $jumlahBimbinganMasuk ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card border-start border-success border-3 shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="card-subtitle text-muted mb-2">Disetujui</h6>
                            <p class="card-text fs-4 fw-bold text-dark"><?= $laporanDisetujui ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card border-start border-warning border-3 shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="card-subtitle text-muted mb-2">Menunggu</h6>
                            <p class="card-text fs-4 fw-bold text-dark"><?= $laporanMenunggu ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional statistics row if needed -->
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card border-start border-danger border-3 shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="card-subtitle text-muted mb-2">Ditolak</h6>
                            <p class="card-text fs-4 fw-bold text-dark"><?= $laporanDitolak ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>