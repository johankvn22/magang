<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_panitia'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header card-header-gradient">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="fas fa-clipboard-list me-2"></i>Daftar Nilai Mahasiswa - Panitia
                </h3>
                <div class="d-flex gap-2">
                    <form method="get" action="<?= site_url('panitia/list_nilai_mahasiswa') ?>" class="d-flex">
                        <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" class="form-control me-2" placeholder="Cari Nama/NIM/Prodi..." style="min-width: 200px;">
                        <button type="submit" class="btn btn-success">Cari</button>
                    </form>
                    <form method="get" action="<?= site_url('panitia/list_nilai_mahasiswa') ?>">
                        <select name="perPage" class="form-select" onchange="this.form.submit()">
                            <?php foreach ([5, 10, 25, 50, 100] as $option): ?>
                            <option value="<?= $option ?>" <?= ($perPage ?? 10) == $option ? 'selected' : '' ?>>
                                Tampilkan <?= $option ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                    <button class="btn btn-outline-light" onclick="window.print()">
                        <i class="fas fa-print me-1"></i>Cetak
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th style="width: 20%">Mahasiswa</th>
                            <th style="width: 15%">Program Studi</th>
                            <th style="width: 30%">Perusahaan</th>
                            <th style="width: 10%">Nilai Dosen</th>
                            <th style="width: 10%">Nilai Industri</th>
                            <th style="width: 10%">Total Nilai</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php if (!empty($mahasiswa_list)): ?>
                            <?php foreach ($mahasiswa_list as $index => $mhs): ?>
                                <tr>
                                    <td class="text-center"><?= ($offset ?? 0) + $index + 1 ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-user-circle fa-lg text-primary me-2"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <div href="<?= base_url('panitia/nilai/detail/' . $mhs['mahasiswa_id']) ?>" class="text-decoration-none fw-bold">
                                                    <?= $mhs['nama_lengkap'] ?>
                                                </div>
                                                <div class="text-muted small"><?= esc($mhs['nim']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            <?= $mhs['program_studi'] ?>
                                        </span>
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            <?= esc($mhs['kelas']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-building text-muted me-2"></i>
                                            <span><?= $mhs['nama_perusahaan'] ?></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php if (isset($mhs['nilai_dosen']['total_nilai'])): ?>
                                            <span class="badge score-badge score-dosen rounded-pill">
                                                <?= $mhs['nilai_dosen']['total_nilai'] ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary score-badge rounded-pill">
                                                <i class="fas fa-minus"></i>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (isset($mhs['nilai_industri']['total_nilai_industri'])): ?>
                                            <span class="badge score-badge score-industri rounded-pill">
                                                <?= number_format($mhs['nilai_industri']['total_nilai_industri'], 2) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary score-badge rounded-pill">
                                                <i class="fas fa-minus"></i>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= is_null($mhs['total_nilai']) ? '–' : number_format($mhs['total_nilai'], 2); ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('panitia/nilai/detail/' . $mhs['mahasiswa_id']) ?>"
                                            class="btn btn-primary btn-sm action-btn">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="bg-warning bg-opacity-10 p-4 rounded-circle d-inline-block mb-3">
                                        <i class="fas fa-exclamation-circle fa-3x text-warning"></i>
                                    </div>
                                    <h4 class="text-dark mb-2">Tidak ada data mahasiswa</h4>
                                    <p class="text-muted">Belum ada mahasiswa yang terdaftar untuk dinilai</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if (isset($pager) && !empty($mahasiswa_list)): ?>
            <div class="d-flex justify-content-center mt-3">
                <?= $pager->links('default', 'custom_pagination') ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>