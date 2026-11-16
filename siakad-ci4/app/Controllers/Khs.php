<?php

namespace App\Controllers;

class Khs extends BaseController
{
    public function index()
    {
        $mhs  = $this->profilMahasiswa();
        $rows = $this->db->query(
            'SELECT k.periode, mk.kode, mk.nama, mk.sks, n.angka, n.huruf, n.bobot
             FROM krs JOIN kelas k ON k.id = krs.kelas_id
             JOIN mata_kuliah mk ON mk.id = k.mata_kuliah_id
             JOIN nilai n ON n.krs_id = krs.id
             WHERE krs.mahasiswa_id = ? ORDER BY k.periode, mk.kode',
            [$mhs['id']]
        )->getResultArray();

        $per = [];
        $totSks = 0;
        $totMutu = 0.0;

        foreach ($rows as $r) {
            $p = $r['periode'];
            $per[$p]['rows'][] = $r;
            $per[$p]['sks']  ??= 0;
            $per[$p]['mutu'] ??= 0.0;
            $per[$p]['sks']  += (int) $r['sks'];
            $per[$p]['mutu'] += (int) $r['sks'] * (float) $r['bobot'];
            $totSks  += (int) $r['sks'];
            $totMutu += (int) $r['sks'] * (float) $r['bobot'];
        }

        foreach ($per as &$p) {
            $p['ips'] = $p['sks'] > 0 ? $p['mutu'] / $p['sks'] : 0;
        }
        unset($p);

        return view('khs/index', [
            'mhs'     => $mhs,
            'per'     => $per,
            'totSks'  => $totSks,
            'ipk'     => $totSks > 0 ? $totMutu / $totSks : 0,
        ]);
    }
}
