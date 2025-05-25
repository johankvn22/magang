<h2>Detail Nilai Mahasiswa</h2>

<!-- Biodata -->
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title"><?= $mahasiswa['nama_lengkap'] ?> (<?= $mahasiswa['nim'] ?>)</h5>
        <p><strong>Program Studi:</strong> <?= $mahasiswa['program_studi'] ?></p>
        <p><strong>Perusahaan:</strong> <?= $mahasiswa['perusahaan'] ?></p>
        <p><strong>Pembimbing Industri:</strong> <?= $mahasiswa['pembimbing_industri'] ?></p>
        <p><strong>Pembimbing Dosen:</strong> <?= $mahasiswa['pembimbing_dosen'] ?></p>
    </div>
</div>

<!-- Nilai dari Pembimbing Industri (Versi lengkap seperti gambar) -->
<div class="card mb-4 border-primary">
    <div class="card-header bg-primary text-white">
        Nilai dari Pembimbing Industri
    </div>
    <div class="card-body row">
        <div class="col-md-6">
            <p>Komunikasi: <strong><?= $nilai_industri['komunikasi'] ?></strong></p>
            <p>Berpikir Kritis: <strong><?= $nilai_industri['berpikir_kritis'] ?></strong></p>
            <p>Kerja Tim: <strong><?= $nilai_industri['kerja_tim'] ?></strong></p>
            <p>Inisiatif: <strong><?= $nilai_industri['inisiatif'] ?></strong></p>
            <p>Literasi Digital: <strong><?= $nilai_industri['literasi_digital'] ?></strong></p>
        </div>
        <div class="col-md-6">
            <p>Deskripsi Produk: <strong><?= $nilai_industri['deskripsi_produk'] ?></strong></p>
            <p>Spesifikasi Produk: <strong><?= $nilai_industri['spesifikasi_produk'] ?></strong></p>
            <p>Desain Produk: <strong><?= $nilai_industri['desain_produk'] ?></strong></p>
            <p>Implementasi Produk: <strong><?= $nilai_industri['implementasi_produk'] ?></strong></p>
            <p>Pengujian Produk: <strong><?= $nilai_industri['pengujian_produk'] ?></strong></p>
        </div>
        <div class="col-12 mt-3">
            <strong>Total Nilai Industri: <?= number_format($nilai_industri['total_nilai_industri'], 2) ?></strong>
        </div>
    </div>
</div>

<!-- Nilai Dosen -->
<div class="card mb-4 border-success">
    <div class="card-header bg-success text-white">
        Nilai dari Dosen Pembimbing
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Pelaporan</th>
                <th>Presentasi</th>
                <th>Bimbingan</th>
                <th>Total</th>
            </tr>
            <tr>
                <td><?= $nilai_dosen['pelaporan'] ?></td>
                <td><?= $nilai_dosen['presentasi'] ?></td>
                <td><?= $nilai_dosen['bimbingan'] ?></td>
                <td><strong><?= $nilai_dosen['total'] ?></strong></td>
            </tr>
        </table>
    </div>
</div>

<a href="<?= base_url('admin/nilai') ?>" class="btn btn-secondary">Kembali</a>