<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="card mx-auto" style="max-width:420px"><div class="card-body p-4">
  <h4 class="mb-3">Masuk</h4>
  <form method="post" action="<?= site_url('login') ?>">
    <?= csrf_field() ?>
    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" value="<?= esc(old('email')) ?>" class="form-control"></div>
    <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control"></div>
    <button class="btn btn-primary w-100">Masuk</button>
  </form>
  <p class="mt-3 mb-0 small">Belum punya akun? <a href="<?= site_url('daftar') ?>">Daftar</a></p>
</div></div>
<?= $this->endSection() ?>
