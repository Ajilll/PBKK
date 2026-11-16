<?php

if (! function_exists('konversi_nilai')) {
    /** Angka 0-100 -> ['huruf' => 'A', 'bobot' => 4.0] berdasarkan Config\Siakad::$skala */
    function konversi_nilai(float $angka): array
    {
        foreach (config('Siakad')->skala as [$batas, $huruf, $bobot]) {
            if ($angka >= $batas) {
                return ['huruf' => $huruf, 'bobot' => $bobot];
            }
        }

        return ['huruf' => 'E', 'bobot' => 0.0];
    }
}

if (! function_exists('fmt_nilai')) {
    function fmt_nilai(float $n): string
    {
        return number_format($n, 2, ',', '.');
    }
}
