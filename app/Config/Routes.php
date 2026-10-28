<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Admin::main');
$routes->get('/dashboard', 'Admin::dashboard');
$routes->get('/dashboard-siswa', 'Admin::dashboard_siswa');
$routes->get('/siswa/keuangan', 'Admin::siswa_rincian_keuangan');
$routes->get('/rincian-keuangan-siswa', 'Admin::detail_keuangan_siswa');
$routes->get('/keuangan_siswa', 'Admin::keuangan_siswa');
$routes->get('/rekap', 'Admin::rekap');
$routes->get('/pendaftaran', 'Admin::pendaftaran');
$routes->get('/peralatan', 'Admin::peralatan');
$routes->get('/uis_uim', 'Admin::uis_uim');
$routes->get('/spp', 'Admin::spp');
$routes->get('/dpp', 'Admin::dpp');
$routes->get('/kegiatan', 'Admin::kegiatan');
$routes->get('/lks', 'Admin::lks');
$routes->get('/seragam_tas', 'Admin::seragam_tas');
$routes->get('/gaji-guru', 'Admin::gaji_guru');
$routes->get('/gaji-guru/simpan', 'Admin::simpan_guru'); // Make sure both post and get might be needed or just post
$routes->post('/gaji-guru/simpan', 'Admin::simpan_guru');
$routes->post('/gaji-guru/update', 'Admin::update_guru');
$routes->get('/gaji-guru/hapus/(:num)', 'Admin::hapus_guru/$1');
$routes->get('/gaji-guru/cetak', 'Admin::cetak_gaji_guru');

$routes->get('/slip-gaji', 'Admin::slip_gaji');
$routes->get('/cetak-slip', 'Admin::cetak_slip');
$routes->get('/data-siswa', 'Admin::data_siswa');

// Data Siswa
$routes->post('/siswa/tambah', 'Admin::tambah_siswa');
$routes->get('siswa/hapus/(:num)', 'Admin::hapus_data_siswa/$1');
$routes->get('siswa/edit/(:num)', 'Admin::edit_data_siswa/$1');
$routes->post('/siswa/update', 'Admin::update_siswa');
$routes->get('/siswa/export', 'Admin::export_siswa');
$routes->post('/siswa/import', 'Admin::import_siswa');
$routes->post('/siswa/notifikasi/kirim', 'Admin::kirim_notifikasi');
$routes->post('/siswa/notifikasi/read/(:num)', 'Admin::mark_notification_read/$1');
$routes->post('/siswa/notifikasi/delete/(:num)', 'Admin::delete_notification/$1');
$routes->get('/siswa/notifikasi/get', 'Admin::get_notifications_json');

// Pendaftaran
$routes->post('/pendaftaran/simpan', 'Admin::simpan_pendaftaran');
$routes->post('/pendaftaran/import', 'Admin::import_pendaftaran'); // Added
$routes->get('pendaftaran/edit/(:num)', 'Admin::edit_pendaftaran/$1');
$routes->post('pendaftaran/update/(:num)', 'Admin::update_pendaftaran/$1');
$routes->post('pendaftaran/delete/(:num)', 'Admin::delete_pendaftaran/$1');

// UIS / UIM
$routes->post('/uis_uim/simpan', 'Admin::simpan_uis_uim');
$routes->post('/uis_uim/import', 'Admin::import_uis_uim'); // Added
$routes->get('uis_uim/edit/(:num)', 'Admin::edit_uis_uim/$1');
$routes->post('uis_uim/update/(:num)', 'Admin::update_uis_uim/$1');
$routes->post('uis_uim/delete/(:num)', 'Admin::delete_uis_uim/$1');

// PERALATAN
$routes->post('/peralatan/simpan', 'Admin::simpan_peralatan');
$routes->post('/peralatan/import', 'Admin::import_peralatan'); // Added
$routes->get('peralatan/edit/(:num)', 'Admin::edit_peralatan/$1');
$routes->post('peralatan/update/(:num)', 'Admin::update_peralatan/$1');
$routes->post('peralatan/delete/(:num)', 'Admin::delete_peralatan/$1');

// LKS
$routes->post('/lks/simpan', 'Admin::simpan_lks');
$routes->post('/lks/import', 'Admin::import_lks'); // Added
$routes->get('lks/edit/(:num)', 'Admin::edit_lks/$1');
$routes->post('lks/update/(:num)', 'Admin::update_lks/$1');
$routes->post('lks/delete/(:num)', 'Admin::delete_lks/$1');

// SERAGAM / TAS
$routes->post('/seragam_tas/simpan', 'Admin::simpan_seragam_tas');
$routes->post('/seragam_tas/import', 'Admin::import_seragam_tas'); // Added
$routes->get('seragam_tas/edit/(:num)', 'Admin::edit_seragam_tas/$1');
$routes->post('seragam_tas/update/(:num)', 'Admin::update_seragam_tas/$1');
$routes->post('seragam_tas/delete/(:num)', 'Admin::delete_seragam_tas/$1');

// KEGIATAN
$routes->post('/kegiatan/simpan', 'Admin::simpan_kegiatan');
$routes->post('/kegiatan/import', 'Admin::import_kegiatan'); // Added
$routes->get('kegiatan/edit/(:num)', 'Admin::edit_kegiatan/$1');
$routes->post('kegiatan/update/(:num)', 'Admin::update_kegiatan/$1');
$routes->post('kegiatan/delete/(:num)', 'Admin::delete_kegiatan/$1');

// SPP
$routes->post('/spp/simpan', 'Admin::simpan_spp');
$routes->post('/spp/import', 'Admin::import_spp'); // Added
$routes->get('spp/edit/(:num)', 'Admin::edit_spp/$1');
$routes->post('spp/update/(:num)', 'Admin::update_spp/$1');
$routes->post('spp/delete/(:num)', 'Admin::delete_spp/$1');

// DPP
$routes->post('/dpp/simpan', 'Admin::simpan_dpp');
$routes->post('/dpp/import', 'Admin::import_dpp'); // Added
$routes->get('dpp/edit/(:num)', 'Admin::edit_dpp/$1');
$routes->post('dpp/update/(:num)', 'Admin::update_dpp/$1');
$routes->post('dpp/delete/(:num)', 'Admin::delete_dpp/$1');

// OPERASIONAL
$routes->get('/operasional', 'Admin::operasional');
$routes->post('/operasional/simpan', 'Admin::simpan_operasional');
$routes->post('/operasional/update', 'Admin::update_operasional');
$routes->get('/operasional/hapus/(:num)', 'Admin::hapus_operasional/$1');




// LAPORAN KEUANGAN
// Pendaftaran
$routes->get('/laporan_pendaftaran', 'Admin::laporan_pendaftaran');
$routes->post('/laporan_pendaftaran/simpan', 'Admin::simpan_laporan_pendaftaran');
$routes->get('laporan_pendaftaran/edit/(:num)', 'Admin::edit_laporan_pendaftaran/$1');
$routes->post('laporan_pendaftaran/update/(:num)', 'Admin::update_laporan_pendaftaran/$1');
$routes->post('laporan_pendaftaran/delete/(:num)', 'Admin::delete_laporan_pendaftaran/$1');

// UIS / UIM
$routes->get('/laporan_uis_uim', 'Admin::laporan_uis_uim');
$routes->post('/laporan_uis_uim/simpan', 'Admin::simpan_laporan_uis_uim');
$routes->get('laporan_uis_uim/edit/(:num)', 'Admin::edit_laporan_uis_uim/$1');
$routes->post('laporan_uis_uim/update/(:num)', 'Admin::update_laporan_uis_uim/$1');
$routes->post('laporan_uis_uim/delete/(:num)', 'Admin::delete_laporan_uis_uim/$1');

// Peralatan
$routes->get('/laporan_peralatan', 'Admin::laporan_peralatan');
$routes->post('/laporan_peralatan/simpan', 'Admin::simpan_laporan_peralatan');
$routes->get('laporan_peralatan/edit/(:num)', 'Admin::edit_laporan_peralatan/$1');
$routes->post('laporan_peralatan/update/(:num)', 'Admin::update_laporan_peralatan/$1');
$routes->post('laporan_peralatan/delete/(:num)', 'Admin::delete_laporan_peralatan/$1');

// LKS
$routes->get('/laporan_lks', 'Admin::laporan_lks');
$routes->post('/laporan_lks/simpan', 'Admin::simpan_laporan_lks');
$routes->get('laporan_lks/edit/(:num)', 'Admin::edit_laporan_lks/$1');
$routes->post('laporan_lks/update/(:num)', 'Admin::update_laporan_lks/$1');
$routes->post('laporan_lks/delete/(:num)', 'Admin::delete_laporan_lks/$1');

// Seragam / Tas
$routes->get('/laporan_seragam_tas', 'Admin::laporan_seragam_tas');
$routes->post('/laporan_seragam_tas/simpan', 'Admin::simpan_laporan_seragam_tas');
$routes->get('laporan_seragam_tas/edit/(:num)', 'Admin::edit_laporan_seragam_tas/$1');
$routes->post('laporan_seragam_tas/update/(:num)', 'Admin::update_laporan_seragam_tas/$1');
$routes->post('laporan_seragam_tas/delete/(:num)', 'Admin::delete_laporan_seragam_tas/$1');

// Kegiatan
$routes->get('/laporan_kegiatan', 'Admin::laporan_kegiatan');
$routes->post('/laporan_kegiatan/simpan', 'Admin::simpan_laporan_kegiatan');
$routes->get('laporan_kegiatan/edit/(:num)', 'Admin::edit_laporan_kegiatan/$1');
$routes->post('laporan_kegiatan/update/(:num)', 'Admin::update_laporan_kegiatan/$1');
$routes->post('laporan_kegiatan/delete/(:num)', 'Admin::delete_laporan_kegiatan/$1');

// SPP
$routes->get('/laporan_spp', 'Admin::laporan_spp');
$routes->post('/laporan_spp/simpan', 'Admin::simpan_laporan_spp');
$routes->get('laporan_spp/edit/(:num)', 'Admin::edit_laporan_spp/$1');
$routes->post('laporan_spp/update/(:num)', 'Admin::update_laporan_spp/$1');
$routes->post('laporan_spp/delete/(:num)', 'Admin::delete_laporan_spp/$1');
$routes->get('/spp/cetak', 'Admin::cetak_spp');
$routes->get('/spp/cetak-siswa', 'Admin::cetak_rekap_siswa');

// DPP
$routes->get('/laporan_dpp', 'Admin::laporan_dpp');
$routes->post('/laporan_dpp/simpan', 'Admin::simpan_laporan_dpp');
$routes->get('laporan_dpp/edit/(:num)', 'Admin::edit_laporan_dpp/$1');
$routes->post('laporan_dpp/update/(:num)', 'Admin::update_laporan_dpp/$1');
$routes->post('laporan_dpp/delete/(:num)', 'Admin::delete_laporan_dpp/$1');


// MANAJEMEN ADMIN
$routes->get('/admin/users', 'Admin::kelola_admin');
$routes->post('/admin/users/simpan', 'Admin::simpan_admin');
$routes->post('/admin/users/update/(:num)', 'Admin::update_admin/$1');
$routes->get('/admin/users/hapus/(:num)', 'Admin::hapus_admin/$1');

// Auth Routes
$routes->post('/login', 'Admin::auth_login', ['as' => 'login']);
// $routes->post('/register', 'Admin::auth_register', ['as' => 'register']);
$routes->get('/logout', 'Admin::logout', ['as' => 'logout']);

$routes->get('/rekap/excel', 'Admin::export_rekap_excel');
$routes->get('/rekap/print', 'Admin::export_rekap_print');
$routes->get('/laporan/cetak', 'Admin::cetak_laporan_keuangan');
$routes->get('/laporan/filter', 'Admin::filter_cetak_laporan'); // Added // Added

// $routes->get('/index', 'Admin::index');

// CLI Route for DB Fix (removed)
