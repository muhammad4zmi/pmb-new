<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Pages::index');
$routes->get('/admin/dasboard', 'Admin::index', ['filter' => 'user']);
$routes->get('/admin/dasboard/profil', 'Admin::profil', ['filter' => 'user']);
$routes->get('/admin/pendaftar', 'Pendaftar::index', ['filter' => 'user']);
$routes->get('/admin/gelombang', 'Gelombang::index', ['filter' => 'user']);
$routes->get('/admin/gelombang/create', 'Gelombang::create', ['filter' => 'user']);
$routes->get('/admin/pendaftar', 'Pendaftar::index', ['filter' => 'user']);
$routes->get('/admin/pendaftar/export', 'Pendaftar::export', ['filter' => 'user']);
$routes->get('/admin/berkas', 'Berkas::index', ['filter' => 'user']);

$routes->get('/admin/pendaftar/detail/(:segment)', 'Pendaftar::detail/$1', ['filter' => 'user']);
$routes->get('/admin/prodi', 'Prodi::index', ['filter' => 'user']);
$routes->get('/admin/prodi/update', 'Prodi::update', ['filter' => 'user']);
$routes->get('/admin/pendaftar/cetakformulir/(:segment)', 'Pendaftar::cetakformulir/$1', ['filter' => 'user']);
$routes->get('/user/dasboard', 'User::index', ['filter' => 'user']);
$routes->get('/user/dasboard/profil', 'User::profil', ['filter' => 'user']);
$routes->get('/user/identitas', 'Identitas::index', ['filter' => 'user']);
$routes->get('/user/formulir/cetakformulir/(:segment)', 'Formulir::cetakformulir/$1', ['filter' => 'user']);
$routes->get('/user/identitas/edit/(:segment)', 'Identitas::edit/$1', ['filter' => 'user']);
$routes->get('/user/dasboard/editprofil', 'User::editprofil', ['filter' => 'user']);
$routes->get('/user/identitas/ortu', 'Identitas::ortu', ['filter' => 'user']);
$routes->get('/user/identitas/edit_ortu/(:segment)', 'Identitas::edit_ortu/$1', ['filter' => 'user']);
$routes->get('/user/upload', 'User::upload', ['filter' => 'user']);
//$routes->get('/user/dasboard/edit/(:segment)', 'Identitas::edit/$1', ['filter' => 'user']);

$routes->get('/admin/pengaturan/', 'Pengaturan::index', ['filter' => 'user']);
$routes->get('/admin/informasi/create', 'Informasi::create', ['filter' => 'user']);
$routes->get('/admin/informasi/', 'Informasi::index', ['filter' => 'user']);
$routes->get('/admin/menu/', 'Menu::index', ['filter' => 'user']);
$routes->delete('/admin/menu/(:num)', 'Menu::delete/$1', ['filter' => 'user']);
$routes->get('/admin/menu/submenu', 'Menu::submenu', ['filter' => 'user']);
$routes->delete('/admin/menu/submenu/(:num)', 'Menu::delete_submenu/$1', ['filter' => 'user']);
$routes->delete('/admin/informasi/(:num)', 'Informasi::delete/$1', ['filter' => 'user']);
$routes->delete('/admin/gelombang/(:num)', 'Gelombang::delete/$1', ['filter' => 'user']);
$routes->get('/admin/informasi/edit/(:segment)', 'Informasi::edit/$1', ['filter' => 'user']);
$routes->get('/admin/berkas/verifikasi/(:segment)', 'Berkas::verifikasi/$1', ['filter' => 'user']);
$routes->get('/admin/berkas/reject/(:segment)', 'Berkas::reject/$1', ['filter' => 'user']);
$routes->get('/admin/gelombang/edit/(:segment)', 'Gelombang::edit/$1', ['filter' => 'user']);

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
