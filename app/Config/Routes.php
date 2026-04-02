<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('login', 'Auth::login');
$routes->post('login/process', 'Auth::loginProcess');

$routes->get('register', 'Auth::register');
$routes->post('register/process', 'Auth::registerProcess');

$routes->get('logout', 'Auth::logout');

$routes->get('dashboard', 'Dashboard::index');

// Routes untuk master Akun
$routes->get('/akun1', "Akun1Controller::index");
$routes->get('/akun1/create', "Akun1Controller::create");
$routes->post('/akun1/store', "Akun1Controller::store");
$routes->get('/akun1/edit/(:num)', "Akun1Controller::edit/$1");
$routes->post('/akun1/update/(:num)', "Akun1Controller::update/$1");
$routes->get('/akun1/delete/(:num)', 'Akun1Controller::delete/$1');

$routes->get('/akun2', "Akun2Controller::index");
$routes->get('/akun2/create', "Akun2Controller::create");
$routes->post('/akun2/store', "Akun2Controller::store");
$routes->get('/akun2/edit/(:num)', "Akun2Controller::edit/$1");
$routes->post('/akun2/update/(:num)', "Akun2Controller::update/$1");
$routes->get('/akun2/delete/(:num)', 'Akun2Controller::delete/$1');

$routes->get('/akun3', "Akun3Controller::index");
$routes->get('/akun3/create', "Akun3Controller::create");
$routes->post('/akun3/store', "Akun3Controller::store");
$routes->get('/akun3/edit/(:num)', "Akun3Controller::edit/$1");
$routes->post('/akun3/update/(:num)', "Akun3Controller::update/$1");
$routes->get('/akun3/delete/(:num)', 'Akun3Controller::delete/$1');


// Routes untuk Transaksi Umum
$routes->get('/transaksi-umum', 'TransaksiUmumController::index');

$routes->get('/transaksi-umum/create', 'TransaksiUmumController::create');
$routes->post('/transaksi-umum/store', 'TransaksiUmumController::store');

$routes->get('/transaksi-umum/edit/(:num)', 'TransaksiUmumController::edit/$1');
$routes->post('/transaksi-umum/update/(:num)', 'TransaksiUmumController::update/$1');

$routes->get('/transaksi-umum/detail/(:num)', 'TransaksiUmumController::detail/$1');
$routes->get('/transaksi-umum/delete/(:num)', 'TransaksiUmumController::delete/$1');


// Routes untuk Transaksi Penyesuaian
$routes->get('/transaksi-penyesuaian', 'TransaksiPenyesuaianController::index');
$routes->get('/transaksi-penyesuaian/create', 'TransaksiPenyesuaianController::create');
$routes->post('/transaksi-penyesuaian/store', 'TransaksiPenyesuaianController::store');
$routes->get('/transaksi-penyesuaian/edit/(:num)', 'TransaksiPenyesuaianController::edit/$1');
$routes->post('/transaksi-penyesuaian/update/(:num)', 'TransaksiPenyesuaianController::update/$1');
$routes->get('/transaksi-penyesuaian/detail/(:num)', 'TransaksiPenyesuaianController::detail/$1');
$routes->get('/transaksi-penyesuaian/delete/(:num)', 'TransaksiPenyesuaianController::delete/$1');

// Routes untuk Jurnal Umum
$routes->get('/jurnal-umum', 'JurnalUmumController::index');
$routes->get('/jurnal-umum/cetak-pdf', 'JurnalUmumController::cetakPdf');

// Routes untuk Jurnal Penyesuaian
$routes->get('/jurnal-penyesuaian', 'JurnalPenyesuaianController::index');
$routes->get('/jurnal-penyesuaian/cetak-pdf', 'JurnalPenyesuaianController::cetakPdf');

// Routes untuk Buku Besar
$routes->get('/buku-besar', 'BukuBesarController::index');
$routes->get('/buku-besar/cetak-pdf', 'BukuBesarController::cetakPdf');

// Routes untuk Neraca Saldo
$routes->get('/neraca-saldo', 'NeracaSaldoController::index');
$routes->get('/neraca-saldo/cetak-pdf', 'NeracaSaldoController::cetakPdf');

// Routes untuk Neraca Saldo Disesuaikan
$routes->get('/neraca-saldo-disesuaikan', 'NeracaSaldoDisesuaikanController::index');
$routes->get('/neraca-saldo-disesuaikan/cetak-pdf', 'NeracaSaldoDisesuaikanController::cetakPdf');

// Routes untuk Laporan Posisi Keuangan
$routes->get('/laporan-posisi-keuangan', 'LaporanPosisiKeuanganController::index');
$routes->get('/laporan-posisi-keuangan/cetak-pdf', 'LaporanPosisiKeuanganController::cetakPdf');

// Routes untuk Laporan Penghasilan Komprehensif
$routes->get('/laporan-komprehensif', 'LaporanKomprehensifController::index');
$routes->get('/laporan-komprehensif/cetak-pdf', 'LaporanKomprehensifController::cetakPdf');

// Routes untuk Laporan Perubahan Aset Neto
$routes->get('/laporan-perubahan-aset-neto', 'LaporanPerubahanAsetNetoController::index');
$routes->get('/laporan-perubahan-aset-neto/cetak-pdf', 'LaporanPerubahanAsetNetoController::cetakPdf');

// Routes untuk Laporan Arus Kas
$routes->get('/laporan-arus-kas', 'LaporanArusKasController::index');
$routes->get('/laporan-arus-kas/cetak-pdf', 'LaporanArusKasController::cetakPdf');

