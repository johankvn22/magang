<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_kps'); ?>
<?= $this->section('content'); ?>

<h3>Edit Dosen Pembimbing</h3>
<form method="post" action="<?= base_url('kps/update-pembimbing') ?>">
    <input type="hidden" name="mahasiswa_id" value="<?= $mahasiswa['mahasiswa_id'] ?>">

    <?php foreach ($listDosen as $dosen): ?>
        <label>
            <input type="checkbox" name="dosen_id[]" value="<?= $dosen['dosen_id'] ?>"
                <?= in_array($dosen['dosen_id'], $dosenTerpilih) ? 'checked' : '' ?>>
            <?= esc($dosen['nama_lengkap']) ?>
        </label><br>
    <?php endforeach; ?>

    <button type="submit">Simpan</button>
</form>


<?= $this->endSection(); ?>
