<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        return session('logged_in') ? redirect()->to('/') : view('auth/login');
    }

    public function attempt()
    {
        if (! $this->validate(['email' => 'required|valid_email', 'password' => 'required'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $this->db->table('users')->where('email', $this->request->getPost('email'))->get()->getRowArray();

        if (! $user || ! password_verify((string) $this->request->getPost('password'), $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        session()->regenerate();
        session()->set(['logged_in' => true, 'user_id' => (int) $user['id'], 'nama' => $user['nama'], 'role' => $user['role']]);

        return redirect()->to($user['role'] === 'admin' ? 'admin' : '/');
    }

    public function daftar()
    {
        return view('auth/daftar');
    }

    public function simpanDaftar()
    {
        $rules = [
            'nama'      => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[120]|is_unique[users.email]',
            'password'  => 'required|min_length[6]',
            'password2' => 'required|matches[password]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->db->table('users')->insert([
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'pelanggan', // role TIDAK diambil dari input form
        ]);

        return redirect()->to('login')->with('ok', 'Pendaftaran berhasil. Silakan masuk.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/');
    }
}
