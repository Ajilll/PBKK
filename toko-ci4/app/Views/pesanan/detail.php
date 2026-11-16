<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Pesanan <?= esc($p['kode']) ?></h4><?= badge_status($p['status']) ?>
</div>
<div class="row g-4">
  <div class="col-md-7"><div class="card"><div class="card-body">
    <table class="table table-sm">
      <thead><tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr></thead>
      <tbody>
      <?php foreach ($items as $it): ?>
        <tr><td><?= esc($it['nama_produk']) ?></td><td><?= rupiah($it['harga']) ?></td><td><?= (int) $it['qty'] ?></td><td><?= rupiah($it['harga'] * $it['qty']) ?></td></tr>
      <?php endforeach ?>
      </tbody>
      <tfoot><tr><th colspan="3" class="text-end">Total</th><th><?= rupiah($p['total']) ?></th></tr></tfoot>
    </table>
    <h6>Pengiriman</h6>
    <p class="mb-0"><?= esc($p['nama_penerima']) ?> (<?= esc($p['telepon']) ?>)<br><?= nl2br(esc($p['alamat'])) ?></p>
  </div></div></div>

  <div class="col-md-5">
    <?php if ($admin): ?>
      <div class="card mb-3"><div class="card-body">
        <h6>Pemesan</h6><p><?= esc($p['pemesan']) ?></p>
        <h6>Ubah status</h6>
        <?php if ($p['status'] === 'batal'): ?>
          <p class="text-muted mb-0">Pesanan dibatalkan dan tidak bisa diubah lagi.</p>
        <?php else: ?>
          <form method="post" action="<?= site_url('admin/pesanan/' . $p['kode'] . '/status') ?>" class="d-flex gap-2">
            <?= csrf_field() ?>
            <select name="status" class="form-select">
              <?php foreach (config('Toko')->status as $k => [$label]): ?><option value="<?= $k ?>" <?= $p['status'] === $k ? 'selected' : '' ?>><?= $label ?></option><?php endforeach ?>
            </select>
            <button class="btn btn-primary">Simpan</button>
          </form>
          <small class="text-muted">Memilih "Batal" akan mengembalikan stok produk.</small>
        <?php endif ?>
      </div></div>
    <?php endif ?>

    <?php if ($p['bukti_bayar']): ?>
      <div class="card mb-3"><div class="card-body"><h6>Bukti pembayaran</h6>
        <a class="btn btn-sm btn-outline-secondary" target="_blank" href="<?= site_url('berkas/bukti/' . $p['kode']) ?>">Lihat bukti</a>
      </div></div>
    <?php endif ?>

    <?php if (! $admin && $p['status'] === 'menunggu_pembayaran'): ?>
      <div class="card"><div class="card-body">
        <h6>Pembayaran</h6>
        <p class="mb-2">Transfer <strong><?= rupiah($p['total']) ?></strong> ke:<br>
          <?= esc($toko->rekening['bank']) ?> <strong><?= esc($toko->rekening['nomor']) ?></strong><br>a.n. <?= esc($toko->rekening['atas_nama']) ?></p>
        <form method="post" enctype="multipart/form-data" action="<?= site_url('pesanan/' . $p['kode'] . '/bukti') ?>">
          <?= csrf_field() ?>
          <input type="file" name="bukti" class="form-control mb-2" accept=".jpg,.jpeg,.png,.pdf">
          <button class="btn btn-primary">Unggah bukti (maks. 2 MB)</button>
        </form>
      </div></div>
    <?php endif ?>
  </div>
</div>
<a href="<?= site_url('pesanan') ?>" class="btn btn-link mt-3">Kembali</a>
<?= $this->endSection() ?>
