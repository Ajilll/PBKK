<?php

namespace App\Controllers;

use App\Libraries\Troli;

class Checkout extends BaseController
{
    public function index()
    {
        $troli = new Troli();
        $d     = $troli->detail();
        if ($d['items'] === []) {
            return redirect()->to('keranjang')->with('error', 'Keranjang masih kosong.');
        }

        if ($this->stokBerubah($troli, $d)) {
            return redirect()->to('keranjang')->with('error', 'Stok sebagian produk berubah. Periksa kembali jumlah di keranjang.');
        }

        return view('checkout/form', $d);
    }

    public function proses()
    {
        $troli = new Troli();
        $d     = $troli->detail();

        if ($d['items'] === []) {
            return redirect()->to('keranjang')->with('error', 'Keranjang masih kosong.');
        }

        // jangan diam-diam membuang item yang stoknya sudah habis atau berkurang
        if ($this->stokBerubah($troli, $d)) {
            return redirect()->to('keranjang')->with('error', 'Stok sebagian produk berubah. Periksa kembali jumlah di keranjang.');
        }

        $rules = [
            'nama_penerima' => 'required|max_length[100]',
            'telepon'       => 'required|regex_match[/^[0-9+\- ]{8,16}$/]',
            'alamat'        => 'required|min_length[10]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $kode = 'PSN-' . date('ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

        // Satu transaksi: pesanan, detail, dan pengurangan stok berhasil semua atau batal semua
        $this->db->transBegin();
        try {
            $this->db->table('pesanan')->insert([
                'kode'          => $kode,
                'user_id'       => session('user_id'),
                'nama_penerima' => $this->request->getPost('nama_penerima'),
                'telepon'       => $this->request->getPost('telepon'),
                'alamat'        => $this->request->getPost('alamat'),
                'total'         => $d['total'],
            ]);
            $pesananId = (int) $this->db->insertID();

            foreach ($d['items'] as $it) {
                // kondisi "stok >= qty" mencegah stok negatif bila dua orang membeli bersamaan
                $this->db->query('UPDATE produk SET stok = stok - ? WHERE id = ? AND stok >= ?', [$it['qty'], $it['id'], $it['qty']]);
                if ($this->db->affectedRows() !== 1) {
                    throw new \RuntimeException('Stok ' . $it['nama'] . ' tidak mencukupi.');
                }

                $this->db->table('detail_pesanan')->insert([
                    'pesanan_id'  => $pesananId,
                    'produk_id'   => $it['id'],
                    'nama_produk' => $it['nama'],
                    'harga'       => $it['harga'],
                    'qty'         => $it['qty'],
                ]);
            }
            $this->db->transCommit();
        } catch (\Throwable $e) {
            $this->db->transRollback();

            return redirect()->to('keranjang')->with('error', $e->getMessage());
        }

        $troli->kosongkan();

        return redirect()->to('pesanan/' . $kode)->with('ok', 'Pesanan dibuat. Silakan lakukan pembayaran.');
    }

    /** True bila ada item di keranjang yang hilang atau jumlahnya dikurangi karena stok */
    private function stokBerubah(Troli $troli, array $d): bool
    {
        $ada = array_column($d['items'], 'qty', 'id');
        foreach ($troli->isi() as $id => $qty) {
            if (($ada[$id] ?? 0) !== (int) $qty) {
                return true;
            }
        }

        return false;
    }
}
