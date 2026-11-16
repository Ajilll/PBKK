<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Kartu Rencana Studi - <?= esc($cfg->periodeAktif) ?></h4>
  <span class="badge text-bg-primary fs-6">SKS diambil: <?= $sks ?> / <?= $cfg->maxSks ?></span>
</div>
<div class="card"><div class="card-body">
<table class="table table-striped align-middle">
  <thead><tr><th>Mata kuliah</th><th>SKS</th><th>Dosen</th><th>Jadwal</th><th>Ruang</th><th>Kuota</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($kelas as $k): $penuh = (int) $k['terisi'] >= (int) $k['kuota']; ?>
    <tr>
      <td><?= esc($k['kode'] . ' - ' . $k['nama']) ?></td>
      <td><?= (int) $k['sks'] ?></td>
      <td><?= esc($k['dosen']) ?></td>
      <td><?= esc($k['hari'] . ', ' . $k['mulai'] . '-' . $k['selesai']) ?></td>
      <td><?= esc($k['ruang']) ?></td>
      <td><span class="badge <?= $penuh ? 'text-bg-danger' : 'text-bg-success' ?>"><?= (int) $k['terisi'] ?>/<?= (int) $k['kuota'] ?></span></td>
      <td class="text-end">
        <?php if ($k['krs_id']): ?>
          <?php if ((int) $k['sudah_dinilai'] > 0): ?><span class="badge text-bg-secondary">Sudah dinilai</span>
          <?php else: ?>
            <form method="post" action="<?= site_url('krs/batal/' . $k['krs_id']) ?>" onsubmit="return confirm('Batalkan kelas ini?')">
              <?= csrf_field() ?><button class="btn btn-sm btn-outline-danger">Batalkan</button></form>
          <?php endif ?>
        <?php else: ?>
          <form method="post" action="<?= site_url('krs/ambil/' . $k['id']) ?>">
            <?= csrf_field() ?><button class="btn btn-sm btn-primary" <?= $penuh ? 'disabled' : '' ?>>Ambil</button></form>
        <?php endif ?>
      </td>
    </tr>
  <?php endforeach; if (! $kelas): ?><tr><td colspan="7" class="text-muted">Belum ada kelas dibuka untuk periode ini.</td></tr><?php endif ?>
  </tbody>
</table>
</div></div>
<?= $this->endSection() ?>
