<?php

namespace App\Controllers;

/**
 * CRUD untuk data yang punya akun login (mahasiswa, dosen).
 * Menambah data -> akun dibuat otomatis (username = NIM/NIDN, password awal sama).
 */
abstract class AkunCrudController extends CrudController
{
    protected string $role;       // 'mahasiswa' | 'dosen'
    protected string $kodeField;  // 'nim' | 'nidn'

    /** NIM/NIDN dipakai sebagai username, jadi tidak boleh bentrok dengan akun lain (admin, dosen, mahasiswa) */
    protected function periksa(array $data, ?int $id): ?string
    {
        $q = $this->db->table('users')->where('username', $data[$this->kodeField]);
        if ($id !== null) {
            $milik = $this->db->table($this->table)->select('user_id')->where('id', $id)->get()->getRowArray();
            $q->where('id !=', $milik['user_id'] ?? 0);
        }

        return $q->countAllResults() > 0 ? 'Kode tersebut sudah dipakai sebagai username akun lain.' : null;
    }

    protected function sebelumSimpan(array $data, ?int $id): array
    {
        if ($id === null) {
            $kode = $data[$this->kodeField];
            $this->db->table('users')->insert([
                'username' => $kode,
                'password' => password_hash($kode, PASSWORD_DEFAULT),
                'nama'     => $data['nama'],
                'role'     => $this->role,
            ]);
            $data['user_id'] = (int) $this->db->insertID();
        }

        return $data;
    }

    protected function sesudahSimpan(int $id, array $data, bool $baru): void
    {
        if (! $baru) {
            // sinkronkan nama dan username pada akun
            $this->db->query(
                "UPDATE users u JOIN {$this->table} t ON t.user_id = u.id SET u.username = ?, u.nama = ? WHERE t.id = ?",
                [$data[$this->kodeField], $data['nama'], $id]
            );
        }
    }

    protected function sesudahHapus(array $row): void
    {
        $this->db->table('users')->where('id', $row['user_id'])->delete();
    }
}
