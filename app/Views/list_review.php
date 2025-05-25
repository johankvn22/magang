<?php
/** @var \CodeIgniter\View\View $this */
?>

<?= $this->extend('layouts/template_admin'); ?>
<?= $this->section('content'); ?>

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <h2 class="mb-4 text-left">Daftar Review Kinerja Mahasiswa</h2>

            <div class="row mb-3">
                <div class="col-md-3 mx-0">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari Review...">
                </div>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="reviewTable">
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
                        <?php if (!empty($reviews)): ?>
                            <?php $no = 1; foreach ($reviews as $review): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($review['nama_mahasiswa']) ?></td>
                                    <td><?= esc($review['nama_perusahaan']) ?></td>
                                    <td><?= esc($review['nama_pembimbing_perusahaan'] ?? '-') ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('admin/review-kinerja/detail/' . $review['review_id']) ?>" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center">Belum ada data review.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('reviewTable').getElementsByTagName('tbody')[0];

    searchInput.addEventListener('keyup', function () {
        const filter = searchInput.value.toLowerCase();
        for (let row of tableBody.rows) {
            row.style.display = [...row.cells].some(cell =>
                cell.textContent.toLowerCase().includes(filter)
            ) ? '' : 'none';
        }
    });
</script>

<?= $this->endSection(); ?>
