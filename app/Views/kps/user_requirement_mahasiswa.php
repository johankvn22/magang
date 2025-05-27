<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_kps'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid px-2">

  <!-- Header & Search -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success mb-0">📝 Daftar Mahasiswa Pengisi User Requirement</h2>

    <form method="get" action="<?= site_url('kps/user-requirement') ?>" class="row mb-3">
      <div class="col-md-9">
        <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" class="form-control" placeholder="Cari Nama / NIM / Prodi...">
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-success">Cari</button>
      </div>
    </form>

    <form method="get" action="<?= site_url('kps/user-requirement') ?>" class="row mb-3 g-2">
      <div class="col-md-12">
        <select name="perPage" class="form-select" onchange="this.form.submit()">
          <?php foreach ([5, 10, 25, 50, 100] as $option): ?>
            <option value="<?= $option ?>" <?= $perPage == $option ? 'selected' : '' ?>>
              Tampilkan <?= $option ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </form>
  </div>

  <!-- Table -->
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover table-bordered text-nowrap align-middle small">
          <thead class="table-light text-center">
            <tr>
              <th>No</th>
              <th>Nama & NIM</th>
              <th>Program Studi & Kelas</th>
              <th>Terakhir Diisi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($mahasiswaList as $index => $mhs): ?>
              <tr>
                <td class="text-center"><?= $offset + $index + 1 ?></td>
                <td>
                  <div class="fw-semibold"><?= esc($mhs['nama_lengkap']) ?></div>
                  <div class="text-muted small"><?= esc($mhs['nim']) ?></div>
                </td>
                <td>
                  <div class="fw-semibold"><?= esc($mhs['program_studi']) ?></div>
                    <div class="text-muted small"><?= esc($mhs['kelas']) ?></div>
                </td>

                <td class="text-center"><?= esc($mhs['terakhir_diisi']) ?></td>
                <td class="text-center">
                  <a href="<?= site_url('kps/user-requirement/detail/' . $mhs['mahasiswa_id']) ?>" class="btn btn-sm btn-outline-info rounded-pill px-3">
                    Detail
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
            <?php if (empty($mahasiswaList)): ?>
              <tr>
                <td colspan="5" class="text-center text-muted">Tidak ada data ditemukan.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-center mt-3">
        <?= $pager->links('default', 'custom_pagination') ?>
      </div>
    </div>
  </div>

</div>

<?= $this->endSection(); ?>
