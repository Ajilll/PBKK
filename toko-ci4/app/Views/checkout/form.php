<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h4 class="mb-3">Checkout</h4>
<div class="row g-4">
  <div class="col-md-7"><div class="card"><div class="card-body">
    <form method="post" action="<?= site_url('checkout') ?>">
      <?= csrf_field() ?>
      <div class="mb-3"><label class="form-label">Nama penerima</label><input name="nama_penerima" value="<?= esc(old('nama_penerima', session('nama'))) ?>" class="form-control"></div>
      <div class="mb-3"><label class="form-label">No. telepon</label><input name="telepon" value="<?= esc(old('telepon')) ?>" class="form-control"></div>
      <div class="mb-3"><label class="form-label">Alamat lengkap</label><textarea name="alamat" rows="3" class="form-control"><?= esc(old('alamat')) ?></textarea></div>
      <button class="btn btn-primary">Buat pesanan</button>
      <a href="<?= site_url('keranjang') ?>" class="btn btn-link">Kembali</a>
    </form>
  </div></div></div>
  <div class="col-md-5"><div class="card"><div class="card-body">
    <h6>Ringkasan</h6>
    <?php foreach ($items as $it): ?>
      <div class="d-flex justify-content-between small"><span><?= esc($it['nama']) ?> x<?= $it['qty'] ?></span><span><?= rupiah($it['subtotal']) ?></span></div>
    <?php endforeach ?>
    <hr><div class="d-flex justify-content-between fw-bold"><span>Total</span><span><?= rupiah($total) ?></span></div>
  </div></div></div>
</div>
<?= $this->endSection() ?>
