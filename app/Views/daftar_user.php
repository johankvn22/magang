<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_admin'); ?>
<?= $this->section('content'); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Daftar User</h2>
        <div>
            <a href="<?= base_url('/upload-user-excel') ?>" class="btn btn-outline-success btn-sm me-2">
                <i class="bi bi-upload"></i> Upload dari Excel
            </a>
            <a href="<?= base_url('/register') ?>" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-person-plus"></i> Tambah Manual
            </a>
        </div>
    </div>

    <!-- Search Input -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari user...">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle" id="userTable">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nomor Induk</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)) : ?>
                    <?php $no = 1; foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($user['nama']) ?></td>
                            <td><?= esc($user['nomor_induk']) ?></td>
                            <td><?= esc($user['email']) ?></td>
                            <td><?= esc($user['role']) ?></td>
                            <td>
                                <form action="<?= base_url('/admin/deleteUser/' . $user['user_id']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada data user</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('userTable').getElementsByTagName('tbody')[0];

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
