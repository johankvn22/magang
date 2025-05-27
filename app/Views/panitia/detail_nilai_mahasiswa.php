<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Nilai Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail Nilai Mahasiswa</h4>
        </div>
        <div class="card-body">
            <h5 class="fw-bold"><?= $mahasiswa['nama_lengkap'] ?> (<?= $mahasiswa['nim'] ?>)</h5>
            <p><strong>Program Studi:</strong> <?= $mahasiswa['program_studi'] ?></p>
            <p><strong>Perusahaan:</strong> <?= $mahasiswa['nama_perusahaan'] ?></p>
            <hr>
            <h6 class="text-primary">Nilai dari Dosen Pembimbing</h6>
            <?php if ($nilai_dosen): ?>
                <ul>
                    <li>Pelaporan: <?= $nilai_dosen['pelaporan'] ?></li>
                    <li>Presentasi: <?= $nilai_dosen['presentasi'] ?></li>
                    <li>Bimbingan: <?= $nilai_dosen['bimbingan'] ?></li>
                    <li><strong>Total Nilai: <?= $nilai_dosen['total_nilai'] ?></strong></li>
                </ul>
            <?php else: ?>
                <p class="text-muted">Belum ada nilai dari dosen.</p>
            <?php endif; ?>
            <hr>
            <h6 class="text-success">Nilai dari Pembimbing Industri</h6>
            <?php if ($nilai_industri): ?>
                <ul>
                    <li>Kompetensi: <?= $nilai_industri['kompetensi'] ?></li>
                    <li>Perilaku: <?= $nilai_industri['perilaku'] ?></li>
                    <li>Disiplin: <?= $nilai_industri['disiplin'] ?></li>
                    <li><strong>Total Nilai: <?= $nilai_industri['total_nilai_industri'] ?></strong></li>
                </ul>
            <?php else: ?>
                <p class="text-muted">Belum ada nilai dari industri.</p>
            <?php endif; ?>
            <a href="<?= base_url(current_url(true)->getSegment(1) . '/nilai') ?>" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>
</body>
</html>
