<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h4 class="mb-3">Kelas yang Saya Ampu</h4>
<div class="card"><div class="card-body">
<table class="table table-striped align-middle datatable">
  <thead><tr><th>Mata kuliah</th><th>Periode</th><th>Jadwal</th><th>Peserta</th><th>Sudah dinilai</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= esc($r['kode'] . ' - ' . $r['nama']) ?></td>
      <td><?= esc($r['periode']) ?></td>
      <td><?= esc($r['hari'] . ', ' . $r['mulai'] . '-' . $r['selesai']) ?></td>
      <td><?= (int) $r['peserta'] ?></td>
      <td><?= (int) $r['dinilai'] ?></td>
      <td class="text-end"><a class="btn btn-sm btn-primary" href="<?= site_url('nilai/' . $r['id']) ?>">Input nilai</a></td>
    </tr>
  <?php endforeach ?>
  </tbody>
</table>
</div></div>
<?= $this->endSection() ?>
