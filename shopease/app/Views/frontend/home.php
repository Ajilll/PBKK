<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
// Pembantu tampilan kecil: format rupiah dan label stok
$rp = static fn (int $n): string => 'Rp ' . number_format($n, 0, ',', '.');
$labelStok = static function (int $stok): array {
    if ($stok === 0) {
        return ['Habis', 'habis'];
    }
    if ($stok <= 5) {
        return ['Stok terbatas: ' . $stok, 'terbatas'];
    }

    return ['Tersedia', 'tersedia'];
};
?>

<!-- HERO -->
<section class="hero" id="beranda">
  <div class="container">
    <div class="row align-items-center gy-5">
      <div class="col-lg-6">
        <span class="hero-pill"><i class="bi bi-lightning-charge-fill"></i> Toko online berbasis CodeIgniter 4</span>
        <h1 class="hero-judul">Belanja kebutuhanmu, <span class="hl">tanpa ribet.</span></h1>
        <p class="hero-lead">Temukan produk, atur keranjang, bayar lewat transfer, dan pantau pesananmu sampai tiba. Semua ada di ShopEase.</p>

        <form class="hero-cari" id="formCari" action="<?= url_to('katalog') ?>" method="get" role="search">
          <i class="bi bi-search"></i>
          <input type="search" name="q" class="form-control" placeholder="Cari produk, misalnya headset" aria-label="Cari produk" autocomplete="off">
          <button type="submit" class="btn btn-aksen">Cari</button>
        </form>
        <div class="invalid-pesan" id="pesanCari" hidden>Ketik minimal 2 huruf untuk mencari.</div>

        <ul class="hero-poin">
          <li><i class="bi bi-check-circle-fill"></i> Stok dicek saat checkout</li>
          <li><i class="bi bi-check-circle-fill"></i> Pembayaran diverifikasi admin</li>
          <li><i class="bi bi-check-circle-fill"></i> Status pesanan bisa dilacak</li>
        </ul>
      </div>

      <div class="col-lg-6">
        <div class="hero-visual" aria-hidden="true">
          <div class="row g-3">
            <?php foreach (array_slice($produk, 0, 4) as $i => $p): ?>
              <div class="col-6 <?= $i % 2 === 1 ? 'geser-bawah' : '' ?>">
                <div class="mini-produk nada-<?= esc($p['warna']) ?>">
                  <i class="bi <?= esc($p['ikon']) ?>"></i>
                  <div class="mini-info"><strong><?= esc($p['nama']) ?></strong><span><?= $rp($p['harga']) ?></span></div>
                </div>
              </div>
            <?php endforeach ?>
          </div>
          <div class="chip chip-a"><i class="bi bi-box-seam"></i> Stok terkini</div>
          <div class="chip chip-b"><i class="bi bi-patch-check-fill"></i> Pembayaran terverifikasi</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- KATEGORI -->
<section class="bagian" id="kategori">
  <div class="container">
    <div class="judul-bagian reveal">
      <span class="label-kecil">Kategori</span>
      <h2>Belanja berdasarkan kategori</h2>
      <p>Pilih kelompok produk yang kamu cari.</p>
    </div>
    <div class="row g-3">
      <?php foreach ($kategori as $k): ?>
        <div class="col-6 col-md-4 col-lg-2 reveal">
          <a class="kartu-kategori" href="<?= url_to('katalog') ?>?kategori=<?= urlencode(strtolower($k['nama'])) ?>">
            <span class="ikon-bulat nada-<?= esc($k['warna']) ?>"><i class="bi <?= esc($k['ikon']) ?>"></i></span>
            <strong><?= esc($k['nama']) ?></strong>
            <small><?= (int) $k['jumlah'] ?> produk</small>
          </a>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</section>

<!-- PRODUK UNGGULAN -->
<section class="bagian bagian-abu" id="produk">
  <div class="container">
    <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 reveal">
      <div class="judul-bagian mb-0 text-start">
        <span class="label-kecil">Produk unggulan</span>
        <h2>Pilihan yang sedang ramai</h2>
      </div>
      <a href="<?= url_to('katalog') ?>" class="btn btn-se-outline">Lihat semua produk <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
    <div class="row g-4">
      <?php foreach ($produk as $p): [$teksStok, $kelasStok] = $labelStok((int) $p['stok']); ?>
        <div class="col-6 col-md-4 col-lg-3 reveal">
          <article class="kartu-produk">
            <a href="<?= url_to('produk', (int) $p['id']) ?>" class="tile nada-<?= esc($p['warna']) ?>" aria-label="Lihat <?= esc($p['nama']) ?>">
              <i class="bi <?= esc($p['ikon']) ?>"></i>
              <?php if ($p['label']): ?><span class="label-produk"><?= esc($p['label']) ?></span><?php endif ?>
            </a>
            <div class="isi">
              <small class="kat"><?= esc($p['kategori']) ?></small>
              <h3><a href="<?= url_to('produk', (int) $p['id']) ?>"><?= esc($p['nama']) ?></a></h3>
              <div class="harga">
                <strong><?= $rp((int) $p['harga']) ?></strong>
                <?php if ($p['coret']): ?><s><?= $rp((int) $p['coret']) ?></s><?php endif ?>
              </div>
              <div class="stok stok-<?= $kelasStok ?>"><i class="bi bi-circle-fill"></i> <?= esc($teksStok) ?></div>
              <?php if ((int) $p['stok'] === 0): ?>
                <button class="btn btn-secondary w-100" disabled>Stok habis</button>
              <?php else: ?>
                <a href="<?= url_to('produk', (int) $p['id']) ?>" class="btn btn-se w-100"><i class="bi bi-cart-plus me-1"></i>Beli</a>
              <?php endif ?>
            </div>
          </article>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</section>

<!-- KEUNGGULAN -->
<section class="bagian" id="keunggulan">
  <div class="container">
    <div class="judul-bagian reveal">
      <span class="label-kecil">Keunggulan</span>
      <h2>Dirancang untuk alur belanja yang lengkap</h2>
      <p>Dari memilih produk sampai pesanan tiba, setiap tahap tercatat dengan rapi.</p>
    </div>
    <div class="row g-4">
      <?php foreach ($keunggulan as $f): ?>
        <div class="col-md-6 col-lg-4 reveal">
          <div class="kartu-fitur">
            <span class="ikon-fitur"><i class="bi <?= esc($f['ikon']) ?>"></i></span>
            <h3><?= esc($f['judul']) ?></h3>
            <p><?= esc($f['isi']) ?></p>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</section>

<!-- CARA BELANJA -->
<section class="bagian bagian-gelap" id="cara-belanja">
  <div class="container">
    <div class="judul-bagian reveal">
      <span class="label-kecil">Cara belanja</span>
      <h2>Lima langkah sampai pesanan tiba</h2>
    </div>
    <div class="row g-4 langkah">
      <?php foreach ($langkah as $i => $l): ?>
        <div class="col-6 col-lg reveal">
          <div class="langkah-item">
            <span class="nomor"><?= $i + 1 ?></span>
            <i class="bi <?= esc($l['ikon']) ?>"></i>
            <h3><?= esc($l['judul']) ?></h3>
            <p><?= esc($l['isi']) ?></p>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</section>

<!-- PERAN -->
<section class="bagian">
  <div class="container">
    <div class="judul-bagian reveal">
      <span class="label-kecil">Satu aplikasi, tiga peran</span>
      <h2>Setiap pengguna melihat yang ia butuhkan</h2>
    </div>
    <div class="row g-4">
      <?php foreach ($peran as $r): ?>
        <div class="col-md-4 reveal">
          <div class="kartu-peran">
            <i class="bi <?= esc($r['ikon']) ?>"></i>
            <h3><?= esc($r['judul']) ?></h3>
            <p><?= esc($r['isi']) ?></p>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="bagian bagian-abu" id="faq">
  <div class="container" style="max-width: 820px">
    <div class="judul-bagian reveal">
      <span class="label-kecil">FAQ</span>
      <h2>Pertanyaan yang sering diajukan</h2>
    </div>
    <div class="accordion se-accordion reveal" id="akordeonFaq">
      <?php foreach ($faq as $i => $q): ?>
        <div class="accordion-item">
          <h3 class="accordion-header">
            <button class="accordion-button <?= $i === 0 ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?= $i ?>" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" aria-controls="faq<?= $i ?>">
              <?= esc($q['t']) ?>
            </button>
          </h3>
          <div id="faq<?= $i ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>" data-bs-parent="#akordeonFaq">
            <div class="accordion-body"><?= esc($q['j']) ?></div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</section>

<!-- AJAKAN -->
<section class="bagian">
  <div class="container">
    <div class="ajakan reveal">
      <div>
        <h2>Siap mulai berbelanja?</h2>
        <p class="mb-0">Buat akun gratis dan mulai pesanan pertamamu.</p>
      </div>
      <div class="d-flex flex-wrap gap-2">
        <a href="<?= url_to('daftar') ?>" class="btn btn-aksen btn-lg">Daftar sekarang</a>
        <a href="<?= url_to('login') ?>" class="btn btn-putih-outline btn-lg">Saya sudah punya akun</a>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>
