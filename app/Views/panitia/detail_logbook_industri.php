<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_panitia'); ?>
<?= $this->section('content'); ?>



<h2>Detail Mahasiswa</h2>
<ul>
    <li>Nama: <?= esc($mahasiswa['nama_lengkap']) ?></li>
    <li>NIM: <?= esc($mahasiswa['nim']) ?></li>
    <li>Perusahaan: <?= esc($mahasiswa['nama_perusahaan']) ?></li>
    <li>Divisi: <?= esc($mahasiswa['divisi']) ?></li>
</ul>

<h3>Log Aktivitas di Industri</h3>
<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Judul</th>
            <th>Isi</th>
            <th>Status Validasi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($logbook_industri as $log): ?>
            <tr>
                <td><?= esc($log['tanggal']) ?></td>
                <td><?= esc($log['aktivitas']) ?></td>
                <td><?= esc($log['catatan_industri']) ?></td>
                <td><?= esc($log['status_validasi']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection(); ?>
