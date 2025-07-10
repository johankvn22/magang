<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>

<form action="<?= base_url('/industri/update-profil') ?>" method="post" class="container mt-4">
    <h4>Edit Profil</h4>

    <!-- ✅ Tampilkan error validasi jika ada -->
    <?php if (!empty(session()->getFlashdata('errors'))): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" value="<?= esc($profil['nama']) ?>" required>
    </div>
    <div class="mb-3">
        <label>No Telepon</label>
        <input 
            type="text" 
            name="no_telepon" 
            class="form-control" 
            value="<?= esc($profil['no_telepon']) ?>" 
            pattern="\d+" 
            title="Hanya boleh angka" 
            required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= esc($profil['email']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Perusahaan</label>
        <input type="text" name="perusahaan" class="form-control" value="<?= esc($profil['perusahaan']) ?>" required>
    </div>
    <div class="mb-3">
        <label>NIP</label>
        <input type="text" name="nip" class="form-control" value="<?= esc($profil['nip']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<?= $this->endSection(); ?>
