<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">
    <?= form_open('/industri/review-kinerja/simpanNilai', ['method' => 'post', 'class' => 'needs-validation', 'novalidate' => '']) ?>
    <?= csrf_field() ?>
    <input type="hidden" name="bimbingan_industri_id" value="<?= esc($bimbingan['bimbingan_industri_id']) ?>">
    <input type="hidden" name="mahasiswa_id" value="<?= esc($bimbingan['mahasiswa_id']) ?>">

    <!-- SECTION: DATA MAHASISWA -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Data Mahasiswa</strong>
        </div>
        <div class="card-body">
            <table class="table table-borderless mb-0">
                <tr>
                    <th style="width: 200px;">Nama Mahasiswa</th>
                    <td><?= esc($bimbingan['nama_lengkap'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th>Email Mahasiswa</th>
                    <td><?= esc($bimbingan['email'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th>No HP Mahasiswa</th>
                    <td><?= esc($bimbingan['no_hp'] ?? '-') ?></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- SECTION: DATA PEMBIMBING -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Data Pembimbing & Perusahaan</strong>
        </div>
        <div class="card-body">
            <table class="table table-borderless mb-0">
                <tr>
                    <th style="width: 200px;">Nama Pembimbing</th>
                    <td><input type="text" class="form-control" name="nama_pembimbing_perusahaan" required></td>
                </tr>
                <tr>
                    <th>Nama Perusahaan</th>
                    <td><input type="text" class="form-control" name="nama_perusahaan" required></td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td><input type="text" class="form-control" name="jabatan" required></td>
                </tr>
                <tr>
                    <th>Divisi</th>
                    <td><input type="text" class="form-control" name="divisi" required></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- SECTION: PENILAIAN -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Penilaian Kompetensi</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th style="width: 35%;">Kompetensi</th>
                        <th>Kurang</th>
                        <th>Cukup</th>
                        <th>Baik</th>
                        <th>Sangat Baik</th>
                    </tr>
                </thead>
                <tbody>
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
                    $options = ['kurang', 'cukup', 'baik', 'sangat_baik'];

                    foreach ($fields as $field => $label): ?>
                        <tr>
                            <td><?= $label ?></td>
                            <?php foreach ($options as $opt): ?>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="<?= $field ?>" value="<?= $opt ?>" required>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- SECTION: ESSAY -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Saran & Evaluasi Tambahan</strong>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Saran untuk Lulusan</label>
                <textarea class="form-control" name="saran_lulusan" rows="3" placeholder="Opsional..."></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Kemampuan Teknik yang Dibutuhkan <span class="text-danger">*</span></label>
                <textarea class="form-control" name="kemampuan_teknik_dibutuhkan" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Profesi yang Cocok untuk Mahasiswa Ini <span class="text-danger">*</span></label>
                <textarea class="form-control" name="profesi_cocok" rows="3" required></textarea>
            </div>
        </div>
    </div>

    <!-- SUBMIT -->
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
        <?php if (!isset($readonly) || !$readonly): ?>
            <button type="submit" class="btn btn-success px-4">
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