<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_panitia'); ?>
<?= $this->section('content'); ?>



<body>
    <div class="container mt-5">
        <h2>Monitoring Aktivitas Mahasiswa di Industri</h2>

        <input type="text" id="searchInput" class="form-control search-input" placeholder="Cari mahasiswa...">

        <table class="table table-bordered table-striped" id="aktivitasTable">
            <thead>
                <tr>
                    <th>Detail</th>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Prodi</th>
                    <th>Kelas</th>
                    <th>Status Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mahasiswa as $mhs): ?>
                    <tr>
                        <td>
                            <a href="<?= base_url('panitia/detail-aktivitas/' . $mhs['mahasiswa_id']) ?>">Detail Aktivitas</a>
                        </td>
                        <td><?= esc($mhs['nama_lengkap']) ?></td>
                        <td><?= esc($mhs['nim']) ?></td>
                        <td><?= esc($mhs['program_studi']) ?></td>
                        <td><?= esc($mhs['kelas']) ?></td>
                        <td class="status-verifikasi <?= $mhs['status'] === 'Sudah Verifikasi' ? 'sudah' : 'belum' ?>">
                            <?= esc($mhs['status']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        const searchInput = document.getElementById("searchInput");
        const table = document.getElementById("aktivitasTable").getElementsByTagName("tbody")[0];

        searchInput.addEventListener("keyup", function() {
            const filter = searchInput.value.toLowerCase();
            for (let row of table.rows) {
                row.style.display = [...row.cells].some(cell =>
                    cell.textContent.toLowerCase().includes(filter)
                ) ? "" : "none";
            }
        });
    </script>
</body>

<?= $this->endSection(); ?>
