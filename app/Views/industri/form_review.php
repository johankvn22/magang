<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>

<?= form_open('/industri/review-kinerja/simpanNilai', ['method' => 'post']) ?>
<?= csrf_field() ?>
<input type="hidden" name="bimbingan_industri_id" value="<?= esc($bimbingan['bimbingan_industri_id']) ?>">


<!-- SECTION: DATA MAHASISWA -->
<h3>Data Mahasiswa</h3>

<?php $disabled = isset($readonly) && $readonly ? 'disabled' : ''; ?>

<div>
    <label>Nama Mahasiswa:</label>
    <input type="text" value="<?= esc($bimbingan['mahasiswa_id']) ?>" readonly>
    <input type="hidden" name="nama_lengkap" value="<?= esc($bimbingan['mahasiswa_id']) ?>">
</div>

<div>
    <label>Email Mahasiswa:</label>
    <input type="text" value="<?= esc($bimbingan['email']) ?>" readonly>
    <input type="hidden" name="email" value="<?= esc($bimbingan['email']) ?>">
</div>

<div>
    <label>No HP Mahasiswa:</label>
    <input type="text" value="<?= esc($bimbingan['no_hp']) ?>" readonly>
    <input type="hidden" name="no_hp" value="<?= esc($bimbingan['no_hp']) ?>">
</div>

<input type="hidden" name="mahasiswa_id" value="<?= esc($bimbingan['mahasiswa_id']) ?>">

<!-- SECTION: PEMBIMBING & PERUSAHAAN -->
<h3>Data Pembimbing & Perusahaan</h3>

<div>
    <label for="nama_pembimbing_perusahaan">Nama Pembimbing</label>
    <input type="text" name="nama_pembimbing_perusahaan" required>
</div>

<div>
    <label for="nama_perusahaan">Nama Perusahaan</label>
    <input type="text" name="nama_perusahaan" required>
</div>

<div>
    <label for="jabatan">Jabatan</label>
    <input type="text" name="jabatan" required>
</div>

<div>
    <label for="divisi">Divisi</label>
    <input type="text" name="divisi" required>
</div>

<!-- SECTION: PENILAIAN KOMPETENSI -->
<!-- SECTION: PENILAIAN KOMPETENSI -->
<h3>Penilaian Kompetensi</h3>

<?php
$fields = [
    'integritas',
    'keahlian_bidang',
    'kemampuan_bahasa_inggris',
    'pengetahuan_bidang',
    'komunikasi_adaptasi',
    'kerja_sama',
    'kemampuan_belajar',
    'kreativitas',
    'menuangkan_ide',
    'pemecahan_masalah',
    'sikap',
    'kerja_dibawah_tekanan',
    'manajemen_waktu',
    'bekerja_mandiri',
    'negosiasi',
    'analisis',
    'bekerja_dengan_budaya_berbeda',
    'kepemimpinan',
    'tanggung_jawab',
    'presentasi',
    'menulis_dokumen'
];

$options = ['sangat_baik', 'baik', 'cukup', 'kurang'];

foreach ($fields as $field): ?>
    <div style="margin-bottom: 15px;">
        <label><strong><?= ucwords(str_replace('_', ' ', $field)) ?></strong></label><br>
        <?php foreach ($options as $option): ?>
            <label style="margin-right: 10px;">
                <input type="radio" name="<?= $field ?>" value="<?= $option ?>" required>
                <?= ucfirst(str_replace('_', ' ', $option)) ?>
            </label>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>


<!-- SECTION: ESSAY -->
<h3>Saran & Evaluasi Tambahan</h3>

<div>
    <label for="saran_lulusan">Saran untuk Lulusan</label>
    <textarea name="saran_lulusan" rows="4" cols="40" placeholder="Opsional..."></textarea>
</div>

<div>
    <label for="kemampuan_teknik_dibutuhkan">Kemampuan Teknik yang Dibutuhkan</label>
    <textarea name="kemampuan_teknik_dibutuhkan" rows="4" cols="40" placeholder="Contoh: Programming, Komunikasi, dll"></textarea>
</div>

<div>
    <label for="profesi_cocok">Profesi yang Cocok untuk Mahasiswa Ini</label>
    <textarea name="profesi_cocok" rows="4" cols="40" placeholder="Contoh: Software Engineer, UI/UX Designer, dsb."></textarea>
</div>

<!-- SUBMIT -->
<?php if (!isset($readonly) || !$readonly): ?>
    <div style="margin-top: 20px;">
        <button type="submit">Simpan Review</button>
    </div>
<?php else: ?>
    <p><em>Review sudah disimpan dan tidak bisa diubah.</em></p>
<?php endif; ?>


<?= form_close() ?>

<?= $this->endSection(); ?>
