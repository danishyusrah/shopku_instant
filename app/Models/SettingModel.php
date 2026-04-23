<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table            = 'settings';
    protected $primaryKey       = 'key';
    protected $allowedFields    = ['key', 'value'];
    protected $useTimestamps    = true;

    /**
     * Mendapatkan semua pengaturan dalam format Key => Value
     */
    public function getAllSettings()
    {
        $settings = $this->findAll();
        $formatted = [];
        foreach ($settings as $s) {
            $formatted[$s['key']] = $s['value'];
        }
        return (object) $formatted;
    }
}
