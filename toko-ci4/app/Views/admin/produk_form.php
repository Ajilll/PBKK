<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h4 class="mb-3"><?= $p ? 'Ubah' : 'Tambah' ?> Produk</h4>
<div class="card" style="max-width:680px"><div class="card-body">
  <form method="post" enctype="multipart/form-data" action="<?= site_url($p ? 'admin/produk/perbarui/' . $p['id'] : 'admin/produk/simpan') ?>">
    <?= csrf_field() ?>
    <div class="mb-3"><label class="form-label">Nama produk</label><input name="nama" value="<?= esc(old('nama', $p['nama'] ?? '')) ?>" class="form-control"></div>
    <div class="mb-3"><label class="form-label">Kategori</label>
      <select name="kategori_id" class="form-select"><option value="">-- pilih --</option>
        <?php foreach ($kategori as $k): ?><option value="<?= $k['id'] ?>" <?= (string) old('kategori_id', $p['kategori_id'] ?? '') === (string) $k['id'] ? 'selected' : '' ?>><?= esc($k['nama']) ?></option><?php endforeach ?>
      </select></div>
    <div class="row">
      <div class="col-md-6 mb-3"><label class="form-label">Harga (Rp)</label><input type="number" name="harga" value="<?= esc(old('harga', $p['harga'] ?? '')) ?>" class="form-control"></div>
      <div class="col-md-6 mb-3"><label class="form-label">Stok</label><input type="number" name="stok" value="<?= esc(old('stok', $p['stok'] ?? '')) ?>" class="form-control"></div>
    </div>
    <div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="deskripsi" rows="4" class="form-control"><?= esc(old('deskripsi', $p['deskripsi'] ?? '')) ?></textarea></div>
    <div class="mb-3"><label class="form-label">Gambar (jpg/png/webp, maks. 2 MB)</label>
      <?php if (! empty($p['gambar'])): ?><div class="mb-2"><img src="<?= gambar_produk($p['gambar']) ?>" height="80" class="rounded"></div><?php endif ?>
      <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.webp"></div>
    <button class="btn btn-primary">Simpan</button>
    <a href="<?= site_url('admin/produk') ?>" class="btn btn-link">Batal</a>
  </form>
</div></div>
<?= $this->endSection() ?>
