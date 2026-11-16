<?php

namespace App\Controllers\Admin;

use App\Controllers\CrudController;

class Kelas extends CrudController
{
    private const HARI = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    protected string $table = 'kelas';
    protected string $judul = 'Kelas dan Jadwal';
    protected string $uri   = 'admin/kelas';
    protected array $kolom  = [
        'mk' => 'Mata Kuliah', 'dosen' => 'Dosen', 'periode' => 'Periode',
        'hari' => 'Hari', 'jam' => 'Jam', 'ruang' => 'Ruang', 'kuota' => 'Kuota',
    ];
    protected array $fields = [
        'mata_kuliah_id' => ['label' => 'Mata kuliah', 'type' => 'select', 'rules' => 'required|is_natural_no_zero'],
        'dosen_id'       => ['label' => 'Dosen pengampu', 'type' => 'select', 'rules' => 'required|is_natural_no_zero'],
        'periode'        => ['label' => 'Periode (contoh: 2026/2027 Ganjil)', 'rules' => 'required|max_length[20]'],
        'hari'           => ['label' => 'Hari', 'type' => 'select', 'rules' => 'required|in_list[Senin,Selasa,Rabu,Kamis,Jumat,Sabtu]'],
        'jam_mulai'      => ['label' => 'Jam mulai', 'type' => 'time', 'rules' => 'required|regex_match[/^\d{2}:\d{2}(:\d{2})?$/]'],
        'jam_selesai'    => ['label' => 'Jam selesai', 'type' => 'time', 'rules' => 'required|regex_match[/^\d{2}:\d{2}(:\d{2})?$/]'],
        'ruang'          => ['label' => 'Ruang', 'rules' => 'required|max_length[20]'],
        'kuota'          => ['label' => 'Kuota', 'type' => 'number', 'rules' => 'required|is_natural_no_zero'],
    ];

    protected function query()
    {
        return $this->db->table('kelas')
            ->select("kelas.*, CONCAT(mk.kode, ' - ', mk.nama) AS mk, d.nama AS dosen,
                      CONCAT(TIME_FORMAT(kelas.jam_mulai,'%H:%i'), '-', TIME_FORMAT(kelas.jam_selesai,'%H:%i')) AS jam", false)
            ->join('mata_kuliah mk', 'mk.id = kelas.mata_kuliah_id')
            ->join('dosen d', 'd.id = kelas.dosen_id');
    }

    protected function opsi(string $field): array
    {
        return match ($field) {
            'mata_kuliah_id' => array_column(
                $this->db->query("SELECT id, CONCAT(kode, ' - ', nama) AS t FROM mata_kuliah ORDER BY kode")->getResultArray(),
                't',
                'id'
            ),
            'dosen_id' => array_column($this->db->table('dosen')->orderBy('nama')->get()->getResultArray(), 'nama', 'id'),
            'hari'     => array_combine(self::HARI, self::HARI),
            default    => [],
        };
    }

    // jam selesai harus setelah jam mulai (dasar deteksi jadwal bentrok di KRS)
    protected function periksa(array $data, ?int $id): ?string
    {
        return strcmp($data['jam_selesai'], $data['jam_mulai']) <= 0 ? 'Jam selesai harus setelah jam mulai.' : null;
    }
}
