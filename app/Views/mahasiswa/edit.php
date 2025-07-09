<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_mahasiswa'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card shadow">
        <div class="card-header bg-success text-white">
          <h2 class="mb-0">Edit Profil Mahasiswa</h2>
        </div>
        
        <div class="card-body">
          <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
              <?= session()->getFlashdata('error') ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>
          
          <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
              <?= session()->getFlashdata('success') ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>

          <form method="POST" action="<?= site_url('mahasiswa/update'); ?>" id="profileForm">
            <div class="row">
              <!-- Personal Information Column -->
              <div class="col-md-6">
                <h4 class="mb-3 text-success">Informasi Pribadi</h4>
                
                <div class="form-group mt-3">
                  <label for="nama_lengkap" class="font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                  <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                        value="<?= esc($mahasiswa['nama_lengkap'] ?? '') ?>" readonly>
                </div>

                <div class="form-group mt-3">
                  <label for="nim" class="font-weight-bold">NIM <span class="text-danger">*</span></label>
                  <input type="text" name="nim" id="nim" class="form-control"
                        value="<?= esc($mahasiswa['nim'] ?? '') ?>" readonly>
                </div>


                <div class="form-group mt-3">
                  <label for="program_studi" class="font-weight-bold">Program Studi <span class="text-danger">*</span></label>
                  <select name="program_studi" id="program_studi" class="form-control" required>
                    <option value="">-- Pilih Program Studi --</option>
                    <option value="TI" <?= ($mahasiswa['program_studi'] ?? '') == 'TI' ? 'selected' : '' ?>>Teknik Informatika</option>
                    <option value="TMD" <?= ($mahasiswa['program_studi'] ?? '') == 'TMD' ? 'selected' : '' ?>>Teknik Mesin D3</option>
                    <option value="TMJ" <?= ($mahasiswa['program_studi'] ?? '') == 'TMJ' ? 'selected' : '' ?>>Teknik Mesin J3</option>
                  </select>
                </div>

                <div class="form-group mt-3">
                  <label for="kelas" class="font-weight-bold">Kelas <span class="text-danger">*</span></label>
                  <input type="text" name="kelas" id="kelas" class="form-control" 
                         value="<?= esc($mahasiswa['kelas'] ?? '') ?>" required minlength="2" maxlength="10">
                </div>

                <div class="form-group mt-3">
                  <label for="no_hp" class="font-weight-bold">No HP <span class="text-danger">*</span></label>
                  <input type="tel" name="no_hp" id="no_hp" class="form-control" 
                         value="<?= esc($mahasiswa['no_hp'] ?? '') ?>" required pattern="[0-9]{10,15}">
                </div>

                <div class="form-group mt-3">
                  <label for="email" class="font-weight-bold">Email <span class="text-danger">*</span></label>
                  <input type="email" name="email" id="email" class="form-control" 
                         value="<?= esc($mahasiswa['email'] ?? '') ?>" required>
                </div>
              </div>
              
              <!-- Internship Information Column -->
              <div class="col-md-6">
                <h4 class="mb-3 text-success">Informasi Magang</h4>
                
                <div class="form-group mt-3">
                  <label for="nama_perusahaan" class="font-weight-bold">Nama Perusahaan <span class="text-danger">*</span></label>
                  <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control" 
                         value="<?= esc($mahasiswa['nama_perusahaan'] ?? '') ?>" required minlength="3" maxlength="100">
                </div>

                <div class="form-group mt-3">
                  <label for="divisi" class="font-weight-bold">Divisi <span class="text-danger">*</span></label>
                  <input type="text" name="divisi" id="divisi" class="form-control" 
                         value="<?= esc($mahasiswa['divisi'] ?? '') ?>" required minlength="2" maxlength="50">
                </div>

                <div class="form-group mt-3">
                  <label for="durasi_magang" class="font-weight-bold">Durasi Magang (minggu) <span class="text-danger">*</span></label>
                  <input type="number" name="durasi_magang" id="durasi_magang" class="form-control" 
                         value="<?= esc($mahasiswa['durasi_magang'] ?? '') ?>" required min="12" max="30">
                </div>

                <div class="form-row mt-3">
                  <div class="form-group col-md-6">
                    <label for="tanggal_mulai" class="font-weight-bold">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" 
                           value="<?= esc($mahasiswa['tanggal_mulai'] ?? '') ?>" required>
                  </div>
                  <div class="form-group col-md-6 mt-3">
                    <label for="tanggal_selesai" class="font-weight-bold">Tanggal Selesai <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" 
                           value="<?= esc($mahasiswa['tanggal_selesai'] ?? '') ?>" required>
                  </div>
                </div>

                <div class="form-group mt-3">
                  <label for="judul_magang" class="font-weight-bold">Judul Magang <span class="text-danger">*</span></label>
                  <input type="text" name="judul_magang" id="judul_magang" class="form-control" 
                         value="<?= esc($mahasiswa['judul_magang'] ?? '') ?>" required minlength="10" maxlength="200">
                </div>

                <div class="form-group mt-3">
                  <label for="alamat_perusahaan" class="font-weight-bold">Alamat Perusahaan <span class="text-danger">*</span></label>
                  <textarea name="alamat_perusahaan" id="alamat_perusahaan" class="form-control" 
                            required minlength="10" maxlength="500"><?= esc($mahasiswa['alamat_perusahaan'] ?? '') ?></textarea>
                </div>
              </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row">
              <!-- Company Supervisor Column -->
              <div class="col-md-6">
                <h4 class="mb-3 text-success">Pembimbing Perusahaan</h4>
                
                <div class="form-group mt-3">
                  <label for="nama_pembimbing_perusahaan" class="font-weight-bold">Nama Pembimbing <span class="text-danger">*</span></label>
                  <input type="text" name="nama_pembimbing_perusahaan" id="nama_pembimbing_perusahaan" class="form-control" 
                         value="<?= esc($mahasiswa['nama_pembimbing_perusahaan'] ?? '') ?>" required minlength="3" maxlength="100">
                </div>

                <div class="form-group mt-3">
                  <label for="no_hp_pembimbing_perusahaan" class="font-weight-bold">No HP Pembimbing <span class="text-danger">*</span></label>
                  <input type="tel" name="no_hp_pembimbing_perusahaan" id="no_hp_pembimbing_perusahaan" class="form-control" 
                         value="<?= esc($mahasiswa['no_hp_pembimbing_perusahaan'] ?? '') ?>" required pattern="[0-9]{10,15}">
                </div>

                <div class="form-group mt-3">
                  <label for="email_pembimbing_perusahaan" class="font-weight-bold">Email Pembimbing <span class="text-danger">*</span></label>
                  <input type="email" name="email_pembimbing_perusahaan" id="email_pembimbing_perusahaan" class="form-control" 
                         value="<?= esc($mahasiswa['email_pembimbing_perusahaan'] ?? '') ?>" required>
                </div>
              </div>
              
              <!-- Academic Supervisor Column -->
              <div class="col-md-6">
                <h4 class="mb-3 text-success">Dosen Pembimbing</h4>
                
                <div class="form-group mt-3">
                  <label for="dospem1" class="font-weight-bold">Dosen Pembimbing 1 <span class="text-danger">*</span></label>
                  <select name="dospem1" id="dospem1" class="form-control" required>
                  <option value="">-- Pilih Dosen Pembimbing 1 --</option>
                  <?php foreach ($dosen as $dsn): ?>
                    <option value="<?= esc($dsn['dosen_id']) ?>" <?= ($mahasiswa['dospem1'] ?? '') == $dsn['dosen_id'] ? 'selected' : '' ?>>
                    <?= esc($dsn['nama_lengkap']) ?> (<?= esc($dsn['nip']) ?>)
                    </option>
                  <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group mt-3">
                  <label for="dospem2" class="font-weight-bold">Dosen Pembimbing 2 <span class="text-danger">*</span></label>
                  <select name="dospem2" id="dospem2" class="form-control" required>
                  <option value="">-- Pilih Dosen Pembimbing 2 --</option>
                  <?php foreach ($dosen as $dsn): ?>
                    <option value="<?= esc($dsn['dosen_id']) ?>" <?= ($mahasiswa['dospem2'] ?? '') == $dsn['dosen_id'] ? 'selected' : '' ?>>
                    <?= esc($dsn['nama_lengkap']) ?> (<?= esc($dsn['nip']) ?>)
                    </option>
                  <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group mt-3">
                  <label for="dospem3" class="font-weight-bold">Dosen Pembimbing 3 <span class="text-danger">*</span></label>
                  <select name="dospem3" id="dospem3" class="form-control" required>
                  <option value="">-- Pilih Dosen Pembimbing 3 --</option>
                  <?php foreach ($dosen as $dsn): ?>
                    <option value="<?= esc($dsn['dosen_id']) ?>" <?= ($mahasiswa['dospem3'] ?? '') == $dsn['dosen_id'] ? 'selected' : '' ?>>
                    <?= esc($dsn['nama_lengkap']) ?> (<?= esc($dsn['nip']) ?>)
                    </option>
                  <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group mt-4">
              <button type="submit" class="btn btn-primary btn-lg px-4">
                <i class="fas fa-save mr-2"></i>Simpan Perubahan
              </button>
              <a href="<?= site_url('mahasiswa/dashboard'); ?>" class="btn btn-secondary btn-lg px-4 ml-2">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
$(document).ready(function() {
  // Form validation
  $('#profileForm').on('submit', function(e) {
    let isValid = true;
    
    // Validate required fields
    $('[required]').each(function() {
      if (!$(this).val()) {
        isValid = false;
        $(this).addClass('is-invalid');
        $(this).after('<div class="invalid-feedback">Field ini wajib diisi</div>');
      } else {
        $(this).removeClass('is-invalid');
        $(this).next('.invalid-feedback').remove();
      }
    });
    
    // Validate email format
    const email = $('#email').val();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email && !emailRegex.test(email)) {
      isValid = false;
      $('#email').addClass('is-invalid');
      $('#email').after('<div class="invalid-feedback">Format email tidak valid</div>');
    }
    
    // Validate duration between 12-30 weeks
    const duration = $('#durasi_magang').val();
    if (duration && (duration < 12 || duration > 30)) {
      isValid = false;
      $('#durasi_magang').addClass('is-invalid');
      $('#durasi_magang').after('<div class="invalid-feedback">Durasi magang harus antara 12-30 minggu</div>');
    }
    
    if (!isValid) {
      e.preventDefault();
      $('html, body').animate({
        scrollTop: $('.is-invalid').first().offset().top - 100
      }, 500);
    }
  });
  
  // Clear validation on input
  $('input, select, textarea').on('input change', function() {
    if ($(this).hasClass('is-invalid')) {
      $(this).removeClass('is-invalid');
      $(this).next('.invalid-feedback').remove();
    }
  });
  
  // Date validation - end date should be after start date
  $('#tanggal_mulai, #tanggal_selesai').change(function() {
    const startDate = new Date($('#tanggal_mulai').val());
    const endDate = new Date($('#tanggal_selesai').val());
    
    if (startDate && endDate && startDate > endDate) {
      $('#tanggal_selesai').addClass('is-invalid');
      $('#tanggal_selesai').after('<div class="invalid-feedback">Tanggal selesai harus setelah tanggal mulai</div>');
    } else {
      $('#tanggal_selesai').removeClass('is-invalid');
      $('#tanggal_selesai').next('.invalid-feedback').remove();
    }
  });
});
</script>
<?= $this->endSection(); ?>