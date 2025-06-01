<?php

/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_admin'); ?>
<?= $this->section('content'); ?>

<body>
    <div class="container mt-3">
        <h2>Daftar Mahasiswa & Bimbingan Dosen</h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col-md-3 mx-0">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari Mahasiswa...">
            </div>
        </div>

        <form method="POST" action="<?= site_url('admin/save-bimbingan'); ?>">
            <table class="table table-bordered table-striped" tabele id="bimbinganTable">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Kelas</th>
                        <th>Perusahaan</th>
                        <th>Dospem 1</th>
                        <th>Dospem 2</th>
                        <th>Dospem 3</th>
                        <th>Pilih Dosen Pembimbing</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mahasiswa as $index => $mhs): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <?= esc($mhs['nama_lengkap']) ?>
                                <input type="hidden" name="mahasiswa_id[]" value="<?= $mhs['mahasiswa_id'] ?>">
                            </td>
                            <td><?= esc($mhs['nim']) ?></td>
                            <td><?= esc($mhs['kelas']) ?></td>
                            <td><?= esc($mhs['nama_perusahaan']) ?></td>
                            <td><?= esc($mhs['dospem1']) ?></td>
                            <td><?= esc($mhs['dospem2']) ?></td>
                            <td><?= esc($mhs['dospem3']) ?></td>
                            <td>
                                <input list="dosen_list_<?= $index ?>" class="form-control" name="dosen_id[]" placeholder="Ketik nama atau NIP..." required>
                                <datalist id="dosen_list_<?= $index ?>">
                                    <?php foreach ($dosen as $dsn): ?>
                                        <option value="<?= $dsn['dosen_id'] ?>">
                                            <?= esc($dsn['nama_lengkap']) ?> (<?= esc($dsn['nip']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </datalist>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Simpan Semua Bimbingan</button>
        </form>
    </div>
</body>

<script>
    const searchInput = document.getElementById("searchInput");
    const table = document.getElementById("bimbinganTable").getElementsByTagName("tbody")[0];

    searchInput.addEventListener("keyup", function() {
        const filter = searchInput.value.toLowerCase();

        for (let row of table.rows) {
            const namaMahasiswa = row.cells[1]?.textContent.toLowerCase() || '';
            const nim = row.cells[2]?.textContent.toLowerCase() || '';
            const kelas = row.cells[3]?.textContent.toLowerCase() || '';
            const perusahaan = row.cells[4]?.textContent.toLowerCase() || '';
            const dospem1 = row.cells[5]?.textContent.toLowerCase() || '';
            const dospem2 = row.cells[6]?.textContent.toLowerCase() || '';
            const dospem3 = row.cells[7]?.textContent.toLowerCase() || '';

            const match =
                namaMahasiswa.includes(filter) ||
                nim.includes(filter) ||
                kelas.includes(filter) ||
                perusahaan.includes(filter) ||
                dospem1.includes(filter) ||
                dospem2.includes(filter) ||
                dospem3.includes(filter);

            row.style.display = match ? "" : "none";
        }
    });
</script>


<?= $this->endSection(); ?>