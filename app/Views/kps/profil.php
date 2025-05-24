<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_kps'); ?>
<?= $this->section('content'); ?>
<body>

<div class="container mt-4">
    <h2 class="mb-4">Profil KPS</h2>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <table class="table table-striped table-bordered">
        <tr>
            <th>Nama</th>
            <td><?= esc($kps['nama']) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= esc($kps['email']) ?></td>
        </tr>
        <tr>
            <th>No. Telepon</th>
            <td><?= esc($kps['no_telepon']) ?></td>
        </tr>
    </table>

    <div class="mt-3">
        <a href="<?= base_url('kps/edit-profil') ?>" class="btn btn-primary">Edit Profil</a>
    </div>
</div>
</body>

<?= $this->endSection(); ?>