<?php

namespace App\Libraries;

use App\Models\ProdukModel;

/**
 * Keranjang belanja berbasis session.
 * Yang disimpan hanya [produk_id => qty]. Nama dan harga SELALU dibaca dari database,
 * sehingga harga tidak bisa dimanipulasi dari browser.
 */
class Troli
{
    private const KEY = 'troli';

    public function isi(): array
    {
        return session()->get(self::KEY) ?? [];
    }

    public function jumlah(): int
    {
        return array_sum($this->isi());
    }

    public function tambah(int $id, int $qty, int $stok): void
    {
        $isi      = $this->isi();
        $isi[$id] = min($stok, ($isi[$id] ?? 0) + $qty);
        session()->set(self::KEY, $isi);
    }

    public function ubah(int $id, int $qty, int $stok): void
    {
        $isi = $this->isi();
        if ($qty <= 0) {
            unset($isi[$id]);
        } else {
            $isi[$id] = min($stok, $qty);
        }
        session()->set(self::KEY, $isi);
    }

    public function hapus(int $id): void
    {
        $isi = $this->isi();
        unset($isi[$id]);
        session()->set(self::KEY, $isi);
    }

    public function kosongkan(): void
    {
        session()->remove(self::KEY);
    }

    /** @return array{items: list<array>, total: int} */
    public function detail(): array
    {
        $isi   = $this->isi();
        $items = [];
        $total = 0;

        if ($isi !== []) {
            foreach (model(ProdukModel::class)->whereIn('id', array_keys($isi))->findAll() as $p) {
                $qty = min((int) $isi[$p['id']], (int) $p['stok']);
                if ($qty < 1) {
                    continue;
                }
                $sub     = $qty * (int) $p['harga'];
                $items[] = $p + ['qty' => $qty, 'subtotal' => $sub];
                $total  += $sub;
            }
        }

        return ['items' => $items, 'total' => $total];
    }
}
