<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Siakad extends BaseConfig
{
    // Ganti nama aplikasi sesuai pilihanmu
    public string $namaApp = 'SIAKAD';

    // Periode yang dibuka untuk pengisian KRS (harus sama persis dengan kolom kelas.periode)
    public string $periodeAktif = '2026/2027 Ganjil';

    // Batas SKS per periode (sesuaikan dengan aturan kampusmu)
    public int $maxSks = 24;

    // Skala nilai: [batas minimal, huruf, bobot]. CONTOH SAJA, sesuaikan dengan pedoman akademik kampusmu.
    public array $skala = [
        [86, 'A', 4.0],
        [76, 'AB', 3.5],
        [66, 'B', 3.0],
        [61, 'BC', 2.5],
        [56, 'C', 2.0],
        [41, 'D', 1.0],
    ];
}
