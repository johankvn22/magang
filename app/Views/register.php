<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_admin'); ?>
<?= $this->section('content'); ?>

    <div class="container mt-5">
        <h2>Registrasi Pengguna</h2>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>


        <form method="POST" action="<?= site_url('register/create'); ?>">
            <div class="form-group">
                <label for="nomor_induk">Nomor Induk</label>
                <input type="text" name="nomor_induk" id="nomor_induk" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="prodi">Program Studi</label>
                <select name="prodi" id="prodi" class="form-control">
                    <option value="">-- Pilih Program Studi --</option>
                    <?php foreach ($prodi as $p): ?>
                        <option value="<?= $p ?>"><?= $p ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="pembimbing_dosen">Dosen</option>
                    <option value="admin">Admin</option>
                    <option value="pembimbing_industri">Pembimbing Industri</option>
                    <option value="panitia">Panitia</option>
                    <option value="kps">KPS</option>
                </select>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var roleSelect = document.getElementById('role');
                    var prodiSelect = document.getElementById('prodi');

                    function toggleProdiRequired() {
                        if (roleSelect.value === 'mahasiswa') {
                            prodiSelect.setAttribute('required', 'required');
                        } else {
                            prodiSelect.removeAttribute('required');
                        }
                    }

                    roleSelect.addEventListener('change', toggleProdiRequired);
                    toggleProdiRequired();
                });
            </script>
            <button type="submit" class="btn btn-primary">Registrasi</button>
        </form>
        <p class="mt-3">Sudah punya akun? <a href="<?= site_url('login'); ?>">Login di sini</a>.</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?= $this->endSection(); ?>