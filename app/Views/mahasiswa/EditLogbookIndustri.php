<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_mahasiswa'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
  <h2>Edit Logbook Industri</h2>
  <form method="POST" action="<?= site_url('mahasiswa/logbook_industri/update/' . $entry['logbook_id']) ?>">
    <div class="form-group mb-3">
      <label for="tanggal">Tanggal:</label>
      <input type="date" name="tanggal" class="form-control" value="<?= esc($entry['tanggal']) ?>" required>
    </div>
    <div class="form-group mb-3">
      <label for="aktivitas">Aktivitas:</label>
      <textarea name="aktivitas" class="form-control" rows="3" required><?= esc($entry['aktivitas']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= site_url('mahasiswa/logbook_industri') ?>" class="btn btn-secondary">Batal</a>
  </form>
</div>

<?= $this->endSection(); ?>
