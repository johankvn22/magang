<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_kps'); ?>
<?= $this->section('content'); ?>

<body>

    <div class="container mt-4">
        <h5 class="mb-3">Bagikan Dosen Pembimbing</h5>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('/kps/simpan-bimbingan') ?>" class="bg-light p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="mahasiswa_id" class="form-label">Nama Mahasiswa</label>
                <select class="form-select" id="mahasiswa_id" name="mahasiswa_id" required>
                    <option value="">-- Pilih Mahasiswa --</option>
                    <?php foreach ($mahasiswa as $mhs): ?>
                        <option value="<?= $mhs['mahasiswa_id'] ?>"><?= $mhs['nama_lengkap'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="dosen_id" class="form-label">Nama Dosen Pembimbing</label>
                <select class="form-select" id="dosen_id" name="dosen_id" required>
                    <option value="">-- Pilih Dosen Pembimbing --</option>
                    <?php foreach ($dosen as $dsn): ?>
                        <option value="<?= $dsn['dosen_id'] ?>"><?= $dsn['nama_lengkap'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Add</button>
            <a href="<?= base_url('kps/bagikan-bimbingan') ?>" class="btn btn-danger">Cancel</a>
        </form>
    </div>

    <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>


</body>

<?= $this->endSection(); ?>