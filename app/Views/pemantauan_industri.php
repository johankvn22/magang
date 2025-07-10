<!-- pemantauan_industri.php -->
<?= $this->extend('layouts/template_admin'); ?>
<?= $this->section('content'); ?>

<h2>Pemantauan Industri</h2>

<?php if (empty($data)): ?>
    <p>Tidak ada data pembimbing industri.</p>
<?php else: ?>
    <?php foreach ($data as $pembimbing): ?>
        <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
            <h3><?= esc($pembimbing['nama_pembimbing']) ?> - <?= esc($pembimbing['perusahaan']) ?></h3>
            <?php if (!empty($pembimbing['mahasiswa'])): ?>
                <ul>
                    <?php foreach ($pembimbing['mahasiswa'] as $mhs): ?>
                        <li><?= esc($mhs['nama']) ?> (<?= esc($mhs['nim']) ?>)</li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p><i>Tidak ada mahasiswa bimbingan.</i></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection(); ?>
