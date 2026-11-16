<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h4 class="mb-1">Input Nilai</h4>
<p class="text-muted"><?= esc($kelas['kode'] . ' - ' . $kelas['nama']) ?> | <?= esc($kelas['periode']) ?></p>
<form method="post" action="<?= site_url('nilai/' . $kelas['id']) ?>">
  <?= csrf_field() ?>
  <div class="card"><div class="card-body">
  <table class="table align-middle">
    <thead><tr><th>NIM</th><th>Nama</th><th style="width:160px">Nilai (0-100)</th><th>Huruf</th></tr></thead>
    <tbody>
    <?php foreach ($peserta as $p): ?>
      <tr>
        <td><?= esc($p['nim']) ?></td>
        <td><?= esc($p['nama']) ?></td>
        <td><input type="number" step="0.01" min="0" max="100" name="nilai[<?= (int) $p['krs_id'] ?>]" value="<?= esc($p['angka'] ?? '') ?>" class="form-control form-control-sm"></td>
        <td><span class="badge text-bg-secondary"><?= esc($p['huruf'] ?? '-') ?></span></td>
      </tr>
    <?php endforeach; if (! $peserta): ?><tr><td colspan="4" class="text-muted">Belum ada mahasiswa yang mengambil kelas ini.</td></tr><?php endif ?>
    </tbody>
  </table>
  </div></div>
  <button class="btn btn-primary mt-3">Simpan nilai</button>
  <a href="<?= site_url('nilai') ?>" class="btn btn-link mt-3">Kembali</a>
</form>
<?= $this->endSection() ?>
