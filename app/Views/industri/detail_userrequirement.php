<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>
<body>
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h3 class="mb-0">User Requirement Mahasiswa</h3>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <p class="mb-1"><strong>Nama:</strong> <?= esc($mahasiswa['nama_lengkap']) ?></p>
                    <p class="mb-1"><strong>NIM:</strong> <?= esc($mahasiswa['nim']) ?></p>
                    <p class="mb-0"><strong>Program Studi:</strong> <?= esc($mahasiswa['program_studi']) ?></p>
                </div>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($requirements)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
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
                                                <span class="badge bg-success">Disetujui</span>
                                            <?php elseif ($req['status_validasi'] == 'ditolak'): ?>
                                                <span class="badge bg-danger">Ditolak</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <?php if ($req['status_validasi'] != 'disetujui'): ?>
                                                    <form action="<?= site_url('industri/user-requirement/setujui/' . $req['requirement_id']) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                                    </form>
                                                <?php endif; ?>

                                                <?php if ($req['status_validasi'] != 'ditolak'): ?>
                                                    <form action="<?= site_url('industri/user-requirement/tolak/' . $req['requirement_id']) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-light border">
                        Belum ada data user requirement.
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</body>
<?= $this->endSection(); ?>