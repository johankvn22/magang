<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_mahasiswa'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <h2 class="mb-3">Logbook Bimbingan</h2>

      <?php if (session()->get('logged_in')): ?>
        <div class="mb-3">
          <h5 class="text-success">Selamat datang, <?= esc(session()->get('nama')) ?>
          Jangan lupa mengisi Logbook Bimbingan!</h5>
        </div>
      <?php endif; ?>

          <div class="container mt-5">
        <h2>Logbook Bimbingan</h2>
        <?php if (session()->get('logged_in')): ?>
            <h5>Selamat datang, <?= esc(session()->get('nama')) ?>!</h5>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= site_url('mahasiswa/logbook/create'); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="aktivitas">Bimbingan:</label>
                <textarea name="aktivitas" id="aktivitas" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="file_dokumen">Upload Dokumen (PDF):</label>
                <small class="form-text text-muted">Maksimal ukuran file: 5MB.</small>

                <input type="file" name="file_dokumen" id="file_dokumen" class="form-control-file" accept=".pdf">
            </div>
            <div class="form-group">
                <label for="link_drive">Link Google Drive (opsional):</label>
                <input type="url" name="link_drive" id="link_drive" class="form-control" placeholder="https://drive.google.com/...">
            </div>
            <button type="submit" class="btn btn-primary">Tambah Logbook</button>
        </form>

        <h3 class="mt-4">Daftar Logbook</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Aktivitas</th>
                    <th>Catatan Dosen</th>
                    <th>Dokumen</th>
                    <th>Link Drive</th>
                    <th>Status Validasi</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($logbook as $entry): ?>
                    <tr>
                        <td><?= esc($entry['tanggal']) ?></td>
                        <td><?= esc($entry['aktivitas']) ?></td>
                        <td><?= esc($entry['catatan_dosen']) ?? 'Belum ada catatan' ?></td>
                        <td>
                            <?php if (!empty($entry['file_dokumen'])): ?>
                                <a href="<?= site_url('mahasiswa/logbook/download/' . $entry['file_dokumen']) ?>" target="_blank">Download</a>
                            <?php else: ?>
                                Tidak ada file
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($entry['link_drive'])): ?>
                                <a href="<?= esc($entry['link_drive']) ?>" target="_blank">Drive</a>
                            <?php else: ?>
                                Tidak ada link
                            <?php endif; ?>
                        </td>
                        <td><?= esc($entry['status_validasi']) ?></td>
                        <td>
                            <?php if ($entry['status_validasi'] == 'menunggu'): ?>
                                <a href="<?= site_url('mahasiswa/logbook/edit/' . $entry['logbook_id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?= site_url('mahasiswa/logbook/delete/' . $entry['logbook_id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Delete</a>
                            <?php else: ?>
                                <span class="text-muted">Terkunci</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>
