<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_mahasiswa'); ?>
<?= $this->section('content'); ?>
<div class="container mt-5">
    <h2>Edit Logbook</h2>
    <form method="POST" action="<?= site_url('mahasiswa/logbook/update/' . $entry['logbook_id']) ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" class="form-control" value="<?= esc($entry['tanggal']) ?>" required>
        </div>
        <div class="form-group">
            <label for="aktivitas">Aktivitas:</label>
            <textarea name="aktivitas" class="form-control" required><?= esc($entry['aktivitas']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="file_dokumen">Upload Dokumen Baru (optional):</label>
            <input type="file" name="file_dokumen" class="form-control-file" accept=".pdf">
        </div>
        <div class="form-group">
            <label for="link_drive">Link Google Drive:</label>
            <input type="url" name="link_drive" class="form-control" value="<?= esc($entry['link_drive']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
<?= $this->endSection(); ?>
