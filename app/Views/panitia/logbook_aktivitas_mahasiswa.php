<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_panitia'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid px-2">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success mb-0">🏭 Monitoring Aktivitas Mahasiswa di Industri</h2>

    <form method="get" action="<?= site_url('panitia/logbook-aktivitas') ?>" class="row mb-3">
      <div class="col-md-8">
        <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" class="form-control" placeholder="Cari Nama / NIM / Prodi...">
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-success">Cari</button>
      </div>
    </form>

    <form method="get" action="<?= site_url('panitia/logbook-aktivitas') ?>" class="row mb-3 g-2">
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
        <table class="table table-hover text-nowrap align-middle small" id="aktivitasTable">
          <thead class="table-light align-middle">
            <tr>
              <th class="text-center">No</th>
              <th>Nama & NIM</th>
              <th>Prodi & Kelas</th>
              <th class="text-center">Status Aktivitas</th>
              <th class="text-center">Detail</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($mahasiswa as $index => $mhs): ?>
              <tr>
                <td class="text-center"><?= $index + 1 ?></td>
                <td>
                  <div class="fw-semibold"><?= esc($mhs['nama_lengkap']) ?></div>
                  <div class="text-muted small"><?= esc($mhs['nim']) ?></div>
                </td>
                <td>
                  <span class="badge bg-primary-subtle text-primary"><?= esc($mhs['program_studi']) ?></span><br>
                  <span class="badge bg-secondary-subtle text-secondary"><?= esc($mhs['kelas']) ?></span>
                </td>
                <td class="text-center">
                  <?php if ($mhs['status'] === 'Sudah Verifikasi'): ?>
                    <span class="badge bg-success rounded-pill">Terverifikasi</span>
                  <?php else: ?>
                    <span class="badge bg-secondary-subtle text-secondary">Belum Verifikasi</span>
                  <?php endif; ?>
                </td>               
                <td class="text-center">
                  <a href="<?= base_url('panitia/detail-aktivitas/' . $mhs['mahasiswa_id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    Detail Aktivitas
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
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