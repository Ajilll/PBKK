<?php

namespace App\Controllers;

class Krs extends BaseController
{
    public function index()
    {
        $mhs = $this->profilMahasiswa();
        $cfg = config('Siakad');

        $kelas = $this->db->query(
            "SELECT k.id, mk.kode, mk.nama, mk.sks, d.nama AS dosen, k.hari,
                    TIME_FORMAT(k.jam_mulai,'%H:%i') AS mulai, TIME_FORMAT(k.jam_selesai,'%H:%i') AS selesai,
                    k.ruang, k.kuota,
                    (SELECT COUNT(*) FROM krs WHERE kelas_id = k.id) AS terisi,
                    (SELECT id FROM krs WHERE kelas_id = k.id AND mahasiswa_id = ?) AS krs_id,
                    (SELECT COUNT(*) FROM nilai n JOIN krs r ON r.id = n.krs_id WHERE r.kelas_id = k.id AND r.mahasiswa_id = ?) AS sudah_dinilai
             FROM kelas k
             JOIN mata_kuliah mk ON mk.id = k.mata_kuliah_id
             JOIN dosen d ON d.id = k.dosen_id
             WHERE k.periode = ?
             ORDER BY mk.kode, k.id",
            [$mhs['id'], $mhs['id'], $cfg->periodeAktif]
        )->getResultArray();

        return view('krs/index', [
            'kelas' => $kelas,
            'sks'   => $this->sksBerjalan((int) $mhs['id']),
            'cfg'   => $cfg,
        ]);
    }

    public function ambil(int $kelasId)
    {
        $mhs = $this->profilMahasiswa();
        $cfg = config('Siakad');

        $this->db->transBegin();

        // FOR UPDATE: kunci baris kelas supaya dua mahasiswa tidak bisa mengambil kursi terakhir bersamaan
        $k = $this->db->query(
            'SELECT k.*, mk.sks FROM kelas k JOIN mata_kuliah mk ON mk.id = k.mata_kuliah_id
             WHERE k.id = ? AND k.periode = ? FOR UPDATE',
            [$kelasId, $cfg->periodeAktif]
        )->getRowArray();

        $err = null;
        if (! $k) {
            $err = 'Kelas tidak tersedia pada periode aktif.';
        } elseif ($this->db->table('krs')->where(['mahasiswa_id' => $mhs['id'], 'kelas_id' => $kelasId])->countAllResults() > 0) {
            $err = 'Kelas ini sudah kamu ambil.';
        } elseif ($this->db->table('krs')->where('kelas_id', $kelasId)->countAllResults() >= (int) $k['kuota']) {
            $err = 'Kuota kelas sudah penuh.';
        } elseif ($this->sksBerjalan((int) $mhs['id']) + (int) $k['sks'] > $cfg->maxSks) {
            $err = "Total SKS melebihi batas {$cfg->maxSks}.";
        } elseif ($this->bentrok((int) $mhs['id'], $k)) {
            $err = 'Jadwal bentrok dengan kelas lain yang sudah kamu ambil.';
        }

        if ($err !== null) {
            $this->db->transRollback();

            return redirect()->to('krs')->with('error', $err);
        }

        $this->db->table('krs')->insert(['mahasiswa_id' => $mhs['id'], 'kelas_id' => $kelasId]);
        $this->db->transCommit();

        return redirect()->to('krs')->with('ok', 'Kelas berhasil ditambahkan ke KRS.');
    }

    public function batal(int $krsId)
    {
        $mhs = $this->profilMahasiswa();

        // hanya bisa dibatalkan selama belum ada nilai
        $this->db->query(
            'DELETE FROM krs WHERE id = ? AND mahasiswa_id = ? AND id NOT IN (SELECT krs_id FROM nilai)',
            [$krsId, $mhs['id']]
        );

        return $this->db->affectedRows() > 0
            ? redirect()->to('krs')->with('ok', 'Kelas dibatalkan dari KRS.')
            : redirect()->to('krs')->with('error', 'KRS tidak bisa dibatalkan (sudah dinilai atau tidak ditemukan).');
    }

    private function sksBerjalan(int $mhsId): int
    {
        $row = $this->db->query(
            'SELECT COALESCE(SUM(mk.sks), 0) AS s FROM krs
             JOIN kelas k ON k.id = krs.kelas_id JOIN mata_kuliah mk ON mk.id = k.mata_kuliah_id
             WHERE krs.mahasiswa_id = ? AND k.periode = ?',
            [$mhsId, config('Siakad')->periodeAktif]
        )->getRowArray();

        return (int) $row['s'];
    }

    /** Dua jadwal bentrok bila hari sama dan rentang jamnya beririsan */
    private function bentrok(int $mhsId, array $k): bool
    {
        return $this->db->query(
            'SELECT 1 FROM krs JOIN kelas x ON x.id = krs.kelas_id
             WHERE krs.mahasiswa_id = ? AND x.periode = ? AND x.hari = ?
               AND x.jam_mulai < ? AND x.jam_selesai > ? LIMIT 1',
            [$mhsId, $k['periode'], $k['hari'], $k['jam_selesai'], $k['jam_mulai']]
        )->getNumRows() > 0;
    }
}
