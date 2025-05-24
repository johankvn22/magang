<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>
<form action="<?= base_url('/industri/simpan-password') ?>" method="post" class="container mt-4">
    <h4>Ganti Password</h4>
    <div class="mb-3">
        <label>Password Baru</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Konfirmasi Password</label>
        <input type="password" name="konfirmasi_password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-warning">Simpan</button>
</form>
<?= $this->endSection(); ?>
