<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_kps'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid px-2">

  <!-- Header & Search -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success mb-0">📋 Daftar Review Kinerja Mahasiswa</h2>

    <form method="get" action="<?= site_url('kps/review-kinerja') ?>" class="row mb-3">
      <div class="col-md-8">
        <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" class="form-control" placeholder="Cari Nama Mahasiswa/Perusahaan...">
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-success">Cari</button>
      </div>
    </form>

    <form method="get" action="<?= site_url('kps/review-kinerja') ?>" class="row mb-3 g-2">
      <div class="col-md-12">
        <select name="perPage" class="form-select" onchange="this.form.submit()">
          <?php foreach ([5, 10, 25, 50, 100] as $option): ?>
            <option value="<?= $option ?>" <?= ($perPage ?? 10) == $option ? 'selected' : '' ?>>
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
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4">
          <?= session()->getFlashdata('error') ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th class="text-center" width="5%">No</th>
              <th width="25%">Nama Mahasiswa</th>
              <th width="25%">Nama Perusahaan</th>
              <th width="25%">Pembimbing Industri</th>
              <th class="text-center" width="20%">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($reviews)): ?>
              <?php foreach ($reviews as $index => $review): ?>
                <tr>
                  <td class="text-center"><?= ($offset ?? 0) + $index + 1 ?></td>
                  <td>
                    <div class="fw-semibold"><?= esc($review['nama_mahasiswa']) ?></div>
                  </td>
                  <td><?= esc($review['nama_perusahaan']) ?></td>
                  <td><?= esc($review['nama_pembimbing_perusahaan'] ?? '-') ?></td>
                  <td class="text-center">
                    <a href="<?= base_url('kps/review-kinerja/detail/' . $review['review_id']) ?>" 
                       class="btn btn-sm btn-outline-primary rounded-pill px-3">
                      <i class="fas fa-eye me-1"></i> Detail
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center py-4">
                  <div class="text-muted">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <p class="h5">Belum ada data review</p>
                  </div>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <?php if (isset($pager) && !empty($reviews)): ?>
      <div class="d-flex justify-content-center mt-3">
        <?= $pager->links('default', 'custom_pagination') ?>
      </div>
      <?php endif; ?>
    </div>
  </div>

</div>

<?= $this->endSection(); ?>