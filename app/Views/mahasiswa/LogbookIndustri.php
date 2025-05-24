<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_mahasiswa'); ?>
<?= $this->section('content'); ?>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        <h2 class="mb-3">Logbook Bimbingan Industri</h2>

        <?php if (session()->get('logged_in')): ?>
          <div class="mb-3">
            <h5 class="text-success">Selamat datang, <?= esc(session()->get('nama')) ?>!</h5>
          </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
          </div>
        <?php endif; ?>

        <div class="card mb-4">
          <div class="card-body">
            <h5 class="card-title">Isi Logbook</h5>
            <form method="POST" action="<?= site_url('mahasiswa/logbook_industri/create'); ?>">
              <div class="form-group mb-3">
                <label for="tanggal">Tanggal:</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
              </div>

              <div class="form-group mb-3">
                <label for="aktivitas">Aktivitas:</label>
                <textarea name="aktivitas" id="aktivitas" rows="3" class="form-control" required></textarea>
              </div>

              <button type="submit" class="btn btn-primary">Tambah Logbook</button>
            </form>
          </div>
        </div>

        <h3 class="mb-3">Daftar Logbook</h3>

        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead class="table-success">
              <tr>
                <th>Tanggal</th>
                <th>Aktivitas</th>
                <th>Catatan Industri</th>
                <th>Status Validasi</th>
              </tr>
            </thead>
            <tbody>
            <?php if (!empty($logbook)) : ?>
              <?php foreach ($logbook as $entry): ?>
                <tr>
                  <td><?= esc($entry['tanggal']) ?></td>
                  <td><?= esc($entry['aktivitas']) ?></td>
                  <td><?= esc($entry['catatan_industri']) ?? 'Belum ada catatan' ?></td>
                  <td><?= esc($entry['status_validasi']) ?></td>
                </tr>
                <tr>
                  <td colspan="4">
                    <?php if ($entry['status_validasi'] !== 'disetujui') : ?>
                      <a href="<?= site_url('mahasiswa/logbook_industri/edit/' . $entry['logbook_id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                      <form action="<?= site_url('mahasiswa/logbook_industri/delete/' . $entry['logbook_id']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus logbook ini?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                      </form>
                    <?php else : ?>
                      <span class="text-muted">Tidak dapat diedit/hapus</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="text-center">Belum ada entri logbook.</td>
              </tr>
            <?php endif; ?>
          </tbody>

          </table>
        </div>

      </div>
    </div>
  </div>
</body>

<?= $this->endSection(); ?>
