<?php
/** @var \CodeIgniter\View\View $this */
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title ?? 'Mahasiswa') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Tambahkan ini di bagian atas, sebelum script custom -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="<?= base_url('assets/js/script.js'); ?>"></script>



</head>
<body class="d-flex flex-column min-vh-100">
  
  <?php echo view('partials/header_mahasiswa'); ?>
  <?php echo view('partials/navbar_mahasiswa'); ?>

  <main class="flex-fill bg-light py-4">
    <div class="container">
      <?= $this->renderSection('content') ?>
    </div>
  </main>

  <?php echo view('partials/footer'); ?>

 

</body>
</html>
