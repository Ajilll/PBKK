<?php

namespace App\Controllers;

use App\Libraries\Troli;
use App\Models\ProdukModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Keranjang extends BaseController
{
    public function index()
    {
        return view('keranjang/index', (new Troli())->detail());
    }

    public function tambah(int $id)
    {
        $p   = $this->produk($id);
        $qty = max(1, (int) $this->request->getPost('qty'));

        if ((int) $p['stok'] < 1) {
            return redirect()->back()->with('error', 'Stok produk habis.');
        }

        (new Troli())->tambah($id, $qty, (int) $p['stok']);

        return redirect()->back()->with('ok', esc($p['nama']) . ' ditambahkan ke keranjang.');
    }

    public function ubah(int $id)
    {
        $p = $this->produk($id);
        (new Troli())->ubah($id, (int) $this->request->getPost('qty'), (int) $p['stok']);

        return redirect()->to('keranjang');
    }

    public function hapus(int $id)
    {
        (new Troli())->hapus($id);

        return redirect()->to('keranjang');
    }

    private function produk(int $id): array
    {
        return model(ProdukModel::class)->find($id) ?? throw PageNotFoundException::forPageNotFound();
    }
}
