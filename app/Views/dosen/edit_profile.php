<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_dosen'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Card for Edit Profile -->
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Edit Profil Dosen Pembimbing</h4>
                </div>

                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                
                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?= form_open('dosen/updateProfile'); ?>
                        <div class="form-group mt-3">
                            <label for="nama_lengkap" class="font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama" 
                                   value="<?= esc($dosen['nama_lengkap']) ?>" required>
                        </div>

                        <div class="form-row mt-3">
                            <div class="form-group col-md-6">
                                <label for="nip" class="font-weight-bold">NIP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nip" name="nip" 
                                       value="<?= esc($dosen['nip']) ?>" required>
                            </div>
                            
                            <div class="form-group col-md-6 mt-3">
                                <label for="no_telepon" class="font-weight-bold">No Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" 
                                       value="<?= esc($dosen['no_telepon']) ?>" required>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="email" class="font-weight-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= esc($dosen['email']) ?>" required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="link_whatsapp" class="font-weight-bold">Link Grup Bimbingan WhatsApp</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                </div>
                                <input type="url" class="form-control" id="link_whatsapp" name="link_whatsapp" 
                                       placeholder="https://wa.me/" 
                                       value="<?= esc($dosen['link_whatsapp']) ?>">
                            </div>

                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save mr-2"></i>Simpan Perubahan
                            </button>
                            <a href="<?= site_url('dosen/'); ?>" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                        </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>