
<!-- Header -->
<header class="bg-dark-green py-2">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-md-6 d-flex align-items-center">
        <img src="<?= base_url('assets/img/LOGO PNJ.png'); ?>" alt="Logo PNJ" class="logo me-3">
        <div class="text-white">
          <h4 class="mb-0">MAGANG</h4>
          <h5 class="mb-0">Politeknik Negeri Jakarta (PNJ)</h5>
        </div>
      </div>
      <div class="col-md-6 text-end">
        <div class="dropdown">
          <button class="btn text-white dropdown-toggle profile-dropdown" type="button" data-bs-toggle="dropdown">
            <span class="me-2"><?= session('nama') ?></span>
            <span class="profile-circle"><i class="bi bi-person-circle fs-4"></i></span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-white" href="<?= site_url('/panitia/edit_profil'); ?>">Profile</a></li>
            <li><a class="dropdown-item text-white" href="<?= site_url('/panitia/ganti_password'); ?>">Ganti Password</a></li>
            <li><a class="dropdown-item text-white" href="<?= base_url('logout'); ?>" id="logoutBtn">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- SweetAlert2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Logout Confirmation Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const logoutBtn = document.getElementById('logoutBtn');
      logoutBtn.addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
          title: 'Yakin ingin logout?',
          text: "Sesi kamu akan berakhir.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, logout!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "<?= base_url('/logout'); ?>";
          }
        });
      });
    });
  </script>
</header>
