<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="segera">
  <div class="container text-center">
    <div class="segera-ikon"><i class="bi bi-tools"></i></div>
    <h1 class="h2"><?= esc($nama) ?></h1>
    <p class="text-muted mb-4">Halaman ini sedang dikembangkan dan akan tersedia pada tahap berikutnya.</p>
    <a href="<?= url_to('home') ?>" class="btn btn-se"><i class="bi bi-arrow-left me-1"></i>Kembali ke beranda</a>
  </div>
</section>
<?= $this->endSection() ?>
