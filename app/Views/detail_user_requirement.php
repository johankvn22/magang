<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_admin'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
    <h3>User Requirement Mahasiswa</h3>
    <p><strong>Nama:</strong> <?= esc($mahasiswa['nama_lengkap']) ?></p>
    <p><strong>NIM:</strong> <?= esc($mahasiswa['nim']) ?></p>
    <p><strong>Program Studi:</strong> <?= esc($mahasiswa['program_studi']) ?></p>

    <?php if (!empty($user_requirements)): ?>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Dikerjakan</th>
                    <th>User Requirement</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user_requirements as $req): ?>
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
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-muted">Belum ada user requirement.</p>
    <?php endif ?>
</div>

<?= $this->endSection(); ?>
