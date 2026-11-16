<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $role = session('role');
        $data = ['role' => $role, 'periode' => config('Siakad')->periodeAktif];

        if ($role === 'admin') {
            foreach (['mahasiswa', 'dosen', 'mata_kuliah', 'kelas'] as $t) {
                $data['stat'][$t] = $this->db->table($t)->countAll();
            }
        } elseif ($role === 'dosen') {
            $d = $this->profilDosen();
            $data['jadwal'] = $this->db->query(
                "SELECT mk.kode, mk.nama, k.hari, TIME_FORMAT(k.jam_mulai,'%H:%i') AS mulai,
                        TIME_FORMAT(k.jam_selesai,'%H:%i') AS selesai, k.ruang,
                        (SELECT COUNT(*) FROM krs WHERE kelas_id = k.id) AS peserta
                 FROM kelas k JOIN mata_kuliah mk ON mk.id = k.mata_kuliah_id
                 WHERE k.dosen_id = ? AND k.periode = ? ORDER BY FIELD(k.hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'), k.jam_mulai",
                [$d['id'], $data['periode']]
            )->getResultArray();
        } else {
            $m = $this->profilMahasiswa();
            $data['mhs'] = $m;
            $data['ringkas'] = $this->db->query(
                'SELECT COALESCE(SUM(mk.sks * n.bobot) / NULLIF(SUM(mk.sks), 0), 0) AS ipk, COALESCE(SUM(mk.sks), 0) AS sks
                 FROM krs JOIN nilai n ON n.krs_id = krs.id
                 JOIN kelas k ON k.id = krs.kelas_id JOIN mata_kuliah mk ON mk.id = k.mata_kuliah_id
                 WHERE krs.mahasiswa_id = ?',
                [$m['id']]
            )->getRowArray();
            $data['jadwal'] = $this->db->query(
                "SELECT mk.kode, mk.nama, mk.sks, k.hari, TIME_FORMAT(k.jam_mulai,'%H:%i') AS mulai,
                        TIME_FORMAT(k.jam_selesai,'%H:%i') AS selesai, k.ruang
                 FROM krs JOIN kelas k ON k.id = krs.kelas_id JOIN mata_kuliah mk ON mk.id = k.mata_kuliah_id
                 WHERE krs.mahasiswa_id = ? AND k.periode = ?
                 ORDER BY FIELD(k.hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'), k.jam_mulai",
                [$m['id'], $data['periode']]
            )->getResultArray();
        }

        return view('dashboard', $data);
    }
}
