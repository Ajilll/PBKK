<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/** Data contoh: php spark db:seed TokoSeeder  (ganti dengan produk tokomu sendiri) */
class TokoSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('users')->insertBatch([
            ['nama' => 'Admin Toko', 'email' => 'admin@toko.test', 'password' => password_hash('Admin#2026', PASSWORD_DEFAULT), 'role' => 'admin'],
            ['nama' => 'Pelanggan Uji', 'email' => 'pelanggan@toko.test', 'password' => password_hash('Pelanggan#2026', PASSWORD_DEFAULT), 'role' => 'pelanggan'],
        ]);

        $this->db->table('kategori')->insertBatch([['nama' => 'Biji Kopi'], ['nama' => 'Alat Seduh'], ['nama' => 'Merchandise']]);

        $this->db->table('produk')->insertBatch([
            ['kategori_id' => 1, 'nama' => 'Arabika Gayo 250 gr', 'deskripsi' => 'Biji kopi arabika single origin, roasting medium.', 'harga' => 85000, 'stok' => 20],
            ['kategori_id' => 1, 'nama' => 'Robusta Temanggung 250 gr', 'deskripsi' => 'Robusta body tebal, cocok untuk kopi susu.', 'harga' => 55000, 'stok' => 30],
            ['kategori_id' => 1, 'nama' => 'Arabika Flores Bajawa 250 gr', 'deskripsi' => 'Aroma cokelat dan rempah, keasaman lembut.', 'harga' => 92000, 'stok' => 3],
            ['kategori_id' => 2, 'nama' => 'V60 Dripper Keramik', 'deskripsi' => 'Dripper ukuran 02 untuk seduh manual.', 'harga' => 120000, 'stok' => 12],
            ['kategori_id' => 2, 'nama' => 'Grinder Manual', 'deskripsi' => 'Burr stainless, kapasitas 30 gr.', 'harga' => 275000, 'stok' => 8],
            ['kategori_id' => 2, 'nama' => 'Timbangan Digital 0,1 gr', 'deskripsi' => 'Dengan timer, cocok untuk seduh manual.', 'harga' => 185000, 'stok' => 1],
            ['kategori_id' => 3, 'nama' => 'Mug Enamel', 'deskripsi' => 'Mug enamel 300 ml.', 'harga' => 65000, 'stok' => 25],
            ['kategori_id' => 3, 'nama' => 'Tote Bag Kanvas', 'deskripsi' => 'Tote bag kanvas tebal.', 'harga' => 45000, 'stok' => 40],
            ['kategori_id' => 1, 'nama' => 'Liberika Jambi 200 gr', 'deskripsi' => 'Rasa nangka dan floral yang khas.', 'harga' => 98000, 'stok' => 10],
        ]);
    }
}
