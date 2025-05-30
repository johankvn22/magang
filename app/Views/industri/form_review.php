<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">
    <?= form_open('/industri/review-kinerja/simpanNilai', ['method' => 'post', 'class' => 'needs-validation', 'novalidate' => '']) ?>
    <?= csrf_field() ?>
    <input type="hidden" name="bimbingan_industri_id" value="<?= esc($bimbingan['bimbingan_industri_id']) ?>">

    <!-- SECTION: DATA MAHASISWA -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <h4 class="mb-0"><i class="fas fa-user-graduate me-2"></i>Data Mahasiswa</h4>
        </div>
        <div class="card-body">
            <?php $disabled = isset($readonly) && $readonly ? 'disabled' : ''; ?>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Mahasiswa</label>
                    <input type="text" class="form-control" value="<?= esc($bimbingan['nama_lengkap'] ?? '') ?>" readonly>
                    <input type="hidden" name="nama_lengkap" value="<?= esc($bimbingan['mahasiswa_id']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email Mahasiswa</label>
                    <input type="text" class="form-control" value="<?= esc($bimbingan['email'] ?? '') ?>" readonly>
                    <input type="hidden" name="email" value="<?= esc($bimbingan['email']) ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">No HP Mahasiswa</label>
                    <input type="text" class="form-control" value="<?= esc($bimbingan['no_hp'] ?? '') ?>" readonly>
                    <input type="hidden" name="no_hp" value="<?= esc($bimbingan['no_hp']) ?>">
                </div>
            </div>

            <input type="hidden" name="mahasiswa_id" value="<?= esc($bimbingan['mahasiswa_id']) ?>">
        </div>
    </div>

    <!-- SECTION: PEMBIMBING & PERUSAHAAN -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <h4 class="mb-0"><i class="fas fa-building me-2"></i>Data Pembimbing & Perusahaan</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_pembimbing_perusahaan" class="form-label">Nama Pembimbing</label>
                    <input type="text" class="form-control" name="nama_pembimbing_perusahaan" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                    <input type="text" class="form-control" name="nama_perusahaan" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" name="jabatan" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="divisi" class="form-label">Divisi</label>
                    <input type="text" class="form-control" name="divisi" required>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION: PENILAIAN KOMPETENSI -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <h4 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>Penilaian Kompetensi</h4>
        </div>
        <div class="card-body">
            <?php
            $fields = [
                'integritas' => 'Integritas',
                'keahlian_bidang' => 'Keahlian Bidang',
                'kemampuan_bahasa_inggris' => 'Kemampuan Bahasa Inggris',
                'pengetahuan_bidang' => 'Pengetahuan Bidang',
                'komunikasi_adaptasi' => 'Komunikasi & Adaptasi',
                'kerja_sama' => 'Kerja Sama',
                'kemampuan_belajar' => 'Kemampuan Belajar',
                'kreativitas' => 'Kreativitas',
                'menuangkan_ide' => 'Menuangkan Ide',
                'pemecahan_masalah' => 'Pemecahan Masalah',
                'sikap' => 'Sikap',
                'kerja_dibawah_tekanan' => 'Kerja di Bawah Tekanan',
                'manajemen_waktu' => 'Manajemen Waktu',
                'bekerja_mandiri' => 'Bekerja Mandiri',
                'negosiasi' => 'Negosiasi',
                'analisis' => 'Analisis',
                'bekerja_dengan_budaya_berbeda' => 'Bekerja dengan Budaya Berbeda',
                'kepemimpinan' => 'Kepemimpinan',
                'tanggung_jawab' => 'Tanggung Jawab',
                'presentasi' => 'Presentasi',
                'menulis_dokumen' => 'Menulis Dokumen'
            ];

            $options = [
                'sangat_baik' => 'Sangat Baik',
                'baik' => 'Baik',
                'cukup' => 'Cukup',
                'kurang' => 'Kurang'
            ];

            foreach ($fields as $field => $label): ?>
                <div class="mb-4">
                    <label class="form-label fw-bold"><?= $label ?></label>
                    <div class="d-flex flex-wrap gap-3">
                        <?php foreach ($options as $value => $text): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="<?= $field ?>" id="<?= $field ?>_<?= $value ?>" value="<?= $value ?>" required>
                                <label class="form-check-label" for="<?= $field ?>_<?= $value ?>">
                                    <?= $text ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- SECTION: ESSAY -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <h4 class="mb-0"><i class="fas fa-comment-dots me-2"></i>Saran & Evaluasi Tambahan</h4>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="saran_lulusan" class="form-label">Saran untuk Lulusan</label>
                <textarea class="form-control" name="saran_lulusan" rows="3" placeholder="Opsional..."></textarea>
            </div>
            <div class="mb-3">
                <label for="kemampuan_teknik_dibutuhkan" class="form-label">Kemampuan Teknik yang Dibutuhkan</label>
                <textarea class="form-control" name="kemampuan_teknik_dibutuhkan" rows="3" placeholder="Contoh: Programming, Komunikasi, dll" required></textarea>
            </div>
            <div class="mb-3">
                <label for="profesi_cocok" class="form-label">Profesi yang Cocok untuk Mahasiswa Ini</label>
                <textarea class="form-control" name="profesi_cocok" rows="3" placeholder="Contoh: Software Engineer, UI/UX Designer, dsb." required></textarea>
            </div>
        </div>
    </div>

    <!-- SUBMIT -->
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <?php if (!isset($readonly) || !$readonly): ?>
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save me-2"></i>Simpan Review
            </button>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>Review sudah disimpan dan tidak bisa diubah.
            </div>
        <?php endif; ?>
    </div>

    <?= form_close() ?>
</div>

<?= $this->endSection(); ?>