<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Menampilkan halaman profil admin
     */
    public function index()
    {
        $data = [
            'app_name' => env('APP_NAME', 'AzureVault'),
            'user'     => $this->userModel->find(session()->get('id')),
            'title'    => 'Keamanan & Profil'
        ];

        return view('admin/profile/index', $data);
    }

    /**
     * Memperbarui informasi profil dan kata sandi
     */
    public function update()
    {
        $id = session()->get('id');
        $rules = [
            'name'     => 'required|min_length[3]',
            'username' => "required|min_length[3]|is_unique[users.username,id,{$id}]",
        ];

        // Jika password diisi, tambahkan validasi password
        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Cek kembali inputan Anda.');
        }

        $data = [
            'name'     => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($this->userModel->update($id, $data)) {
            // Update session jika username/nama berubah
            session()->set(['name' => $data['name'], 'username' => $data['username']]);
            return redirect()->back()->with('success', 'Profil dan keamanan berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui profil.');
    }
}
