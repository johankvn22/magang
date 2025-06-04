<?php /** @var \CodeIgniter\View\View $this */ ?>
<?= $this->extend('layouts/template_admin'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Daftar Mahasiswa & Bimbingan Dosen</h2>

        <!-- Search -->
        <form method="get" action="<?= current_url() ?>" class="row mb-3">
            <div class="col-md-8">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari Nama/NIM/Kelas/Perusahaan...">
            </div>
        </form>
    </div>

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Form Table -->
    <form method="POST" action="<?= site_url('admin/save-bimbingan'); ?>">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0" id="bimbinganTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th width="20%">Nama Mahasiswa</th>
                                <th width="10%">NIM</th>
                                <th width="10%">Kelas</th>
                                <th width="10%">Perusahaan</th>
                                <th width="10%">Dospem 1</th>
                                <th width="10%">Dospem 2</th>
                                <th width="10%">Dospem 3</th>
                                <th width="25%">Pilih Dosen Pembimbing</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($mahasiswa as $index => $mhs): ?>
    <tr>
        <td class="text-center"><?= $index + 1 ?></td>
        <td>
            <div class="fw-semibold"><?= esc($mhs['nama_lengkap']) ?></div>
            <input type="hidden" name="mahasiswa_id[]" value="<?= $mhs['mahasiswa_id'] ?>">
        </td>
        <td><?= esc($mhs['nim']) ?></td>
        <td><span class="badge bg-secondary-subtle text-secondary"><?= esc($mhs['kelas']) ?></span></td>
        <td><?= esc($mhs['nama_perusahaan']) ?></td>
        <td><?= esc($mhs['dospem1']) ?></td>
        <td><?= esc($mhs['dospem2']) ?></td>
        <td><?= esc($mhs['dospem3']) ?></td>
        <td>
            <?php
                $selectedName = '';
                $selectedId = '';
                if (isset($bimbinganMap[$mhs['mahasiswa_id']])) {
                    foreach ($bimbinganMap[$mhs['mahasiswa_id']] as $b) {
                        $selectedId = $b['dosen_id'];
                        foreach ($dosen as $dsn) {
                            if ($dsn['dosen_id'] == $selectedId) {
                                $selectedName = $dsn['nama_lengkap'] . ' (' . $dsn['nip'] . ')';
                                break;
                            }
                        }
                    }
                }
            ?>
            <input 
                list="dosen_list_<?= $index ?>" 
                class="form-control form-control-sm dosen-input" 
                name="dosen_label[<?= $mhs['mahasiswa_id'] ?>]" 
                placeholder="Ketik nama atau NIP..." 
                value="<?= esc($selectedName) ?>" 
                required
            >
            <input type="hidden" name="dosen_id[<?= $mhs['mahasiswa_id'] ?>]" class="dosen-id-hidden" value="<?= esc($selectedId) ?>">

            <datalist id="dosen_list_<?= $index ?>">
                <?php foreach ($dosen as $dsn): ?>
                    <option 
                        value="<?= esc($dsn['nama_lengkap']) ?> (<?= esc($dsn['nip']) ?>)" 
                        data-id="<?= $dsn['dosen_id'] ?>">
                        <?= esc($dsn['nama_lengkap']) ?> (<?= esc($dsn['nip']) ?>) - <?= $dsn['total_bimbingan'] ?? 0 ?> bimbingan
                    </option>
                <?php endforeach; ?>
            </datalist>
        </td>
    </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Submit -->
                <div class="text-end p-3 bg-light border-top">
                    <button type="submit" class="btn btn-primary px-4">Simpan Semua Bimbingan</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Search Script -->
<script>
    const searchInput = document.getElementById("searchInput");
    const table = document.getElementById("bimbinganTable").getElementsByTagName("tbody")[0];

    searchInput.addEventListener("keyup", function() {
        const filter = searchInput.value.toLowerCase();

        for (let row of table.rows) {
            const nama = row.cells[1]?.textContent.toLowerCase() || '';
            const nim = row.cells[2]?.textContent.toLowerCase() || '';
            const kelas = row.cells[3]?.textContent.toLowerCase() || '';
            const perusahaan = row.cells[4]?.textContent.toLowerCase() || '';
            const dospem1 = row.cells[5]?.textContent.toLowerCase() || '';
            const dospem2 = row.cells[6]?.textContent.toLowerCase() || '';
            const dospem3 = row.cells[7]?.textContent.toLowerCase() || '';

            const match = nama.includes(filter) || nim.includes(filter) || kelas.includes(filter) || perusahaan.includes(filter) || dospem1.includes(filter) || dospem2.includes(filter) || dospem3.includes(filter);
            row.style.display = match ? '' : 'none';
        }
    });
</script>

<?= $this->endSection(); ?>
