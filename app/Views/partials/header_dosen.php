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
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item text-white" href="<?= site_url('/dosen/editProfile'); ?>">Profile</a></li>
            <li><a class="dropdown-item text-white" href="<?= site_url('/dosen/changePassword'); ?>">Ganti Password</a></li>
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

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Konfirmasi untuk tombol "Setujui"
        document.querySelectorAll('.btn-confirm-setujui-bimbingan').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Setujui Logbook?',
                    text: "Logbook yang disetujui tidak dapat diubah.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Setujui!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Konfirmasi untuk tombol "Tolak"
        document.querySelectorAll('.btn-confirm-tolak-bimbingan').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Tolak Logbook?',
                    text: "Jangan lupa untuk memberikan catatan untuk mahasiswa.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Tolak!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
  </script>

</header>