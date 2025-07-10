<?= $this->extend('layouts/template_admin'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h4>Kirim Pesan Broadcast</h4>
    <form method="post" action="<?= base_url('/admin/broadcast/simpan') ?>">
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="isi" class="form-label">Isi Pesan</label>
            <textarea name="isi" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="untuk" class="form-label">Dikirim Untuk</label>
            <select name="untuk" class="form-select" required>
                <option value="mahasiswa">Mahasiswa</option>
                <option value="dosen">Dosen</option>
                <option value="industri">Pembimbing Industri</option>
                <option value="panitia">Panitia</option>
                <option value="kps">KPS</option>
                <option value="semua">Semua</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Kirim</button>
    </form>
</div>

<?= $this->endSection(); ?>