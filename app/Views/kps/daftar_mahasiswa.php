 <?php
  /** @var \CodeIgniter\View\View $this */
  ?>
<?= $this->extend('layouts/template_kps'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid px-2">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success mb-0">📋 Daftar Mahasiswa Magang</h2>
    
    <form method="get" action="<?= site_url('kps/daftar_mahasiswa') ?>" class="row mb-3">
      <div class="col-md-9">
        <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" class="form-control" placeholder="Cari Nama / NIM / Prodi...">
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-success">Cari</button>
      </div>
    </form>

    <form method="get" action="<?= site_url('kps/daftar_mahasiswa') ?>" class="row mb-3 g-2">
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

  <!-- Flash Success -->
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
      <?= session()->getFlashdata('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <!-- Table -->
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover  text-nowrap align-middle small" id="mahasiswaTable">
          <thead class="table-light text-center align-middle">
            <tr>
              <th>No</th>
              <th>Nama & NIM</th>
              <th>Prodi & Kelas</th>
              <th>Kontak Mahasiswa</th>
              <th>Perusahaan</th>
              <th>Durasi</th>
              <th>Pembimbing</th>
              <th>Judul Magang</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($mahasiswa as $index => $mhs): ?>
              <tr>
                <td class="text-center"><?= $offset + $index + 1 ?></td>
                <td>
                  <div class="fw-semibold"><?= esc($mhs['nama_lengkap']) ?></div>
                  <div class="text-muted small"><?= esc($mhs['nim']) ?></div>
                </td>
                <td>
                  <span class="badge bg-primary-subtle text-primary"><?= esc($mhs['program_studi']) ?></span><br>
                  <span class="badge bg-secondary-subtle text-secondary"><?= esc($mhs['kelas']) ?></span>
                </td>
                <td>
                  <div><?= esc($mhs['no_hp']) ?></div>
                  <div class="text-muted small"><?= esc($mhs['email']) ?></div>
                </td>
                <td>
                  <div class="fw-semibold text-wrap text-break" style="maxmax-width: 200px"><?= esc($mhs['nama_perusahaan']) ?></div>
                  <div class="text-muted small text-wrap text-break" style="max-width: 200px;"><?= esc($mhs['divisi']) ?></div>
                </td>
                <td class="text-center">
                  <span class="badge bg-success-subtle text-success"><?= esc($mhs['durasi_magang']) ?> bln</span><br>
                  <small class="text-muted small text-wrap text-break" style="max-width: 200px;"><?= date('d M Y', strtotime($mhs['tanggal_mulai'])) ?> - <?= date('d M Y', strtotime($mhs['tanggal_selesai'])) ?></small>
                </td>
                <td>
                  <div class="fw-semibold text-wrap text-break" style="max-width: 200px;"><?= esc($mhs['nama_pembimbing_perusahaan']) ?></div>
                  <div class="text-muted small text-wrap text-break" style="max-width: 200px;"><?= esc($mhs['email_pembimbing_perusahaan']) ?></div>
                </td>

                <td class="text-wrap text-break" style="max-width: 220px;">
                  <?= esc($mhs['judul_magang']) ?>
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
