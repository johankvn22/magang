<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_dosen'); ?>
<?= $this->section('content'); ?>

<h2 class="mb-4">Detail Logbook Aktivitas Industri Mahasiswa</h2>

<h4>Informasi Mahasiswa</h4>
<table class="table table-bordered mb-4">
    <tr>
        <th>Nama Lengkap</th>
        <td><?= esc($mahasiswa['nama_lengkap']) ?></td>
    </tr>
    <tr>
        <th>NIM</th>
        <td><?= esc($mahasiswa['nim']) ?></td>
    </tr>
    <tr>
        <th>Program Studi</th>
        <td><?= esc($mahasiswa['program_studi']) ?></td>
    </tr>
    <tr>
        <th>Kelas</th>
        <td><?= esc($mahasiswa['kelas']) ?></td>
    </tr>
    <tr>
        <th>No. HP</th>
        <td><?= esc($mahasiswa['no_hp']) ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?= esc($mahasiswa['email']) ?></td>
    </tr>
    <tr>
        <th>Perusahaan</th>
        <td><?= esc($mahasiswa['nama_perusahaan']) ?></td>
    </tr>
    <tr>
        <th>Divisi</th>
        <td><?= esc($mahasiswa['divisi']) ?></td>
    </tr>
    <tr>
        <th>Durasi Magang</th>
        <td><?= esc($mahasiswa['durasi_magang']) ?> hari</td>
    </tr>
    <tr>
        <th>Tanggal Mulai</th>
        <td><?= esc($mahasiswa['tanggal_mulai']) ?></td>
    </tr>
    <tr>
        <th>Tanggal Selesai</th>
        <td><?= esc($mahasiswa['tanggal_selesai']) ?></td>
    </tr>
    <tr>
        <th>Nama Pembimbing Perusahaan</th>
        <td><?= esc($mahasiswa['nama_pembimbing_perusahaan']) ?></td>
    </tr>
    <tr>
        <th>No. HP Pembimbing</th>
        <td><?= esc($mahasiswa['no_hp_pembimbing_perusahaan']) ?></td>
    </tr>
    <tr>
        <th>Email Pembimbing</th>
        <td><?= esc($mahasiswa['email_pembimbing_perusahaan']) ?></td>
    </tr>
    <tr>
        <th>Judul Magang</th>
        <td><?= esc($mahasiswa['judul_magang']) ?></td>
    </tr>
</table>

<h4>Logbook Aktivitas Industri</h4>
<table class="table table-striped table-bordered">
    <thead class="table-light">
        <tr>
            <th>Tanggal</th>
            <th>Aktivitas</th>
            <th>Catatan Industri</th>
            <th>Status Validasi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($logbooks)) : ?>
            <?php foreach ($logbooks as $log) : ?>
                <tr>
                    <td><?= esc($log['tanggal']) ?></td>
                    <td><?= esc($log['aktivitas']) ?></td>
                    <td><?= esc($log['catatan_industri']) ?></td>
                    <td><?= esc($log['status_validasi']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="4" class="text-center">Belum ada logbook aktivitas.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection(); ?>
