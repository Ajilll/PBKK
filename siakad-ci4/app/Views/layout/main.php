<?php
$cfg  = config('Siakad');
$role = session('role');
$menu = match ($role) {
    'admin'     => ['Dashboard' => 'dashboard', 'Program Studi' => 'admin/prodi', 'Mahasiswa' => 'admin/mahasiswa', 'Dosen' => 'admin/dosen', 'Mata Kuliah' => 'admin/matakuliah', 'Kelas & Jadwal' => 'admin/kelas'],
    'dosen'     => ['Dashboard' => 'dashboard', 'Input Nilai' => 'nilai'],
    'mahasiswa' => ['Dashboard' => 'dashboard', 'KRS' => 'krs', 'KHS' => 'khs'],
    default     => [],
};
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($cfg->namaApp) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <style>
    .sidebar { min-height: 100vh; background: #1f2a44; }
    .sidebar a { color: #cbd5e1; text-decoration: none; display: block; padding: .6rem 1rem; border-radius: .4rem; }
    .sidebar a:hover, .sidebar a.active { background: #34456b; color: #fff; }
    @media print { .sidebar, .no-print { display: none !important; } main { width: 100% !important; } }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 sidebar p-3 no-print">
      <h5 class="text-white mb-4"><?= esc($cfg->namaApp) ?></h5>
      <?php foreach ($menu as $label => $uri): ?>
        <a href="<?= site_url($uri) ?>" class="<?= str_starts_with(uri_string(), $uri) ? 'active' : '' ?>"><?= esc($label) ?></a>
      <?php endforeach ?>
      <hr class="text-secondary">
      <div class="text-white-50 small mb-2"><?= esc(session('nama')) ?> (<?= esc($role) ?>)</div>
      <a href="<?= site_url('logout') ?>">Keluar</a>
    </nav>
    <main class="col-md-10 p-4">
      <?php if ($m = session()->getFlashdata('ok')): ?><div class="alert alert-success"><?= esc($m) ?></div><?php endif ?>
      <?php if ($m = session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc($m) ?></div><?php endif ?>
      <?php if ($errs = session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errs as $e): ?><li><?= esc($e) ?></li><?php endforeach ?></ul></div>
      <?php endif ?>
      <?= $this->renderSection('content') ?>
    </main>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script>$('.datatable').DataTable({language: {search: 'Cari:', lengthMenu: 'Tampilkan _MENU_', info: '_START_-_END_ dari _TOTAL_', zeroRecords: 'Tidak ada data', paginate: {previous: '‹', next: '›'}}});</script>
</body>
</html>
