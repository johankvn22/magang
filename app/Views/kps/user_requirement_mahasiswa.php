<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_kps'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
    <h3 class="mb-4">Daftar Mahasiswa Pengisi User Requirement</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIM</th>
                <th>Program Studi</th>
                <th>Terakhir Diisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mahasiswaList as $mhs): ?>
                <tr>
                    <td><?= esc($mhs['nama_lengkap']) ?></td>
                    <td><?= esc($mhs['nim']) ?></td>
                    <td><?= esc($mhs['program_studi']) ?></td>
                    <td><?= esc($mhs['terakhir_diisi']) ?></td>
                    <td>
                        <a href="<?= site_url('kps/user-requirement/detail/' . $mhs['mahasiswa_id']) ?>" class="btn btn-info btn-sm">Detail</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>
