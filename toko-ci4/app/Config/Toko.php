<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Toko extends BaseConfig
{
    // Ganti dengan nama tokomu
    public string $nama = 'TokoKu';

    public array $rekening = ['bank' => 'Bank Contoh', 'nomor' => '1234567890', 'atas_nama' => 'Nama Pemilik Toko'];

    // Produk dengan stok <= angka ini muncul di peringatan dashboard admin
    public int $stokMenipis = 5;

    // kode status => [label, warna badge Bootstrap]
    public array $status = [
        'menunggu_pembayaran' => ['Menunggu pembayaran', 'warning'],
        'menunggu_verifikasi' => ['Menunggu verifikasi', 'info'],
        'dibayar'             => ['Dibayar', 'primary'],
        'dikirim'             => ['Dikirim', 'secondary'],
        'selesai'             => ['Selesai', 'success'],
        'batal'               => ['Batal', 'danger'],
    ];
}
