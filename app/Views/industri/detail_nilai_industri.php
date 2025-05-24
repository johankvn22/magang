<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h2>Detail Penilaian Mahasiswa</h2>

    <div class="mb-3">
        <strong>Nama Mahasiswa:</strong> <?= esc($penilaian['nama_lengkap']) ?><br>
        <strong>NIM:</strong> <?= esc($penilaian['nim']) ?>
    </div>

    <h5 class="mt-4">Aspek Soft Skill 50%</h5>
    <?php
    $softSkills = [
        'komunikasi' => '1.1 Mahasiswa memiliki Kemampuan berkomunikasi yang baik',
        'berpikir_kritis' => '1.2 Mahasiswa mampu Berpikir Kritis',
        'kerja_tim' => '1.3 Mahasiswa mampu bekerja individu maupun Tim',
        'inisiatif' => '1.4 Mahasiswa memiliki daya Inisiatif, Kreatif, Inovatif dan Adaptif yang tinggi',
        'literasi_digital' => '1.5 Mahasiswa memiliki kemampuan Literasi, informasi, media dan teknologi'
    ];
    foreach ($softSkills as $name => $label): ?>
        <div class="form-group">
            <label><?= $label ?></label>
            <input type="number" class="form-control" value="<?= esc($penilaian[$name]) ?>" readonly>
        </div>
    <?php endforeach; ?>

    <h5 class="mt-4">Aspek Hard Skill 50%</h5>
    <?php
    $produkSkills = [
        'deskripsi_produk' => '2.1 Mahasiswa mampu membuat deskripsi produk',
        'spesifikasi_produk' => '2.2 Mahasiswa mampu menentukan requirement/Spesifikasi Produk',
        'desain_produk' => '2.3 Mahasiswa mampu membuat desain produk',
        'implementasi_produk' => '2.4 Mahasiswa mampu mengimplementasikan produk',
        'pengujian_produk' => '2.5 Mahasiswa mampu melakukan pengujian produk'
    ];
    foreach ($produkSkills as $name => $label): ?>
        <div class="form-group">
            <label><?= $label ?></label>
            <input type="number" class="form-control" value="<?= esc($penilaian[$name]) ?>" readonly>
        </div>
    <?php endforeach; ?>

    <div class="form-group mt-4">
        <label><strong>Total Nilai:</strong></label>
        <input type="number" class="form-control" value="<?= esc($penilaian['total_nilai_industri']) ?>" readonly>
    </div>
</div>

<?= $this->endSection(); ?>
