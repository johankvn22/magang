<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_dosen'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0">
            <i class="bi bi-people-fill me-2"></i>Daftar Mahasiswa Bimbingan
        </h2>
        <div class="d-flex">
            <form class="d-flex" method="get" action="">
                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari mahasiswa..." value="<?= esc($search ?? '') ?>">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Student List Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <?php if (!empty($mahasiswaList)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Mahasiswa</th>
                                <th>NIM</th>
                                <th>Program Studi</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mahasiswaList as $mhs): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3 bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-medium"><?= esc($mhs['nama_lengkap']) ?></h6>
                                                <small class="text-muted"><?= esc($mhs['kelas'] ?? '-') ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= esc($mhs['nim']) ?></td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary"><?= esc($mhs['program_studi']) ?></span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="<?= site_url('dosen/bimbingan/detail/' . $mhs['mahasiswa_id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                <i class="bi bi-eye me-1"></i> Detail
                                            </a>
                                            <a href="<?= site_url('dosen/bimbingan/logbook/' . $mhs['mahasiswa_id']) ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                                                <i class="bi bi-journal-text me-1"></i> Logbook
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if (isset($pager)): ?>
                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <div class="text-muted small">
                        Menampilkan <?= count($mahasiswaList) ?> dari <?= $pager->getTotal() ?> mahasiswa
                    </div>
                    <div>
                        <?= $pager->links() ?>
                    </div>
                </div>
                <?php endif; ?>
                
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Tidak ada mahasiswa bimbingan</h5>
                    <p class="text-muted">Belum ada mahasiswa yang ditugaskan sebagai bimbingan Anda</p>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>



<?= $this->endSection(); ?>