<?php $beranda = url_to('home'); ?>
<nav class="navbar navbar-expand-lg fixed-top se-navbar" id="navbarSe">
  <div class="container">
    <a class="navbar-brand se-logo" href="<?= $beranda ?>">
      <span class="se-logo-ikon"><i class="bi bi-bag-heart-fill"></i></span>ShopEase
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuUtama" aria-controls="menuUtama" aria-expanded="false" aria-label="Buka menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menuUtama">
      <ul class="navbar-nav mx-lg-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="<?= $beranda ?>#kategori">Kategori</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $beranda ?>#produk">Produk</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $beranda ?>#keunggulan">Keunggulan</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $beranda ?>#cara-belanja">Cara Belanja</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $beranda ?>#faq">FAQ</a></li>
      </ul>
      <div class="d-flex align-items-center gap-2">
        <a class="btn btn-icon position-relative" href="<?= url_to('keranjang') ?>" aria-label="Keranjang belanja">
          <i class="bi bi-cart3"></i><span class="badge-keranjang">0</span>
        </a>
        <a class="btn btn-se-outline" href="<?= url_to('login') ?>">Masuk</a>
        <a class="btn btn-se" href="<?= url_to('daftar') ?>">Daftar</a>
      </div>
    </div>
  </div>
</nav>
