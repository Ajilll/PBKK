<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($judul ?? 'ShopEase') ?></title>
  <meta name="description" content="ShopEase adalah aplikasi toko online untuk menjelajahi produk, berbelanja, membayar, dan memantau pesanan.">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/css/shopease.css') ?>" rel="stylesheet">
  <noscript><style>.reveal { opacity: 1; transform: none; }</style></noscript>
</head>
<body data-bs-spy="scroll" data-bs-target="#menuUtama" data-bs-offset="100" tabindex="0">
  <a class="skip-link" href="#konten">Lewati ke konten utama</a>

  <?= $this->include('layouts/navbar') ?>

  <main id="konten">
    <?= $this->renderSection('content') ?>
  </main>

  <?= $this->include('layouts/footer') ?>

  <button type="button" id="keAtas" class="ke-atas" aria-label="Kembali ke atas"><i class="bi bi-arrow-up"></i></button>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('assets/js/shopease.js') ?>"></script>
</body>
</html>
