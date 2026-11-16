<?php
$cfg   = config('Toko');
$role  = session('role');
$jmlKeranjang = $role === 'pelanggan' ? (new \App\Libraries\Troli())->jumlah() : 0;
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($cfg->nama) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .produk-img { height: 180px; object-fit: cover; background: #e9ecef; }
    .produk-ph  { height: 180px; background: #e9ecef; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: #adb5bd; }
    .pagination { display: flex; gap: .25rem; list-style: none; padding: 0; justify-content: center; }
    .pagination li a { display: block; padding: .35rem .75rem; border: 1px solid #dee2e6; border-radius: .375rem; text-decoration: none; color: #0d6efd; background: #fff; }
    .pagination li.active a { background: #0d6efd; color: #fff; border-color: #0d6efd; }
  </style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="<?= site_url('/') ?>"><?= esc($cfg->nama) ?></a>
    <div class="d-flex flex-wrap gap-2 align-items-center">
      <?php if ($role === 'admin'): ?>
        <a class="btn btn-sm btn-outline-light" href="<?= site_url('admin') ?>">Dashboard</a>
        <a class="btn btn-sm btn-outline-light" href="<?= site_url('admin/produk') ?>">Produk</a>
        <a class="btn btn-sm btn-outline-light" href="<?= site_url('pesanan') ?>">Pesanan</a>
      <?php elseif ($role === 'pelanggan'): ?>
        <a class="btn btn-sm btn-outline-light" href="<?= site_url('keranjang') ?>">Keranjang <span class="badge text-bg-warning"><?= $jmlKeranjang ?></span></a>
        <a class="btn btn-sm btn-outline-light" href="<?= site_url('pesanan') ?>">Pesanan saya</a>
      <?php endif ?>
      <?php if (session('logged_in')): ?>
        <span class="text-white-50 small"><?= esc(session('nama')) ?></span>
        <a class="btn btn-sm btn-light" href="<?= site_url('logout') ?>">Keluar</a>
      <?php else: ?>
        <a class="btn btn-sm btn-outline-light" href="<?= site_url('login') ?>">Masuk</a>
        <a class="btn btn-sm btn-warning" href="<?= site_url('daftar') ?>">Daftar</a>
      <?php endif ?>
    </div>
  </div>
</nav>
<div class="container pb-5">
  <?php if ($m = session()->getFlashdata('ok')): ?><div class="alert alert-success"><?= $m ?></div><?php endif ?>
  <?php if ($m = session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc($m) ?></div><?php endif ?>
  <?php if ($errs = session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errs as $e): ?><li><?= esc($e) ?></li><?php endforeach ?></ul></div>
  <?php endif ?>
  <?= $this->renderSection('content') ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
