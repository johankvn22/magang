<?php
/** @var \CodeIgniter\View\View $this */
?>

<?= $this->extend('layouts/template_mahasiswa'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
  <h3>Edit User Requirement</h3>

  <form method="POST" action="<?= site_url('mahasiswa/user-requirement/update/' . $requirement['requirement_id']) ?>">
    <?= csrf_field() ?>
    
    <div class="form-group mb-3">
      <label for="tanggal">Tanggal:</label>
      <input type="date" name="tanggal" class="form-control" value="<?= esc($requirement['tanggal']) ?>" required>
    </div>

    <div class="form-group mb-3">
      <label for="dikerjakan">Modul/Unit yang Dikerjakan:</label>
      <textarea name="dikerjakan" class="form-control" required><?= esc($requirement['dikerjakan']) ?></textarea>
    </div>

    <div class="form-group mb-3">
      <label for="user_requirement">User Requirement / Spesifikasi:</label>
      <textarea name="user_requirement" class="form-control"><?= esc($requirement['user_requirement']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="<?= site_url('mahasiswa/user-requirement') ?>" class="btn btn-secondary">Batal</a>
  </form>
</div>

<?= $this->endSection(); ?>
