<?php
// ===== View: industri/permintaan_bimbingan.php =====
?>
<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>

<h4 class="fw-bold">Permintaan Bimbingan</h4>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (empty($pengajuan)): ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> Belum ada pengajuan dari mahasiswa.
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Email</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($pengajuan as $p): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <?php
                                $foto = $p['foto'] ?? null;
                                $fotoPath = $foto && file_exists(FCPATH . 'uploads/foto_mahasiswa/' . $foto)
                                    ? base_url('uploads/foto_mahasiswa/' . $foto)
                                    : base_url('uploads/foto_mahasiswa/default.png');
                            ?>
                            <img src="<?= $fotoPath ?>" alt="Foto Mahasiswa" width="50" height="50" class="rounded-circle object-fit-cover">
                        </td>

                        <td><?= esc($p['nama_mahasiswa']) ?></td>
                        <td><?= esc($p['nim'] ?? '-') ?></td>
                        <td><?= esc($p['email']) ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($p['created_at'])) ?></td>
                        <td>
                            <a href="<?= base_url('industri/setujui/' . $p['bimbingan_industri_id']) ?>" 
                               class="btn btn-success btn-sm"
                               onclick="return confirm('Yakin ingin menyetujui pengajuan ini?')">
                                <i class="fas fa-check"></i> Setujui
                            </a>
                            <a href="<?= base_url('industri/tolak/' . $p['bimbingan_industri_id']) ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin ingin menolak dan menghapus pengajuan ini?')">
                                <i class="fas fa-times"></i> Tolak
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?= $this->endSection(); ?>