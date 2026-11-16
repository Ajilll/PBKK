<?php

if (! function_exists('rupiah')) {
    function rupiah($angka): string
    {
        return 'Rp ' . number_format((float) $angka, 0, ',', '.');
    }
}

if (! function_exists('badge_status')) {
    function badge_status(string $status): string
    {
        [$label, $warna] = config('Toko')->status[$status] ?? [$status, 'secondary'];

        return '<span class="badge text-bg-' . $warna . '">' . esc($label) . '</span>';
    }
}

if (! function_exists('gambar_produk')) {
    /** URL gambar produk, atau '' bila belum ada gambar */
    function gambar_produk(?string $gambar): string
    {
        return $gambar ? base_url('uploads/produk/' . $gambar) : '';
    }
}
