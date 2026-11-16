<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Produk extends BaseController
{
    public function index()
    {
        return view('admin/produk_index', [
            'rows' => $this->db->table('produk')->select('produk.*, kategori.nama AS kategori')
                ->join('kategori', 'kategori.id = produk.kategori_id')->orderBy('produk.id', 'DESC')->get()->getResultArray(),
        ]);
    }

    public function create()
    {
        return $this->form(null);
    }

    public function edit(int $id)
    {
        return $this->form($this->cari($id));
    }

    public function store()
    {
        return $this->simpan(null);
    }

    public function update(int $id)
    {
        $this->cari($id);

        return $this->simpan($id);
    }

    public function delete(int $id)
    {
        $p = $this->cari($id);
        model(ProdukModel::class)->delete($id); // riwayat pesanan aman: detail_pesanan menyimpan salinan nama dan harga
        $this->hapusGambar($p['gambar']);

        return redirect()->to('admin/produk')->with('ok', 'Produk dihapus.');
    }

    private function form(?array $p)
    {
        return view('admin/produk_form', [
            'p'        => $p,
            'kategori' => $this->db->table('kategori')->orderBy('nama')->get()->getResultArray(),
        ]);
    }

    private function simpan(?int $id)
    {
        $rules = [
            'nama'        => 'required|max_length[150]',
            'kategori_id' => 'required|is_natural_no_zero',
            'deskripsi'   => 'permit_empty',
            'harga'       => 'required|is_natural_no_zero',
            'stok'        => 'required|is_natural',
        ];

        $file    = $this->request->getFile('gambar');
        $adaFile = $file !== null && $file->getError() !== UPLOAD_ERR_NO_FILE;
        if ($adaFile) {
            $rules['gambar'] = 'is_image[gambar]|max_size[gambar,2048]|ext_in[gambar,jpg,jpeg,png,webp]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost(['kategori_id', 'nama', 'deskripsi', 'harga', 'stok']);
        $lama = $id ? $this->cari($id)['gambar'] : null;

        if ($adaFile) {
            $nama = $file->getRandomName();
            $file->move(FCPATH . 'uploads/produk', $nama);
            $data['gambar'] = $nama;
            $this->hapusGambar($lama);
        }

        $model = model(ProdukModel::class);
        $id ? $model->update($id, $data) : $model->insert($data);

        return redirect()->to('admin/produk')->with('ok', 'Produk disimpan.');
    }

    private function hapusGambar(?string $nama): void
    {
        if ($nama && is_file(FCPATH . 'uploads/produk/' . basename($nama))) {
            unlink(FCPATH . 'uploads/produk/' . basename($nama));
        }
    }

    private function cari(int $id): array
    {
        return model(ProdukModel::class)->find($id) ?? throw PageNotFoundException::forPageNotFound();
    }
}
