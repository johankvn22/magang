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
            </div>
          <?php endif; ?>
          
          <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
              <?= session()->getFlashdata('success') ?>
            </div>
          <?php endif; ?>

          <form id="profileForm" method="POST" action="<?= site_url('mahasiswa/update'); ?>" enctype="multipart/form-data">
            <div class="row">
              <!-- Foto Profil Section -->
              <div class="col-md-12 mb-4">
                <div class="text-center">
                  <div class="form-group">
                    <div class="profile-img-container">
                      <?php 
                      // Perbaikan path gambar
                      $defaultFoto = base_url('uploads/foto_profil/default.jpg');
                      $currentFoto = (!empty($mahasiswa['foto_profil']) && file_exists(ROOTPATH.'public/uploads/foto_profil/'.$mahasiswa['foto_profil'])) 
                                   ? base_url('uploads/foto_profil/'.$mahasiswa['foto_profil'])
                                   : $defaultFoto;
                      ?>
                      <img src="<?= $currentFoto ?>" id="previewFoto" 
                           class="img-thumbnail rounded-circle mb-3"
                           style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #28a745;"
                           onerror="this.onerror=null;this.src='<?= $defaultFoto ?>'"
                           alt="Foto Profil">
                      
                      <br>
                      <input type="file" name="foto_profil" id="foto_profil" 
                             accept="image/jpeg,image/png,image/jpg" style="display: none;">
                      
                      <label for="foto_profil" class="btn btn-outline-success">
                        <i class="fas fa-camera"></i> Ganti Foto
                      </label>
                      
                      <button type="button" id="resetFoto" class="btn btn-outline-secondary ml-2" style="display: none;">
                        <i class="fas fa-undo"></i> Reset
                      </button>
                      
                      <br>
                      <small class="text-muted">Max. 2MB (JPG/PNG)</small>
                      <div id="fotoError" class="text-danger mt-2" style="display: none;"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

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
                  <div class="form-group col-md-6">
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

<script>
$(document).ready(function () {
  const $input = $('#foto_profil');
  const $preview = $('#previewFoto');
  const $resetBtn = $('#resetFoto');
  const $errorDiv = $('#fotoError');
  const originalSrc = $preview.attr('src');

  $input.on('change', function () {
    const file = this.files[0];
    $errorDiv.hide().text('');

    if (!file) {
      console.log('Tidak ada file dipilih');
      return;
    }

    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!allowedTypes.includes(file.type)) {
      $errorDiv.text('Hanya file JPG/PNG yang diperbolehkan!').show();
      this.value = '';
      return;
    }

    if (file.size > 2 * 1024 * 1024) {
      $errorDiv.text('Ukuran file tidak boleh lebih dari 2MB!').show();
      this.value = '';
      return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
      $preview.attr('src', e.target.result);
      $resetBtn.show();
    };
    reader.readAsDataURL(file);
  });

  $resetBtn.on('click', function () {
    $preview.attr('src', originalSrc);
    $input.val('');
    $errorDiv.hide();
    $(this).hide();
  });


  // Form validation
  $('#profileForm').on('submit', function(e) {
    let isValid = true;
    
    // Remove previous error messages
    $('.invalid-feedback').remove();
    $('.is-invalid').removeClass('is-invalid');
    
    // Validate required fields
    $('[required]').each(function() {
      if (!$(this).val() || $(this).val().trim() === '') {
        isValid = false;
        $(this).addClass('is-invalid');
        $(this).after('<div class="invalid-feedback">Field ini wajib diisi</div>');
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
    
    // Validate company supervisor email
    const emailPembimbing = $('#email_pembimbing_perusahaan').val();
    if (emailPembimbing && !emailRegex.test(emailPembimbing)) {
      isValid = false;
      $('#email_pembimbing_perusahaan').addClass('is-invalid');
      $('#email_pembimbing_perusahaan').after('<div class="invalid-feedback">Format email tidak valid</div>');
    }
    
    // Validate phone number format
    const phoneRegex = /^[0-9]{10,15}$/;
    const phone = $('#no_hp').val();
    if (phone && !phoneRegex.test(phone)) {
      isValid = false;
      $('#no_hp').addClass('is-invalid');
      $('#no_hp').after('<div class="invalid-feedback">Nomor HP harus berupa angka 10-15 digit</div>');
    }
    
    const phonePembimbing = $('#no_hp_pembimbing_perusahaan').val();
    if (phonePembimbing && !phoneRegex.test(phonePembimbing)) {
      isValid = false;
      $('#no_hp_pembimbing_perusahaan').addClass('is-invalid');
      $('#no_hp_pembimbing_perusahaan').after('<div class="invalid-feedback">Nomor HP harus berupa angka 10-15 digit</div>');
    }
    
    // Validate duration between 12-30 weeks
    const duration = $('#durasi_magang').val();
    if (duration && (duration < 12 || duration > 30)) {
      isValid = false;
      $('#durasi_magang').addClass('is-invalid');
      $('#durasi_magang').after('<div class="invalid-feedback">Durasi magang harus antara 12-30 minggu</div>');
    }
    
    // Validate date range
    const startDate = new Date($('#tanggal_mulai').val());
    const endDate = new Date($('#tanggal_selesai').val());
    if (startDate && endDate && startDate >= endDate) {
      isValid = false;
      $('#tanggal_selesai').addClass('is-invalid');
      $('#tanggal_selesai').after('<div class="invalid-feedback">Tanggal selesai harus setelah tanggal mulai</div>');
    }
    
    // Validate supervisor selection (cannot select same supervisor)
    const dospem1 = $('#dospem1').val();
    const dospem2 = $('#dospem2').val();
    const dospem3 = $('#dospem3').val();
    
    if (dospem1 && dospem2 && dospem1 === dospem2) {
      isValid = false;
      $('#dospem2').addClass('is-invalid');
      $('#dospem2').after('<div class="invalid-feedback">Dosen pembimbing 2 tidak boleh sama dengan dosen pembimbing 1</div>');
    }
    
    if (dospem1 && dospem3 && dospem1 === dospem3) {
      isValid = false;
      $('#dospem3').addClass('is-invalid');
      $('#dospem3').after('<div class="invalid-feedback">Dosen pembimbing 3 tidak boleh sama dengan dosen pembimbing 1</div>');
    }
    
    if (dospem2 && dospem3 && dospem2 === dospem3) {
      isValid = false;
      $('#dospem3').addClass('is-invalid');
      $('#dospem3').after('<div class="invalid-feedback">Dosen pembimbing 3 tidak boleh sama dengan dosen pembimbing 2</div>');
    }
    
    if (!isValid) {
      e.preventDefault();
      // Scroll to first error
      $('html, body').animate({
        scrollTop: $('.is-invalid').first().offset().top - 100
      }, 500);
    }
  });
  
  // Clear validation on input change
  $('input, select, textarea').on('input change', function() {
    if ($(this).hasClass('is-invalid')) {
      $(this).removeClass('is-invalid');
      $(this).next('.invalid-feedback').remove();
    }
  });
  
  // Auto-dismiss alerts after 5 seconds
  setTimeout(function() {
    $('.alert').fadeOut();
  }, 5000);
});
</script>

<style>
.profile-img-container {
  position: relative;
  display: inline-block;
}

.profile-img-container img {
  transition: all 0.3s ease;
}

.profile-img-container:hover img {
  opacity: 0.8;
}

.invalid-feedback {
  display: block;
}

.form-control.is-invalid {
  border-color: #dc3545;
}

.form-control.is-invalid:focus {
  border-color: #dc3545;
  box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}
</style>

<?= $this->endSection(); ?>