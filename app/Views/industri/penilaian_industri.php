<?php /** @var \CodeIgniter\View\View $this */ ?>
<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">
    <!-- Student Information Card -->
    <div class="card border-0 shadow-lg mb-4">
        <div class="card-header bg-primary text-white fw-bold py-3">
            <i class="fas fa-user-graduate me-2"></i>Informasi Mahasiswa
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-circle">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0"><?= esc($mahasiswa['nama_lengkap']) ?></h5>
                            <small class="text-muted">NIM: <?= esc($mahasiswa['nim']) ?></small>
                        </div>
                    </div>
                    
                    <p><i class="fas fa-graduation-cap text-primary me-2"></i> <strong>Program Studi:</strong> <?= esc($mahasiswa['program_studi']) ?></p>
                    <p><i class="fas fa-users text-primary me-2"></i> <strong>Kelas:</strong> <?= esc($mahasiswa['kelas']) ?></p>
                </div>
                <div class="col-md-6">
                    <p><i class="fas fa-building text-primary me-2"></i> <strong>Perusahaan:</strong> <?= esc($mahasiswa['nama_perusahaan']) ?></p>
                    <p><i class="fas fa-sitemap text-primary me-2"></i> <strong>Divisi:</strong> <?= esc($mahasiswa['divisi']) ?></p>
                    <p><i class="fas fa-calendar-alt text-primary me-2"></i> <strong>Tanggal Magang:</strong> <?= esc($mahasiswa['tanggal_mulai']) ?> s/d <?= esc($mahasiswa['tanggal_selesai']) ?></p>
                    <p><i class="fas fa-file-alt text-primary me-2"></i> <strong>Judul Magang:</strong> <?= esc($mahasiswa['judul_magang']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Industrial Evaluation Form -->
    <form method="post" action="<?= site_url('industri/penilaianindustri/store') ?>" class="card border-0 shadow-lg">
        <?= csrf_field() ?>
        <input type="hidden" name="mahasiswa_id" value="<?= $mahasiswa['mahasiswa_id'] ?>">
        
        <div class="card-header bg-primary text-white fw-bold py-3">
            <i class="fas fa-edit me-2"></i>Form Penilaian Pembimbing Industri
        </div>
        
        <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif ?>
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th style="width: 20%">Kategori</th>
                            <th>Kriteria Penilaian</th>
                            <th style="width: 10%">Range</th>
                            <th style="width: 15%">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Soft Skills -->
                        <tr>
                            <td class="fw-semibold bg-light" rowspan="5">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <i class="fas fa-comments mb-1 text-primary"></i>
                                    <span>Soft Skills</span>
                                    <small class="badge bg-primary mt-1">50%</small>
                                </div>
                            </td>
                            <td>1.1 Kemampuan berkomunikasi yang baik</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="komunikasi" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>
                        <tr>
                            <td>1.2 Kemampuan berpikir kritis</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="berpikir_kritis" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>
                        <tr>
                            <td>1.3 Kemampuan bekerja individu maupun tim</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="kerja_tim" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>
                        <tr>
                            <td>1.4 Inisiatif, kreatif, inovatif dan adaptif</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="inisiatif" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>
                        <tr>
                            <td>1.5 Kemampuan literasi informasi, media dan teknologi</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="literasi_digital" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>

                        <!-- Hard Skills -->
                        <tr>
                            <td class="fw-semibold bg-light" rowspan="5">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <i class="fas fa-cogs mb-1 text-primary"></i>
                                    <span>Hard Skills</span>
                                    <small class="badge bg-primary mt-1">50%</small>
                                </div>
                            </td>
                            <td>2.1 Kemampuan membuat deskripsi produk</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="deskripsi_produk" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>
                        <tr>
                            <td>2.2 Kemampuan menentukan requirement/spesifikasi produk</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="spesifikasi_produk" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>
                        <tr>
                            <td>2.3 Kemampuan membuat desain produk</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="desain_produk" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>
                        <tr>
                            <td>2.4 Kemampuan mengimplementasikan produk</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="implementasi_produk" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>
                        <tr>
                            <td>2.5 Kemampuan melakukan pengujian produk</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="pengujian_produk" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Final Score Calculation -->
            <div class="mt-4 pt-3 border-top">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Komponen Nilai</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Soft Skills (50%):</span>
                                    <span class="fw-bold">(Akan dihitung)</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Hard Skills (50%):</span>
                                    <span class="fw-bold">(Akan dihitung)</span>
                                </div>
                                <div class="d-flex justify-content-between fw-bold text-primary">
                                    <span>Total Nilai Industri:</span>
                                    <span>(Soft Skills × 0.5) + (Hard Skills × 0.5)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-4 py-2 fw-bold shadow-sm">
                    <i class="fas fa-save me-2"></i>Simpan Penilaian
                </button>
                <button class="btn btn-outline-secondary px-4 py-2 ms-2" onclick="history.back(); return false;">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </button>
            </div>
        </div>
    </form>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const inputs = document.querySelectorAll('input[type="number"][min][max]');

        inputs.forEach(function (input) {
            input.addEventListener('input', function () {
                const min = parseInt(input.min);
                const max = parseInt(input.max);
                let value = parseInt(input.value);

                if (isNaN(value)) return;

                if (value < min) input.value = min;
                if (value > max) input.value = max;
            });
        });
    });
</script>


<?= $this->endSection(); ?>