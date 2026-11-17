# Landing Page ShopEase (CodeIgniter 4)

Tidak perlu database untuk tugas ini. Semua data contoh disiapkan di controller.

## Langkah

1. Buat proyek baru (di luar folder `siakad-ci4` dan `toko-ci4`):

   ```
   composer create-project codeigniter4/appstarter shopease-ci4
   cd shopease-ci4
   ```

2. Salin **isi** folder `app/` dan `public/` dari paket ini ke dalam `app/` dan `public/` proyek. Pilih "replace" bila ditanya (`Routes.php` memang diganti).
3. Salin `env.contoh` menjadi `.env` di root proyek.
4. Edit `app/Config/App.php`: ubah `$indexPage = 'index.php'` menjadi `$indexPage = ''` (supaya tautan tidak memuat `index.php`).
5. Jalankan: `php spark serve`, lalu buka `http://localhost:8080`.

File bawaan `app/Controllers/Home.php` dan `app/Views/welcome_message.php` tidak lagi dipakai, boleh dihapus.

## Peta file

| File | Peran |
|---|---|
| `app/Config/Routes.php` | Rute `/` ke landing page. Rute `login`, `daftar`, `katalog`, `keranjang`, dan `produk/(:num)` mengarah ke halaman "sedang dikembangkan" supaya tombol tidak berujung 404. Semua rute bernama (`as`) sehingga view memakai `url_to()`. |
| `app/Controllers/HomeController.php` | `index()` menyiapkan data (kategori, produk unggulan, keunggulan, langkah, peran, FAQ) lalu memanggil `view()`. `segera()` menampilkan halaman sementara. |
| `app/Views/layouts/main.php`, `navbar.php`, `footer.php` | Kerangka halaman yang dipakai ulang. |
| `app/Views/frontend/home.php` | Isi landing page: hero, kategori, produk unggulan, keunggulan, cara belanja, peran, FAQ, ajakan. |
| `app/Views/frontend/segera.php` | Halaman sementara. |
| `public/assets/css/shopease.css`, `js/shopease.js` | Gaya dan interaksi. |

## Uji manual

1. `/` menampilkan landing page lengkap. Gulir ke bawah dan cek animasi muncul.
2. Klik menu Kategori, Produk, Keunggulan, Cara Belanja, FAQ: halaman menggulir ke bagian itu dan menu aktif ikut berubah.
3. Perkecil jendela browser: navbar menjadi tombol menu, kartu menjadi satu atau dua kolom.
4. Ketik 1 huruf di kolom pencarian lalu Cari: muncul pesan, tidak berpindah halaman. Ketik "headset": menuju `/katalog?q=headset`.
5. Klik "Beli" pada produk: menuju `/produk/1` dan seterusnya. Produk "Sepatu Lari Ringan" berstok 0, tombolnya nonaktif.
6. Buka `/halaman-ngawur`: tampil 404 karena auto-routing nonaktif.

## Supaya hasilmu berbeda

Ganti isi di `HomeController` (nama produk, kategori, teks), palet warna di bagian `:root` pada `shopease.css`, dan urutan atau jenis bagian pada `home.php`. Gunakan screenshot dari tampilanmu sendiri.
