<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_kps'); ?>
<?= $this->section('content'); ?>

<body>
    <nav>
        <strong>Edit Profil KPS</strong>
    </nav>
    <div class="container">
        <?= form_open('kps/updateProfile'); ?>
            <?= csrf_field() ?>

            <label for="nip">NIP</label>
            <input type="text" name="nip" value="<?= esc($kps['nip']) ?>" required readonly>

            <label for="nama">Nama</label>
            <input type="text" name="nama" value="<?= esc($kps['nama']) ?>" required>

            <label for="email">Email</label>
            <input type="email" name="email" value="<?= esc($kps['email']) ?>" required>

            <label for="no_telepon">No Telepon</label>
            <input type="text" name="no_telepon" value="<?= esc($kps['no_telepon']) ?>" required>

            <button type="submit">Simpan Perubahan</button>
        <?= form_close(); ?>
    </div>
</body>

<?= $this->endSection(); ?>