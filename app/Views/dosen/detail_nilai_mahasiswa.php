<?php /** @var \CodeIgniter\View\View $this */ ?>
<?= $this->extend('layouts/template_dosen'); ?>
<?= $this->section('content'); ?>

<div class="container py-5">
    <h4 class="text-center mb-5 fw-bold">Detail Nilai Mahasiswa</h4>

    <!-- ✅ Nilai dari Industri -->
    <?php if (isset($nilaiIndustri) && $nilaiIndustri): ?>
        <div class="card mb-5 border border-primary shadow-sm">
            <div class="card-header bg-primary text-white fw-semibold">
                Nilai dari Pembimbing Industri
            </div>
            <div class="card-body">

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
        <div class="alert alert-warning text-center mb-5">
            Data penilaian dari industri belum tersedia.
        </div>
    <?php endif; ?>

    <!-- ✅ Nilai dari Dosen -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle shadow-sm">
            <thead class="text-center bg-light">
                <tr>
                    <th class="w-25">Kategori</th>
                    <th>Kriteria Unjuk Kerja (KUK)</th>
                    <th class="w-15">Angka Mutu</th>
                    <th class="w-10">Nilai</th>
                </tr>
            </thead>
            <tbody>
                <!-- Pelaporan 30% -->
                <tr>
                    <td class="kategori" rowspan="3">Pelaporan (30%)</td>
                    <td>1.1 Mahasiswa mampu menuliskan kesesuaian judul Magang dengan produk yang dihasilkan</td>
                    <td class="text-center">5 - 10</td>
                    <td class="text-center"><?= $penilaian['nilai_1_1'] ?></td>
                </tr>
                <tr>
                    <td>1.2 Mahasiswa mampu menggunakan Tata bahasa & Tata tulis dengan baik dan benar</td>
                    <td class="text-center">5 - 10</td>
                    <td class="text-center"><?= $penilaian['nilai_1_2'] ?></td>
                </tr>
                <tr>
                    <td>1.3 Mahasiswa mampu menyusun laporan magang sesuai dengan format & kerangka standar yang berlaku</td>
                    <td class="text-center">5 - 10</td>
                    <td class="text-center"><?= $penilaian['nilai_1_3'] ?></td>
                </tr>

                <!-- Presentasi 40% -->
                <tr>
                    <td class="kategori" rowspan="4">Presentasi (40%)</td>
                    <td>2.1 Mahasiswa mampu menunjukkan Pengetahuan praktis sesuai dengan kegiatan magang</td>
                    <td class="text-center">5 - 10</td>
                    <td class="text-center"><?= $penilaian['nilai_2_1'] ?></td>
                </tr>
                <tr>
                    <td>2.2 Mahasiswa mampu menjawab pertanyaan dengan tepat dan jelas</td>
                    <td class="text-center">5 - 10</td>
                    <td class="text-center"><?= $penilaian['nilai_2_2'] ?></td>
                </tr>
                <tr>
                    <td>2.3 Mahasiswa menunjukkan Etika/sikap yang baik</td>
                    <td class="text-center">5 - 10</td>
                    <td class="text-center"><?= $penilaian['nilai_2_3'] ?></td>
                </tr>
                <tr>
                    <td>2.4 Mahasiswa mampu menjustifikasi kesesuaian kegiatan magang dengan profil lulusan PS</td>
                    <td class="text-center">5 - 10</td>
                    <td class="text-center"><?= $penilaian['nilai_2_4'] ?></td>
                </tr>

                <!-- Bimbingan 30% -->
                <tr>
                    <td class="kategori" rowspan="2">Bimbingan (30%)</td>
                    <td>3.1 Mahasiswa melakukan bimbingan minimal 4 kali</td>
                    <td class="text-center">5 - 10</td>
                    <td class="text-center"><?= $penilaian['nilai_3_1'] ?></td>
                </tr>
                <tr>
                    <td>3.2 Mahasiswa mampu menunjukkan bukti kemajuan bimbingan secara berkala</td>
                    <td class="text-center">5 - 10</td>
                    <td class="text-center"><?= $penilaian['nilai_3_2'] ?></td>
                </tr>
            </tbody>

            <!-- Total Nilai -->
            <tfoot>
                <tr class="fw-bold text-center">
                    <td colspan="3" class="text-end">Total Nilai Dosen</td>
                    <td class="bg-success text-white"><?= $penilaian['total_nilai'] ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="<?= site_url('/dosen/penilaian-dosen/listNilai') ?>" class="btn btn-secondary px-4">Kembali</a>
    </div>
</div>

<?= $this->endSection(); ?>
