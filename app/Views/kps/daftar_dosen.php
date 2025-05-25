<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_kps'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid py-0 px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success">Daftar Mahasiswa & Dosen Pembimbing</h2>
    </div>

    <!-- Search -->
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari Mahasiswa...">
        </div>
    </div>

    <!-- Flash -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('kps/update-dosen') ?>">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle text-nowrap small" id="mahasiswaTable">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th class="sortable">Kelas</th>
                                <th class="sortable">Perusahaan</th>
                                <th>Divisi</th>
                                <th class="sortable">Dosen Pembimbing</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mahasiswa as $index => $m): ?>
                                <tr class="<?= empty($m['dosen_terpilih']) ? 'table-warning' : '' ?>">
                                    <td class="text-center"><?= $offset + $index + 1 ?></td>
                                    <td><?= esc($m['nama_lengkap']) ?></td>
                                    <td><?= esc($m['nim']) ?></td>
                                    <td><?= esc($m['kelas']) ?></td>
                                    <td><?= esc($m['nama_perusahaan']) ?></td>
                                    <td><?= esc($m['divisi']) ?></td>
 <td>
    <input type="hidden" name="mahasiswa_id[]" value="<?= $m['mahasiswa_id'] ?>">
    <input type="hidden" 
           name="dosen_id_<?= $m['mahasiswa_id'] ?>" 
           id="dosen_id_<?= $m['mahasiswa_id'] ?>" 
           value="<?= $m['dosen_terpilih'][0] ?? '' ?>">

    <input list="dosen_list_<?= $index ?>" 
           class="form-control dosen-input" 
           data-target="<?= $m['mahasiswa_id'] ?>"
           value="<?php
                $selectedId = $m['dosen_terpilih'][0] ?? '';
                $selectedDosen = array_filter($listDosen, fn($d) => $d['dosen_id'] == $selectedId);
                if (!empty($selectedDosen)) {
                    $dosen = array_values($selectedDosen)[0];
                    echo esc($dosen['nama_lengkap']) . ' (' . esc($dosen['nip']) . ')';
                }
           ?>"
           placeholder="Ketik nama atau NIP...">

    <datalist id="dosen_list_<?= $index ?>">
        <?php foreach ($listDosen as $dsn): ?>
            <option data-id="<?= $dsn['dosen_id'] ?>" 
                    value="<?= esc($dsn['nama_lengkap']) ?> (<?= esc($dsn['nip']) ?>)">
            <?php endforeach; ?>
    </datalist>
</td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
<script>
  document.querySelectorAll('.dosen-input').forEach(input => {
    input.addEventListener('change', function () {
      const mahasiswaId = this.dataset.target;
      const selectedValue = this.value.toLowerCase();
      const listId = this.getAttribute('list');
      const datalist = document.getElementById(listId);
      const options = datalist.getElementsByTagName('option');

      let matchedId = '';

      for (let opt of options) {
        if (opt.value.toLowerCase() === selectedValue) {
          matchedId = opt.getAttribute('data-id');
          break;
        }
      }

      // Set hidden input to ID if match found
      document.getElementById('dosen_id_' + mahasiswaId).value = matchedId;
    });
  });
</script>

                </div>

                <!-- Submit -->
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Simpan Semua</button>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    <?= $pager->links('default', 'custom_pagination') ?>
                </div>
            </div>
        </div>
    </form>

    <!-- Rekap -->
    <div class="mt-5">
        <h4>Rekap Mahasiswa Bimbingan per Dosen</h4>
        <table class="table table-sm table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nama Dosen</th>
                    <th>Total Mahasiswa Bimbingan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listDosen as $d): ?>
                    <tr>
                        <td><?= esc($d['nama_lengkap']) ?> (<?= esc($d['nip']) ?>)</td>
                        <td><?= $d['total_bimbingan'] ?? 0 ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

    <!-- Script: Search & Sort -->
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

    // Sortable columns
    document.querySelectorAll('th.sortable').forEach(th => {
        th.style.cursor = 'pointer';
        th.addEventListener('click', () => {
        const table = th.closest('table');
        Array.from(table.querySelectorAll('tbody tr'))
            .sort(((idx, asc) => (a, b) => {
            const getVal = tr => tr.children[idx].innerText.toLowerCase();
            return getVal(asc ? a : b).localeCompare(getVal(asc ? b : a));
            })(Array.from(th.parentNode.children).indexOf(th), th.asc = !th.asc))
            .forEach(tr => table.querySelector('tbody').appendChild(tr));
        });
    });
    </script>



<?= $this->endSection(); ?>