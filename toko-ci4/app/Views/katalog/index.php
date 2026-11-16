<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<form method="get" action="<?= site_url('/') ?>" class="row g-2 mb-4">
  <div class="col-md-5"><input name="q" value="<?= esc($q) ?>" class="form-control" placeholder="Cari produk..."></div>
  <div class="col-md-3">
    <select name="kategori" class="form-select"><option value="">Semua kategori</option>
      <?php foreach ($kategori as $k): ?><option value="<?= $k['id'] ?>" <?= $kat === (int) $k['id'] ? 'selected' : '' ?>><?= esc($k['nama']) ?></option><?php endforeach ?>
    </select>
  </div>
  <div class="col-md-2">
    <select name="urut" class="form-select">
      <?php foreach (['' => 'Terbaru', 'murah' => 'Termurah', 'mahal' => 'Termahal', 'nama' => 'Nama A-Z'] as $v => $t): ?>
        <option value="<?= $v ?>" <?= $urut === $v ? 'selected' : '' ?>><?= $t ?></option><?php endforeach ?>
    </select>
  </div>
  <div class="col-md-2"><button class="btn btn-primary w-100">Cari</button></div>
</form>

<div class="row g-3">
  <?php foreach ($produk as $p): ?><?= view('katalog/_kartu', ['p' => $p]) ?><?php endforeach ?>
  <?php if (! $produk): ?><div class="col-12 text-muted">Produk tidak ditemukan.</div><?php endif ?>
</div>
<div class="mt-4"><?= $pager->links() ?></div>
<?= $this->endSection() ?>
