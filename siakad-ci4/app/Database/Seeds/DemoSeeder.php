<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/** Data contoh: php spark db:seed DemoSeeder  (ganti isinya dengan data milikmu sendiri) */
class DemoSeeder extends Seeder
{
    public function run()
    {
        $db  = $this->db;
        $akun = function (string $username, string $pass, string $nama, string $role) use ($db): int {
            $db->table('users')->insert([
                'username' => $username,
                'password' => password_hash($pass, PASSWORD_DEFAULT),
                'nama'     => $nama,
                'role'     => $role,
            ]);

            return (int) $db->insertID();
        };

        $akun('admin', 'Admin#2026', 'Administrator', 'admin');

        $db->table('prodi')->insertBatch([
            ['kode' => 'IF', 'nama' => 'Informatika'],
            ['kode' => 'SI', 'nama' => 'Sistem Informasi'],
        ]);

        foreach ([['0711000001', 'Dr. Budi Santoso'], ['0711000002', 'Sari Wulandari, M.Kom.']] as [$nidn, $nama]) {
            $db->table('dosen')->insert(['user_id' => $akun($nidn, $nidn, $nama, 'dosen'), 'nidn' => $nidn, 'nama' => $nama]);
        }

        foreach ([['5099000001', 'Ajeng Pratama', 1, 2024], ['5099000002', 'Rizky Hidayat', 2, 2024]] as [$nim, $nama, $prodi, $angk]) {
            $db->table('mahasiswa')->insert([
                'user_id' => $akun($nim, $nim, $nama, 'mahasiswa'), 'nim' => $nim, 'nama' => $nama,
                'prodi_id' => $prodi, 'angkatan' => $angk,
            ]);
        }

        $db->table('mata_kuliah')->insertBatch([
            ['kode' => 'IF101', 'nama' => 'Pemrograman Web', 'sks' => 3],
            ['kode' => 'IF102', 'nama' => 'Basis Data', 'sks' => 3],
            ['kode' => 'IF103', 'nama' => 'Struktur Data', 'sks' => 4],
            ['kode' => 'IF104', 'nama' => 'Jaringan Komputer', 'sks' => 3],
        ]);

        $p = '2026/2027 Ganjil';
        $db->table('kelas')->insertBatch([
            ['mata_kuliah_id' => 1, 'dosen_id' => 1, 'periode' => $p, 'hari' => 'Senin',  'jam_mulai' => '08:00', 'jam_selesai' => '10:30', 'ruang' => 'R-101', 'kuota' => 30],
            ['mata_kuliah_id' => 2, 'dosen_id' => 2, 'periode' => $p, 'hari' => 'Senin',  'jam_mulai' => '09:00', 'jam_selesai' => '11:30', 'ruang' => 'R-102', 'kuota' => 1],
            ['mata_kuliah_id' => 3, 'dosen_id' => 1, 'periode' => $p, 'hari' => 'Selasa', 'jam_mulai' => '13:00', 'jam_selesai' => '15:30', 'ruang' => 'R-103', 'kuota' => 30],
            ['mata_kuliah_id' => 4, 'dosen_id' => 2, 'periode' => $p, 'hari' => 'Rabu',   'jam_mulai' => '10:00', 'jam_selesai' => '12:30', 'ruang' => 'Lab-1', 'kuota' => 30],
        ]);
    }
}
