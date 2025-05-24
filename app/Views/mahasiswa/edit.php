<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_mahasiswa'); ?>
<?= $this->section('content'); ?>

   <div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <h2 class="mb-4">Edit Profil Mahasiswa</h2>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
          <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>

      <div class="card mb-4">
        <div class="card-body">
          <form method="POST" action="<?= site_url('mahasiswa/update'); ?>">

            <div class="mb-3">
              <label for="nama_lengkap" class="form-label">Nama Lengkap:</label>
              <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="<?= esc($mahasiswa['nama_lengkap']) ?>" required>
            </div>

            <div class="mb-3">
              <label for="nim" class="form-label">NIM:</label>
              <input type="text" name="nim" id="nim" class="form-control" value="<?= esc($mahasiswa['nim']) ?>" required>
            </div>

            <div class="mb-3">
              <label for="program_studi" class="form-label">Program Studi:</label>
              <input type="text" name="program_studi" id="program_studi" class="form-control" value="<?= esc($mahasiswa['program_studi']) ?>" required>
            </div>

            <div class="mb-3">
              <label for="kelas" class="form-label">Kelas:</label>
              <input type="text" name="kelas" id="kelas" class="form-control" value="<?= esc($mahasiswa['kelas']) ?>" required>
            </div>

            <div class="mb-3">
              <label for="no_hp" class="form-label">No HP:</label>
              <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?= esc($mahasiswa['no_hp']) ?>">
            </div>

            <div class="mb-3">
              <label for="nama_perusahaan" class="form-label">Nama Perusahaan:</label>
              <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control" value="<?= esc($mahasiswa['nama_perusahaan']) ?>">
            </div>

            <div class="mb-3">
              <label for="divisi" class="form-label">Divisi:</label>
              <input type="text" name="divisi" id="divisi" class="form-control" value="<?= esc($mahasiswa['divisi']) ?>">
            </div>

            <div class="mb-3">
              <label for="durasi_magang" class="form-label">Durasi Magang (minggu/bulan):</label>
              <input type="number" name="durasi_magang" id="durasi_magang" class="form-control" value="<?= esc($mahasiswa['durasi_magang']) ?>">
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai:</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="<?= esc($mahasiswa['tanggal_mulai']) ?>">
              </div>
              <div class="col-md-6 mb-3">
                <label for="tanggal_selesai" class="form-label">Tanggal Selesai:</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="<?= esc($mahasiswa['tanggal_selesai']) ?>">
              </div>
            </div>

            <div class="mb-3">
              <label for="nama_pembimbing_perusahaan" class="form-label">Nama Pembimbing Perusahaan:</label>
              <input type="text" name="nama_pembimbing_perusahaan" id="nama_pembimbing_perusahaan" class="form-control" value="<?= esc($mahasiswa['nama_pembimbing_perusahaan']) ?>">
            </div>

            <div class="mb-3">
              <label for="no_hp_pembimbing_perusahaan" class="form-label">No HP Pembimbing Perusahaan:</label>
              <input type="text" name="no_hp_pembimbing_perusahaan" id="no_hp_pembimbing_perusahaan" class="form-control" value="<?= esc($mahasiswa['no_hp_pembimbing_perusahaan']) ?>">
            </div>

            <div class="mb-3">
              <label for="email_pembimbing_perusahaan" class="form-label">Email Pembimbing Perusahaan:</label>
              <input type="email" name="email_pembimbing_perusahaan" id="email_pembimbing_perusahaan" class="form-control" value="<?= esc($mahasiswa['email_pembimbing_perusahaan']) ?>">
            </div>

            <div class="mb-3">
              <label for="judul_magang" class="form-label">Judul Magang:</label>
              <input type="text" name="judul_magang" id="judul_magang" class="form-control" value="<?= esc($mahasiswa['judul_magang']) ?>">
            </div>

            <div class="mb-3">
              <label for="dospem1" class="form-label">Dosen Pembimbing 1:</label>
              <input type="text" name="dospem1" id="dospem1" class="form-control" value="<?= esc($mahasiswa['dospem1']) ?>">
            </div>

            <div class="mb-3">
              <label for="dospem2" class="form-label">Dosen Pembimbing 2:</label>
              <input type="text" name="dospem2" id="dospem2" class="form-control" value="<?= esc($mahasiswa['dospem2']) ?>">
            </div> 

            <div class="mb-3">
              <label for="dospem3" class="form-label">Dosen Pembimbing 3:</label>
              <input type="text" name="dospem3" id="dospem3" class="form-control" value="<?= esc($mahasiswa['dospem3']) ?>">
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </form>
        </div>
      </div>

      <a href="<?= site_url('mahasiswa/dashboard'); ?>" class="btn btn-secondary">Kembali ke Dashboard</a>

    </div>
  </div>
</div>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<?= $this->endSection(); ?>