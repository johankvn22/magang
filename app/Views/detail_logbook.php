<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_admin'); ?>
<?= $this->section('content'); ?>
    

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Materi Bimbingan</th>
                    <th>Catatan Dosen</th>
                    <th>Status Validasi</th>


                </tr>
            </thead>
            <tbody>
                <?php foreach ($logbook as $entry): ?>
                    <tr>
                        <td><?= esc($entry['tanggal']) ?></td>
                        <td><?= esc($entry['aktivitas']) ?></td>
                        <td><?= esc($entry['catatan_dosen']) ?: 'Belum Ada Catatan dari Dosen' ?></td>
                        <td><?= esc($entry['status_validasi']) ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?= $this->endSection(); ?>