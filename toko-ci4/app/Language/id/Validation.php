<?php

// Pesan validasi bahasa Indonesia. Aktifkan dengan: App.php -> $defaultLocale = 'id';
return [
    'required'              => '{field} wajib diisi.',
    'permit_empty'          => '{field} boleh kosong.',
    'is_unique'             => '{field} sudah dipakai.',
    'max_length'            => '{field} maksimal {param} karakter.',
    'min_length'            => '{field} minimal {param} karakter.',
    'exact_length'          => '{field} harus tepat {param} karakter.',
    'is_natural'            => '{field} harus berupa angka bulat 0 atau lebih.',
    'is_natural_no_zero'    => '{field} harus berupa angka bulat lebih dari 0 (atau pilih salah satu).',
    'less_than_equal_to'    => '{field} tidak boleh lebih dari {param}.',
    'in_list'               => '{field} tidak valid.',
    'regex_match'           => '{field} formatnya tidak sesuai.',
    'valid_email'           => '{field} harus berupa email yang valid.',
    'matches'               => '{field} tidak sama dengan {param}.',
    'uploaded'              => '{field} belum dipilih atau gagal diunggah.',
    'max_size'              => 'Ukuran {field} terlalu besar (maksimal {param} KB).',
    'ext_in'                => 'Jenis file {field} tidak diizinkan.',
    'mime_in'               => 'Jenis file {field} tidak diizinkan.',
    'is_image'              => '{field} harus berupa gambar.',
];
