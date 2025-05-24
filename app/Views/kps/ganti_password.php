<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_kps'); ?>
<?= $this->section('content'); ?>

<nav>
    <strong>Ganti Password</strong>
</nav>

<div class="container">
    <form action="/kps/ganti-password" method="post">
        <?= csrf_field() ?>
        <label for="old_password">Password Lama</label>
        <input type="password" name="old_password" required>

        <label for="new_password">Password Baru</label>
        <input type="password" name="new_password" required>

        <label for="confirm_password">Konfirmasi Password Baru</label>
        <input type="password" name="confirm_password" required>

        <button type="submit">Ganti Password</button>
    </form>
</div>

</body>

<?= $this->endSection(); ?>
