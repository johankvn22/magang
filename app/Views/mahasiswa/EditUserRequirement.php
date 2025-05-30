<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_mahasiswa'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-success mb-0">
                    <i class="fas fa-edit me-2"></i>Edit User Requirement
                </h2>
            </div>

            <!-- Edit Form -->
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-success text-white rounded-top-3">
                    <h5 class="mb-0">Perbarui User Requirement</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= site_url('mahasiswa/user-requirement/update/' . $requirement['requirement_id']) ?>">
                        <?= csrf_field() ?>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" 
                                       value="<?= esc($requirement['tanggal']) ?>" 
                                       max="<?= date('Y-m-d') ?>" required>
                            </div>
                            
                            <div class="col-12">
                                <label for="dikerjakan" class="form-label">Modul/Unit yang Dikerjakan</label>
                                <textarea name="dikerjakan" class="form-control" rows="4"
                                          placeholder="Deskripsikan modul atau unit yang dikerjakan" required><?= esc($requirement['dikerjakan']) ?></textarea>
                            </div>
                            
                            <div class="col-12">
                                <label for="user_requirement" class="form-label">User Requirement / Spesifikasi</label>
                                <textarea name="user_requirement" class="form-control" rows="4"
                                          placeholder="Tuliskan spesifikasi atau requirement dari modul/unit tersebut"><?= esc($requirement['user_requirement']) ?></textarea>
                            </div>
                            
                            <div class="col-12 text-end mt-3">
                                <button type="submit" class="btn btn-success px-4 me-2">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                                <a href="<?= site_url('mahasiswa/user-requirement') ?>" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>