<?php
/** @var \CodeIgniter\View\View $this */
?>

<?= $this->extend('layouts/template_panitia'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h2>Daftar Review Kinerja Mahasiswa</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>Nama Perusahaan</th>
                <th>Pembimbing Industri</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($reviews as $review): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($review['nama_mahasiswa']) ?></td>
                    <td><?= esc($review['nama_perusahaan']) ?></td>
                    <td><?= esc($review['nama_pembimbing_perusahaan'] ?? '-') ?></td>
                    <td>
                        <a href="<?= base_url('panitia/review-kinerja/detail/' . $review['review_id']) ?>" class="btn btn-sm btn-info">Lihat Detail</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($reviews)): ?>
                <tr><td colspan="6" class="text-center">Belum ada data review.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<?= $this->endSection(); ?>
