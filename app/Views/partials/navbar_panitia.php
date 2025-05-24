<nav class="navbar navbar-expand-lg bg-medium-green mt-0">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link text-white" href="<?= base_url('/panitia/dashboard'); ?>">Dashboard</a></li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" role="button" data-bs-toggle="dropdown" 
        aria-expanded="false">Daftar Mahasiswa</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item text-white" href="<?= base_url('/panitia/daftar_mahasiswa'); ?>">Daftar Mahasiswa</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="<?= base_url('panitia/user-requirement'); ?>">User Requirement</a></li>
            <li><a class="dropdown-item text-white" href="<?= base_url('/panitia/logbook-mahasiswa'); ?>">Logbook Bimbingan</a></li>
            <li><a class="dropdown-item text-white" href="<?= base_url('/panitia/logbook-aktivitas'); ?>">Logbook Aktivitas</a></li>
            <li><a class="dropdown-item text-white" href="<?= base_url('/nilai'); ?>">Nilai Mahasiswa</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link text-white" href="<?= base_url('panitia/review-kinerja'); ?>">Kuesioner Industri</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="<?= base_url('panitia/bagikan-bimbingan'); ?>">Bagikan Bimbingan</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="<?= base_url('panitia/daftar-dosen'); ?>">Daftar Dosen</a></li>

      </ul>
    </div>
  </div>
</nav>


