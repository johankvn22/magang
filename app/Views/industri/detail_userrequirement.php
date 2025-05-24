<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>
<body>
    <div class="container mt-4">
        <h2>User Requirement Mahasiswa</h2>

        <p><strong>Nama:</strong> <?= esc($mahasiswa['nama_lengkap']) ?></p>
        <p><strong>NIM:</strong> <?= esc($mahasiswa['nim']) ?></p>
        <p><strong>Program Studi:</strong> <?= esc($mahasiswa['program_studi']) ?></p>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (!empty($requirements)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Yang Dikerjakan</th>
                        <th>User Requirement</th>
                        <th>Status</th>
                        <th>Aksi</th>
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
                            <td>
                                <?php if ($req['status_validasi'] != 'disetujui'): ?>
                                    <form action="<?= site_url('industri/user-requirement/setujui/' . $req['requirement_id']) ?>" method="post" style="display:inline;">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                    </form>
                                <?php endif; ?>

                                <?php if ($req['status_validasi'] != 'ditolak'): ?>
                                    <form action="<?= site_url('industri/user-requirement/tolak/' . $req['requirement_id']) ?>" method="post" style="display:inline;">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Belum ada data user requirement.</p>
        <?php endif ?>
        
    </div>
</body>

<?= $this->endSection(); ?>
