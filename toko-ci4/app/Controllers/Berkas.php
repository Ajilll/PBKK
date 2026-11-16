<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

/** Menyajikan bukti pembayaran (disimpan di writable/, tidak bisa diakses langsung lewat URL) */
class Berkas extends BaseController
{
    public function bukti(string $kode)
    {
        $q = $this->db->table('pesanan')->where('kode', $kode);
        if (session('role') !== 'admin') {
            $q->where('user_id', session('user_id'));
        }
        $p = $q->get()->getRowArray();

        $path = $p && $p['bukti_bayar'] ? WRITEPATH . 'uploads/bukti/' . basename($p['bukti_bayar']) : null;
        if ($path === null || ! is_file($path)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $this->response->setContentType(mime_content_type($path))->setBody(file_get_contents($path));
    }
}
