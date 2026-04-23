<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class OrderController extends BaseController
{
    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    /**
     * Menampilkan daftar pesanan masuk dengan pagination
     */
    public function index()
    {
        $limit = env('PAGINATION_LIMIT', 10);

        $data = [
            'app_name' => env('APP_NAME', 'AzureVault'),
            'orders'   => $this->orderModel->select('orders.*, products.name as product_name')
                ->join('products', 'products.id = orders.product_id')
                ->orderBy('orders.created_at', 'DESC')
                ->paginate($limit, 'orders'),
            'pager'    => $this->orderModel->pager,
            'title'    => 'Daftar Pesanan Masuk'
        ];

        return view('admin/orders/index', $data);
    }

    /**
     * Update status pesanan (misal: dari pending ke completed)
     */
    public function update_status($id, $status)
    {
        if ($this->orderModel->update($id, ['status' => $status])) {
            return redirect()->back()->with('success', 'Status pesanan diperbarui.');
        }
        return redirect()->back()->with('error', 'Gagal memperbarui status.');
    }
}
