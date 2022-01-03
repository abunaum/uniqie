<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('layanan', 'Home::layanan');
$routes->get('privasi', 'Home::privasi');
$routes->get('saran', 'Home::saran');
$routes->get('logo', 'Home::logo');

$routes->post('authgoogle', 'Gauth::index');
$routes->get('authuser', 'Gauth::authuser');
$routes->get('logout', 'Gauth::logout');

$routes->post('checkout', 'User::checkout');

$routes->group('user', function ($routes) {
    $routes->post('transaksi', 'User::transaksi');
    $routes->get('transaksi', 'User::transaksi_list');
    $routes->get('transaksi/detail/(:any)', 'User::detailtrans/$1');
});
$routes->group('admin', function ($routes) {
    $routes->get('/', 'Admin::index');

    $routes->get('payment', 'Admin::payment');
    $routes->post('edit_payment', 'AdminProses::edit_payment');
    $routes->get('channel', 'Admin::channel');

    $routes->get('kategori', 'Admin::kategori');
    $routes->post('tambah_kategori', 'AdminProses::tambah_kategori');
    $routes->post('edit_kategori/(:num)', 'AdminProses::edit_kategori/$1');
    $routes->delete('kategori/(:num)', 'AdminProses::hapus_kategori/$1');

    $routes->get('produk', 'Admin::produk');
    $routes->post('tambah_produk', 'AdminProses::tambah_produk');
    $routes->post('edit_produk/(:num)', 'AdminProses::edit_produk/$1');
    $routes->delete('produk/(:num)', 'AdminProses::hapus_produk/$1');

    $routes->get('transaksi-berlangsung', 'Admin::transaksi_open');
    $routes->get('transaksi', 'Admin::transaksi');
    $routes->get('transaksi/(:any)', 'Admin::transaksi_detail/$1');

    $routes->get('smtp', 'Admin::smtp');
    $routes->post('tambah_smtp', 'AdminProses::tambah_smtp');
    $routes->post('edit_smtp/(:num)', 'AdminProses::edit_smtp/$1');
    $routes->delete('smtp/(:num)', 'AdminProses::hapus_smtp/$1');
});

$routes->group('api', function ($routes) {
    $routes->post('cekapipayment', 'Api::api');
    $routes->post('syncchannel', 'Api::syncchannel');
    $routes->post('onoffchannel', 'Api::onoffchannel');
});
$routes->group('test', function ($routes) {
    $routes->post('callback', 'Callback::index');
    $routes->get('tester', 'Callback::tester');
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
