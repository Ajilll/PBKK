<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="card mx-auto" style="max-width:420px"><div class="card-body p-4">
  <h4 class="mb-3">Daftar Akun</h4>
  <form method="post" action="<?= site_url('daftar') ?>">
    <?= csrf_field() ?>
    <div class="mb-3"><label class="form-label">Nama lengkap</label><input name="nama" value="<?= esc(old('nama')) ?>" class="form-control"></div>
    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" value="<?= esc(old('email')) ?>" class="form-control"></div>
    <div class="mb-3"><label class="form-label">Password (min. 6 karakter)</label><input type="password" name="password" class="form-control"></div>
    <div class="mb-3"><label class="form-label">Ulangi password</label><input type="password" name="password2" class="form-control"></div>
    <button class="btn btn-primary w-100">Daftar</button>
  </form>
</div></div>
<?= $this->endSection() ?>
