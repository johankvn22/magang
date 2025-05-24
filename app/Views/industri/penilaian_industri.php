<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>

<body>
    <div class="container mt-4">
        <h2>Form Penilaian Mahasiswa</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif ?>

        <form action="<?= site_url('industri/penilaianindustri/store') ?>" method="post">

            <?= csrf_field() ?>

            <div class="form-group">
                <label for="mahasiswa_id">Nama Mahasiswa</label>
                <input type="hidden" name="mahasiswa_id" value="<?= $mahasiswa[0]['mahasiswa_id'] ?>">

                <div class="form-group">
                    <label>Nama Mahasiswa</label>
                    <input type="text" class="form-control" value="<?= $mahasiswa[0]['nama_lengkap'] ?> - <?= $mahasiswa[0]['nim'] ?>" readonly>
                </div>

            </div>

            <h5 class="mt-4">Aspek Soft Skill 50%</h5>
            <?php
            $softSkills = [
                'komunikasi' => '1.1 Mahasiswa memiliki Kemampuan berkomunikasi yang baik',
                'berpikir_kritis' => '1.2 Mahasiswa mampu Berpikir Kritis',
                'kerja_tim' => '1.3 Mahasiswa mampu bekerja individu maupun Tim',
                'inisiatif' => '1.4 Mahasiswa memiliki daya Inisiatif, Kreatif, Inovatif dan Adaptif yang tinggi',
                'literasi_digital' => '1.5 Mahasiswa memiliki kemampuan Literasi, informasi, media dan teknologi'
            ];
            foreach ($softSkills as $name => $label): ?>
                <div class="form-group">
                    <label for="<?= $name ?>"><?= $label ?></label>
                    <input type="number" class="form-control" name="<?= $name ?>" min="5" max="10" required>
                </div>
            <?php endforeach; ?>

            <h5 class="mt-4">Aspek Hard Skill 50%</h5>
            <?php
            $produkSkills = [
                'deskripsi_produk' => '2.1 Mahasiswa mampu membuat deskripsi produk',
                'spesifikasi_produk' => '2.2 Mahasiswa mampu menentukan requirement/Spesifikasi Produk',
                'desain_produk' => '2.3 Mahasiswa mampu membuat desain produk',
                'implementasi_produk' => '2.4 Mahasiswa mampu mengimplementasikan produk',
                'pengujian_produk' => '2.5 Mahasiswa mampu melakukan pengujian produk'
            ];
            foreach ($produkSkills as $name => $label): ?>
                <div class="form-group">
                    <label for="<?= $name ?>"><?= $label ?></label>
                    <input type="number" class="form-control" name="<?= $name ?>" min="5" max="10" required>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="btn btn-primary mt-3">Simpan Review</button>
        </form>
    </div>
</body>


<?= $this->endSection(); ?>
