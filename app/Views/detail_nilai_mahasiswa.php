  <?php
    /** @var \CodeIgniter\View\View $this */
    ?>
  <?= $this->extend('layouts/template_admin'); ?>
  <?= $this->section('content'); ?>



  <body>
      <div class="container py-4">
          <div class="d-flex justify-content-between align-items-center mb-4">
              <h2 class="mb-0 text-primary fw-bold">
                  <i class="fas fa-clipboard-check me-2"></i>Detail Nilai Mahasiswa
              </h2>
              <button class="btn btn-outline-primary" onclick="window.history.back()">
                  <i class="fas fa-back me-1"></i>Kembali
              </button>
              <button class="btn btn-outline-primary" onclick="window.print()">
                  <i class="fas fa-print me-1"></i>Cetak
              </button>
          </div>

          <div class="row g-4 mb-4">
              <!-- Biodata Mahasiswa -->
              <div class="col-lg-6">
                  <div class="card h-100 shadow-sm card-hover border-primary">
                      <div class="card-header bg-primary text-white">
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
                              <div class="ms-3" style="word-break: break-word; max-width: calc(100% - 60px);">
                                  <h4 class="mb-0"><?= esc($mahasiswa['nama_lengkap']) ?></h4>
                                  <span class="text-muted">NIM: <?= esc($mahasiswa['nim']) ?></span>
                              </div>
                          </div>

                          <div class="list-group list-group-flush">
                              <div class="list-group-item d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center py-3">
                                  <div class="mb-2 mb-sm-0 d-flex align-items-center">
                                      <i class="fas fa-graduation-cap me-2 text-primary"></i>
                                      <span>Program Studi</span>
                                  </div>
                                  <div class="d-flex flex-column flex-sm-row align-items-end align-items-sm-center gap-2">
                                      <span class="badge bg-primary bg-opacity-10 text-primary text-wrap text-start"><?= esc($mahasiswa['program_studi']) ?></span>
                                      <small class="badge bg-primary bg-opacity-10 text-primary"><?= esc($mahasiswa['kelas']) ?></small>
                                  </div>
                              </div>

                              <div class="list-group-item d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center py-3">
                                  <div class="mb-2 mb-sm-0 d-flex align-items-center">
                                      <i class="fas fa-building me-2 text-primary"></i>
                                      <span>Perusahaan</span>
                                  </div>
                                  <span class="badge bg-primary bg-opacity-10 text-primary text-wrap text-start" style="max-width: 200px;">
                                      <?= esc($mahasiswa['nama_perusahaan']) ?>
                                  </span>
                              </div>

                              <div class="list-group-item d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center py-3">
                                  <div class="mb-2 mb-sm-0 d-flex align-items-center">
                                      <i class="fas fa-user-tie me-2 text-primary"></i>
                                      <span>Pembimbing Industri</span>
                                  </div>
                                  <span class="badge bg-primary bg-opacity-10 text-primary text-wrap text-start" style="max-width: 200px;">
                                      <?= esc($mahasiswa['nama_pembimbing_perusahaan']) ?>
                                  </span>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Rangkuman Nilai -->
              <div class="col-lg-6">
                  <div class="card h-100 shadow-sm card-hover border-success">
                      <div class="card-header bg-success text-white">
                          <div class="d-flex align-items-center">
                              <i class="fas fa-chart-pie fa-lg me-3"></i>
                              <h5 class="mb-0">Rangkuman Nilai</h5>
                          </div>
                      </div>
                      <div class="card-body">
                          <?php if ($nilai_industri || $nilai_dosen): ?>
                              <div class="d-flex flex-column h-100">
                                  <!-- Nilai Industri -->
                                  <?php if ($nilai_industri): ?>
                                      <div class="mb-4">
                                          <h6 class="fw-bold text-success mb-3">
                                              <i class="fas fa-industry me-2"></i>Nilai Industri (60%)
                                          </h6>
                                          <div class="d-flex justify-content-between mb-2">
                                              <span>Soft Skills (50%)</span>
                                              <span class="fw-bold">
                                                  <?= number_format((
                                                        $nilai_industri['komunikasi'] +
                                                        $nilai_industri['berpikir_kritis'] +
                                                        $nilai_industri['kerja_tim'] +
                                                        $nilai_industri['inisiatif'] +
                                                        $nilai_industri['literasi_digital']
                                                    ), 2) ?>
                                              </span>
                                          </div>
                                          <div class="d-flex justify-content-between mb-3">
                                              <span>Hard Skills (50%)</span>
                                              <span class="fw-bold">
                                                  <?= number_format((
                                                        $nilai_industri['deskripsi_produk'] +
                                                        $nilai_industri['spesifikasi_produk'] +
                                                        $nilai_industri['desain_produk'] +
                                                        $nilai_industri['implementasi_produk'] +
                                                        $nilai_industri['pengujian_produk']
                                                    ), 2) ?>
                                              </span>
                                          </div>
                                          <div class="progress mb-3" style="height: 10px;">
                                              <div class="progress-bar bg-success" role="progressbar"
                                                  style="width: <?= $nilai_industri['total_nilai_industri']  ?>%"
                                                  aria-valuenow="<?= $nilai_industri['total_nilai_industri'] ?>"
                                                  aria-valuemin="0"
                                                  aria-valuemax="100">
                                              </div>
                                          </div>
                                          <div class="d-flex justify-content-between">
                                              <span class="text-muted">Total</span>
                                              <span class="fw-bold text-success"><?= number_format($nilai_industri['total_nilai_industri'], 2) ?></span>
                                          </div>
                                      </div>
                                  <?php endif; ?>

                                  <!-- Nilai Dosen -->
                                  <?php if ($nilai_dosen): ?>
                                      <div class="mb-4">
                                          <h6 class="fw-bold text-primary mb-3">
                                              <i class="fas fa-chalkboard-teacher me-2"></i>Nilai Dosen (40%)
                                          </h6>
                                          <div class="d-flex justify-content-between mb-2">
                                              <span>Pelaporan (30%)</span>
                                              <span class="fw-bold">
                                                  <?= number_format((
                                                        $nilai_dosen['nilai_1_1'] +
                                                        $nilai_dosen['nilai_1_2'] +
                                                        $nilai_dosen['nilai_1_3']
                                                    ), 2) ?>
                                              </span>
                                          </div>
                                          <div class="d-flex justify-content-between mb-2">
                                              <span>Presentasi (40%)</span>
                                              <span class="fw-bold">
                                                  <?= number_format((
                                                        $nilai_dosen['nilai_2_1'] +
                                                        $nilai_dosen['nilai_2_2'] +
                                                        $nilai_dosen['nilai_2_3'] +
                                                        $nilai_dosen['nilai_2_4']
                                                    ), 2) ?>
                                              </span>
                                          </div>
                                          <div class="d-flex justify-content-between mb-3">
                                              <span>Bimbingan (30%)</span>
                                              <span class="fw-bold">
                                                  <?= number_format((
                                                        $nilai_dosen['nilai_3_1'] +
                                                        $nilai_dosen['nilai_3_2']
                                                    ), 2) ?>
                                              </span>
                                          </div>
                                          <div class="progress mb-3" style="height: 10px;">
                                              <div class="progress-bar bg-primary" role="progressbar"
                                                  style="width: <?= $nilai_dosen['total_nilai'] ?>%"
                                                  aria-valuenow="<?= $nilai_dosen['total_nilai'] ?>"
                                                  aria-valuemin="0"
                                                  aria-valuemax="100">
                                              </div>
                                          </div>
                                          <div class="d-flex justify-content-between">
                                              <span class="text-muted">Total</span>
                                              <span class="fw-bold text-primary"><?= number_format($nilai_dosen['total_nilai'], 2) ?></span>
                                          </div>
                                      </div>
                                  <?php endif; ?>

                                  <!-- Total Nilai Akhir -->
                                  <div class="mt-auto pt-3 border-top">
                                      <?php
                                        $total_nilai = 0;
                                        if ($nilai_industri && $nilai_dosen) {
                                            $total_nilai = ($nilai_industri['total_nilai_industri'] * 0.6) + ($nilai_dosen['total_nilai'] * 0.4);
                                        } elseif ($nilai_industri) {
                                            $total_nilai = $nilai_industri['total_nilai_industri'];
                                        } elseif ($nilai_dosen) {
                                            $total_nilai = $nilai_dosen['total_nilai'];
                                        }
                                        ?>
                                      <div class="d-flex justify-content-between align-items-center">
                                          <h5 class="mb-0 fw-bold">Nilai Akhir</h5>
                                          <div class="display-5 fw-bold text-dark"><?= number_format($total_nilai, 2) ?></div>
                                      </div>

                                      <div class="d-flex justify-content-between mt-2">
                                          <small class="text-muted">0</small>
                                          <small class="text-muted">100</small>
                                      </div>
                                  </div>
                              </div>
                          <?php else: ?>
                              <div class="text-center py-4">
                                  <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                                      <i class="fas fa-exclamation-circle fa-2x text-warning"></i>
                                  </div>
                                  <h6 class="text-dark mb-2">Belum ada nilai</h6>
                                  <p class="text-muted small mb-0">Nilai akan muncul setelah pembimbing mengisi evaluasi</p>
                              </div>
                          <?php endif; ?>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Nilai Industri -->
          <div class="col-12">
              <?php if ($nilai_industri): ?>
                  <div class="card h-100 shadow-sm card-hover border-success">
                      <div class="card-header bg-success text-white">
                          <div class="d-flex align-items-center">
                              <i class="fas fa-industry fa-lg me-3"></i>
                              <h5 class="mb-0">Nilai Pembimbing Industri</h5>
                          </div>
                      </div>
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table table-bordered table-hover align-middle mb-0">
                                  <thead class="table-light">
                                      <tr>
                                          <th style="width: 15%" class="text-center">Kategori</th>
                                          <th>Kriteria Unjuk Kerja (KUK)</th>
                                          <th style="width: 15%" class="text-center">Angka Mutu</th>
                                          <th style="width: 15%" class="text-center">Nilai</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <!-- Soft Skills -->
                                      <tr>
                                          <td class="text-center align-middle fw-bold bg-info bg-opacity-10" rowspan="5">
                                              <div class="d-flex flex-column justify-content-center align-items-center">
                                                  <i class="fas fa-comments fa-2x mb-2 text-info"></i>
                                                  <span>Soft Skills</span>
                                                  <span class="badge bg-info mt-1">50%</span>

                                              </div>
                                          </td>
                                          <td>1.1 Mahasiswa memiliki kemampuan berkomunikasi yang baik</td>
                                          <td class="text-center">1 - 10</td>
                                          <td class="text-center"><span class="badge bg-info score-badge"><?= $nilai_industri['komunikasi'] ?></span></td>
                                      </tr>
                                      <tr>
                                          <td>1.2 Mahasiswa mampu berpikir kritis</td>
                                          <td class="text-center">1 - 10</td>
                                          <td class="text-center"><span class="badge bg-info score-badge"><?= $nilai_industri['berpikir_kritis'] ?></span></td>
                                      </tr>
                                      <tr>
                                          <td>1.3 Mahasiswa mampu bekerja secara individu maupun tim</td>
                                          <td class="text-center">1 - 10</td>
                                          <td class="text-center"><span class="badge bg-info score-badge"><?= $nilai_industri['kerja_tim'] ?></span></td>
                                      </tr>
                                      <tr>
                                          <td>1.4 Mahasiswa memiliki daya inisiatif, kreatif, inovatif, dan adaptif yang tinggi</td>
                                          <td class="text-center">1 - 10</td>
                                          <td class="text-center"><span class="badge bg-info score-badge"><?= $nilai_industri['inisiatif'] ?></span></td>
                                      </tr>
                                      <tr>
                                          <td>1.5 Mahasiswa memiliki kemampuan literasi, informasi, media, dan teknologi</td>
                                          <td class="text-center">1 - 10</td>
                                          <td class="text-center"><span class="badge bg-info score-badge"><?= $nilai_industri['literasi_digital'] ?></span></td>
                                      </tr>

                                      <!-- Hard Skills -->
                                      <tr>
                                          <td class="text-center align-middle fw-bold bg-success bg-opacity-10" rowspan="5">
                                              <div class="d-flex flex-column justify-content-center align-items-center">
                                                  <i class="fas fa-cogs fa-2x mb-2 text-success"></i>
                                                  <span>Hard Skills</span>
                                                  <span class="badge bg-success mt-1">50%</span>

                                              </div>
                                          </td>
                                          <td>2.1 Mahasiswa mampu membuat deskripsi produk</td>
                                          <td class="text-center">1 - 10</td>
                                          <td class="text-center"><span class="badge bg-success score-badge"><?= $nilai_industri['deskripsi_produk'] ?></span></td>
                                      </tr>
                                      <tr>
                                          <td>2.2 Mahasiswa mampu menentukan requirement/Spesifikasi produk</td>
                                          <td class="text-center">1 - 10</td>
                                          <td class="text-center"><span class="badge bg-success score-badge"><?= $nilai_industri['spesifikasi_produk'] ?></span></td>
                                      </tr>
                                      <tr>
                                          <td>2.3 Mahasiswa mampu membuat desain produk</td>
                                          <td class="text-center">1 - 10</td>
                                          <td class="text-center"><span class="badge bg-success score-badge"><?= $nilai_industri['desain_produk'] ?></span></td>
                                      </tr>
                                      <tr>
                                          <td>2.4 Mahasiswa mampu mengimplementasikan produk</td>
                                          <td class="text-center">1 - 10</td>
                                          <td class="text-center"><span class="badge bg-success score-badge"><?= $nilai_industri['implementasi_produk'] ?></span></td>
                                      </tr>
                                      <tr>
                                          <td>2.5 Mahasiswa mampu melakukan pengujian produk</td>
                                          <td class="text-center">1 - 10</td>
                                          <td class="text-center"><span class="badge bg-success score-badge"><?= $nilai_industri['pengujian_produk'] ?></span></td>
                                      </tr>
                                  </tbody>
                                  <tfoot class="table-light">
                                      <tr>
                                          <td colspan="3" class="text-end fw-bold fs-5">Total Nilai Industri</td>
                                          <td class="text-center fw-bold fs-4">
                                              <span class="badge bg-primary total-score"><?= number_format($nilai_industri['total_nilai_industri'], 2) ?></span>
                                          </td>
                                      </tr>
                                  </tfoot>
                              </table>
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
                                      <th style="width: 15%" class="text-center">Angka Mutu</th>
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
                                      <td class="text-center">5 - 15</td>
                                      <td class="text-center fw-bold">
                                          <span class="badge bg-success score-badge"><?= $nilai_dosen['nilai_3_1'] ?></span>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>3.2 Mahasiswa mampu menunjukkan bukti kemajuan bimbingan secara berkala</td>
                                      <td class="text-center">5 - 15</td>
                                      <td class="text-center fw-bold">
                                          <span class="badge bg-success score-badge"><?= $nilai_dosen['nilai_3_2'] ?></span>
                                      </td>
                                  </tr>
                              </tbody>
                              <tfoot class="table-light">
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

  </body>

  <?= $this->endSection(); ?>