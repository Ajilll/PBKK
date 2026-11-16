<?php

namespace App\Controllers\Admin;

use App\Controllers\AkunCrudController;

class Mahasiswa extends AkunCrudController
{
    protected string $table     = 'mahasiswa';
    protected string $judul     = 'Mahasiswa';
    protected string $uri       = 'admin/mahasiswa';
    protected string $role      = 'mahasiswa';
    protected string $kodeField = 'nim';
    protected array $kolom      = ['nim' => 'NIM', 'nama' => 'Nama', 'prodi' => 'Program Studi', 'angkatan' => 'Angkatan'];
    protected array $fields     = [
        'nim'      => ['label' => 'NIM', 'rules' => 'required|max_length[20]|is_unique[mahasiswa.nim,id,{id}]'],
        'nama'     => ['label' => 'Nama', 'rules' => 'required|max_length[100]'],
        'prodi_id' => ['label' => 'Program studi', 'type' => 'select', 'rules' => 'required|is_natural_no_zero'],
        'angkatan' => ['label' => 'Angkatan', 'type' => 'number', 'rules' => 'required|exact_length[4]|is_natural_no_zero'],
    ];

    protected function query()
    {
        return $this->db->table('mahasiswa')->select('mahasiswa.*, prodi.nama AS prodi')->join('prodi', 'prodi.id = mahasiswa.prodi_id');
    }

    protected function opsi(string $field): array
    {
        return array_column($this->db->table('prodi')->orderBy('nama')->get()->getResultArray(), 'nama', 'id');
    }
}
