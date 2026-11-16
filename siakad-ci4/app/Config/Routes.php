<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->get('logout', 'Auth::logout');

// Semua pengguna yang sudah login
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'role']);

// Admin: data master (6 rute CRUD per modul dibuat lewat perulangan)
$routes->group('admin', ['filter' => 'role:admin'], static function ($routes) {
    $modul = [
        'prodi'      => 'Prodi',
        'mahasiswa'  => 'Mahasiswa',
        'dosen'      => 'Dosen',
        'matakuliah' => 'MataKuliah',
        'kelas'      => 'Kelas',
    ];

    foreach ($modul as $uri => $ctl) {
        $routes->get($uri, "Admin\\{$ctl}::index");
        $routes->get("{$uri}/baru", "Admin\\{$ctl}::create");
        $routes->post("{$uri}/simpan", "Admin\\{$ctl}::store");
        $routes->get("{$uri}/ubah/(:num)", "Admin\\{$ctl}::edit/$1");
        $routes->post("{$uri}/perbarui/(:num)", "Admin\\{$ctl}::update/$1");
        $routes->post("{$uri}/hapus/(:num)", "Admin\\{$ctl}::delete/$1");
    }
});

// Dosen: input nilai
$routes->group('nilai', ['filter' => 'role:dosen'], static function ($routes) {
    $routes->get('/', 'Nilai::index');
    $routes->get('(:num)', 'Nilai::peserta/$1');
    $routes->post('(:num)', 'Nilai::simpan/$1');
});

// Mahasiswa: KRS dan KHS
$routes->group('', ['filter' => 'role:mahasiswa'], static function ($routes) {
    $routes->get('krs', 'Krs::index');
    $routes->post('krs/ambil/(:num)', 'Krs::ambil/$1');
    $routes->post('krs/batal/(:num)', 'Krs::batal/$1');
    $routes->get('khs', 'Khs::index');
});
