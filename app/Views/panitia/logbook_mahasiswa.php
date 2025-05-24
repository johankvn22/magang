<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_panitia'); ?>
<?= $this->section('content'); ?>


<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-10">

      <h2 class="mb-4 text-center">Monitoring Logbook Mahasiswa</h2>

      <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari Mahasiswa...">
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle" id="logbookTable">
          <thead class="table-light">
            <tr>
              <th>Detail</th>
              <th>Nama Mahasiswa</th>
              <th>NIM</th>
              <th>Prodi</th>
              <th>Kelas</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($mahasiswa as $mhs): ?>
              <tr>
                <td>
                  <a href="<?= base_url('panitia/detail-logbook/' . $mhs['mahasiswa_id']) ?>" class="btn btn-sm btn-outline-primary">Lihat</a>
                </td>
                <td><?= esc($mhs['nama_lengkap']) ?></td>
                <td><?= esc($mhs['nim']) ?></td>
                <td><?= esc($mhs['program_studi']) ?></td>
                <td><?= esc($mhs['kelas']) ?></td>
                <td>
                  <span class="badge <?= $mhs['status'] === 'Sudah Verifikasi' ? 'bg-success' : 'bg-secondary' ?>">
                    <?= esc($mhs['status']) ?>
                  </span>
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
        const table = document.getElementById("logbookTable").getElementsByTagName("tbody")[0];

        searchInput.addEventListener("keyup", function() {
            const filter = searchInput.value.toLowerCase();
            for (let row of table.rows) {
                row.style.display = [...row.cells].some(cell =>
                    cell.textContent.toLowerCase().includes(filter)
                ) ? "" : "none";
            }
        });
    </script>



<?= $this->endSection(); ?>
