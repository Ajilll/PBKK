<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Publik
$routes->get('/', 'Katalog::index');
$routes->get('produk/(:num)', 'Katalog::detail/$1');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->get('daftar', 'Auth::daftar');
$routes->post('daftar', 'Auth::simpanDaftar');
$routes->get('logout', 'Auth::logout');

// Pelanggan
$routes->group('', ['filter' => 'role:pelanggan'], static function ($routes) {
    $routes->get('keranjang', 'Keranjang::index');
    $routes->post('keranjang/tambah/(:num)', 'Keranjang::tambah/$1');
    $routes->post('keranjang/ubah/(:num)', 'Keranjang::ubah/$1');
    $routes->post('keranjang/hapus/(:num)', 'Keranjang::hapus/$1');
    $routes->get('checkout', 'Checkout::index');
    $routes->post('checkout', 'Checkout::proses');
    $routes->post('pesanan/(:segment)/bukti', 'Pesanan::bukti/$1');
});

// Pelanggan dan admin
$routes->group('', ['filter' => 'role:pelanggan,admin'], static function ($routes) {
    $routes->get('pesanan', 'Pesanan::index');
    $routes->get('pesanan/(:segment)', 'Pesanan::detail/$1');
    $routes->get('berkas/bukti/(:segment)', 'Berkas::bukti/$1');
});

// Admin
$routes->group('admin', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('produk', 'Admin\Produk::index');
    $routes->get('produk/baru', 'Admin\Produk::create');
    $routes->post('produk/simpan', 'Admin\Produk::store');
    $routes->get('produk/ubah/(:num)', 'Admin\Produk::edit/$1');
    $routes->post('produk/perbarui/(:num)', 'Admin\Produk::update/$1');
    $routes->post('produk/hapus/(:num)', 'Admin\Produk::delete/$1');
    $routes->post('pesanan/(:segment)/status', 'Pesanan::status/$1');
});
