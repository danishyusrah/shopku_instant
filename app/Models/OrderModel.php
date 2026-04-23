<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $protectFields    = true;
    protected $allowedFields    = ['order_ref', 'customer_name', 'customer_whatsapp', 'product_id', 'total_price', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    /**
     * Generate Reference Unik (Misal: AZV-240501-XXXX)
     */
    public function generateReference()
    {
        return 'AZV-' . date('ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));
    }

    /**
     * Mendapatkan detail order dengan info produk
     */
    public function getOrderWithProduct($ref)
    {
        return $this->select('orders.*, products.name as product_name')
            ->join('products', 'products.id = orders.product_id')
            ->where('order_ref', $ref)
            ->first();
    }
}
