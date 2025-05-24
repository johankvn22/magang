<nav class="navbar navbar-expand-lg bg-medium-green mt-0">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link text-white" href="<?= base_url('/dosen/'); ?>">Dashboard</a></li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" role="button" data-bs-toggle="dropdown" 
        aria-expanded="false">Logbook</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item text-white" href="<?= base_url('/dosen/bimbingan'); ?>">Logbook Bimbingan</a></li>
            <li><a class="dropdown-item text-white" href="<?= base_url('/dosen/aktivitas'); ?>">Logbook Aktivitas</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link text-white" href="<?= base_url('/dosen/user-requirement'); ?>">User Requirement</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="<?= base_url('/dosen/penilaian-dosen/listNilai'); ?>">Nilai Mahasiswa</a></li>

      </ul>
    </div>
  </div>
</nav>


