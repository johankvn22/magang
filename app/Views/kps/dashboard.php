<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_kps'); ?>
<?= $this->section('content'); ?>

<body>

    <!-- ISI DASHBOARD -->

    <div class="container">
        <h2>Selamat Datang, <?= esc(session('nama')) ?>!</h2>

        <div class="card">
            <p><strong>NIP:</strong> <?= esc($kps['nip']) ?></p>
            <p><strong>Email:</strong> <?= esc($kps['email']) ?></p>
            <p><strong>No Telepon:</strong> <?= esc($kps['no_telepon']) ?></p>
        </div>
    </div>

</body>

<?= $this->endSection(); ?>