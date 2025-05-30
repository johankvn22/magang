<?php /** @var \CodeIgniter\View\View $this */ ?>
<?= $this->extend('layouts/template_dosen'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">
    <!-- Student Information Card -->
    <div class="card border-0 shadow-lg mb-4">
        <div class="card-header bg-success text-white fw-bold py-3">
            <i class="fas fa-user-graduate me-2"></i>Informasi Mahasiswa
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-2 rounded-circle">
                                <i class="fas fa-user text-success"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0"><?= esc($mahasiswa['nama_lengkap']) ?></h5>
                            <small class="text-muted">NIM: <?= esc($mahasiswa['nim']) ?></small>
                        </div>
                    </div>
                    
                    <p><i class="fas fa-graduation-cap text-success me-2"></i> <strong>Program Studi:</strong> <?= esc($mahasiswa['program_studi']) ?></p>
                    <p><i class="fas fa-users text-success me-2"></i> <strong>Kelas:</strong> <?= esc($mahasiswa['kelas']) ?></p>
                    <p><i class="fas fa-user-tie text-success me-2"></i> <strong>Pembimbing Industri:</strong> <?= isset($nilaiIndustri) ? esc($nilaiIndustri['nama_pembimbing_perusahaan']) : '-' ?></p>
                </div>
                <div class="col-md-6">
                    <p><i class="fas fa-building text-success me-2"></i> <strong>Perusahaan:</strong> <?= esc($mahasiswa['nama_perusahaan']) ?></p>
                    <p><i class="fas fa-sitemap text-success me-2"></i> <strong>Divisi:</strong> <?= esc($mahasiswa['divisi']) ?></p>
                    <p><i class="fas fa-calendar-alt text-success me-2"></i> <strong>Tanggal Magang:</strong> <?= esc($mahasiswa['tanggal_mulai']) ?> s/d <?= esc($mahasiswa['tanggal_selesai']) ?></p>
                    <p><i class="fas fa-file-alt text-success me-2"></i> <strong>Judul Magang:</strong> <?= esc($mahasiswa['judul_magang']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Industrial Evaluation -->
    <?php if (isset($nilaiIndustri) && $nilaiIndustri): ?>
        <div class="card border-0 shadow-lg mb-4">
            <div class="card-header bg-success text-white fw-bold py-3">
                <i class="fas fa-industry me-2"></i>Nilai Pembimbing Industri
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Soft Skills -->
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="card h-100 border-success">
                            <div class="card-header bg-success text-white py-2">
                                <h6 class="mb-0"><i class="fas fa-comments me-2"></i>Soft Skills (50%)</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 pb-2 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong>1.1 Komunikasi</strong>
                                        <span class="badge bg-success rounded-pill"><?= $nilaiIndustri['komunikasi'] ?></span>
                                    </div>
                                    <small class="text-muted">Mahasiswa menunjukkan kemampuan berkomunikasi yang baik dan efektif</small>
                                </div>
                                
                                <div class="mb-3 pb-2 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong>1.2 Berpikir Kritis</strong>
                                        <span class="badge bg-success rounded-pill"><?= $nilaiIndustri['berpikir_kritis'] ?></span>
                                    </div>
                                    <small class="text-muted">Mampu menganalisis permasalahan dan memberikan solusi</small>
                                </div>
                                
                                <div class="mb-3 pb-2 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong>1.3 Kerja Tim</strong>
                                        <span class="badge bg-success rounded-pill"><?= $nilaiIndustri['kerja_tim'] ?></span>
                                    </div>
                                    <small class="text-muted">Dapat bekerja secara mandiri maupun kolaboratif</small>
                                </div>
                                
                                <div class="mb-3 pb-2 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong>1.4 Inisiatif & Kreativitas</strong>
                                        <span class="badge bg-success rounded-pill"><?= $nilaiIndustri['inisiatif'] ?></span>
                                    </div>
                                    <small class="text-muted">Menunjukkan inisiatif, kreativitas dan adaptabilitas</small>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong>1.5 Literasi Digital</strong>
                                        <span class="badge bg-success rounded-pill"><?= $nilaiIndustri['literasi_digital'] ?></span>
                                    </div>
                                    <small class="text-muted">Menguasai keterampilan literasi digital dan teknologi</small>
                                </div>
                                
                                <div class="mt-4 pt-3 border-top">
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Rata-rata Soft Skills:</span>
                                        <span class="text-success">
                                            <?= number_format((
                                                $nilaiIndustri['komunikasi'] + 
                                                $nilaiIndustri['berpikir_kritis'] + 
                                                $nilaiIndustri['kerja_tim'] + 
                                                $nilaiIndustri['inisiatif'] + 
                                                $nilaiIndustri['literasi_digital']
                                            ) / 5, 2) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hard Skills -->
                    <div class="col-lg-6">
                        <div class="card h-100 border-success">
                            <div class="card-header bg-success text-white py-2">
                                <h6 class="mb-0"><i class="fas fa-cogs me-2"></i>Hard Skills (50%)</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 pb-2 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong>2.1 Deskripsi Produk</strong>
                                        <span class="badge bg-success rounded-pill"><?= $nilaiIndustri['deskripsi_produk'] ?></span>
                                    </div>
                                    <small class="text-muted">Mampu menyusun deskripsi produk dengan jelas</small>
                                </div>
                                
                                <div class="mb-3 pb-2 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong>2.2 Spesifikasi Produk</strong>
                                        <span class="badge bg-success rounded-pill"><?= $nilaiIndustri['spesifikasi_produk'] ?></span>
                                    </div>
                                    <small class="text-muted">Mampu merumuskan requirement/spesifikasi teknis</small>
                                </div>
                                
                                <div class="mb-3 pb-2 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong>2.3 Desain Produk</strong>
                                        <span class="badge bg-success rounded-pill"><?= $nilaiIndustri['desain_produk'] ?></span>
                                    </div>
                                    <small class="text-muted">Dapat merancang desain produk yang baik</small>
                                </div>
                                
                                <div class="mb-3 pb-2 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong>2.4 Implementasi Produk</strong>
                                        <span class="badge bg-success rounded-pill"><?= $nilaiIndustri['implementasi_produk'] ?></span>
                                    </div>
                                    <small class="text-muted">Mengimplementasikan produk sesuai desain</small>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong>2.5 Pengujian Produk</strong>
                                        <span class="badge bg-success rounded-pill"><?= $nilaiIndustri['pengujian_produk'] ?></span>
                                    </div>
                                    <small class="text-muted">Melakukan pengujian produk secara sistematis</small>
                                </div>
                                
                                <div class="mt-4 pt-3 border-top">
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Rata-rata Hard Skills:</span>
                                        <span class="text-success">
                                            <?= number_format((
                                                $nilaiIndustri['deskripsi_produk'] + 
                                                $nilaiIndustri['spesifikasi_produk'] + 
                                                $nilaiIndustri['desain_produk'] + 
                                                $nilaiIndustri['implementasi_produk'] + 
                                                $nilaiIndustri['pengujian_produk']
                                            ) / 5, 2) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Total Score -->
                <div class="mt-4">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center py-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="mb-0 fw-bold">Total Nilai Industri</h5>
                                        <div class="display-5 fw-bold text-success">
                                            <?= number_format($nilaiIndustri['total_nilai_industri'], 2) ?>
                                        </div>
                                    </div>
                                    <div class="progress" style="height: 15px;">
                                        <div class="progress-bar bg-success" 
                                             role="progressbar" 
                                             style="width: <?= $nilaiIndustri['total_nilai_industri'] * 10 ?>%" 
                                             aria-valuenow="<?= $nilaiIndustri['total_nilai_industri'] ?>" 
                                             aria-valuemin="0" 
                                             aria-valuemax="10">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-1 small text-muted">
                                        <span>0</span>
                                        <span>10</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning shadow-sm">
            <i class="fas fa-exclamation-circle me-2"></i>Data penilaian dari industri belum tersedia
        </div>
    <?php endif; ?>

    <!-- Lecturer Evaluation Form -->
    <form method="post" action="<?= site_url('dosen/penilaian-dosen/save'); ?>" class="card border-0 shadow-lg">
        <input type="hidden" name="bimbingan_id" value="<?= $bimbingan_id ?>">
        
        <div class="card-header bg-success text-white fw-bold py-3">
            <i class="fas fa-edit me-2"></i>Form Penilaian Dosen Pembimbing
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-success">
                        <tr>
                            <th style="width: 20%">Kategori</th>
                            <th>Kriteria Penilaian</th>
                            <th style="width: 10%">Range</th>
                            <th style="width: 15%">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Pelaporan -->
                        <tr>
                            <td class="fw-semibold bg-light" rowspan="3">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <i class="fas fa-file-alt mb-1 text-primary"></i>
                                    <span>Pelaporan</span>
                                    <small class="badge bg-primary mt-1">30%</small>
                                </div>
                            </td>
                            <td>1.1 Kesesuaian judul dengan produk yang dihasilkan</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="nilai_1_1" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>
                        <tr>
                            <td>1.2 Penggunaan tata bahasa & tata tulis yang baik</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="nilai_1_2" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>
                        <tr>
                            <td>1.3 Penyusunan laporan sesuai format standar</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="nilai_1_3" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>

                        <!-- Presentasi -->
                        <tr>
                            <td class="fw-semibold bg-light" rowspan="4">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <i class="fas fa-presentation-screen mb-1 text-warning"></i>
                                    <span>Presentasi</span>
                                    <small class="badge bg-warning mt-1">40%</small>
                                </div>
                            </td>
                            <td>2.1 Pengetahuan praktis sesuai kegiatan magang</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="nilai_2_1" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>
                        <tr>
                            <td>2.2 Kemampuan menjawab pertanyaan dengan tepat</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="nilai_2_2" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>
                        <tr>
                            <td>2.3 Etika dan sikap selama presentasi</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="nilai_2_3" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>
                        <tr>
                            <td>2.4 Kesesuaian kegiatan dengan profil lulusan</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="nilai_2_4" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>

                        <!-- Bimbingan -->
                        <tr>
                            <td class="fw-semibold bg-light" rowspan="2">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <i class="fas fa-handshake mb-1 text-success"></i>
                                    <span>Bimbingan</span>
                                    <small class="badge bg-success mt-1">30%</small>
                                </div>
                            </td>
                            <td>3.1 Frekuensi bimbingan minimal 4 kali</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="nilai_3_1" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>
                        <tr>
                            <td>3.2 Bukti kemajuan bimbingan berkala</td>
                            <td class="text-center">5-10</td>
                            <td>
                                <input type="number" name="nilai_3_2" min="5" max="10" 
                                       class="form-control form-control-sm" required>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Final Score Calculation -->
            <?php if (isset($nilaiIndustri) && $nilaiIndustri): ?>
                <div class="mt-4 pt-3 border-top">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Komponen Nilai</h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Nilai Industri (60%):</span>
                                        <span class="fw-bold"><?= number_format($nilaiIndustri['total_nilai_industri'], 2) ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Nilai Dosen (40%):</span>
                                        <span class="fw-bold">(Akan dihitung)</span>
                                    </div>
                                    <div class="d-flex justify-content-between fw-bold text-success">
                                        <span>Total Nilai Akhir:</span>
                                        <span><?= number_format($nilaiIndustri['total_nilai_industri'] * 0.6, 2) ?> + (Nilai Dosen × 0.4)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-4 py-2 fw-bold shadow-sm">
                    <i class="fas fa-save me-2"></i>Simpan Penilaian
                </button>
                <a href="<?= site_url('dosen/penilaian-dosen') ?>" class="btn btn-outline-secondary px-4 py-2 ms-2">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>