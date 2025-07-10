<?= $this->extend('layouts/template_admin'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h4>Daftar Pesan Broadcast</h4>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <a href="<?= base_url('admin/broadcast/kirim') ?>" class="btn btn-primary mb-3">+ Kirim Pesan</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Isi</th>
                <th>Untuk</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pesan as $p): ?>
                <tr>
                    <td><?= esc($p['judul']) ?></td>
                    <td><?= esc($p['isi']) ?></td>
                    <td><?= esc($p['untuk']) ?></td>
                    <td><?= date('d M Y, H:i', strtotime($p['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>
