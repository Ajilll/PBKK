<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h4 class="mb-3">Keranjang Belanja</h4>
<?php if (! $items): ?>
  <div class="alert alert-info">Keranjang masih kosong. <a href="<?= site_url('/') ?>">Mulai belanja</a></div>
<?php else: ?>
<div class="card"><div class="card-body">
<table class="table align-middle">
  <thead><tr><th>Produk</th><th>Harga</th><th style="width:150px">Jumlah</th><th>Subtotal</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($items as $it): ?>
    <tr>
      <td><a href="<?= site_url('produk/' . $it['id']) ?>" class="text-decoration-none"><?= esc($it['nama']) ?></a></td>
      <td><?= rupiah($it['harga']) ?></td>
      <td>
        <form method="post" action="<?= site_url('keranjang/ubah/' . $it['id']) ?>" class="d-flex gap-1">
          <?= csrf_field() ?>
          <input type="number" name="qty" value="<?= $it['qty'] ?>" min="1" max="<?= (int) $it['stok'] ?>" class="form-control form-control-sm">
          <button class="btn btn-sm btn-outline-secondary">Ubah</button>
        </form>
      </td>
      <td><?= rupiah($it['subtotal']) ?></td>
      <td>
        <form method="post" action="<?= site_url('keranjang/hapus/' . $it['id']) ?>"><?= csrf_field() ?><button class="btn btn-sm btn-outline-danger">Hapus</button></form>
      </td>
    </tr>
  <?php endforeach ?>
  </tbody>
  <tfoot><tr><th colspan="3" class="text-end">Total</th><th colspan="2"><?= rupiah($total) ?></th></tr></tfoot>
</table>
<div class="text-end"><a class="btn btn-primary" href="<?= site_url('checkout') ?>">Lanjut ke checkout</a></div>
</div></div>
<?php endif ?>
<?= $this->endSection() ?>
