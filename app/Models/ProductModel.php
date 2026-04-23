<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['category_id', 'name', 'price', 'stock', 'features', 'is_recommended'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // Kita tidak menggunakan updated_at di schema awal

    /**
     * Mendapatkan produk dengan relasi kategori
     */
    public function getProductsWithCategory()
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->orderBy('is_recommended', 'DESC')
            ->orderBy('id', 'ASC');
    }

    /**
     * Helper untuk memproses JSON features menjadi Array
     */
    public function formatFeatures($json)
    {
        return json_decode($json, true) ?? [];
    }
}
