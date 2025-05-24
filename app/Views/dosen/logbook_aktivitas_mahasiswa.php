<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_dosen'); ?>
<?= $this->section('content'); ?>

<h2>Daftar Mahasiswa Bimbingan</h2>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Nama</th>
            <th>NIM</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($mahasiswaList)) : ?>
            <?php foreach ($mahasiswaList as $mhs) : ?>
                <tr>
                    <td><?= esc($mhs['nama_lengkap']) ?></td>
                    <td><?= esc($mhs['nim']) ?></td>
                    <td>
                        <a href="<?= site_url('/dosen/logbook/' . $mhs['mahasiswa_id']) ?>">Lihat Aktivitas</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr><td colspan="3">Tidak ada mahasiswa bimbingan.</td></tr>
        <?php endif; ?>
    </tbody>
</table>



<?= $this->endSection(); ?>
