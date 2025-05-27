<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/Admin', 'Admin::about');
$routes->get('/', 'Home::index');
$routes->get('/register', 'AuthController::register'); // Menampilkan halaman registrasi
$routes->post('/register/create', 'AuthController::create'); // Memproses pendaftaran baru
$routes->get('/login', 'AuthController::index'); // Menampilkan halaman login
$routes->post('/login', 'AuthController::login'); // Memproses login

$routes->get('/admin', 'AdminController::index', ['filter' => 'auth']); // Menampilkan dashboard admin

$routes->get('/admin/daftarmahasiswa', 'MahasiswaController::index'); // Rute untuk daftar mahasiswa
$routes->get('/logout', 'AuthController::logout'); // Menangani logout

$routes->get('/admin/logbook', 'AdminLogbookController::index'); // Menampilkan logbook mahasiswa
$routes->get('/admin/logbook/(:num)', 'AdminLogbookController::detail/$1');

$routes->get('/admin/tambah-bimbingan', 'AdminController::tambahBimbingan'); // Menampilkan form untuk menambahkan bimbingan
$routes->post('/admin/save-bimbingan', 'AdminController::saveBimbingan');

$routes->get('/admin/bimbingan-industri', 'AdminController::tambahBimbinganIndustri'); //atur bimbingan industri
$routes->post('/admin/bimbingan-industri/save', 'AdminController::saveBimbinganIndustri'); // Menyimpan bimbingan industri

$routes->get('admin/daftar_user', 'AdminController::daftarUser'); // Menampilkan daftar user
$routes->post('/admin/deleteUser/(:num)', 'AdminController::deleteUser/$1');

$routes->get('/admin/nilai-mahasiswa', 'AdminPenilaianController::index');
$routes->get('/admin/nilai-mahasiswa/(:num)', 'AdminPenilaianController::detail/$1');

$routes->get('/admin/aktivitas', 'AdminLogbookController::aktivitas'); // Menampilkan logbook aktivitas mahasiswa
$routes->get('admin/aktivitas/(:num)', 'AdminLogbookController::detailAktivitas/$1');
$routes->get('admin/daftar_mahasiswa', 'AdminController::daftarMahasiswa');

$routes->get('/admin/user-requirement', 'AdminLogbookController::userRequirement');
$routes->get('/admin/user-requirement/detail/(:num)', 'AdminLogbookController::detailUserRequirement/$1');

$routes->get('/admin/review-kinerja', 'AdminLogbookController::listreview');
$routes->get('/admin/review-kinerja/detail/(:num)', 'AdminLogbookController::detailReview/$1');
$routes->get('/admin/nilai', 'AdminController::listNilaiMahasiswa');

$routes->get('admin/nilai/detail/(:num)', 'AdminController::detail_nilai/$1');






$routes->group('mahasiswa', function ($routes) {
    $routes->get('dashboard', 'MahasiswaController::index');

    // Logbook Bimbingan Mahasiswa
    $routes->get('logbook', 'LogbookController::index');
    $routes->post('logbook/create', 'LogbookController::create');
    $routes->get('logbook/edit/(:num)', 'LogbookController::edit/$1');
    $routes->post('logbook/update/(:num)', 'LogbookController::update/$1');
    $routes->get('logbook/delete/(:num)', 'LogbookController::delete/$1');
    $routes->get('logbook/download/(:any)', 'LogbookController::downloadLogbookFile/$1');


    // Logbook Aktivitas Industri Mahasiswa
    $routes->get('logbook_industri', 'LogbookIndustriController::index');
    $routes->post('logbook_industri/create', 'LogbookIndustriController::create');
    $routes->get('logbook_industri/edit/(:num)', 'LogbookIndustriController::edit/$1');
    $routes->post('logbook_industri/update/(:num)', 'LogbookIndustriController::update/$1');
    $routes->get('logbook_industri/delete/(:num)', 'LogbookIndustriController::delete/$1');

    // User Requirement
    $routes->get('user-requirement', 'UserRequirementController::index');
    $routes->post('user-requirement/create', 'UserRequirementController::create');
    $routes->get('user-requirement/edit/(:num)', 'UserRequirementController::edit/$1');
    $routes->post('user-requirement/update/(:num)', 'UserRequirementController::update/$1');
    $routes->post('user-requirement/delete/(:num)', 'UserRequirementController::delete/$1');

    // Profile dan Ganti Password
    $routes->get('edit', 'MahasiswaController::edit'); // memanggil halaman edit
    $routes->post('update', 'MahasiswaController::update'); // menyimpan data mahasiswa
    $routes->get('ganti-password', 'MahasiswaController::ganti_password');

    // // Upload Laporan
    // $routes->post('upload', 'MahasiswaController::upload');
});

$routes->group('dosen', ['filter' => 'auth'], function ($routes) {
    // Rute untuk Pembimbing Dosen
    $routes->get('/', 'DosenPembimbingController::index'); // /dosen
    $routes->get('editProfile', 'DosenPembimbingController::editProfile'); // /dosen/editProfile
    $routes->post('updateProfile', 'DosenPembimbingController::updateProfile');
    $routes->get('changePassword', 'DosenPembimbingController::changePassword');
    $routes->post('update-password', 'DosenPembimbingController::updatePassword');
    // $routes->get('mahasiswa-bimbingan', 'DosenPembimbingController::daftarMahasiswaBimbingan');

    // Rute Bimbingan Logbook Mahasiswa
    $routes->get('bimbingan', 'BimbinganController::index');
    $routes->get('bimbingan/detail/(:num)', 'BimbinganController::detail/$1');
    $routes->get('download-logbook/(:any)', 'BimbinganController::downloadLogbookFile/$1');


    // Rute untuk Penilaian Dosen
    // $routes->get('penilaian-dosen', 'PenilaianDosenController::index');
    $routes->get('penilaian-dosen/form/(:num)', 'PenilaianDosenController::showForm/$1');

    $routes->post('penilaian-dosen/save', 'PenilaianDosenController::save');

    $routes->get('penilaian-dosen/detail/(:num)', 'PenilaianDosenController::showNilai/$1');
    $routes->get('penilaian-dosen/listNilai', 'PenilaianDosenController::listNilai');

    // Rute untuk Validasi Logbook Mahasiswa
    $routes->post('bimbingan/setujui/(:num)', 'BimbinganController::setujui/$1');
    $routes->post('bimbingan/tolak/(:num)', 'BimbinganController::tolak/$1');
    $routes->post('bimbingan/hapus/(:num)', 'BimbinganController::hapus/$1');
    $routes->post('update_catatan/(:num)', 'BimbinganController::update_catatan/$1');


    $routes->get('aktivitas', 'BimbinganController::aktivitasMahasiswaBimbingan');
    $routes->get('logbook/(:num)', 'BimbinganController::detailAktivitasMahasiswa/$1');

    // Rute untuk User Requirement
    $routes->get('user-requirement', 'UserRequirementDosenController::index');
    $routes->get('user-requirement/detail/(:num)', 'UserRequirementDosenController::detail/$1');
});

$routes->get('/admin/form-tambah-akun', 'Admin::formTambahAkun');
$routes->get('/upload-excel', 'UploadExcelController::index');
$routes->post('/upload-excel', 'UploadExcelController::upload');
$routes->get('/upload-user-excel', 'UploadUserController::index');
$routes->post('/upload-user-excel', 'UploadUserController::upload');



$routes->group('kps', ['filter' => 'kpsauth'], function ($routes) {
    $routes->get('dashboard', 'KpsController::dashboard');
    // $routes->get('profil', 'KpsController::profil');

    $routes->get('editProfile', 'KpsController::editProfile');
    $routes->post('updateProfile', 'KpsController::updateProfile');

    $routes->match(['GET', 'POST'], 'gantiPassword', 'KpsController::gantiPassword');
    $routes->get('logout', 'KpsController::logout');
    
    $routes->get('daftar-dosen', 'KpsController::daftarDosen');
    $routes->post('update-dosen', 'KpsController::updateDosen');

    $routes->get('daftar_mahasiswa', 'KpsController::daftarMahasiswa');

    $routes->get('logbook', 'KpsController::logbookMahasiswa');
    $routes->get('logbook/(:num)', 'KpsController::detailLogbook/$1');
    $routes->get('logbook-aktivitas', 'KpsController::logbookAktivitas');
    $routes->get('logbook-aktivitas/(:num)', 'KpsController::detailAktivitas/$1');

    $routes->get('user-requirement', 'KpsController::userRequirement');
    $routes->get('user-requirement/detail/(:num)', 'KpsController::detail/$1');

    $routes->get('review-kinerja', 'KpsController::listReview');
    $routes->get('review-kinerja/detail/(:num)', 'KpsController::detailReview/$1');

    $routes->get('list_nilai_mahasiswa', 'KpsController::listNilaiMahasiswa');
});

$routes->group('panitia', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'PanitiaController::index');
    $routes->get('edit_profil', 'PanitiaController::editProfil');
    $routes->post('updateProfil', 'PanitiaController::updateProfil');
    $routes->post('gantiPassword', 'PanitiaController::gantiPassword');
    $routes->match(['get', 'post'], 'panitia/ganti_password', 'PanitiaController::gantiPassword');


    // Tambahan berdasarkan view dashboard.php:
    $routes->get('daftar_mahasiswa', 'PanitiaController::daftarMahasiswa');
    $routes->get('logbook-mahasiswa', 'PanitiaController::logbookMahasiswa');
    $routes->get('detail-logbook/(:num)', 'PanitiaController::detailLogbook/$1');
    $routes->get('logbook-aktivitas', 'PanitiaController::logbookAktivitas');
    $routes->get('detail-aktivitas/(:num)', 'PanitiaController::detailAktivitas/$1');

    $routes->get('daftar-dosen', 'PanitiaController::daftarDosen');
    $routes->post('update-dosen', 'PanitiaController::updateDosen');


    $routes->get('kuisioner', 'PanitiaController::kuisionerIndustri');
    $routes->get('bagikan-bimbingan', 'PanitiaController::bagikanBimbingan');
    $routes->get('daftar-dosen', 'PanitiaController::daftarDosen');
    $routes->match(['get', 'post'], 'ganti_password', 'PanitiaController::gantiPassword');

    $routes->get('user-requirement', 'PanitiaController::userRequirement');
    $routes->get('user-requirement/detail/(:num)', 'PanitiaController::detail/$1');

    $routes->get('review-kinerja', 'PanitiaController::listReview');
    $routes->get('review-kinerja/detail/(:num)', 'PanitiaController::detailReview/$1');

    $routes->get('list_nilai_mahasiswa', 'PanitiaController::listNilaiMahasiswa');

    // Rute untuk atur pembimbingan industri


});

// ROUTE UNTUK INDUSTRI
$routes->group('industri', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'PembimbingIndustriController::dashboard');

    // 🔧 Edit Profil
    $routes->get('edit-profil', 'PembimbingIndustriController::editProfil');
    $routes->post('update-profil', 'PembimbingIndustriController::updateProfil');

    // 🔒 Ganti Password
    $routes->get('ganti-password', 'PembimbingIndustriController::gantiPassword');
    $routes->post('simpan-password', 'PembimbingIndustriController::simpanPassword');

    // Bimbingan Industri
    $routes->get('bimbingan', 'BimbinganIndustriController::index');
    $routes->get('bimbingan/detail/(:num)', 'BimbinganIndustriController::detail/$1');
    $routes->post('bimbingan/update-catatan/(:num)', 'BimbinganIndustriController::updateCatatanIndustri/$1');


    $routes->post('bimbingan/setujui/(:num)', 'BimbinganIndustriController::setujui/$1');
    $routes->post('bimbingan/tolak/(:num)', 'BimbinganIndustriController::tolak/$1');

    // nilai industri
    $routes->get('penilaian-industri/(:num)', 'PenilaianIndustri::create/$1');
    $routes->post('penilaianindustri/store', 'PenilaianIndustri::store');

    $routes->get('list-nilai', 'PenilaianIndustri::listNilaiMahasiswa');
    $routes->get('penilaianindustri', 'PenilaianIndustri::index');
    $routes->get('penilaian-industri/detail/(:num)', 'PenilaianIndustri::detail/$1');

    // review kinerja
    $routes->get('review-kinerja/berikan/(:num)', 'ReviewKinerjaController::berikanNilai/$1');
    $routes->post('review-kinerja/simpanNilai', 'ReviewKinerjaController::simpanNilai');

    $routes->get('review-kinerja/daftar', 'ReviewKinerjaController::listReview');
    $routes->get('review-kinerja/detail/(:num)', 'ReviewKinerjaController::detailReview/$1');

    // User Requirement
    $routes->get('user-requirement', 'UserRequirementIndustriController::index');
    $routes->get('user-requirement/detail/(:num)', 'UserRequirementIndustriController::detail/$1');
    $routes->post('user-requirement/setujui/(:num)', 'UserRequirementIndustriController::setujui/$1');
    $routes->post('user-requirement/tolak/(:num)', 'UserRequirementIndustriController::tolak/$1');
});
