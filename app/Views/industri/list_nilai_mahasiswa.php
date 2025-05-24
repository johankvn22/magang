<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>

<body>
    <div class="container mt-5">
        <h3 class="mb-4">Daftar Mahasiswa Bimbingan Industri</h3>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Program Studi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($mahasiswaList)) : ?>
                    <?php foreach ($mahasiswaList as $mhs) : ?>
                        <tr>
                            <td><?= esc($mhs['nama_lengkap']) ?></td>
                            <td><?= esc($mhs['nim']) ?></td>
                            <td><?= esc($mhs['program_studi']) ?></td>
                            <td>
                                <a href="<?= base_url('industri/penilaian-industri/detail/' . $mhs['mahasiswa_id']) ?>" class="btn btn-info btn-sm">Detail Nilai</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="text-center">Belum ada mahasiswa bimbingan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

<?= $this->endSection(); ?>
