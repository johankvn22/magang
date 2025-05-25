<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Nilai Mahasiswa</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .category-header {
            background: linear-gradient(135deg,rgb(3, 122, 49) 0%,rgb(4, 244, 96) 100%);
            color: white;
        }

        .score-badge {
            min-width: 50px;
            font-size: 0.9rem;
        }

        .total-score {
            font-size: 1.2rem;
            letter-spacing: 1px;
        }

        .criteria-col {
            min-width: 300px;
        }

        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .criteria-col {
                min-width: 200px;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 text-primary fw-bold">
                <i class="fas fa-clipboard-check me-2"></i>Detail Nilai Mahasiswa
            </h2>
            <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print me-1"></i>Cetak
            </button>
        </div>

        <div class="row g-4 mb-4">
            <!-- Biodata Mahasiswa -->
            <div class="col-lg-6">
                <div class="card h-100 shadow-sm card-hover border-primary">
                    <div class="card-header category-header">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-graduate fa-lg me-3"></i>
                            <h5 class="mb-0">Biodata Mahasiswa</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                                    <i class="fas fa-user fa-2x text-primary"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h4 class="mb-0"><?= $mahasiswa['nama_lengkap'] ?></h4>
                                <span class="text-muted">NIM: <?= $mahasiswa['nim'] ?></span>
                            </div>
                        </div>

                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <i class="fas fa-graduation-cap me-2 text-primary"></i>
                                    <span>Pgdi</span>
                                </div>
                                <span class="badge bg-primary bg-opacity-10 text-primary fs-6"><?= $mahasiswa['program_studi'] ?></span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <i class="fas fa-building me-2 text-primary"></i>
                                    <span>Perusahaan</span>
                                </div>
                                <span class="badge bg-primary bg-opacity-10 text-primary fs-6"><?= $mahasiswa['nama_perusahaan'] ?></span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <i class="fas fa-user-tie me-2 text-primary"></i>
                                    <span>Pembimbing Industri</span>
                                </div>
                                <span class="badge bg-primary bg-opacity-10 text-primary fs-6"><?= $mahasiswa['nama_pembimbing_perusahaan'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nilai Industri -->
            <div class="col-lg-6">
                <?php if ($nilai_industri): ?>
                    <div class="card h-100 shadow-sm card-hover border-success">
                        <div class="card-header bg-success text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-industry fa-lg me-3"></i>
                                <h5 class="mb-0">Nilai Pembimbing Industri</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded p-3 h-100">
                                        <h6 class="text-success fw-bold mb-3">
                                            <i class="fas fa-comments me-2"></i>Soft Skills
                                        </h6>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-3 d-flex justify-content-between align-items-center">
                                                <span>Komunikasi</span>
                                                <span class="badge bg-success score-badge"><?= $nilai_industri['komunikasi'] ?></span>
                                            </li>
                                            <li class="mb-3 d-flex justify-content-between align-items-center">
                                                <span>Berpikir Kritis</span>
                                                <span class="badge bg-success score-badge"><?= $nilai_industri['berpikir_kritis'] ?></span>
                                            </li>
                                            <li class="mb-3 d-flex justify-content-between align-items-center">
                                                <span>Kerja Tim</span>
                                                <span class="badge bg-success score-badge"><?= $nilai_industri['kerja_tim'] ?></span>
                                            </li>
                                            <li class="mb-3 d-flex justify-content-between align-items-center">
                                                <span>Inisiatif</span>
                                                <span class="badge bg-success score-badge"><?= $nilai_industri['inisiatif'] ?></span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center">
                                                <span>Literasi Digital</span>
                                                <span class="badge bg-success score-badge"><?= $nilai_industri['literasi_digital'] ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded p-3 h-100">
                                        <h6 class="text-success fw-bold mb-3">
                                            <i class="fas fa-cogs me-2"></i>Hard Skills
                                        </h6>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-3 d-flex justify-content-between align-items-center">
                                                <span>Deskripsi Produk</span>
                                                <span class="badge bg-success score-badge"><?= $nilai_industri['deskripsi_produk'] ?></span>
                                            </li>
                                            <li class="mb-3 d-flex justify-content-between align-items-center">
                                                <span>Spesifikasi Produk</span>
                                                <span class="badge bg-success score-badge"><?= $nilai_industri['spesifikasi_produk'] ?></span>
                                            </li>
                                            <li class="mb-3 d-flex justify-content-between align-items-center">
                                                <span>Desain Produk</span>
                                                <span class="badge bg-success score-badge"><?= $nilai_industri['desain_produk'] ?></span>
                                            </li>
                                            <li class="mb-3 d-flex justify-content-between align-items-center">
                                                <span>Implementasi Produk</span>
                                                <span class="badge bg-success score-badge"><?= $nilai_industri['implementasi_produk'] ?></span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center">
                                                <span>Pengujian Produk</span>
                                                <span class="badge bg-success score-badge"><?= $nilai_industri['pengujian_produk'] ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-success bg-opacity-10 rounded text-center">
                                <h4 class="mb-0 text-success">
                                    Total Nilai Industri:
                                    <span class="badge bg-success total-score ms-2"><?= number_format($nilai_industri['total_nilai_industri'], 2) ?></span>
                                </h4>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center d-flex flex-column justify-content-center py-5">
                            <div class="bg-warning bg-opacity-10 p-4 rounded-circle d-inline-block mb-3">
                                <i class="fas fa-exclamation-circle fa-3x text-warning"></i>
                            </div>
                            <h5 class="text-dark mb-2">Belum ada nilai dari pembimbing industri</h5>
                            <p class="text-muted mb-0">Nilai akan muncul setelah pembimbing industri mengisi evaluasi</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Nilai Dosen -->
        <div class="card shadow-sm mb-4 border-primary card-hover">
            <div class="card-header category-header">
                <div class="d-flex align-items-center">
                    <i class="fas fa-chalkboard-teacher fa-lg me-3"></i>
                    <h5 class="mb-0">Nilai Dosen Pembimbing</h5>
                </div>
            </div>
            <div class="card-body">
                <?php if ($nilai_dosen): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 15%" class="text-center">Kategori</th>
                                    <th class="criteria-col">Kriteria Unjuk Kerja (KUK)</th>
                                    <th style="width: 15%" class="text-center">Range Nilai</th>
                                    <th style="width: 15%" class="text-center">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Pelaporan 30% -->
                                <tr>
                                    <td class="text-center align-middle fw-bold bg-info bg-opacity-10" rowspan="3">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <i class="fas fa-file-alt fa-2x mb-2 text-info"></i>
                                            <span>Pelaporan</span>
                                            <span class="badge bg-info mt-1">30%</span>
                                        </div>
                                    </td>
                                    <td>1.1 Mahasiswa mampu menuliskan kesesuaian judul Magang dengan produk yang dihasilkan</td>
                                    <td class="text-center">5 - 10</td>
                                    <td class="text-center fw-bold">
                                        <span class="badge bg-info score-badge"><?= $nilai_dosen['nilai_1_1'] ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1.2 Mahasiswa mampu menggunakan Tata bahasa & Tata tulis dengan baik dan benar</td>
                                    <td class="text-center">5 - 10</td>
                                    <td class="text-center fw-bold">
                                        <span class="badge bg-info score-badge"><?= $nilai_dosen['nilai_1_2'] ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1.3 Mahasiswa mampu menyusun laporan magang sesuai dengan format & kerangka standar yang berlaku</td>
                                    <td class="text-center">5 - 10</td>
                                    <td class="text-center fw-bold">
                                        <span class="badge bg-info score-badge"><?= $nilai_dosen['nilai_1_3'] ?></span>
                                    </td>
                                </tr>

                                <!-- Presentasi 40% -->
                                <tr>
                                    <td class="text-center align-middle fw-bold bg-warning bg-opacity-10" rowspan="4">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <i class="fas fa-presentation-screen fa-2x mb-2 text-warning"></i>
                                            <span>Presentasi</span>
                                            <span class="badge bg-warning mt-1">40%</span>
                                        </div>
                                    </td>
                                    <td>2.1 Mahasiswa mampu menunjukkan Pengetahuan praktis sesuai dengan kegiatan magang</td>
                                    <td class="text-center">5 - 10</td>
                                    <td class="text-center fw-bold">
                                        <span class="badge bg-warning score-badge"><?= $nilai_dosen['nilai_2_1'] ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.2 Mahasiswa mampu menjawab pertanyaan dengan tepat dan jelas</td>
                                    <td class="text-center">5 - 10</td>
                                    <td class="text-center fw-bold">
                                        <span class="badge bg-warning score-badge"><?= $nilai_dosen['nilai_2_2'] ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.3 Mahasiswa menunjukkan Etika/sikap yang baik</td>
                                    <td class="text-center">5 - 10</td>
                                    <td class="text-center fw-bold">
                                        <span class="badge bg-warning score-badge"><?= $nilai_dosen['nilai_2_3'] ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.4 Mahasiswa mampu menjustifikasi kesesuaian kegiatan magang dengan profil lulusan PS</td>
                                    <td class="text-center">5 - 10</td>
                                    <td class="text-center fw-bold">
                                        <span class="badge bg-warning score-badge"><?= $nilai_dosen['nilai_2_4'] ?></span>
                                    </td>
                                </tr>

                                <!-- Bimbingan 30% -->
                                <tr>
                                    <td class="text-center align-middle fw-bold bg-success bg-opacity-10" rowspan="2">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <i class="fas fa-handshake fa-2x mb-2 text-success"></i>
                                            <span>Bimbingan</span>
                                            <span class="badge bg-success mt-1">30%</span>
                                        </div>
                                    </td>
                                    <td>3.1 Mahasiswa melakukan bimbingan minimal 4 kali</td>
                                    <td class="text-center">5 - 10</td>
                                    <td class="text-center fw-bold">
                                        <span class="badge bg-success score-badge"><?= $nilai_dosen['nilai_3_1'] ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3.2 Mahasiswa mampu menunjukkan bukti kemajuan bimbingan secara berkala</td>
                                    <td class="text-center">5 - 10</td>
                                    <td class="text-center fw-bold">
                                        <span class="badge bg-success score-badge"><?= $nilai_dosen['nilai_3_2'] ?></span>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="table-dark">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold fs-5">Total Nilai Dosen</td>
                                    <td class="text-center fw-bold fs-4">
                                        <span class="badge bg-primary total-score"><?= $nilai_dosen['total_nilai'] ?></span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="bg-warning bg-opacity-10 p-4 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-exclamation-circle fa-3x text-warning"></i>
                        </div>
                        <h4 class="text-dark mb-2">Belum ada nilai dari dosen pembimbing</h4>
                        <p class="text-muted">Nilai akan muncul setelah dosen pembimbing mengisi evaluasi</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>