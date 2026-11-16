<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="card mb-4"><div class="card-body"><div class="row g-4">
  <div class="col-md-5">
    <?php if ($g = gambar_produk($p['gambar'])): ?><img src="<?= $g ?>" class="img-fluid rounded" alt="<?= esc($p['nama']) ?>">
    <?php else: ?><div class="produk-ph rounded" style="height:320px"><?= esc(mb_substr($p['nama'], 0, 1)) ?></div><?php endif ?>
  </div>
  <div class="col-md-7">
    <span class="badge text-bg-light border"><?= esc($p['kategori']) ?></span>
    <h3 class="mt-2"><?= esc($p['nama']) ?></h3>
    <h4 class="text-primary"><?= rupiah($p['harga']) ?></h4>
    <p class="text-muted">Stok tersedia: <?= (int) $p['stok'] ?></p>
    <p><?= nl2br(esc($p['deskripsi'] ?? '')) ?></p>
    <?php if ((int) $p['stok'] < 1): ?>
      <button class="btn btn-secondary" disabled>Stok habis</button>
    <?php elseif (session('role') === 'pelanggan'): ?>
      <form method="post" action="<?= site_url('keranjang/tambah/' . $p['id']) ?>" class="d-flex gap-2" style="max-width:260px">
        <?= csrf_field() ?>
        <input type="number" name="qty" value="1" min="1" max="<?= (int) $p['stok'] ?>" class="form-control">
        <button class="btn btn-primary text-nowrap">+ Keranjang</button>
      </form>
    <?php elseif (! session('logged_in')): ?>
      <a class="btn btn-primary" href="<?= site_url('login') ?>">Masuk untuk membeli</a>
    <?php endif ?>
  </div>
</div></div></div>
<?php if ($serupa): ?>
  <h5>Produk serupa</h5>
  <div class="row g-3"><?php foreach ($serupa as $s): ?><?= view('katalog/_kartu', ['p' => $s]) ?><?php endforeach ?></div>
<?php endif ?>
<?= $this->endSection() ?>
