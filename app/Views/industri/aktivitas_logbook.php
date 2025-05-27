<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>
<body>
    <div class="container mt-4">
        <h2>Logbook Aktivitas Industri</h2>

        <p><strong>Nama:</strong> <?= esc($mahasiswa['nama_lengkap']) ?></p>
        <p><strong>NIM:</strong> <?= esc($mahasiswa['nim']) ?></p>
        <p><strong>Program Studi:</strong> <?= esc($mahasiswa['program_studi']) ?></p>
        <p><strong>Total Logbook:</strong> <?= $totalCount ?></p>
        <p><strong>Disetujui:</strong> <?= $disetujuiCount ?></p>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (!empty($logbooks)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Catatan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logbooks as $log): ?>
                        <tr>
                            <td><?= esc($log['tanggal']) ?></td>
                            <td><?= esc($log['aktivitas']) ?></td>
                            <td>
                                <?php if ($log['status_validasi'] === 'menunggu') : ?>
                                    <form action="<?= site_url('industri/bimbingan/update-catatan/' . $log['logbook_id']) ?>" method="post">
                                        <textarea name="catatan_industri" class="form-control form-control-sm" rows="2" required><?= esc($log['catatan_industri']) ?></textarea>
                                        <button type="submit" class="btn btn-primary btn-sm mt-1">Simpan</button>
                                    </form>
                                <?php else : ?>
                                    <?= esc($log['catatan_industri']) ?: '<em>Belum ada catatan</em>' ?>
                                <?php endif; ?>
                            </td>


                            <td>
                                <?php if ($log['status_validasi'] === 'menunggu') : ?>
                                    <form action="<?= site_url('industri/bimbingan/setujui/' . $log['logbook_id']) ?>" method="post" style="display:inline;">
                                        <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                    </form>
                                    <form action="<?= site_url('industri/bimbingan/tolak/' . $log['logbook_id']) ?>" method="post" style="display:inline;">
                                        <button type="submit" class="btn btn-warning btn-sm">Tolak</button>
                                    </form>
                                <?php elseif ($log['status_validasi'] === 'disetujui') : ?>
                                    <span class="badge bg-success">Disetujui</span>
                                <?php elseif ($log['status_validasi'] === 'ditolak') : ?>
                                    <span class="badge bg-danger">Ditolak</span>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

        <?php if ($disetujuiCount >= 2 && !empty($bimbingan_id) && !$penilaian_sudah_ada): ?>
            <div class="mt-3">
                <a href="<?= site_url('industri/penilaian-industri/' . $bimbingan_id) ?>" class="btn btn-primary">
                    Beri Penilaian
                </a>
            </div>
        <?php endif; ?>

        <?php else: ?>
            <p>Belum ada data logbook.</p>
        <?php endif ?>
        
    </div>
</body>

<?= $this->endSection(); ?>
