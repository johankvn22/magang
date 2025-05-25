<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_admin'); ?>
<?= $this->section('content'); ?>

<body class="container mt-4">

<h2>Detail Review Kinerja Mahasiswa</h2>

<table class="table table-bordered">
    <tr><th>Nama Mahasiswa</th><td><?= esc($review_id['nama_mahasiswa']) ?></td></tr>
    <tr><th>Email</th><td><?= esc($review_id['email']) ?></td></tr>
    <tr><th>No HP</th><td><?= esc($review_id['no_hp']) ?></td></tr>

    <tr><th>Nama Pembimbing Perusahaan</th><td><?= esc($review_id['nama_pembimbing_perusahaan']) ?></td></tr>
    <tr><th>Nama Perusahaan</th><td><?= esc($review_id['nama_perusahaan']) ?></td></tr>
    <tr><th>Jabatan</th><td><?= esc($review_id['jabatan']) ?></td></tr>
    <tr><th>Divisi</th><td><?= esc($review_id['divisi']) ?></td></tr>

    <tr><th>Integritas</th><td><?= esc($review_id['integritas']) ?></td></tr>
    <tr><th>Keahlian di Bidangnya</th><td><?= esc($review_id['keahlian_bidang']) ?></td></tr>
    <tr><th>Kemampuan Bahasa Inggris</th><td><?= esc($review_id['kemampuan_bahasa_inggris']) ?></td></tr>
    <tr><th>Pengetahuan Bidang</th><td><?= esc($review_id['pengetahuan_bidang']) ?></td></tr>
    <tr><th>Komunikasi & Adaptasi</th><td><?= esc($review_id['komunikasi_adaptasi']) ?></td></tr>
    <tr><th>Kerja Sama</th><td><?= esc($review_id['kerja_sama']) ?></td></tr>
    <tr><th>Kemampuan Belajar</th><td><?= esc($review_id['kemampuan_belajar']) ?></td></tr>
    <tr><th>Kreativitas</th><td><?= esc($review_id['kreativitas']) ?></td></tr>
    <tr><th>Menuangkan Ide</th><td><?= esc($review_id['menuangkan_ide']) ?></td></tr>
    <tr><th>Pemecahan Masalah</th><td><?= esc($review_id['pemecahan_masalah']) ?></td></tr>
    <tr><th>Sikap</th><td><?= esc($review_id['sikap']) ?></td></tr>
    <tr><th>Kerja di Bawah Tekanan</th><td><?= esc($review_id['kerja_dibawah_tekanan']) ?></td></tr>
    <tr><th>Manajemen Waktu</th><td><?= esc($review_id['manajemen_waktu']) ?></td></tr>
    <tr><th>Bekerja Mandiri</th><td><?= esc($review_id['bekerja_mandiri']) ?></td></tr>
    <tr><th>Negosiasi</th><td><?= esc($review_id['negosiasi']) ?></td></tr>
    <tr><th>Analisis</th><td><?= esc($review_id['analisis']) ?></td></tr>
    <tr><th>Bekerja dengan Budaya Berbeda</th><td><?= esc($review_id['bekerja_dengan_budaya_berbeda']) ?></td></tr>
    <tr><th>Kepemimpinan</th><td><?= esc($review_id['kepemimpinan']) ?></td></tr>
    <tr><th>Tanggung Jawab</th><td><?= esc($review_id['tanggung_jawab']) ?></td></tr>
    <tr><th>Presentasi</th><td><?= esc($review_id['presentasi']) ?></td></tr>
    <tr><th>Menulis Dokumen</th><td><?= esc($review_id['menulis_dokumen']) ?></td></tr>

    <tr><th>Saran untuk Lulusan</th><td><?= esc($review_id['saran_lulusan']) ?></td></tr>
    <tr><th>Kemampuan Teknik yang Dibutuhkan</th><td><?= esc($review_id['kemampuan_teknik_dibutuhkan']) ?></td></tr>
    <tr><th>Profesi yang Cocok</th><td><?= esc($review_id['profesi_cocok']) ?></td></tr>

    <tr><th>Tanggal Review</th><td><?= date('d M Y, H:i', strtotime($review_id['created_at'])) ?></td></tr>
</table>

<a href="<?= base_url('admin/review-kinerja') ?>" class="btn btn-secondary">← Kembali ke Daftar</a>

</body>
<?= $this->endSection(); ?>
