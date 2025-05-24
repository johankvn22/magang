<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_dosen'); ?>
<?= $this->section('content'); ?>

<body>

<form method="post" action="<?= site_url('dosen/penilaian-dosen/save'); ?>" class="container py-5">
    <input type="hidden" name="bimbingan_id" value="<?= $bimbingan_id ?>">

    <h4 class="text-center mb-4 fw-bold">Form Penilaian Dosen Pembimbing</h4>

    <?php if (isset($nilaiIndustri) && $nilaiIndustri): ?>
        <div class="card mb-4 border border-primary shadow-sm">
            <div class="card-header bg-primary text-white fw-semibold">
                Nilai dari Pembimbing Industri
            </div>
            <div class="card-body">
                <p><strong>Nama Pembimbing Industri:</strong> <?= esc($nilaiIndustri['nama_pembimbing_perusahaan']) ?></p>
                <p><strong>Judul Magang:</strong> <?= esc($nilaiIndustri['judul_magang']) ?></p>

                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Komunikasi: <strong><?= $nilaiIndustri['komunikasi'] ?></strong></li>
                            <li class="list-group-item">Berpikir Kritis: <strong><?= $nilaiIndustri['berpikir_kritis'] ?></strong></li>
                            <li class="list-group-item">Kerja Tim: <strong><?= $nilaiIndustri['kerja_tim'] ?></strong></li>
                            <li class="list-group-item">Inisiatif: <strong><?= $nilaiIndustri['inisiatif'] ?></strong></li>
                            <li class="list-group-item">Literasi Digital: <strong><?= $nilaiIndustri['literasi_digital'] ?></strong></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Deskripsi Produk: <strong><?= $nilaiIndustri['deskripsi_produk'] ?></strong></li>
                            <li class="list-group-item">Spesifikasi Produk: <strong><?= $nilaiIndustri['spesifikasi_produk'] ?></strong></li>
                            <li class="list-group-item">Desain Produk: <strong><?= $nilaiIndustri['desain_produk'] ?></strong></li>
                            <li class="list-group-item">Implementasi Produk: <strong><?= $nilaiIndustri['implementasi_produk'] ?></strong></li>
                            <li class="list-group-item">Pengujian Produk: <strong><?= $nilaiIndustri['pengujian_produk'] ?></strong></li>
                        </ul>
                    </div>
                </div>

                <div class="mt-3">
                    <strong>Total Nilai Industri: </strong> <?= $nilaiIndustri['total_nilai_industri'] ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            Data penilaian dari industri belum tersedia.
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="text-center">
                <tr>
                    <th class="w-25">Kategori</th>
                    <th>Kriteria Unjuk Kerja (KUK)</th>
                    <th class="w-15">Angka Mutu</th>
                    <th class="w-10">Input Nilai</th>
                </tr>
            </thead>
            <tbody>
                <!-- Pelaporan -->
                <tr>
                    <td class="fw-semibold bg-light" rowspan="3">Pelaporan (30%)</td>
                    <td>1.1 Mahasiswa mampu menuliskan kesesuaian judul Magang dengan produk yang dihasilkan</td>
                    <td class="text-center">5 - 10</td>
                    <td><input type="number" name="nilai_1_1" min="5" max="10" class="form-control" required></td>
                </tr>
                <tr>
                    <td>1.2 Mahasiswa mampu menggunakan Tata bahasa & Tata tulis dengan baik dan benar</td>
                    <td class="text-center">5 - 10</td>
                    <td><input type="number" name="nilai_1_2" min="5" max="10" class="form-control" required></td>
                </tr>
                <tr>
                    <td>1.3 Mahasiswa mampu menyusun laporan magang sesuai dengan format & kerangka standar yang berlaku</td>
                    <td class="text-center">5 - 10</td>
                    <td><input type="number" name="nilai_1_3" min="5" max="10" class="form-control" required></td>
                </tr>

                <!-- Presentasi -->
                <tr>
                    <td class="fw-semibold bg-light" rowspan="4">Presentasi (40%)</td>
                    <td>2.1 Mahasiswa mampu menunjukkan Pengetahuan praktis sesuai dengan kegiatan magang</td>
                    <td class="text-center">5 - 10</td>
                    <td><input type="number" name="nilai_2_1" min="5" max="10" class="form-control" required></td>
                </tr>
                <tr>
                    <td>2.2 Mahasiswa mampu menjawab pertanyaan dengan tepat dan jelas</td>
                    <td class="text-center">5 - 10</td>
                    <td><input type="number" name="nilai_2_2" min="5" max="10" class="form-control" required></td>
                </tr>
                <tr>
                    <td>2.3 Mahasiswa menunjukkan Etika/sikap yang baik</td>
                    <td class="text-center">5 - 10</td>
                    <td><input type="number" name="nilai_2_3" min="5" max="10" class="form-control" required></td>
                </tr>
                <tr>
                    <td>2.4 Mahasiswa mampu menjustifikasi kesesuaian kegiatan magang dengan profil lulusan PS</td>
                    <td class="text-center">5 - 10</td>
                    <td><input type="number" name="nilai_2_4" min="5" max="10" class="form-control" required></td>
                </tr>

                <!-- Bimbingan -->
                <tr>
                    <td class="fw-semibold bg-light" rowspan="2">Bimbingan (30%)</td>
                    <td>3.1 Mahasiswa melakukan bimbingan minimal 4 kali</td>
                    <td class="text-center">5 - 10</td>
                    <td><input type="number" name="nilai_3_1" min="5" max="10" class="form-control" required></td>
                </tr>
                <tr>
                    <td>3.2 Mahasiswa mampu menunjukkan bukti kemajuan bimbingan secara berkala</td>
                    <td class="text-center">5 - 10</td>
                    <td><input type="number" name="nilai_3_2" min="5" max="10" class="form-control" required></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary px-4">Submit</button>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
<?= $this->endSection(); ?>
