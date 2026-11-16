<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Masuk - <?= esc(config('Siakad')->namaApp) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh">
  <div class="container" style="max-width:420px">
    <div class="card shadow-sm"><div class="card-body p-4">
      <h4 class="mb-1"><?= esc(config('Siakad')->namaApp) ?></h4>
      <p class="text-muted">Silakan masuk untuk melanjutkan</p>
      <?php if ($m = session()->getFlashdata('error')): ?><div class="alert alert-danger py-2"><?= esc($m) ?></div><?php endif ?>
      <?php if ($errs = session()->getFlashdata('errors')): ?><div class="alert alert-danger py-2"><?php foreach ($errs as $e): ?><div><?= esc($e) ?></div><?php endforeach ?></div><?php endif ?>
      <form method="post" action="<?= site_url('login') ?>">
        <?= csrf_field() ?>
        <div class="mb-3"><label class="form-label">Username (NIM / NIDN)</label>
          <input name="username" class="form-control" value="<?= esc(old('username')) ?>" autofocus></div>
        <div class="mb-3"><label class="form-label">Password</label>
          <input type="password" name="password" class="form-control"></div>
        <button class="btn btn-primary w-100">Masuk</button>
      </form>
    </div></div>
  </div>
</body>
</html>
