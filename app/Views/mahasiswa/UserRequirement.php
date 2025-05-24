<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_mahasiswa'); ?>
<?= $this->section('content'); ?>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        <h2 class="mb-3">User Requirement / Spesifikasi</h2>

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
            <h5 class="card-title">Form User Requirement</h5>
            <form method="POST" action="<?= site_url('mahasiswa/user-requirement/create'); ?>">
              <div class="form-group mb-3">
                <label for="tanggal">Tanggal:</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
              </div>

              <div class="form-group mb-3">
                <label for="dikerjakan">Modul/Unit yang Dikerjakan:</label>
                <textarea name="dikerjakan" id="dikerjakan" rows="3" class="form-control" required></textarea>
              </div>

              <div class="form-group mb-3">
                <label for="user_requirement">User Requirement / Spesifikasi:</label>
                <textarea name="user_requirement" id="user_requirement" rows="2" class="form-control"></textarea>
              </div>

              <button type="submit" class="btn btn-primary">Tambah User Requirement</button>
            </form>
          </div>
        </div>

        <h3 class="mb-3">Daftar User Requirement</h3>

        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead class="table-primary">
              <tr>
                <th>Tanggal</th>
                <th>Pekerjaan yang Dikerjakan</th>
                <th>User Requirement / Spesifikasi</th>
                <th>Status Validasi</th>
                <th>Aksi</th>

              </tr>
            </thead>
            <tbody>
              <?php if (!empty($requirements)) : ?>
                <?php foreach ($requirements as $entry): ?>
                  <tr>
                    <td><?= esc($entry['tanggal']) ?></td>
                    <td><?= esc($entry['dikerjakan']) ?></td>
                    <td><?= esc($entry['user_requirement']) ?? 'Belum ada spesifikasi' ?></td>
                    <td><?= esc($entry['status_validasi']) ?></td>
                    <td>
                    <?php if ($entry['status_validasi'] !== 'disetujui'): ?>
                      <a href="<?= site_url('mahasiswa/user-requirement/edit/' . $entry['requirement_id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                      <form action="<?= site_url('mahasiswa/user-requirement/delete/' . $entry['requirement_id']) ?>" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                      </form>
                    <?php else: ?>
                      <span class="text-muted">Terkunci</span>
                    <?php endif; ?>
                  </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="text-center">Belum ada entri user requirement.</td>
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
