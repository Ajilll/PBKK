<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

/** Dipakai pelanggan (pesanan miliknya) dan admin (semua pesanan) */
class Pesanan extends BaseController
{
    private function admin(): bool
    {
        return session('role') === 'admin';
    }

    public function index()
    {
        $q = $this->db->table('pesanan')->select('pesanan.*, users.nama AS pemesan')->join('users', 'users.id = pesanan.user_id');

        $status = (string) $this->request->getGet('status');
        if ($this->admin()) {
            if (isset(config('Toko')->status[$status])) {
                $q->where('pesanan.status', $status);
            }
        } else {
            $q->where('pesanan.user_id', session('user_id'));
        }

        return view('pesanan/index', [
            'rows'   => $q->orderBy('pesanan.id', 'DESC')->get()->getResultArray(),
            'admin'  => $this->admin(),
            'status' => $status,
        ]);
    }

    public function detail(string $kode)
    {
        $p = $this->cari($kode);

        return view('pesanan/detail', [
            'p'     => $p,
            'items' => $this->db->table('detail_pesanan')->where('pesanan_id', $p['id'])->get()->getResultArray(),
            'admin' => $this->admin(),
            'toko'  => config('Toko'),
        ]);
    }

    /** Pelanggan mengunggah bukti pembayaran */
    public function bukti(string $kode)
    {
        $p = $this->cari($kode);

        if ($p['status'] !== 'menunggu_pembayaran') {
            return redirect()->back()->with('error', 'Pesanan ini tidak sedang menunggu pembayaran.');
        }

        $rules = ['bukti' => 'uploaded[bukti]|max_size[bukti,2048]|ext_in[bukti,jpg,jpeg,png,pdf]|mime_in[bukti,image/jpeg,image/png,application/pdf]'];
        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('bukti');
        $nama = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/bukti', $nama); // di luar folder public, diakses lewat Berkas::bukti

        $this->db->table('pesanan')->where('id', $p['id'])->update(['bukti_bayar' => $nama, 'status' => 'menunggu_verifikasi']);

        return redirect()->to('pesanan/' . $kode)->with('ok', 'Bukti pembayaran terkirim, menunggu verifikasi admin.');
    }

    /** Admin mengubah status pesanan */
    public function status(string $kode)
    {
        $p   = $this->cari($kode);
        $baru = (string) $this->request->getPost('status');

        if (! isset(config('Toko')->status[$baru])) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }
        if ($p['status'] === 'batal') {
            return redirect()->back()->with('error', 'Pesanan yang sudah dibatalkan tidak bisa diubah lagi.');
        }

        $this->db->transStart();
        if ($baru === 'batal') {
            // kembalikan stok produk
            $this->db->query(
                'UPDATE produk p JOIN detail_pesanan d ON d.produk_id = p.id SET p.stok = p.stok + d.qty WHERE d.pesanan_id = ?',
                [$p['id']]
            );
        }
        $this->db->table('pesanan')->where('id', $p['id'])->update(['status' => $baru]);
        $this->db->transComplete();

        return redirect()->to('pesanan/' . $kode)->with('ok', 'Status pesanan diperbarui.');
    }

    private function cari(string $kode): array
    {
        $q = $this->db->table('pesanan')->select('pesanan.*, users.nama AS pemesan')
            ->join('users', 'users.id = pesanan.user_id')->where('pesanan.kode', $kode);
        if (! $this->admin()) {
            $q->where('pesanan.user_id', session('user_id'));
        }

        return $q->get()->getRowArray() ?? throw PageNotFoundException::forPageNotFound();
    }
}
