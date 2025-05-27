<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_kps'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid px-2">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary mb-0">🏭 Monitoring Aktivitas Mahasiswa di Industri</h2>

    <div class="col-md-6">
      <input type="text" id="searchInput" class="form-control" placeholder="🔍 Cari mahasiswa...">
    </div>
  </div>

  <!-- Table -->
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover table-bordered text-nowrap align-middle small" id="aktivitasTable">
          <thead class="table-light text-center align-middle">
            <tr>
              <th>No</th>
              <th>Nama & NIM</th>
              <th>Prodi & Kelas</th>
              <th>Status Aktivitas</th>
              <th>Detail</th>
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
                  <span class="badge <?= $mhs['status'] === 'Sudah Verifikasi' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' ?>">
                    <?= esc($mhs['status']) ?>
                  </span>
                </td>
                <td class="text-center">
                  <a href="<?= base_url('kps/logbook-aktivitas/' . $mhs['mahasiswa_id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    Detail Aktivitas
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<script>
  const searchInput = document.getElementById("searchInput");
  const tableRows = document.querySelectorAll("#aktivitasTable tbody tr");

  searchInput.addEventListener("keyup", function () {
    const filter = searchInput.value.toLowerCase();
    tableRows.forEach(row => {
      const text = row.innerText.toLowerCase();
      row.style.display = text.includes(filter) ? "" : "none";
    });
  });
</script>

<?= $this->endSection(); ?>
