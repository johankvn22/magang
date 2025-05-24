<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_panitia'); ?>
<?= $this->section('content'); ?>

<body>

    <h2>Daftar Dosen Pembimbing dan Mahasiswa Bimbingan</h2>

    <?php if (!empty($bimbingan)): ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Dosen</th>
                    <th>NIP</th>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($bimbingan as $b): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($b['nama_dosen']) ?></td>
                        <td><?= esc($b['nip']) ?></td>
                        <td><?= esc($b['nama_mahasiswa']) ?></td>
                        <td><?= esc($b['nim']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada data bimbingan ditemukan.</p>
    <?php endif; ?>

</body>

<?= $this->endSection(); ?>