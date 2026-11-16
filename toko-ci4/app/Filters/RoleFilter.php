<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Pemakaian di Routes:  ['filter' => 'role']            -> cukup sudah login
 *                       ['filter' => 'role:admin']       -> hanya admin
 *                       ['filter' => 'role:dosen,admin'] -> dosen atau admin
 */
class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('logged_in')) {
            return redirect()->to('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (! empty($arguments) && ! in_array(session()->get('role'), $arguments, true)) {
            return redirect()->to('/')->with('error', 'Kamu tidak punya akses ke halaman itu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
