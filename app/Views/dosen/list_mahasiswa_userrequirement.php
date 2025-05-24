<?php
/** @var \CodeIgniter\View\View $this */
?>

<?= $this->extend('layouts/template_dosen'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
    <h3 class="mb-4">Daftar Mahasiswa Bimbingan</h3>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Nama</th>
                <th>NIM</th>
                <th>Program Studi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mahasiswaList as $mhs) : ?>
                <tr>
                    <td><?= esc($mhs['nama_lengkap']) ?></td>
                    <td><?= esc($mhs['nim']) ?></td>
                    <td><?= esc($mhs['program_studi']) ?></td>
                    <td>
                        <a href="<?= base_url('dosen/user-requirement/detail/' . $mhs['mahasiswa_id']) ?>" class="btn btn-info btn-sm">Detail</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>
