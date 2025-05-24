<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_panitia'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h2>Detail User Requirement Mahasiswa</h2>

    <p><strong>Nama:</strong> <?= esc($mahasiswa['nama_lengkap']) ?></p>
    <p><strong>NIM:</strong> <?= esc($mahasiswa['nim']) ?></p>
    <p><strong>Program Studi:</strong> <?= esc($mahasiswa['program_studi']) ?></p>

    <hr>

    <?php if (!empty($user_requirements)) : ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>User Requirement</th>
                    <th>Status Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user_requirements as $req) : ?>
                    <tr>
                        <td><?= esc($req['tanggal']) ?></td>
                        <td><?= esc($req['user_requirement']) ?></td>
                        <td>
                            <?php
                                $status = $req['status_validasi'];
                                if ($status == 'disetujui') {
                                    echo '<span class="badge bg-success">Disetujui</span>';
                                } elseif ($status == 'ditolak') {
                                    echo '<span class="badge bg-danger">Ditolak</span>';
                                } else {
                                    echo '<span class="badge bg-warning text-dark">Menunggu</span>';
                                }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="alert alert-info">Belum ada data user requirement yang diisi oleh mahasiswa ini.</div>
    <?php endif; ?>
</div>


<?= $this->endSection(); ?>
