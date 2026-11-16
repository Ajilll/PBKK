<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Kelola Produk</h4>
  <a href="<?= site_url('admin/produk/baru') ?>" class="btn btn-primary">+ Tambah produk</a>
</div>
<div class="card"><div class="card-body">
<table class="table table-striped align-middle">
  <thead><tr><th></th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td style="width:60px"><?php if ($g = gambar_produk($r['gambar'])): ?><img src="<?= $g ?>" width="48" height="48" style="object-fit:cover" class="rounded"><?php endif ?></td>
      <td><?= esc($r['nama']) ?></td><td><?= esc($r['kategori']) ?></td><td><?= rupiah($r['harga']) ?></td><td><?= (int) $r['stok'] ?></td>
      <td class="text-end text-nowrap">
        <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('admin/produk/ubah/' . $r['id']) ?>">Ubah</a>
        <form method="post" action="<?= site_url('admin/produk/hapus/' . $r['id']) ?>" class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
          <?= csrf_field() ?><button class="btn btn-sm btn-outline-danger">Hapus</button></form>
      </td>
    </tr>
  <?php endforeach ?>
  </tbody>
</table>
</div></div>
<?= $this->endSection() ?>
