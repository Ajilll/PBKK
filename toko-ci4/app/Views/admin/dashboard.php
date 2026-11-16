<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h4 class="mb-3">Dashboard Admin</h4>
<div class="row g-3 mb-4">
  <div class="col-md-3"><div class="card text-center"><div class="card-body"><div class="fs-4"><?= rupiah($omzet) ?></div><div class="text-muted">Omzet (dibayar/dikirim/selesai)</div></div></div></div>
  <div class="col-md-3"><div class="card text-center"><div class="card-body"><div class="fs-4"><?= array_sum($perStatus) ?></div><div class="text-muted">Total pesanan</div></div></div></div>
  <div class="col-md-3"><div class="card text-center"><div class="card-body"><div class="fs-4"><?= $jmlProduk ?></div><div class="text-muted">Produk</div></div></div></div>
  <div class="col-md-3"><div class="card text-center"><div class="card-body"><div class="fs-4"><?= $jmlUser ?></div><div class="text-muted">Pelanggan</div></div></div></div>
</div>
<div class="row g-3">
  <div class="col-md-5"><div class="card"><div class="card-body">
    <h6>Pesanan per status</h6><canvas id="grafik" height="220"></canvas>
  </div></div></div>
  <div class="col-md-7"><div class="card"><div class="card-body">
    <h6>Stok menipis</h6>
    <table class="table table-sm mb-0"><thead><tr><th>Produk</th><th>Stok</th><th></th></tr></thead><tbody>
    <?php foreach ($menipis as $m): ?><tr><td><?= esc($m['nama']) ?></td><td><?= (int) $m['stok'] ?></td><td class="text-end"><a href="<?= site_url('admin/produk/ubah/' . $m['id']) ?>">Ubah</a></td></tr>
    <?php endforeach; if (! $menipis): ?><tr><td colspan="3" class="text-muted">Semua stok aman.</td></tr><?php endif ?>
    </tbody></table>
  </div></div></div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
const label = <?= json_encode(array_map(fn ($s) => $s[0], $status)) ?>;
const data  = <?= json_encode($perStatus) ?>;
new Chart(document.getElementById('grafik'), {
  type: 'doughnut',
  data: { labels: Object.keys(label).map(k => label[k]), datasets: [{ data: Object.keys(label).map(k => data[k] || 0) }] },
});
</script>
<?= $this->endSection() ?>
