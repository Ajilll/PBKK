<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0"><?= $admin ? 'Semua Pesanan' : 'Pesanan Saya' ?></h4>
  <?php if ($admin): ?>
    <form method="get" class="d-flex gap-2">
      <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
        <option value="">Semua status</option>
        <?php foreach (config('Toko')->status as $k => [$label]): ?><option value="<?= $k ?>" <?= $status === $k ? 'selected' : '' ?>><?= $label ?></option><?php endforeach ?>
      </select>
    </form>
  <?php endif ?>
</div>
<div class="card"><div class="card-body">
<table class="table table-striped align-middle">
  <thead><tr><th>Kode</th><?php if ($admin): ?><th>Pemesan</th><?php endif ?><th>Tanggal</th><th>Total</th><th>Status</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= esc($r['kode']) ?></td>
      <?php if ($admin): ?><td><?= esc($r['pemesan']) ?></td><?php endif ?>
      <td><?= esc(date('d/m/Y H:i', strtotime($r['dibuat_pada']))) ?></td>
      <td><?= rupiah($r['total']) ?></td>
      <td><?= badge_status($r['status']) ?></td>
      <td class="text-end"><a class="btn btn-sm btn-outline-primary" href="<?= site_url('pesanan/' . $r['kode']) ?>">Detail</a></td>
    </tr>
  <?php endforeach; if (! $rows): ?><tr><td colspan="6" class="text-muted">Belum ada pesanan.</td></tr><?php endif ?>
  </tbody>
</table>
</div></div>
<?= $this->endSection() ?>
