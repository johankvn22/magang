<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_panitia'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
  <h2>Daftar Mahasiswa</h2>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
      <?= session()->getFlashdata('success') ?>
    </div>
  <?php endif; ?>

 <body class="bg-light">

  <body>
  <div class="container py-5">
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class=""table-light text-center">
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Prodi</th>
            <th>Kelas</th>
            <th>No HP</th>
            <th>Email</th>
            <th>Perusahaan</th>
            <th>Divisi</th>
            <th>Durasi</th>
            <th>Mulai</th>
            <th>Selesai</th>
            <th>Pembimbing</th>
            <th>No HP Pembimbing</th>
            <th>Email Pembimbing</th>
            <th>Judul Magang</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($mahasiswa as $index => $mhs): ?>
            <tr>
              <td><?= $offset + $index + 1 ?></td>
              <td><?= esc($mhs['nama_lengkap']) ?></td>
              <td><?= esc($mhs['nim']) ?></td>
              <td><?= esc($mhs['program_studi']) ?></td>
              <td><?= esc($mhs['kelas']) ?></td>
              <td><?= esc($mhs['no_hp']) ?></td>
              <td><?= esc($mhs['email']) ?></td>
              <td><?= esc($mhs['nama_perusahaan']) ?></td>
              <td><?= esc($mhs['divisi']) ?></td>
              <td><?= esc($mhs['durasi_magang']) ?></td>
              <td><?= esc($mhs['tanggal_mulai']) ?></td>
              <td><?= esc($mhs['tanggal_selesai']) ?></td>
              <td><?= esc($mhs['nama_pembimbing_perusahaan']) ?></td>
              <td><?= esc($mhs['no_hp_pembimbing_perusahaan']) ?></td>
              <td><?= esc($mhs['email_pembimbing_perusahaan']) ?></td>
              <td><?= esc($mhs['judul_magang']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- PAGINATION -->
    <div class="d-flex justify-content-center mt-4">
      <?= $pager->links('default', 'default_full') ?>
    </div>
  </div>

</body>

<?= $this->endSection(); ?>
