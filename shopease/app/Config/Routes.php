<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Auto-routing nonaktif (bawaan CI 4): hanya rute yang didefinisikan di bawah ini yang bisa diakses.

// Landing page
$routes->get('/', 'HomeController::index', ['as' => 'home']);

// Halaman yang belum dibuat (milestone M2-M5 pada PRD). Rute sudah dipasang supaya tombol
// di landing page tidak mengarah ke 404; semuanya ditangani HomeController::segera.
foreach (['login', 'daftar', 'katalog', 'keranjang'] as $uri) {
    $routes->get($uri, 'HomeController::segera/' . $uri, ['as' => $uri]);
}
$routes->get('produk/(:num)', 'HomeController::segera/produk/$1', ['as' => 'produk']);
