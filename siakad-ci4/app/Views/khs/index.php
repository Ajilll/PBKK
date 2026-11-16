<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Kartu Hasil Studi</h4>
  <button class="btn btn-outline-secondary no-print" onclick="window.print()">Cetak</button>
</div>
<p><strong><?= esc($mhs['nama']) ?></strong> (<?= esc($mhs['nim']) ?>)</p>

<?php foreach ($per as $periode => $p): ?>
  <div class="card mb-3"><div class="card-header"><?= esc($periode) ?></div><div class="card-body">
    <table class="table table-sm mb-0">
      <thead><tr><th>Kode</th><th>Mata kuliah</th><th>SKS</th><th>Nilai</th><th>Huruf</th><th>Bobot</th></tr></thead>
      <tbody>
      <?php foreach ($p['rows'] as $r): ?>
        <tr><td><?= esc($r['kode']) ?></td><td><?= esc($r['nama']) ?></td><td><?= (int) $r['sks'] ?></td><td><?= fmt_nilai((float) $r['angka']) ?></td><td><?= esc($r['huruf']) ?></td><td><?= number_format((float) $r['bobot'], 1) ?></td></tr>
      <?php endforeach ?>
      </tbody>
      <tfoot><tr><th colspan="2">Jumlah / IPS</th><th><?= $p['sks'] ?></th><th colspan="3">IPS: <?= fmt_nilai($p['ips']) ?></th></tr></tfoot>
    </table>
  </div></div>
<?php endforeach; if (! $per): ?><div class="alert alert-info">Belum ada nilai yang masuk.</div><?php endif ?>

<div class="card border-primary"><div class="card-body d-flex justify-content-between">
  <span>Total SKS: <strong><?= $totSks ?></strong></span>
  <span>IPK: <strong><?= fmt_nilai($ipk) ?></strong></span>
</div></div>
<?= $this->endSection() ?>
