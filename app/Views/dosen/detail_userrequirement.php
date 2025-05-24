<?php
/** @var \CodeIgniter\View\View $this */
?>

<?= $this->extend('layouts/template_dosen'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
    <h4>Data User Requirement Mahasiswa</h4>
    <p><strong>Nama:</strong> <?= esc($mahasiswa['nama_lengkap']) ?></p>
    <p><strong>NIM:</strong> <?= esc($mahasiswa['nim']) ?></p>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Dikerjakan</th>
                <th>User Requirement</th>
                <th>Status Verifikasi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requirements as $req): ?>
                <tr>
                    <td><?= esc($req['tanggal']) ?></td>
                    <td><?= esc($req['dikerjakan']) ?></td>
                    <td><?= esc($req['user_requirement']) ?></td>
                    <td>
                        <?php if ($req['status_validasi'] == 'disetujui'): ?>
                            <span class="badge badge-success">Disetujui</span>
                        <?php elseif ($req['status_validasi'] == 'ditolak'): ?>
                            <span class="badge badge-danger">Ditolak</span>
                        <?php else: ?>
                            <span class="badge badge-warning">Menunggu</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?= $this->endSection(); ?>
