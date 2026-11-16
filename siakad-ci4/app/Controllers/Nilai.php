<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Nilai extends BaseController
{
    public function index()
    {
        $dsn  = $this->profilDosen();
        $rows = $this->db->query(
            "SELECT k.id, mk.kode, mk.nama, k.periode, k.hari,
                    TIME_FORMAT(k.jam_mulai,'%H:%i') AS mulai, TIME_FORMAT(k.jam_selesai,'%H:%i') AS selesai,
                    (SELECT COUNT(*) FROM krs WHERE kelas_id = k.id) AS peserta,
                    (SELECT COUNT(*) FROM krs r JOIN nilai n ON n.krs_id = r.id WHERE r.kelas_id = k.id) AS dinilai
             FROM kelas k JOIN mata_kuliah mk ON mk.id = k.mata_kuliah_id
             WHERE k.dosen_id = ? ORDER BY k.periode DESC, mk.kode",
            [$dsn['id']]
        )->getResultArray();

        return view('nilai/index', ['rows' => $rows]);
    }

    public function peserta(int $kelasId)
    {
        $kelas    = $this->kelasMilik($kelasId);
        $peserta = $this->db->query(
            'SELECT krs.id AS krs_id, m.nim, m.nama, n.angka, n.huruf
             FROM krs JOIN mahasiswa m ON m.id = krs.mahasiswa_id
             LEFT JOIN nilai n ON n.krs_id = krs.id
             WHERE krs.kelas_id = ? ORDER BY m.nim',
            [$kelasId]
        )->getResultArray();

        return view('nilai/peserta', ['kelas' => $kelas, 'peserta' => $peserta]);
    }

    public function simpan(int $kelasId)
    {
        $this->kelasMilik($kelasId);

        $input = $this->request->getPost('nilai') ?? [];
        $sah   = array_map('intval', array_column(
            $this->db->table('krs')->select('id')->where('kelas_id', $kelasId)->get()->getResultArray(),
            'id'
        ));

        // validasi semua dulu, baru simpan
        $simpan = [];
        foreach ($input as $krsId => $angka) {
            $angka = trim((string) $angka);
            if ($angka === '' || ! in_array((int) $krsId, $sah, true)) {
                continue;
            }
            if (! is_numeric($angka) || (float) $angka < 0 || (float) $angka > 100) {
                return redirect()->back()->with('error', 'Nilai harus berupa angka 0 sampai 100.');
            }
            $simpan[(int) $krsId] = (float) $angka;
        }

        $this->db->transStart();
        foreach ($simpan as $krsId => $angka) {
            $h = konversi_nilai($angka);
            $this->db->query(
                'INSERT INTO nilai (krs_id, angka, huruf, bobot) VALUES (?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE angka = VALUES(angka), huruf = VALUES(huruf), bobot = VALUES(bobot)',
                [$krsId, $angka, $h['huruf'], $h['bobot']]
            );
        }
        $this->db->transComplete();

        return redirect()->to("nilai/{$kelasId}")->with('ok', count($simpan) . ' nilai disimpan.');
    }

    /** Dosen hanya boleh membuka kelas yang ia ampu */
    private function kelasMilik(int $kelasId): array
    {
        $dsn = $this->profilDosen();
        $k   = $this->db->query(
            'SELECT k.*, mk.kode, mk.nama FROM kelas k JOIN mata_kuliah mk ON mk.id = k.mata_kuliah_id
             WHERE k.id = ? AND k.dosen_id = ?',
            [$kelasId, $dsn['id']]
        )->getRowArray();

        return $k ?? throw PageNotFoundException::forPageNotFound();
    }
}
