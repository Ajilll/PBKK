<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h4 class="mb-3"><?= $row ? 'Ubah' : 'Tambah' ?> <?= esc($judul) ?></h4>
<div class="card" style="max-width:640px"><div class="card-body">
  <form method="post" action="<?= site_url($row ? "{$uri}/perbarui/{$row['id']}" : "{$uri}/simpan") ?>">
    <?= csrf_field() ?>
    <?php foreach ($fields as $nama => $f): $type = $f['type'] ?? 'text'; $val = old($nama, $row[$nama] ?? ''); ?>
      <div class="mb-3">
        <label class="form-label"><?= esc($f['label']) ?></label>
        <?php if ($type === 'select'): ?>
          <select name="<?= $nama ?>" class="form-select">
            <option value="">-- pilih --</option>
            <?php foreach ($opsi[$nama] as $v => $t): ?>
              <option value="<?= esc($v) ?>" <?= (string) $val === (string) $v ? 'selected' : '' ?>><?= esc($t) ?></option>
            <?php endforeach ?>
          </select>
        <?php else: ?>
          <input type="<?= $type ?>" name="<?= $nama ?>" value="<?= esc($val) ?>" class="form-control">
        <?php endif ?>
      </div>
    <?php endforeach ?>
    <button class="btn btn-primary">Simpan</button>
    <a href="<?= site_url($uri) ?>" class="btn btn-link">Batal</a>
  </form>
</div></div>
<?= $this->endSection() ?>
