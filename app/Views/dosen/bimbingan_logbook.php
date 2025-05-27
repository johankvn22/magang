    <?php
    /** @var \CodeIgniter\View\View $this */
    ?>
    <?= $this->extend('layouts/template_dosen'); ?>
    <?= $this->section('content'); ?>

    <div class="container mt-4">
        <h2 class="mb-4">Detail Logbook Bimbingan Mahasiswa</h2>

        <h4>Informasi Mahasiswa</h4>
        <table class="table table-bordered mb-4">
            <tr>
                <th>Nama Lengkap</th>
                <td><?= esc($mahasiswa['nama_lengkap']) ?></td>
            </tr>
            <tr>
                <th>NIM</th>
                <td><?= esc($mahasiswa['nim']) ?></td>
            </tr>
            <tr>
                <th>Program Studi</th>
                <td><?= esc($mahasiswa['program_studi']) ?></td>
            </tr>
            <tr>
                <th>Kelas</th>
                <td><?= esc($mahasiswa['kelas']) ?></td>
            </tr>
            <tr>
                <th>No. HP</th>
                <td><?= esc($mahasiswa['no_hp']) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= esc($mahasiswa['email']) ?></td>
            </tr>
            <tr>
                <th>Perusahaan</th>
                <td><?= esc($mahasiswa['nama_perusahaan']) ?></td>
            </tr>
            <tr>
                <th>Divisi</th>
                <td><?= esc($mahasiswa['divisi']) ?></td>
            </tr>
            <tr>
                <th>Tanggal Magang</th>
                <td><?= esc($mahasiswa['tanggal_mulai']) ?> s/d <?= esc($mahasiswa['tanggal_selesai']) ?></td>
            </tr>
            <tr>
                <th>Judul Magang</th>
                <td><?= esc($mahasiswa['judul_magang']) ?></td>
            </tr>
        </table>

        <?php
        $logbookLayakDinilai = array_filter($logbooks, fn($log) => isset($log['status_validasi']) && $log['status_validasi'] === 'disetujui');
        $jumlahDisetujui = count($logbookLayakDinilai);
        ?>
        
        <p><strong>Logbook Disetujui:</strong> <?= $jumlahDisetujui ?> / <?= count($logbooks) ?></p>

        <?php if (!empty($logbooks)) : ?>
            <table class="table table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Catatan Dosen</th>
                        <th>Dokumen</th>
                        <th>Link Drive</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logbooks as $log): ?>
                        <tr>
                            <td><?= esc($log['tanggal']) ?></td>
                            <td><?= esc($log['aktivitas']) ?></td>
                            <td>
                                <?php if ($log['status_validasi'] === 'menunggu') : ?>
                                    <form action="<?= site_url('dosen/update_catatan/' . $log['logbook_id']) ?>" method="post">
                                        <textarea name="catatan_dosen" class="form-control form-control-sm" rows="2" required><?= esc($log['catatan_dosen']) ?></textarea>
                                        <button type="submit" class="btn btn-primary btn-sm mt-1">Simpan</button>
                                    </form>
                                <?php else : ?>
                                    <?= esc($log['catatan_dosen']) ?: '<em>Belum ada catatan</em>' ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($log['file_dokumen'])): ?>
                                    <a href="<?= site_url('dosen/download-logbook/' . $log['file_dokumen']) ?>" class="btn btn-sm btn-outline-primary">Download</a>
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada file</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($log['link_drive'])): ?>
                                    <a href="<?= esc($log['link_drive']) ?>" target="_blank" class="btn btn-sm btn-outline-success">Buka Link</a>
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada link</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($log['status_validasi'] === 'menunggu') : ?>
                                    <form action="<?= site_url('dosen/bimbingan/setujui/' . $log['logbook_id']) ?>" method="post" style="display:inline;">
                                        <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                    </form>
                                    <form action="<?= site_url('dosen/bimbingan/tolak/' . $log['logbook_id']) ?>" method="post" style="display:inline;">
                                        <button type="submit" class="btn btn-warning btn-sm">Tolak</button>
                                    </form>
                                <?php elseif ($log['status_validasi'] === 'disetujui') : ?>
                                    <span class="badge bg-success">Disetujui</span>
                                <?php elseif ($log['status_validasi'] === 'ditolak') : ?>
                                    <span class="badge bg-danger">Ditolak</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="alert alert-info">Belum ada logbook yang diinput oleh mahasiswa.</div>
        <?php endif; ?>

        <?php if (!$penilaian_sudah_ada && $jumlahDisetujui >= 6 && !empty($bimbingan_id)) : ?>
            <a href="<?= site_url('dosen/penilaian-dosen/form/' . $bimbingan_id) ?>" class="btn btn-primary mt-3">
                Beri Penilaian
            </a>
        <?php elseif ($penilaian_sudah_ada) : ?>
            <a href="<?= site_url('dosen/penilaian-dosen/nilai/' . $bimbingan_id) ?>" class="btn btn-secondary mt-3">
                Lihat Penilaian
            </a>
        <?php else : ?>
            <div class="alert alert-warning mt-3">  
                Mahasiswa belum memenuhi syarat penilaian atau data bimbingan tidak ditemukan.
            </div>
        <?php endif; ?>

        <a href="<?= site_url('dosen/bimbingan') ?>" class="btn btn-outline-secondary mt-3">Kembali</a>
    </div>

    <?= $this->endSection(); ?>
