<h2>Daftar Nilai Mahasiswa</h2>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Nama Mahasiswa</th>
            <th>NIM</th>
            <th>Program Studi</th>
            <th>Perusahaan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($mahasiswa_list as $mhs): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td>
                    <a href="<?= base_url('admin/nilai/detail/' . $mhs['mahasiswa_id']) ?>">
                        <?= $mhs['nama_lengkap'] ?>
                    </a>
                </td>
                <td><?= $mhs['nim'] ?></td>
                <td><?= $mhs['program_studi'] ?></td>
                <td><?= $mhs['nama_perusahaan'] ?></td>
                <td>
                    <a href="<?= base_url('admin/nilai/detail/' . $mhs['mahasiswa_id']) ?>" class="btn btn-primary btn-sm">
                        Lihat Detail
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>