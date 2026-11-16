<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Katalog extends BaseController
{
    public function index()
    {
        $model = model(ProdukModel::class);
        $q     = trim((string) $this->request->getGet('q'));
        $kat   = (int) $this->request->getGet('kategori');
        $urut  = (string) $this->request->getGet('urut');

        $model->select('produk.*, kategori.nama AS kategori')->join('kategori', 'kategori.id = produk.kategori_id');
        if ($q !== '') {
            $model->like('produk.nama', $q);
        }
        if ($kat > 0) {
            $model->where('produk.kategori_id', $kat);
        }
        match ($urut) {
            'murah' => $model->orderBy('produk.harga', 'ASC'),
            'mahal' => $model->orderBy('produk.harga', 'DESC'),
            'nama'  => $model->orderBy('produk.nama', 'ASC'),
            default => $model->orderBy('produk.id', 'DESC'),
        };

        return view('katalog/index', [
            'produk'   => $model->paginate(8),
            'pager'    => $model->pager,
            'kategori' => $this->db->table('kategori')->orderBy('nama')->get()->getResultArray(),
            'q'        => $q,
            'kat'      => $kat,
            'urut'     => $urut,
        ]);
    }

    public function detail(int $id)
    {
        $p = $this->db->table('produk')->select('produk.*, kategori.nama AS kategori')
            ->join('kategori', 'kategori.id = produk.kategori_id')->where('produk.id', $id)->get()->getRowArray();

        if (! $p) {
            throw PageNotFoundException::forPageNotFound();
        }

        $serupa = $this->db->table('produk')->where('kategori_id', $p['kategori_id'])->where('id !=', $id)
            ->orderBy('id', 'DESC')->limit(4)->get()->getResultArray();

        return view('katalog/detail', ['p' => $p, 'serupa' => $serupa]);
    }
}
