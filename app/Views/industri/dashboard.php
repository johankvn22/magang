<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>

<body>

 
  <!-- Main content -->
  <div class="container mt-4">
    <h3>Selamat datang di Dashboard Pembimbing Industri</h3>
    <p>Ini adalah halaman utama Anda untuk memantau kegiatan bimbingan industri.</p>

    <!-- Statistik -->
    <div class="row mt-4">
      <div class="col-md-4">
        <div class="card border-primary shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Total Mahasiswa Bimbingan</h5>
            <p class="card-text fs-4"><?= $totalMahasiswa ?? 0 ?></p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card border-success shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Laporan Disetujui</h5>
            <p class="card-text fs-4"><?= $laporanDisetujui ?? 0 ?></p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card border-warning shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Laporan Menunggu</h5>
            <p class="card-text fs-4"><?= $laporanMenunggu ?? 0 ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Daftar Mahasiswa Bimbingan
    <div class="mt-5">
      <h4>Daftar Mahasiswa Bimbingan</h4>
      <?php if (!empty($mahasiswaBimbingan)) : ?>
        <div class="table-responsive">
          <table class="table table-bordered table-hover mt-3">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Perusahaan</th>
                <th>Divisi</th>
                <th>Durasi Magang</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($mahasiswaBimbingan as $mhs) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= esc($mhs['nama']) ?></td>
                  <td><?= esc($mhs['nim']) ?></td>
                  <td><?= esc($mhs['nama_perusahaan']) ?></td>
                  <td><?= esc($mhs['divisi']) ?></td>
                  <td><?= esc($mhs['durasi']) ?> bulan</td>
                  <td>
                    <a href="<?= base_url('industri/bimbingan/detail/' . $mhs['id']) ?>" class="btn btn-sm btn-primary">Detail</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else : ?>
        <div class="alert alert-warning mt-3">Belum ada mahasiswa bimbingan.</div>
      <?php endif; ?>
    </div>
  </div> -->

</body>

<?= $this->endSection(); ?>
