<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_kps'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success">Daftar Mahasiswa & Dosen Pembimbing</h2>
            <!-- Search -->
    <form method="get" action="<?= site_url('kps/daftar-dosen') ?>" class="row mb-3">
      <div class="col-md-8">
        <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" class="form-control" placeholder="Cari Nama Mahasiswa/Perusahaan...">
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-success">Cari</button>
      </div>
    </form>

    <form method="get" action="<?= site_url('kps/daftar-dosen') ?>" class="row mb-3 g-2">
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

        <form method="get" action="<?= site_url('kps/daftar-dosen') ?>" class="row mb-3 g-2">
        <input type="hidden" name="keyword" value="<?= esc($keyword) ?>">
        <input type="hidden" name="perPage" value="<?= esc($perPage) ?>">

        <div class="col-md-3">
            <select name="sortProdi" class="form-select" onchange="this.form.submit()">
                <option value="">Filter Program Studi</option>
                <?php foreach (['TI', 'TMJ', 'TMD'] as $prodi): ?>
                    <option value="<?= $prodi ?>" <?= ($sortProdi == $prodi) ? 'selected' : '' ?>>
                        <?= $prodi ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        </form>

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('kps/update-dosen') ?>">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0" id="mahasiswaTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th width="15%">Nama</th>
                                <th class="sortable" width="15%">Kelas</th>
                                <th class="sortable" width="20%">Perusahaan</th>
                                <th width="15%">Divisi</th>
                                <th class="sortable" width="25%">Dosen Pembimbing</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mahasiswa as $index => $m): ?>
                                <tr class="<?= empty($m['dosen_terpilih']) ? 'table-warning' : '' ?>">
                                    <td class="text-center"><?= $offset + $index + 1 ?></td>
                                    <td>
                                        <div class="fw-semibold"><?= esc($m['nama_lengkap']) ?></div>
                                        <div class="text-muted small"><?= esc($m['nim']) ?></div>                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary"><?= esc($m['program_studi']) ?></span><br>
                                        <span class="badge bg-secondary-subtle text-secondary"><?= esc($m['kelas']) ?></span>                                    </td>
                                    <td style="max-width: 250px;" title="<?= esc($m['nama_perusahaan']) ?>">
                                        <?= esc($m['nama_perusahaan']) ?>
                                    </td>
                                    <td><?= esc($m['divisi']) ?></td>
                                    <td>
                                        <input type="hidden" name="mahasiswa_id[]" value="<?= $m['mahasiswa_id'] ?>">
                                        <input type="hidden" 
                                               name="dosen_id_<?= $m['mahasiswa_id'] ?>" 
                                               id="dosen_id_<?= $m['mahasiswa_id'] ?>" 
                                               value="<?= $m['dosen_terpilih'][0] ?? '' ?>">

                                        <div class="input-group input-group-sm">
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
                                                   placeholder="Ketik nama atau NIP..."
                                                   autocomplete="off"
                                                   onfocus="this.setAttribute('list', 'dosen_list_<?= $index ?>')"
                                                   oninput="if(this.value===''){this.setAttribute('list', 'dosen_list_<?= $index ?>');}">

                                            <button type="button" class="btn btn-outline-secondary btn-clear-dosen" tabindex="-1"
                                                onclick="this.previousElementSibling.value='';this.previousElementSibling.dispatchEvent(new Event('input'));this.previousElementSibling.focus();">
                                                &times;
                                            </button>
                                        </div>

                                        <datalist id="dosen_list_<?= $index ?>">
                                            <?php foreach ($listDosen as $dsn): ?>
                                                <option data-id="<?= $dsn['dosen_id'] ?>" 
                                                        value="<?= esc($dsn['nama_lengkap']) ?> (<?= esc($dsn['nip']) ?>)">
                                                    <?= $dsn['total_bimbingan'] ?? 0 ?> bimbingan
                                                </option>
                                            <?php endforeach; ?>
                                        </datalist>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Submit Button -->
                <div class="text-end p-3 bg-light border-top">
                    <button type="submit" class="btn btn-success px-4">Simpan Semua</button>
                </div>

                <!-- Pagination -->
                <?php if (isset($pager)): ?>
                <div class="d-flex justify-content-center p-3 border-top">
                    <?= $pager->links('default', 'custom_pagination') ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <!-- Rekap Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Rekap Mahasiswa Bimbingan per Dosen</h5>
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="70%">Nama Dosen</th>
                            <th width="30%">Total Mahasiswa Bimbingan</th>
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
    </div>
</div>

<!-- Scripts (unchanged) -->
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

        document.getElementById('dosen_id_' + mahasiswaId).value = matchedId;
    });
});

</script>

<?= $this->endSection(); ?>