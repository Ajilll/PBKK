<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * Kerangka CRUD yang dipakai ulang oleh semua modul data master.
 * Subclass cukup mengisi $table, $judul, $uri, $kolom, $fields
 * dan (bila perlu) meng-override query(), opsi(), serta hook sebelumSimpan/sesudahSimpan/sesudahHapus.
 */
abstract class CrudController extends BaseController
{
    protected string $table;
    protected string $judul;
    protected string $uri;

    /** alias_kolom => Label (kolom yang tampil di tabel) */
    protected array $kolom = [];

    /** nama_field => ['label' => ..., 'type' => text|number|time|select, 'rules' => ...]; {id} diganti id baris saat ubah */
    protected array $fields = [];

    protected function query()
    {
        return $this->db->table($this->table)->select($this->table . '.*');
    }

    /** Pilihan untuk field bertipe select: [nilai => teks] */
    protected function opsi(string $field): array
    {
        return [];
    }

    /** Pemeriksaan tambahan setelah validasi biasa; kembalikan pesan error, atau null bila aman */
    protected function periksa(array $data, ?int $id): ?string
    {
        return null;
    }

    protected function sebelumSimpan(array $data, ?int $id): array
    {
        return $data;
    }

    protected function sesudahSimpan(int $id, array $data, bool $baru): void
    {
    }

    protected function sesudahHapus(array $row): void
    {
    }

    public function index()
    {
        return view('crud/index', [
            'judul' => $this->judul,
            'uri'   => $this->uri,
            'kolom' => $this->kolom,
            'rows'  => $this->query()->orderBy($this->table . '.id', 'DESC')->get()->getResultArray(),
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
        $row = $this->cari($id);

        try {
            if (! $this->db->table($this->table)->where('id', $id)->delete()) {
                throw new \RuntimeException('gagal hapus');
            }
            $this->sesudahHapus($row);
        } catch (\Throwable $e) {
            return redirect()->to($this->uri)->with('error', 'Data tidak bisa dihapus karena masih dipakai data lain.');
        }

        return redirect()->to($this->uri)->with('ok', 'Data berhasil dihapus.');
    }

    private function cari(int $id): array
    {
        $row = $this->db->table($this->table)->where('id', $id)->get()->getRowArray();

        return $row ?? throw PageNotFoundException::forPageNotFound();
    }

    private function form(?array $row)
    {
        $opsi = [];
        foreach ($this->fields as $nama => $f) {
            if (($f['type'] ?? 'text') === 'select') {
                $opsi[$nama] = $this->opsi($nama);
            }
        }

        return view('crud/form', [
            'judul'  => $this->judul,
            'uri'    => $this->uri,
            'fields' => $this->fields,
            'row'    => $row,
            'opsi'   => $opsi,
        ]);
    }

    private function simpan(?int $id)
    {
        $baru  = $id === null;
        $rules = [];
        foreach ($this->fields as $nama => $f) {
            $rules[$nama] = ['label' => $f['label'], 'rules' => str_replace('{id}', (string) ($id ?? 0), $f['rules'])];
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $post = $this->request->getPost(array_keys($this->fields));
        if ($pesan = $this->periksa($post, $id)) {
            return redirect()->back()->withInput()->with('error', $pesan);
        }

        $this->db->transStart();
        $data = $this->sebelumSimpan($post, $id);

        if ($baru) {
            $this->db->table($this->table)->insert($data);
            $id = (int) $this->db->insertID();
        } else {
            $this->db->table($this->table)->where('id', $id)->update($data);
        }

        $this->sesudahSimpan($id, $data, $baru);
        $this->db->transComplete();

        if (! $this->db->transStatus()) {
            return redirect()->back()->withInput()->with('error', 'Data gagal disimpan.');
        }

        return redirect()->to($this->uri)->with('ok', 'Data berhasil disimpan.');
    }
}
