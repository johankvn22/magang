<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_admin'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid py-0 px-0">

  <!-- Heading -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success">Daftar Mahasiswa</h2>
  </div>

  <!-- Input Search -->
  <div class="row mb-3">
    <div class="col-md-3 mx-0">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari Mahasiswa...">
    </div>
  </div>

  <!-- Flash Success -->
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <!-- Table -->
  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle text-nowrap small" id="mahasiswaTable">
          <thead class="table-light text-center">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>NIM</th>
              <th>Prodi</th>
              <th>Kelas</th>
              <th>No HP</th>
              <th>Email</th>
              <th>Perusahaan</th>
              <th>Divisi</th>
              <th>Durasi</th>
              <th>Mulai</th>
              <th>Selesai</th>
              <th>Pembimbing</th>
              <th>No HP</th>
              <th>Email Pembimbing</th>
              <th>Judul Magang</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($mahasiswa as $index => $mhs): ?>
              <tr>
                <td class="text-center"><?= $offset + $index + 1 ?></td>
                <td><?= esc($mhs['nama_lengkap']) ?></td>
                <td><?= esc($mhs['nim']) ?></td>
                <td><?= esc($mhs['program_studi']) ?></td>
                <td><?= esc($mhs['kelas']) ?></td>
                <td><?= esc($mhs['no_hp']) ?></td>
                <td><?= esc($mhs['email']) ?></td>
                <td><?= esc($mhs['nama_perusahaan']) ?></td>
                <td><?= esc($mhs['divisi']) ?></td>
                <td><?= esc($mhs['durasi_magang']) ?></td>
                <td><?= esc($mhs['tanggal_mulai']) ?></td>
                <td><?= esc($mhs['tanggal_selesai']) ?></td>
                <td><?= esc($mhs['nama_pembimbing_perusahaan']) ?></td>
                <td><?= esc($mhs['no_hp_pembimbing_perusahaan']) ?></td>
                <td><?= esc($mhs['email_pembimbing_perusahaan']) ?></td>
                <td><?= esc($mhs['judul_magang']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-center mt-4">
        <?= $pager->links('default', 'custom_pagination') ?>
      </div>
    </div>
  </div>

</div>

<!-- Script: Search Filter -->
<script>
  const searchInput = document.getElementById("searchInput");
  const table = document.getElementById("mahasiswaTable").getElementsByTagName("tbody")[0];

  searchInput.addEventListener("keyup", function () {
    const filter = searchInput.value.toLowerCase();
    for (let row of table.rows) {
      row.style.display = [...row.cells].some(cell =>
        cell.textContent.toLowerCase().includes(filter)
      ) ? "" : "none";
    }
  });
</script>

<?= $this->endSection(); ?>
