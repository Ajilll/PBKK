<?php

namespace App\Controllers;

/**
 * Controller hanya menyiapkan data lalu menyerahkannya ke view.
 * Saat ProductModel dan CategoryModel sudah ada (milestone M2), isi method
 * kategori() dan produkUnggulan() cukup diganti dengan query ke database.
 */
class HomeController extends BaseController
{
    public function index(): string
    {
        return view('frontend/home', [
            'judul'      => 'ShopEase - Belanja Online Mudah dan Terpercaya',
            'kategori'   => $this->kategori(),
            'produk'     => $this->produkUnggulan(),
            'keunggulan' => $this->keunggulan(),
            'langkah'    => $this->langkah(),
            'peran'      => $this->peran(),
            'faq'        => $this->faq(),
        ]);
    }

    /** Halaman sementara untuk fitur yang belum dibuat */
    public function segera(string $halaman = '', ?string $id = null): string
    {
        $nama = match ($halaman) {
            'login'     => 'Halaman Masuk',
            'daftar'    => 'Halaman Pendaftaran',
            'katalog'   => 'Katalog Produk',
            'keranjang' => 'Keranjang Belanja',
            'produk'    => 'Detail Produk' . ($id !== null ? ' #' . $id : ''),
            default     => 'Halaman ini',
        };

        return view('frontend/segera', ['judul' => $nama . ' - ShopEase', 'nama' => $nama]);
    }

    private function kategori(): array
    {
        return [
            ['nama' => 'Elektronik',          'ikon' => 'bi-phone',       'warna' => 'biru',   'jumlah' => 128],
            ['nama' => 'Fashion',             'ikon' => 'bi-bag',         'warna' => 'merah',  'jumlah' => 342],
            ['nama' => 'Rumah Tangga',        'ikon' => 'bi-house-heart', 'warna' => 'hijau',  'jumlah' => 215],
            ['nama' => 'Kecantikan',          'ikon' => 'bi-stars',       'warna' => 'ungu',   'jumlah' => 187],
            ['nama' => 'Olahraga',            'ikon' => 'bi-bicycle',     'warna' => 'oranye', 'jumlah' => 96],
            ['nama' => 'Buku dan Alat Tulis', 'ikon' => 'bi-book',        'warna' => 'kuning', 'jumlah' => 154],
        ];
    }

    private function produkUnggulan(): array
    {
        return [
            ['id' => 1, 'nama' => 'Headset Nirkabel Pro',    'kategori' => 'Elektronik',   'ikon' => 'bi-headphones', 'warna' => 'biru',   'harga' => 349000, 'coret' => null,   'stok' => 24, 'label' => 'Terlaris'],
            ['id' => 2, 'nama' => 'Jaket Bomber Urban',      'kategori' => 'Fashion',      'ikon' => 'bi-bag',        'warna' => 'merah',  'harga' => 289000, 'coret' => null,   'stok' => 4,  'label' => null],
            ['id' => 3, 'nama' => 'Blender Portabel 600 ml', 'kategori' => 'Rumah Tangga', 'ikon' => 'bi-cup-straw',  'warna' => 'hijau',  'harga' => 179000, 'coret' => null,   'stok' => 15, 'label' => 'Baru'],
            ['id' => 4, 'nama' => 'Serum Vitamin C 30 ml',   'kategori' => 'Kecantikan',   'ikon' => 'bi-droplet',    'warna' => 'ungu',   'harga' => 125000, 'coret' => null,   'stok' => 40, 'label' => null],
            ['id' => 5, 'nama' => 'Sepatu Lari Ringan',      'kategori' => 'Olahraga',     'ikon' => 'bi-lightning',  'warna' => 'oranye', 'harga' => 459000, 'coret' => null,   'stok' => 0,  'label' => null],
            ['id' => 6, 'nama' => 'Novel Fiksi Ilmiah',      'kategori' => 'Buku',         'ikon' => 'bi-book',       'warna' => 'kuning', 'harga' => 89000,  'coret' => null,   'stok' => 33, 'label' => null],
            ['id' => 7, 'nama' => 'Smartwatch Fit Series',   'kategori' => 'Elektronik',   'ikon' => 'bi-smartwatch', 'warna' => 'biru',   'harga' => 599000, 'coret' => 699000, 'stok' => 9, 'label' => 'Diskon'],
            ['id' => 8, 'nama' => 'Tas Ransel Anti Air',     'kategori' => 'Fashion',      'ikon' => 'bi-backpack',   'warna' => 'merah',  'harga' => 215000, 'coret' => null,   'stok' => 18, 'label' => null],
        ];
    }

    private function keunggulan(): array
    {
        return [
            ['ikon' => 'bi-search',      'judul' => 'Katalog terpusat',         'isi' => 'Telusuri produk lewat pencarian, filter kategori, dan pengurutan harga di satu tempat.'],
            ['ikon' => 'bi-cart-check',  'judul' => 'Keranjang dan checkout',   'isi' => 'Atur jumlah belanjaan, lalu buat pesanan. Total dihitung ulang oleh server dari harga terbaru.'],
            ['ikon' => 'bi-patch-check', 'judul' => 'Pembayaran terverifikasi', 'isi' => 'Unggah bukti transfer, lalu admin memeriksa dan menyetujuinya.'],
            ['ikon' => 'bi-geo-alt',     'judul' => 'Status pesanan jelas',     'isi' => 'Pantau pesananmu dari menunggu pembayaran hingga selesai, lengkap dengan nomor resi.'],
            ['ikon' => 'bi-shield-lock', 'judul' => 'Akses dan data aman',      'isi' => 'Password di-hash, form dilindungi CSRF, dan halaman privat dibatasi menurut peran.'],
            ['ikon' => 'bi-graph-up',    'judul' => 'Dashboard penjualan',      'isi' => 'Admin melihat ringkasan produk, pelanggan, pesanan, dan penjualan secara sekilas.'],
        ];
    }

    private function langkah(): array
    {
        return [
            ['ikon' => 'bi-grid',           'judul' => 'Pilih produk',           'isi' => 'Jelajahi katalog dan buka detail produk.'],
            ['ikon' => 'bi-cart3',          'judul' => 'Isi keranjang',          'isi' => 'Tambahkan barang dan atur jumlahnya.'],
            ['ikon' => 'bi-bag-check',      'judul' => 'Checkout',               'isi' => 'Isi alamat, lalu konfirmasi pesanan.'],
            ['ikon' => 'bi-cloud-arrow-up', 'judul' => 'Bayar dan unggah bukti', 'isi' => 'Transfer sesuai total, lalu kirim bukti pembayaran.'],
            ['ikon' => 'bi-box-seam',       'judul' => 'Pesanan dikirim',        'isi' => 'Pantau status sampai paket tiba.'],
        ];
    }

    private function peran(): array
    {
        return [
            ['ikon' => 'bi-person',      'judul' => 'Customer',      'isi' => 'Berbelanja, membayar, dan memantau pesanan sendiri.'],
            ['ikon' => 'bi-person-gear', 'judul' => 'Administrator', 'isi' => 'Mengelola katalog, stok, pembayaran, pengiriman, dan laporan.'],
            ['ikon' => 'bi-boxes',       'judul' => 'Operator',      'isi' => 'Menyiapkan pesanan dan memperbarui status serta nomor resi.'],
        ];
    }

    private function faq(): array
    {
        return [
            ['t' => 'Bagaimana cara membayar?', 'j' => 'Pembayaran dilakukan lewat transfer manual. Setelah checkout, unggah bukti transfer di halaman pesanan, lalu admin akan memverifikasinya.'],
            ['t' => 'Apakah stok yang tampil selalu akurat?', 'j' => 'Stok dicek ulang oleh server saat checkout. Jika stok tidak mencukupi, pesanan ditolak agar tidak terjadi kelebihan penjualan.'],
            ['t' => 'Bagaimana memantau pesanan saya?', 'j' => 'Setiap pesanan memiliki status: menunggu pembayaran, menunggu verifikasi, diproses, dikirim, dan selesai. Nomor resi muncul saat pesanan dikirim.'],
            ['t' => 'Apakah data akun saya aman?', 'j' => 'Password disimpan dalam bentuk hash, form dilindungi token CSRF, dan hanya pemilik pesanan atau admin yang dapat membuka detail pesanan.'],
            ['t' => 'Bagaimana dengan ongkos kirim?', 'j' => 'Pada versi ini ongkos kirim berupa nilai tetap atau diisi admin. Integrasi ekspedisi otomatis belum termasuk cakupan.'],
        ];
    }
}
