<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Nilai Mahasiswa (Panitia)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card-header-gradient {
            background: linear-gradient(135deg, #fc466b 0%, #3f5efb 100%);
            color: white;
        }

        .table-hover tbody tr:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .score-badge {
            min-width: 60px;
            font-size: 0.85rem;
            padding: 5px 8px;
        }

        .score-dosen {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }

        .score-industri {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
        }

        .action-btn {
            min-width: 100px;
        }

        @media (max-width: 992px) {
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header card-header-gradient">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>Daftar Nilai Mahasiswa - Panitia
                    </h3>
                    <div>
                        <button class="btn btn-outline-light btn-sm" onclick="window.print()">
                            <i class="fas fa-print me-1"></i>Cetak
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th style="width: 20%">Mahasiswa</th>
                                <th style="width: 10%">NIM</th>
                                <th style="width: 15%">Program Studi</th>
                                <th style="width: 20%">Perusahaan</th>
                                <th class="text-center" style="width: 15%">Nilai Dosen</th>
                                <th class="text-center" style="width: 15%">Nilai Industri</th>
                                <th class="text-center" style="width: 15%">Total Nilai</th>

                                <th class="text-center" style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($mahasiswa_list as $mhs): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-user-circle fa-lg text-primary me-2"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <a href="<?= base_url('panitia/nilai/detail/' . $mhs['mahasiswa_id']) ?>" class="text-decoration-none fw-bold">
                                                    <?= $mhs['nama_lengkap'] ?>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= $mhs['nim'] ?></td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            <?= $mhs['program_studi'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-building text-muted me-2"></i>
                                            <span><?= $mhs['nama_perusahaan'] ?></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php if (isset($mhs['nilai_dosen']['total_nilai'])): ?>
                                            <span class="badge score-badge score-dosen rounded-pill">
                                                <?= $mhs['nilai_dosen']['total_nilai'] ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary score-badge rounded-pill">
                                                <i class="fas fa-minus"></i>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (isset($mhs['nilai_industri']['total_nilai_industri'])): ?>
                                            <span class="badge score-badge score-industri rounded-pill">
                                                <?= number_format($mhs['nilai_industri']['total_nilai_industri'], 2) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary score-badge rounded-pill">
                                                <i class="fas fa-minus"></i>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('panitia/nilai/detail/' . $mhs['mahasiswa_id']) ?>"
                                            class="btn btn-primary btn-sm action-btn">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (empty($mahasiswa_list)): ?>
                    <div class="text-center py-5">
                        <div class="bg-warning bg-opacity-10 p-4 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-exclamation-circle fa-3x text-warning"></i>
                        </div>
                        <h4 class="text-dark mb-2">Tidak ada data mahasiswa</h4>
                        <p class="text-muted">Belum ada mahasiswa yang terdaftar untuk dinilai</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>