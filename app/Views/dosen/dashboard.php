<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_dosen'); ?>
<?= $this->section('content'); ?>

<body>


<div class="container mt-4">
    <h2>Dashboard Dosen Pembimbing</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="card mt-3 p-4">
        <h5>Informasi Dosen Pembimbing</h5>
        <p class="card-text">
            <strong>Nama:</strong> <?= esc($dosen['nama_lengkap']) ?> <br>
            <strong>NIP:</strong> <?= esc($dosen['nip']) ?> <br>
            <strong>No Telepon:</strong> <?= esc($dosen['no_telepon']) ?> <br>
            <strong>Email:</strong> <?= esc($dosen['email']) ?> <br>
            <strong>Link WhatsApp:</strong> <a href="<?= esc($dosen['link_whatsapp']) ?>" target="_blank"><?= esc($dosen['link_whatsapp']) ?></a>
        </p>
    </div>

    <div class="mt-4">
        <a href="<?= site_url('dosen/bimbingan'); ?>" class="btn btn-primary">Lihat Bimbingan Mahasiswa</a>
        
    </div>
</div>




</body>

<?= $this->endSection(); ?>