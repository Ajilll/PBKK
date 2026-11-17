<footer class="se-footer">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-5">
        <div class="se-logo text-white mb-2"><span class="se-logo-ikon"><i class="bi bi-bag-heart-fill"></i></span>ShopEase</div>
        <p class="mb-0">Aplikasi toko online untuk menjelajahi produk, berbelanja, membayar, dan memantau pesanan dalam satu tempat.</p>
      </div>
      <div class="col-6 col-lg-3">
        <h6>Jelajahi</h6>
        <ul class="list-unstyled mb-0">
          <li><a href="<?= url_to('katalog') ?>">Katalog</a></li>
          <li><a href="<?= url_to('home') ?>#produk">Produk unggulan</a></li>
          <li><a href="<?= url_to('home') ?>#cara-belanja">Cara belanja</a></li>
        </ul>
      </div>
      <div class="col-6 col-lg-4">
        <h6>Akun</h6>
        <ul class="list-unstyled mb-0">
          <li><a href="<?= url_to('login') ?>">Masuk</a></li>
          <li><a href="<?= url_to('daftar') ?>">Daftar</a></li>
          <li><a href="<?= url_to('keranjang') ?>">Keranjang</a></li>
        </ul>
      </div>
    </div>
    <hr>
    <div class="d-flex flex-column flex-md-row justify-content-between small">
      <span>&copy; <?= date('Y') ?> ShopEase. Proyek pembelajaran CodeIgniter 4.</span>
      <span>Data produk pada halaman ini adalah contoh.</span>
    </div>
  </div>
</footer>
