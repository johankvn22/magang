<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_dosen'); ?>
<?= $this->section('content'); ?>

<body>
    <div class="container mt-4">
        <h2>Daftar Nilai Mahasiswa</h2>

        <?php if (!empty($mahasiswaList)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Program Studi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mahasiswaList as $mhs): ?>
                        <tr>
                            <td><?= esc($mhs['nama_lengkap']) ?></td>
                            <td><?= esc($mhs['nim']) ?></td>
                            <td><?= esc($mhs['program_studi']) ?></td>
                            <td>
                                <?php if ($mhs['sudah_dinilai']): ?>
                                    <a href="<?= site_url('dosen/penilaian-dosen/detail/' . $mhs['bimbingan_id']) ?>" class="btn btn-info btn-sm">Detail</a>
                                <?php else: ?>
                                    <span class="text-muted">Mahasiswa Belum Melengkapi Logbook Bimbingan</span>
                                <?php endif; ?>                            
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Tidak ada mahasiswa bimbingan.</p>
        <?php endif ?>
    </div>
</body>

<?= $this->endSection(); ?>