<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h2>Detail Review Kinerja Mahasiswa</h2>

    <table class="table table-bordered">
        <tr><th>Nama Mahasiswa</th><td><?= esc($review['nama_mahasiswa']) ?></td></tr>
        <tr><th>Email</th><td><?= esc($review['email']) ?></td></tr>
        <tr><th>No HP</th><td><?= esc($review['no_hp']) ?></td></tr>

        <tr><th>Pembimbing Perusahaan</th><td><?= esc($review['nama_pembimbing_perusahaan'] ?? '-') ?></td></tr>
        <tr><th>Nama Perusahaan</th><td><?= esc($review['nama_perusahaan'] ?? '-') ?></td></tr>
        <tr><th>Jabatan</th><td><?= esc($review['jabatan'] ?? '-') ?></td></tr>
        <tr><th>Divisi</th><td><?= esc($review['divisi'] ?? '-') ?></td></tr>

        <tr><th>Integritas</th><td><?= esc($review['integritas']) ?></td></tr>
        <tr><th>Keahlian di Bidangnya</th><td><?= esc($review['keahlian_bidang']) ?></td></tr>
        <tr><th>Kemampuan Bahasa Inggris</th><td><?= esc($review['kemampuan_bahasa_inggris']) ?></td></tr>
        <tr><th>Pengetahuan Bidang</th><td><?= esc($review['pengetahuan_bidang']) ?></td></tr>
        <tr><th>Komunikasi & Adaptasi</th><td><?= esc($review['komunikasi_adaptasi']) ?></td></tr>
        <tr><th>Kerja Sama</th><td><?= esc($review['kerja_sama']) ?></td></tr>
        <tr><th>Kemampuan Belajar</th><td><?= esc($review['kemampuan_belajar']) ?></td></tr>
        <tr><th>Kreativitas</th><td><?= esc($review['kreativitas']) ?></td></tr>
        <tr><th>Menuangkan Ide</th><td><?= esc($review['menuangkan_ide']) ?></td></tr>
        <tr><th>Pemecahan Masalah</th><td><?= esc($review['pemecahan_masalah']) ?></td></tr>
        <tr><th>Sikap</th><td><?= esc($review['sikap']) ?></td></tr>
        <tr><th>Kerja di Bawah Tekanan</th><td><?= esc($review['kerja_dibawah_tekanan']) ?></td></tr>
        <tr><th>Manajemen Waktu</th><td><?= esc($review['manajemen_waktu']) ?></td></tr>
        <tr><th>Bekerja Mandiri</th><td><?= esc($review['bekerja_mandiri']) ?></td></tr>
        <tr><th>Negosiasi</th><td><?= esc($review['negosiasi']) ?></td></tr>
        <tr><th>Analisis</th><td><?= esc($review['analisis']) ?></td></tr>
        <tr><th>Bekerja dengan Budaya Berbeda</th><td><?= esc($review['bekerja_dengan_budaya_berbeda']) ?></td></tr>
        <tr><th>Kepemimpinan</th><td><?= esc($review['kepemimpinan']) ?></td></tr>
        <tr><th>Tanggung Jawab</th><td><?= esc($review['tanggung_jawab']) ?></td></tr>
        <tr><th>Presentasi</th><td><?= esc($review['presentasi']) ?></td></tr>
        <tr><th>Menulis Dokumen</th><td><?= esc($review['menulis_dokumen']) ?></td></tr>

        <tr><th>Saran untuk Lulusan</th><td><?= esc($review['saran_lulusan']) ?></td></tr>
        <tr><th>Kemampuan Teknik yang Dibutuhkan</th><td><?= esc($review['kemampuan_teknik_dibutuhkan']) ?></td></tr>
        <tr><th>Profesi yang Cocok</th><td><?= esc($review['profesi_cocok']) ?></td></tr>

        <tr><th>Tanggal Review</th><td><?= date('d M Y, H:i', strtotime($review['created_at'])) ?></td></tr>
    </table>

    <a href="<?= base_url('industri/review-kinerja/daftar') ?>" class="btn btn-secondary">← Kembali ke Daftar</a>
</div>

