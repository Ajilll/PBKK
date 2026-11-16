<div class="col-6 col-md-3">
  <div class="card h-100 shadow-sm">
    <a href="<?= site_url('produk/' . $p['id']) ?>">
      <?php if ($g = gambar_produk($p['gambar'])): ?><img src="<?= $g ?>" class="card-img-top produk-img" alt="<?= esc($p['nama']) ?>">
      <?php else: ?><div class="produk-ph"><?= esc(mb_substr($p['nama'], 0, 1)) ?></div><?php endif ?>
    </a>
    <div class="card-body d-flex flex-column">
      <a class="text-decoration-none text-dark fw-semibold" href="<?= site_url('produk/' . $p['id']) ?>"><?= esc($p['nama']) ?></a>
      <div class="text-primary fw-bold mb-2"><?= rupiah($p['harga']) ?></div>
      <?php if ((int) $p['stok'] < 1): ?><span class="badge text-bg-secondary mt-auto align-self-start">Stok habis</span>
      <?php else: ?><small class="text-muted mt-auto">Stok: <?= (int) $p['stok'] ?></small><?php endif ?>
    </div>
  </div>
</div>
