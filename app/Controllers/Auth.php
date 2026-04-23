<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return session()->get('role') === 'admin'
                ? redirect()->to('admin/dashboard')
                : redirect()->to('user/dashboard');
        }

        $data = [
            'app_name' => env('APP_NAME', 'AzureVault'),
            'title'    => 'Masuk Ke Akun'
        ];
        return view('auth/login', $data);
    }

    public function register()
    {
        $data = [
            'app_name' => env('APP_NAME', 'AzureVault'),
            'title'    => 'Daftar Akun Baru'
        ];
        return view('auth/register', $data);
    }

    public function store()
    {
        $rules = [
            'name'     => 'required|min_length[3]',
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan atau data tidak valid.');
        }

        $data = [
            'name'     => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'balance'  => 0,
            'role'     => 'customer'
        ];

        $this->userModel->insert($data);

        return redirect()->to('auth/login')->with('success', 'Akun berhasil dibuat! Silakan masuk.');
    }

    public function attempt()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user->password)) {
            session()->set([
                'id'         => $user->id,
                'username'   => $user->username,
                'name'       => $user->name,
                'balance'    => $user->balance,
                'role'       => $user->role,
                'isLoggedIn' => true
            ]);

            return $user->role === 'admin'
                ? redirect()->to('admin/dashboard')
                : redirect()->to('user/dashboard');
        }

        return redirect()->back()->with('error', 'Kredensial tidak valid.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('auth/login');
    }
}

