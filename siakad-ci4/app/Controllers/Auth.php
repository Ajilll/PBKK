<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function index()
    {
        return redirect()->to(session('logged_in') ? 'dashboard' : 'login');
    }

    public function login()
    {
        if (session('logged_in')) {
            return redirect()->to('dashboard');
        }

        return view('auth/login');
    }

    public function attempt()
    {
        $rules = ['username' => 'required', 'password' => 'required'];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $this->db->table('users')->where('username', $this->request->getPost('username'))->get()->getRowArray();

        if (! $user || ! password_verify((string) $this->request->getPost('password'), $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah.');
        }

        session()->regenerate();
        session()->set([
            'logged_in' => true,
            'user_id'   => (int) $user['id'],
            'nama'      => $user['nama'],
            'role'      => $user['role'],
        ]);

        return redirect()->to('dashboard');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('login');
    }
}
