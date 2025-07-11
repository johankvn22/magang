<?php

// ===== View: mahasiswa/pilih_pembimbing.php =====
?>
<?= $this->extend('layouts/template_mahasiswa'); ?>
<?= $this->section('content'); ?>

<h4 class="fw-bold mb-4">Pilih Pembimbing Industri</h4>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<!-- Jika sudah ada pengajuan -->
<?php if ($pengajuan): ?>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Status Pengajuan</h5>
            <p class="mb-1"><strong>Status:</strong> <?= ucfirst($pengajuan['status']) ?></p>

            <?php if ($pengajuan['status'] == 'pending'): ?>
                <form action="<?= base_url('mahasiswa/batalkan-pengajuan/' . $pengajuan['bimbingan_industri_id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger btn-sm">Batalkan Pengajuan</button>
                </form>
<?php elseif ($pengajuan['status'] == 'disetujui'): ?>
    <div class="mt-3">
        <p class="mb-0"><strong>Nama Pembimbing:</strong> <?= $pengajuan['nama_pembimbing'] ?? '-' ?></p>
        <p class="mb-0"><strong>Perusahaan:</strong> <?= $pengajuan['perusahaan'] ?? '-' ?></p>
        <p class="mb-0"><strong>Email:</strong> <?= $pengajuan['email'] ?? '-' ?></p>
        <p class="mb-0"><strong>Telepon:</strong> <?= $pengajuan['no_telepon'] ?? '-' ?></p>
    </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Jika status bukan pending, diterima -->
<?php if (!$pengajuan || in_array($pengajuan['status'], ['ditolak', 'dibatalkan'])): ?>
<form action="<?= base_url('mahasiswa/ajukan-bimbingan') ?>" method="post" class="mb-4">
    <?= csrf_field() ?>
    
    <div class="mb-3">
        <label for="pembimbing_id" class="form-label">Pilih Pembimbing</label>
        <select name="pembimbing_id" id="pembimbing_id" class="form-select" required>
            <option value="" disabled selected>-- Pilih Pembimbing Industri --</option>
            <?php foreach ($pembimbing as $p): ?>
                <option value="<?= $p['pembimbing_id'] ?>">
                    <?= esc($p['nama']) ?> - <?= esc($p['perusahaan']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Ajukan</button>
    <a href="<?= base_url('mahasiswa/dashboard') ?>" class="btn btn-secondary">Kembali</a>
</form>
<?php endif; ?>




<?= $this->endSection(); ?>