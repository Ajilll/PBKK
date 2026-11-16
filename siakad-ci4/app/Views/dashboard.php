<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h4 class="mb-1">Halo, <?= esc(session('nama')) ?></h4>
<p class="text-muted">Periode aktif: <?= esc($periode) ?></p>

<?php if ($role === 'admin'): ?>
  <div class="row g-3">
    <?php foreach (['mahasiswa' => 'Mahasiswa', 'dosen' => 'Dosen', 'mata_kuliah' => 'Mata Kuliah', 'kelas' => 'Kelas'] as $k => $label): ?>
      <div class="col-md-3"><div class="card text-center"><div class="card-body">
        <div class="display-6"><?= (int) $stat[$k] ?></div><div class="text-muted"><?= $label ?></div>
      </div></div></div>
    <?php endforeach ?>
  </div>
<?php elseif ($role === 'dosen'): ?>
  <h5 class="mt-4">Jadwal mengajar</h5>
  <table class="table table-sm"><thead><tr><th>Mata kuliah</th><th>Hari</th><th>Jam</th><th>Ruang</th><th>Peserta</th></tr></thead><tbody>
  <?php foreach ($jadwal as $j): ?><tr><td><?= esc($j['kode'] . ' - ' . $j['nama']) ?></td><td><?= esc($j['hari']) ?></td><td><?= esc($j['mulai'] . '-' . $j['selesai']) ?></td><td><?= esc($j['ruang']) ?></td><td><?= (int) $j['peserta'] ?></td></tr>
  <?php endforeach; if (! $jadwal): ?><tr><td colspan="5" class="text-muted">Belum ada kelas pada periode ini.</td></tr><?php endif ?>
  </tbody></table>
<?php else: ?>
  <div class="row g-3 mb-4">
    <div class="col-md-4"><div class="card text-center"><div class="card-body"><div class="display-6"><?= fmt_nilai((float) $ringkas['ipk']) ?></div><div class="text-muted">IPK</div></div></div></div>
    <div class="col-md-4"><div class="card text-center"><div class="card-body"><div class="display-6"><?= (int) $ringkas['sks'] ?></div><div class="text-muted">SKS lulus dinilai</div></div></div></div>
    <div class="col-md-4"><div class="card text-center"><div class="card-body"><div class="fs-5"><?= esc($mhs['nim']) ?></div><div class="text-muted"><?= esc($mhs['nama']) ?></div></div></div></div>
  </div>
  <h5>Jadwal kuliah periode ini</h5>
  <table class="table table-sm"><thead><tr><th>Mata kuliah</th><th>SKS</th><th>Hari</th><th>Jam</th><th>Ruang</th></tr></thead><tbody>
  <?php foreach ($jadwal as $j): ?><tr><td><?= esc($j['kode'] . ' - ' . $j['nama']) ?></td><td><?= (int) $j['sks'] ?></td><td><?= esc($j['hari']) ?></td><td><?= esc($j['mulai'] . '-' . $j['selesai']) ?></td><td><?= esc($j['ruang']) ?></td></tr>
  <?php endforeach; if (! $jadwal): ?><tr><td colspan="5" class="text-muted">Belum ada kelas di KRS. Isi KRS pada menu KRS.</td></tr><?php endif ?>
  </tbody></table>
<?php endif ?>
<?= $this->endSection() ?>
