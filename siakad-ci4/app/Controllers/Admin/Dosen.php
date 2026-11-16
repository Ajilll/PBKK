<?php

namespace App\Controllers\Admin;

use App\Controllers\AkunCrudController;

class Dosen extends AkunCrudController
{
    protected string $table     = 'dosen';
    protected string $judul     = 'Dosen';
    protected string $uri       = 'admin/dosen';
    protected string $role      = 'dosen';
    protected string $kodeField = 'nidn';
    protected array $kolom      = ['nidn' => 'NIDN', 'nama' => 'Nama'];
    protected array $fields     = [
        'nidn' => ['label' => 'NIDN', 'rules' => 'required|max_length[20]|is_unique[dosen.nidn,id,{id}]'],
        'nama' => ['label' => 'Nama', 'rules' => 'required|max_length[100]'],
    ];
}
