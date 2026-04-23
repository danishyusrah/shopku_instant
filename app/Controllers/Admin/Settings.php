<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class Settings extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $data = [
            'app_name' => env('APP_NAME', 'AzureVault'),
            'settings' => $this->settingModel->getAllSettings(),
            'title'    => 'Pengaturan Situs'
        ];

        return view('admin/settings/index', $data);
    }

    public function update()
    {
        $posts = $this->request->getPost();

        foreach ($posts as $key => $value) {
            // Hanya update jika key ada di daftar yang diizinkan
            if (in_array($key, ['site_name', 'site_tagline', 'hero_title', 'hero_description', 'whatsapp_number', 'contact_email'])) {
                $this->settingModel->save([
                    'key'   => $key,
                    'value' => $value
                ]);
            }
        }

        return redirect()->back()->with('success', 'Pengaturan situs berhasil diperbarui.');
    }
}
