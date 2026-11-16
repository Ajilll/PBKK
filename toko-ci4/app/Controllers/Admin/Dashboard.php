<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $cfg = config('Toko');

        $perStatus = array_column(
            $this->db->query('SELECT status, COUNT(*) AS n FROM pesanan GROUP BY status')->getResultArray(),
            'n',
            'status'
        );

        return view('admin/dashboard', [
            'perStatus' => $perStatus,
            'omzet'     => (int) $this->db->query("SELECT COALESCE(SUM(total), 0) AS t FROM pesanan WHERE status IN ('dibayar','dikirim','selesai')")->getRow()->t,
            'jmlProduk' => $this->db->table('produk')->countAll(),
            'jmlUser'   => $this->db->table('users')->where('role', 'pelanggan')->countAllResults(),
            'menipis'   => $this->db->table('produk')->where('stok <=', $cfg->stokMenipis)->orderBy('stok')->get()->getResultArray(),
            'status'    => $cfg->status,
        ]);
    }
}
