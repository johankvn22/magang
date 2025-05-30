<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_mahasiswa'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="col-12">
        <div class="card shadow-sm mb-4 border-0 rounded-3">
            <div class="card-header bg-success text-white rounded-top-3">
                <h5>Edit Logbook</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= site_url('mahasiswa/logbook/update/' . $entry['logbook_id']) ?>" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="tanggal" class="form-label">Tanggal:</label>
                            <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?= esc($entry['tanggal']) ?>" required>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-9">
                            <label for="aktivitas" class="form-label">Aktivitas:</label>
                            <textarea id="aktivitas" name="aktivitas" class="form-control" required><?= esc($entry['aktivitas']) ?></textarea>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-5">
                            <label for="file_dokumen" class="form-label">Upload Dokumen Baru (optional):</label>
                            <input type="file" id="file_dokumen" name="file_dokumen" class="form-control" accept=".pdf">
                        </div>
                        <div class="col-md-7">
                            <label for="link_drive" class="form-label">Link Google Drive:</label>
                            <input type="url" id="link_drive" name="link_drive" class="form-control" value="<?= esc($entry['link_drive']) ?>">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="<?= site_url('mahasiswa/logbook') ?>" class="btn btn-secondary">Kembali</a>
                    </div>

                </form>
            </div>
        </div>  
    </div>
</div>
<?= $this->endSection(); ?>
