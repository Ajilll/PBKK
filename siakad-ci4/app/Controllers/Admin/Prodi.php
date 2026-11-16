<?php

namespace App\Controllers\Admin;

use App\Controllers\CrudController;

class Prodi extends CrudController
{
    protected string $table = 'prodi';
    protected string $judul = 'Program Studi';
    protected string $uri   = 'admin/prodi';
    protected array $kolom  = ['kode' => 'Kode', 'nama' => 'Nama Program Studi'];
    protected array $fields = [
        'kode' => ['label' => 'Kode', 'rules' => 'required|max_length[10]|is_unique[prodi.kode,id,{id}]'],
        'nama' => ['label' => 'Nama program studi', 'rules' => 'required|max_length[100]'],
    ];
}
