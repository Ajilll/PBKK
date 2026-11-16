<?php

namespace App\Controllers\Admin;

use App\Controllers\CrudController;

class MataKuliah extends CrudController
{
    protected string $table = 'mata_kuliah';
    protected string $judul = 'Mata Kuliah';
    protected string $uri   = 'admin/matakuliah';
    protected array $kolom  = ['kode' => 'Kode', 'nama' => 'Nama Mata Kuliah', 'sks' => 'SKS'];
    protected array $fields = [
        'kode' => ['label' => 'Kode', 'rules' => 'required|max_length[15]|is_unique[mata_kuliah.kode,id,{id}]'],
        'nama' => ['label' => 'Nama mata kuliah', 'rules' => 'required|max_length[100]'],
        'sks'  => ['label' => 'SKS', 'type' => 'number', 'rules' => 'required|is_natural_no_zero|less_than_equal_to[6]'],
    ];
}
